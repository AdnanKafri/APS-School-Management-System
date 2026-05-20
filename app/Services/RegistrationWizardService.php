<?php

namespace App\Services;

use App\Classe;
use App\FeeSetting;
use App\Student_register;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegistrationWizardService
{
    protected const ACTIVE_TOKEN_KEY = 'admission_wizard.active_token';
    protected const DRAFTS_KEY = 'admission_wizard.drafts';

    public function activeToken(): string
    {
        $token = (string) session(self::ACTIVE_TOKEN_KEY, '');
        if ($token === '') {
            $token = (string) Str::uuid();
            session()->put(self::ACTIVE_TOKEN_KEY, $token);
        }

        return $token;
    }

    public function resetWizardState(): void
    {
        $token = (string) session(self::ACTIVE_TOKEN_KEY, '');
        if ($token !== '') {
            session()->forget($this->draftKey($token));
        }
        session()->forget(self::ACTIVE_TOKEN_KEY);
    }

    protected function draftKey(?string $token = null): string
    {
        $token = trim((string) ($token ?: $this->activeToken()));

        return self::DRAFTS_KEY . '.' . $token;
    }

    public function getDraft(?string $token = null): array
    {
        return (array) session($this->draftKey($token), []);
    }

    public function saveDraft(array $draft, ?string $token = null): array
    {
        session()->put($this->draftKey($token), $draft);

        return $draft;
    }

    public function clearDraft(?string $token = null): void
    {
        session()->forget($this->draftKey($token));
    }

    public function saveStep1Terms(?string $token = null): array
    {
        $draft = $this->getDraft($token);
        $draft['accepted_terms'] = 1;
        $draft['admission_status'] = 'draft';
        $draft['current_step'] = 2;
        $draft['updated_at'] = now()->toDateTimeString();

        return $this->saveDraft($draft, $token);
    }

    public function saveStep2Form(?string $token, array $data, array $files = []): array
    {
        $draft = $this->getDraft($token);

        if (isset($data['last_mather_name']) && !isset($data['last_mother_name'])) {
            $data['last_mother_name'] = $data['last_mather_name'];
        }
        unset($data['last_mather_name']);

        $draft['form_data'] = array_merge((array) ($draft['form_data'] ?? []), $data);
        $draft['accepted_terms'] = 1;
        $draft['admission_status'] = 'draft';
        $draft['current_step'] = 3;
        $draft['updated_at'] = now()->toDateTimeString();

        foreach ($files as $field => $file) {
            if (!$file instanceof UploadedFile) {
                continue;
            }
            $draft['uploaded_files'][$field] = $this->saveWizardTempFile($file, $field, $token);
        }

        return $this->saveDraft($draft, $token);
    }

    public function saveWizardTempFile(UploadedFile $file, string $field, ?string $token = null): array
    {
        $token = $this->resolveToken($token);
        $this->assertSupportedFile($file);

        $draft = $this->getDraft($token);
        $oldPath = (string) ($draft['uploaded_files'][$field]['path'] ?? '');
        if ($oldPath !== '') {
            Storage::disk('local')->delete($oldPath);
        }

        $extension = strtolower((string) $file->getClientOriginalExtension());
        if ($extension === '') {
            $extension = 'bin';
        }
        $fileName = uniqid('reg_', true) . '.' . $extension;

        $tempDirectory = 'admission-wizard/' . $token;
        $path = $file->storeAs($tempDirectory, $fileName, 'local');

        $draft['uploaded_files'][$field] = [
            'path' => $path,
            'original_name' => (string) $file->getClientOriginalName(),
            'stored_name' => $fileName,
            'field' => $field,
        ];
        $draft['updated_at'] = now()->toDateTimeString();
        $this->saveDraft($draft, $token);

        return $draft['uploaded_files'][$field];
    }

    public function saveStep3Transport(?string $token, $wantsTransport, $acceptedTransportTerms = 0): array
    {
        $draft = $this->getDraft($token);
        $draft['wants_transport'] = $wantsTransport ? 1 : 0;
        $draft['accepted_transport_terms'] = $acceptedTransportTerms ? 1 : 0;
        $draft['current_step'] = $draft['wants_transport'] ? 4 : 5;
        $draft['admission_status'] = $draft['admission_status'] ?? 'draft';
        $draft['updated_at'] = now()->toDateTimeString();

        return $this->saveDraft($draft, $token);
    }

    public function preparePaymentSummary(?string $token = null): array
    {
        $draft = $this->getDraft($token);
        $draft['fees'] = $this->calculateFees($draft);
        $draft['current_step'] = 5;
        $draft['updated_at'] = now()->toDateTimeString();

        return $this->saveDraft($draft, $token);
    }

    public function submitRegistration(?string $token, $paymentMethod, ?UploadedFile $receiptFile = null): Student_register
    {
        $token = $this->resolveToken($token);
        $draft = $this->getDraft($token);
        $formData = (array) ($draft['form_data'] ?? []);

        if (empty($formData['first_name']) || empty($formData['last_name'])) {
            throw ValidationException::withMessages([
                'draft_token' => __('wizard.errors.complete_student_first'),
            ]);
        }

        $feeData = $draft['fees'] ?? $this->calculateFees($draft);
        $attributes = $this->filterFinalAttributes($formData);

        $attributes['accepted_terms'] = 1;
        $attributes['wants_transport'] = !empty($draft['wants_transport']) ? 1 : 0;
        $attributes['accepted_transport_terms'] = !empty($draft['accepted_transport_terms']) ? 1 : 0;
        $attributes['registration_fee'] = (float) ($feeData['registration_fee'] ?? 0);
        $attributes['services_fee'] = (float) ($feeData['services_fee'] ?? 0);
        $attributes['transport_fee'] = (float) ($feeData['transport_fee'] ?? 0);
        $attributes['total_amount'] = (float) ($feeData['total_amount'] ?? 0);
        $attributes['payment_status'] = 'pending';
        $attributes['admission_status'] = 'pending_review';
        $attributes['admission_submitted_at'] = now();
        $attributes['admission_status_changed_at'] = now();
        $attributes['payment_date'] = now();
        $attributes['probe'] = 0;
        $attributes['current_step'] = null;

        if ($paymentMethod === 'shamcash') {
            $attributes['payment_method'] = 1;
        } elseif ($paymentMethod === 'manual') {
            $attributes['payment_method'] = 0;
        } elseif (is_numeric($paymentMethod)) {
            $attributes['payment_method'] = (int) $paymentMethod;
        }

        if ($receiptFile instanceof UploadedFile) {
            $this->assertSupportedFile($receiptFile);
            $attributes['payment_receipt'] = $this->storeFinalFile($receiptFile, 'payment_receipts');
        }

        foreach ((array) ($draft['uploaded_files'] ?? []) as $field => $fileMeta) {
            $tempPath = is_array($fileMeta) ? (string) ($fileMeta['path'] ?? '') : (string) $fileMeta;
            $promotedPath = $this->promoteTempFile($tempPath, 'filesteachers/admission');
            if ($promotedPath !== null) {
                $attributes[$field] = $promotedPath;
            }
        }

        $student = DB::transaction(function () use ($attributes) {
            $student = new Student_register();
            $student->fill($attributes);
            $student->save();

            return $student;
        });

        $this->clearDraft($token);
        $this->resetWizardState();

        return $student;
    }

    protected function calculateFees(array $draft): array
    {
        $fees = [
            'registration_fee' => 0,
            'services_fee' => 0,
            'transport_fee' => 0,
            'total_amount' => 0,
        ];

        $gradeLevel = $this->resolveGradeLevel($draft);
        if (!$gradeLevel) {
            return $fees;
        }

        $feeSetting = FeeSetting::where('grade_level', $gradeLevel)->first();
        if (!$feeSetting) {
            return $fees;
        }

        $fees['registration_fee'] = (float) $feeSetting->registration_fee;
        $fees['services_fee'] = (float) $feeSetting->services_fee;
        $fees['transport_fee'] = !empty($draft['wants_transport']) ? (float) $feeSetting->transport_fee : 0;
        $fees['total_amount'] = $fees['registration_fee'] + $fees['services_fee'] + $fees['transport_fee'];

        return $fees;
    }

    protected function resolveGradeLevel(array $draft): ?string
    {
        $formData = (array) ($draft['form_data'] ?? []);
        $gradeLevel = trim((string) ($formData['grade_level'] ?? ''));
        $validFeeKeys = ['kindergarten', 'primary', 'middle', 'high'];

        if (in_array($gradeLevel, $validFeeKeys, true)) {
            return $gradeLevel;
        }

        $classId = (int) ($formData['class1'] ?? 0);
        if ($classId <= 0) {
            return null;
        }

        $class = Classe::select('stage_id')->find($classId);
        if (!$class) {
            return null;
        }

        return $this->mapStageIdToGradeLevel((int) $class->stage_id);
    }

    protected function filterFinalAttributes(array $data): array
    {
        if (isset($data['last_mather_name']) && !isset($data['last_mother_name'])) {
            $data['last_mother_name'] = $data['last_mather_name'];
        }
        unset($data['last_mather_name']);

        static $fillableColumns = null;
        if ($fillableColumns === null) {
            $fillableColumns = array_flip(Schema::getColumnListing('student_register'));
        }

        return array_intersect_key($data, $fillableColumns);
    }

    protected function storeFinalFile(UploadedFile $file, string $directory): string
    {
        $this->assertSupportedFile($file);

        $extension = strtolower((string) $file->getClientOriginalExtension());
        if ($extension === '') {
            $extension = 'bin';
        }

        $name = uniqid('reg_', true) . '.' . $extension;

        return $file->storeAs($directory, $name, 'public');
    }

    protected function promoteTempFile(?string $tempPath, string $directory): ?string
    {
        $tempPath = trim((string) $tempPath);
        if ($tempPath === '') {
            return null;
        }

        if (!Storage::disk('local')->exists($tempPath)) {
            return null;
        }

        $fileName = basename($tempPath);
        $finalPath = trim($directory, '/') . '/' . $fileName;
        Storage::disk('public')->put($finalPath, Storage::disk('local')->get($tempPath));
        Storage::disk('local')->delete($tempPath);

        return $finalPath;
    }

    protected function resolveToken(?string $token = null): string
    {
        $token = trim((string) ($token ?: $this->activeToken()));
        if ($token === '') {
            $token = $this->activeToken();
        }

        return $token;
    }

    protected function assertSupportedFile(UploadedFile $file): void
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
    }

    protected function mapStageIdToGradeLevel(int $stageId): string
    {
        if ($stageId === 0) {
            return 'kindergarten';
        }
        if ($stageId === 1 || $stageId === 2) {
            return 'primary';
        }
        if ($stageId === 3) {
            return 'middle';
        }

        return 'high';
    }
}
