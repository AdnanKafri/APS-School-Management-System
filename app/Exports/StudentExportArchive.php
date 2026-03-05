<?php

namespace App\Exports;

use App\Student;
use App\Year;
use App\Classe;
use App\Room;
use App\Basic_stages_class;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;

class StudentExportArchive implements FromCollection, WithHeadings
{

    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {

        return [

            'رقم التسجيل',
            'الاسم الأول',
            'الكنية',
            'اسم الأب',
              'اسم الجد',
            'اسم الأم',
             'كنية الام ',
            'تاريخ الولادة',  
            'العنوان',
            'الديانة',
            'اللغة',
            'الرقم في السجل العام',
            'الصف',
            'الشعبة',
            ' العملة' ,
             'مبلغ الدفع ' ,
          'رقم تسلسلي',
        ];
    }
    public function collection()
    {

        set_time_limit(100000);
        ini_set("max_execution_time", "-1");
        ini_set('memory_limit','-1');

        $year = Year::find($this->request->year_id);
       
            $classes_id=[];
            $classes = Classe::all();
            foreach($classes as $classe){
              $classes_id[]= $classe->id; 
            }
             if(in_array("student_hidden", Auth::user()->role->permissions)){
                   $product = Student::with(['invoices'=>function($q1) use($year){
                        $q1->where('invoices.year_id',$year->id);
                    
                    }])
                     ->where('hidden',0)
                  ->join('invoices', 'invoices.student_id', '=', 'students.id')
                  ->join('student_details', 'student_details.student_id', '=', 'students.id')
                  ->join('room_student', 'room_student.student_id', '=', 'students.id')
                  ->join('users', 'users.student_id', '=', 'students.id')
                  ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                  ->join('classes', 'rooms.class_id', '=', 'classes.id')
                   ->join('countries_currencies', 'students.country_currency', '=', 'countries_currencies.id')
                  ->select('students.id','students.first_name','students.last_name','student_details.father_name','student_details.grandfather_name','student_details.mother_name',
                 'student_details.last_mother_name', 'students.date_birth','students.address',DB::raw('(CASE
                  WHEN students.religion = "0" THEN "مسلم"
                  ELSE "مسيحي"
                  END) AS religion') , DB::raw('(CASE
                  WHEN students.lang = "0" THEN "فرنسي"
                  ELSE "روسي"
                  END) AS lang') ,DB::raw('(CASE
                    WHEN classes.stage_id = 3 THEN (CASE WHEN students.lang = "0" THEN "فرنسي " ELSE "روسي " END)
                    ELSE (CASE WHEN students.lang = "0" THEN " " ELSE " " END)
                    END) AS lang') ,'students.public_record_number','classes.name as class_name' ,'rooms.name','countries_currencies.currency_country')
                 
                  ->where('room_student.year_id',$year->id)
                  ->where('invoices.year_id',$year->id)
                  ->whereIn('classes.id',$classes_id)
                  ->get();
      
             }
             else{
                  $product = Student::with(['invoices'=>function($q1) use($year){
                        $q1->where('invoices.year_id',$year->id);
                    
                    }])
                     
                  ->join('invoices', 'invoices.student_id', '=', 'students.id')
                  ->join('student_details', 'student_details.student_id', '=', 'students.id')
                  ->join('room_student', 'room_student.student_id', '=', 'students.id')
                  ->join('users', 'users.student_id', '=', 'students.id')
                  ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
                  ->join('classes', 'rooms.class_id', '=', 'classes.id')
                   ->join('countries_currencies', 'students.country_currency', '=', 'countries_currencies.id')
                  ->select('students.id','students.first_name','students.last_name','student_details.father_name','student_details.grandfather_name','student_details.mother_name',
                 'student_details.last_mother_name', 'students.date_birth','students.address',DB::raw('(CASE
                  WHEN students.religion = "0" THEN "مسلم"
                  ELSE "مسيحي"
                  END) AS religion') , DB::raw('(CASE
                  WHEN students.lang = "0" THEN "فرنسي"
                  ELSE "روسي"
                  END) AS lang') ,DB::raw('(CASE
                    WHEN classes.stage_id = 3 THEN (CASE WHEN students.lang = "0" THEN "فرنسي " ELSE "روسي " END)
                    ELSE (CASE WHEN students.lang = "0" THEN " " ELSE " " END)
                    END) AS lang') ,'students.public_record_number','classes.name as class_name' ,'rooms.name','countries_currencies.currency_country')
                 
                  ->where('room_student.year_id',$year->id)
                  ->where('invoices.year_id',$year->id)
                  ->whereIn('classes.id',$classes_id)
                  ->get();
             }

         $collect = new Collection;
    $count = 1; // Start the count from 1
    foreach ($product as $item) {
        $total = 0;
        foreach ($item->invoices as $invoice) {
            $total += $invoice->invoice_amount;
            
        }
     
        $itemArray = $item->toArray(); // Convert the Eloquent model to an array
        $itemArray['total_invoice_amount'] = $total; // Add the total invoice amount to the array
        $itemArray['serial_number'] = $count; // Add serial number to the array
        unset($itemArray['invoices']); // Remove the invoices object from the array
        $collect->push($itemArray); // Add the array to the collection
        $count++; // Increment the count for each item
    }
    
    return $collect;

    }
      
}
