<?php

namespace App\Exports;

use App\Student;
use App\Teacher;
use App\Year;
use App\Classe;
use App\Room;
use App\Basic_stages_class;
use App\Stage;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class TeacherExportArchive implements FromCollection, WithHeadings
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
            'تاريخ الولادة',  
            'العنوان',
            ' الرقم التسلسلي',
   
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
            
              $product = DB::table('teachers')
            ->join('users', 'users.teacher_id', '=', 'teachers.id')
            ->join('teacher_room_lesson', 'teacher_room_lesson.teacher_id', '=', 'teachers.id')
            ->join('rooms', 'teacher_room_lesson.room_id', '=', 'rooms.id')
            ->join('classes', 'rooms.class_id', '=', 'classes.id')
            ->select('teachers.first_name','teachers.last_name', 'teachers.date_birth','teachers.address')
            ->whereIn('classes.id', $classes_id)
            ->where('rooms.year_id', $year->id)
            ->orderBy('classes.id')
            ->distinct()
            ->get();

        $collect = new Collection;
        $count = 1; // Start the count from 1
        foreach ($product as $item) {
            $item->serial_number = $count; // Add serial number to the item
            $collect->push($item);
            $count++; // Increment the count for each item
        }
        
        return $collect;
    }
}
