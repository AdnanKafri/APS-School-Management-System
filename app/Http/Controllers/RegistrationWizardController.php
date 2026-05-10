<?php

namespace App\Http\Controllers;

use App\Services\RegistrationWizardService;
use App\Student_register;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

class RegistrationWizardController extends Controller
{
    /** @var RegistrationWizardService */
    protected $wizard;

    public function __construct(RegistrationWizardService $wizard)
    {
        $this->wizard = $wizard;
    }

    public function saveStep1Terms(Request $request)
    {
        $data = $request->validate([
            'accepted_terms' => 'required|boolean',
        ]);

        if (!((bool) $data['accepted_terms'])) {
            return response()->json([
                'success' => false,
                'message' => __('wizard.errors.terms_required'),
            ], 422);
        }

        return response()->json([
            'success' => true,
            'accepted_terms' => true,
            'next_step' => 2,
        ]);
    }

    public function saveStep2Form(Request $request)
    {
        $data = $request->validate([
            'registration_id' => 'nullable|integer|exists:student_register,id',
            'form_data' => 'required|array',
            'form_data.first_name' => 'required|string|max:255',
            'form_data.last_name' => 'required|string|max:255',
            'form_data.father_name' => 'required|string|max:255',
            'form_data.mather_name' => 'required|string|max:255',
            'form_data.date' => 'required|date',
            'form_data.class1' => 'required|integer|exists:classes,id',
            'form_data.gender' => 'nullable|in:0,1',
            'form_data.religion' => 'nullable|in:0,1',
            'form_data.country' => 'required|string|max:255',
            'form_data.email' => 'nullable|email|max:255',
            'form_data.phone' => 'required|string|max:255',
            'form_data.father_phone' => 'nullable|string|max:255',
            'form_data.mather_phone' => 'nullable|string|max:255',
            'form_data.father_job' => 'nullable|string|max:255',
            'form_data.mather_job' => 'nullable|string|max:255',
            'form_data.guardian_name' => 'nullable|string|max:255',
            'form_data.guardian_relation' => 'nullable|string|max:255',
            'form_data.guardian_phone' => 'nullable|string|max:255',
            'form_data.permanent_address' => 'nullable|string|max:2000',
            'form_data.current_address' => 'nullable|string|max:2000',
            'form_data.medical_notes' => 'nullable|string|max:2000',
            'form_data.chronic_diseases' => 'nullable|string|max:2000',
            'form_data.allergies' => 'nullable|string|max:2000',
            'form_data.fever_medicine_permission' => 'nullable|boolean',
            'form_data.custody_notes' => 'nullable|string|max:2000',
            'form_data.other_phone' => 'nullable|string|max:255',
            'fourth_image' => 'nullable|file|max:4096',
            'passbord' => 'nullable|file|max:4096',
            'personal_image' => 'nullable|file|max:4096',
            'certification' => 'nullable|file|max:4096',
            'mather_page' => 'nullable|file|max:4096',
            'father_page' => 'nullable|file|max:4096',
        ]);

        $formData = $data['form_data'];
        $existingRegistration = null;

        if (!empty($data['registration_id'])) {
            $existingRegistration = Student_register::find($data['registration_id']);
        }

        $requiredFiles = ['fourth_image', 'personal_image', 'certification', 'mather_page', 'father_page'];
        $missingFiles = [];

        foreach ($requiredFiles as $fileField) {
            $hasUploadedFile = $request->hasFile($fileField);
            $hasExistingFile = $existingRegistration && !empty($existingRegistration->{$fileField});

            if (!$hasUploadedFile && !$hasExistingFile) {
                $missingFiles[$fileField] = __('wizard.errors.required_file');
            }
        }

        if (!empty($missingFiles)) {
            throw ValidationException::withMessages($missingFiles);
        }

        foreach (['fourth_image', 'passbord', 'personal_image', 'certification', 'mather_page', 'father_page'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $formData[$fileField] = $this->storeRegistrationFile($request->file($fileField));
            }
        }

        $registration = $this->wizard->saveStep2Form($data['registration_id'] ?? null, $formData);

        return response()->json([
            'success' => true,
            'registration_id' => $registration->id,
            'current_step' => $registration->current_step,
            'status' => $registration->status,
        ]);
    }

    public function saveStep3Transport(Request $request)
    {
        $data = $request->validate([
            'registration_id' => 'required|integer|exists:student_register,id',
            'wants_transport' => 'required|boolean',
            'accepted_transport_terms' => 'nullable|boolean',
        ]);

        $registration = $this->wizard->saveStep3Transport(
            $data['registration_id'],
            (bool) $data['wants_transport'],
            (bool) ($data['accepted_transport_terms'] ?? false)
        );

        return response()->json([
            'success' => true,
            'registration_id' => $registration->id,
            'current_step' => $registration->current_step,
            'status' => $registration->status,
        ]);
    }

    public function preparePaymentSummary(Request $request)
    {
        $data = $request->validate([
            'registration_id' => 'required|integer|exists:student_register,id',
        ]);

        $registration = $this->wizard->preparePaymentSummary($data['registration_id']);

        return response()->json([
            'success' => true,
            'registration_id' => $registration->id,
            'current_step' => $registration->current_step,
            'status' => $registration->status,
            'fees' => [
                'registration_fee' => $registration->registration_fee,
                'services_fee' => $registration->services_fee,
                'transport_fee' => $registration->transport_fee,
                'total_amount' => $registration->total_amount,
            ],
            'payment' => [
                'payment_method' => $registration->payment_method,
                'payment_status' => $registration->payment_status,
            ],
        ]);
    }

    public function finalSubmit(Request $request)
    {
        $data = $request->validate([
            'registration_id' => 'required|integer|exists:student_register,id',
            'payment_method' => 'nullable|in:manual,shamcash,0,1',
            'payment_receipt' => 'required|file|max:6144',
        ]);

        $receiptPath = $this->storeRegistrationFile($request->file('payment_receipt'));
        $paymentMethod = $data['payment_method'] ?? 'manual';

        $registration = $this->wizard->submitRegistration(
            (int) $data['registration_id'],
            $paymentMethod,
            $receiptPath
        );

        $request->session()->flash('registration_success', [
            'title' => __('wizard.success.final_submit'),
            'hint' => __('wizard.success.final_submit_hint'),
        ]);

        return response()->json([
            'success' => true,
            'registration_id' => $registration->id,
            'status' => $registration->status,
            'payment_status' => $registration->payment_status,
            'message' => __('wizard.success.final_submit'),
        ]);
    }

    private function storeRegistrationFile(UploadedFile $file): string
    {
        $extension = strtolower((string) $file->getClientOriginalExtension());

        if ($extension === '') {
            $extension = 'bin';
        }

        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'pdf'], true)) {
            throw ValidationException::withMessages([
                'file' => __('wizard.errors.unsupported_file'),
            ]);
        }

        $name = uniqid('reg_', true) . '.' . $extension;

        return $file->storeAs('filesteachers', $name, 'public');
    }
}

