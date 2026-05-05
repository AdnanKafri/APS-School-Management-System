<?php

namespace App\Services;

use App\Student_register;

class RegistrationWizardService
{
    /**
     * Start a new registration or return existing one
     */
    public function initializeRegistration()
    {
        $student = new Student_register();
        $student->status = 'draft';
        $student->current_step = 1;
        $student->save();

        return $student;
    }

    /**
     * Step 1: Save terms acceptance
     */
    public function saveStep1Terms($registrationId, $acceptedTerms)
    {
        $student = Student_register::findOrFail($registrationId);
        $student->accepted_terms = $acceptedTerms ? 1 : 0;
        
        if ($acceptedTerms) {
            $student->current_step = 2;
        }
        
        $student->save();
        return $student;
    }

    /**
     * Step 2: Save main form data
     */
    public function saveStep2Form($registrationId, array $data)
    {
        $student = Student_register::findOrFail($registrationId);
        
        // Update basic info
        $student->fill($data);
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
        
        $student->status = 'pending_payment';
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
        
        $student->payment_method = $paymentMethod;
        $student->payment_status = 'pending'; // Requires admin verification
        $student->status = 'under_review';
        
        if ($receiptFile) {
            $student->payment_receipt = $receiptFile;
        }
        
        $student->payment_date = now();
        $student->current_step = null; // Wizard completed
        $student->save();
        
        return $student;
    }
}
