<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\School_staff;
use stdClass;

use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class EmployeeImport implements ToModel, WithHeadingRow
{
 

    public function model(array $item)
    {


 
            $school_employee= new School_staff();
            $school_employee->first_name = $item['first_name'];
            $school_employee->last_name = $item['last_name'];
     
            if($item['date_birth']){
                $school_employee->birth_date =\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item['date_birth']);
            }
            $school_employee->phone = $item['phone'];
            $school_employee->address = $item['address'];
            $school_employee->diseases = $item['diseases'];
            $school_employee->salary = $item['salary'];
            $school_employee->business_register = $item['business_register'];
 
            $school_employee->save();
         
         
    }
}
