<?php

namespace App\Exports;

use App\Student;
use App\Year;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class StudentExport implements FromCollection, WithHeadings
{

    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {

        return [
            'الاسم الأول',
            'الكنية',
            'اسم الأب',
            'اسم الأم',
            'تاريخ الولادة',
            'العنوان',
            'الديانة',
            'اللغة',
            'الصف',
            'الشعبة',
        ];
    }
    public function collection()
    {

        set_time_limit(100000);
        ini_set("max_execution_time", "-1");
        ini_set('memory_limit','-1');

        $year = Year::where('current_year',1)->first();
        $product = DB::table('students')
        ->join('student_details', 'student_details.student_id', '=', 'students.id')
        ->join('room_student', 'room_student.student_id', '=', 'students.id')
        ->join('rooms', 'room_student.room_id', '=', 'rooms.id')
        ->join('classes', 'rooms.class_id', '=', 'classes.id')
        ->select('students.first_name','students.last_name','student_details.father_name','student_details.mother_name',
        'students.date_birth','students.address',DB::raw('(CASE
        WHEN students.religion = "0" THEN "مسلم"
        ELSE "مسيحي"
        END) AS religion') , DB::raw('(CASE
        WHEN students.lang = "0" THEN "فرنسي"
        ELSE "روسي"
        END) AS lang') ,'classes.name as class_name' ,'rooms.name')
        ->where('room_student.year_id',$year->id)
        ->where('classes.id','like',$this->request->classes)
        ->where('rooms.id','like',$this->request->rooms)
        ->get();

        $collect = new Collection;
        foreach ($product as $item) {
            $collect->push($item);
        }
        return $collect;
    }
}
