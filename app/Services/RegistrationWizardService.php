<?php

namespace App\Services;

use App\Student_register;

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
        
        if ($student->grade_level) {
            $feeSetting = \App\FeeSetting::where('grade_level', $student->grade_level)->first();
            if ($feeSetting) {
                $registrationFee = $feeSetting->registration_fee;
                $servicesFee = $feeSetting->services_fee;
                
                if ($student->wants_transport) {
                    $transportFee = $feeSetting->transport_fee;
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
