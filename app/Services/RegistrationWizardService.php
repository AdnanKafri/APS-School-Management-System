<?php

namespace App\Services;

use App\Classe;
use App\FeeSetting;
use App\Student_register;
use Illuminate\Support\Facades\Schema;

class RegistrationWizardService
{
    /**
     * Step 2: Save main form data
     */
    public function saveStep2Form($registrationId, array $data)
    {
        $student = $registrationId
            ? Student_register::findOrFail($registrationId)
            : new Student_register();

        // Keep compatibility with legacy form naming.
        if (isset($data['last_mather_name']) && !isset($data['last_mother_name'])) {
            $data['last_mother_name'] = $data['last_mather_name'];
        }
        unset($data['last_mather_name']);

        // Guard against UI-only keys (e.g. country_label) that are not DB columns.
        static $fillableColumns = null;
        if ($fillableColumns === null) {
            $fillableColumns = array_flip(Schema::getColumnListing('student_register'));
        }
        $data = array_intersect_key($data, $fillableColumns);
        
        // Update basic info
        $student->fill($data);
        $student->accepted_terms = 1;
        $student->current_step = 3;
        $student->save();
        
        return $student;
    }

    /**
     * Step 3: Save transport choice
     */
    public function saveStep3Transport($registrationId, $wantsTransport, $acceptedTransportTerms = 0)
    {
        $student = Student_register::findOrFail($registrationId);
        $student->wants_transport = $wantsTransport ? 1 : 0;
        $student->accepted_transport_terms = $acceptedTransportTerms ? 1 : 0;
        
        $student->current_step = 4;
        $student->save();
        
        return $student;
    }

    /**
     * Step 4: Prepare payment summary and fees
     */
    public function preparePaymentSummary($registrationId)
    {
        $student = Student_register::findOrFail($registrationId);
        
        // Default to 0 for fees
        $registrationFee = 0;
        $servicesFee = 0;
        $transportFee = 0;
        
        $gradeLevel = $student->grade_level;
        $validFeeKeys = ['kindergarten', 'primary', 'middle', 'high'];
        if (!in_array((string) $gradeLevel, $validFeeKeys, true) && !empty($student->class1)) {
            $class = Classe::select('stage_id')->find($student->class1);
            if ($class) {
                $gradeLevel = $this->mapStageIdToGradeLevel((int) $class->stage_id);
            }
        }
        if (in_array((string) $gradeLevel, $validFeeKeys, true)) {
            $student->grade_level = $gradeLevel;
        }

        if ($student->grade_level) {
            $feeSetting = FeeSetting::where('grade_level', $student->grade_level)->first();
            if ($feeSetting) {
                $registrationFee = (float) $feeSetting->registration_fee;
                $servicesFee = (float) $feeSetting->services_fee;

                if ($student->wants_transport) {
                    $transportFee = (float) $feeSetting->transport_fee;
                }
            }
        }
        
        $student->registration_fee = $registrationFee;
        $student->services_fee = $servicesFee;
        $student->transport_fee = $transportFee;
        $student->total_amount = $registrationFee + $servicesFee + $transportFee;
        $student->current_step = 5;
        $student->save();
        
        return $student;
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

    /**
     * Step 5: Final Submission (Manual Payment or ShamCash)
     */
    public function submitRegistration($registrationId, $paymentMethod, $receiptFile = null)
    {
        $student = Student_register::findOrFail($registrationId);

        if ($paymentMethod === 'shamcash') {
            $student->payment_method = 1;
        } elseif ($paymentMethod === 'manual') {
            $student->payment_method = 0;
        } elseif (is_numeric($paymentMethod)) {
            $student->payment_method = (int) $paymentMethod;
        }

        $student->payment_status = 'pending'; // Requires admin verification

        if ($receiptFile) {
            $student->payment_receipt = $receiptFile;
        }

        $student->payment_date = now();
        $student->current_step = null; // Wizard completed
        $student->save();
        
        return $student;
    }
}
