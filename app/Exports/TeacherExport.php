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


class TeacherExport implements FromCollection, WithHeadings
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
            ' الايميل ',
            ' كلمة السر  ',
   
        ];
    }
    public function collection()
    {

        set_time_limit(100000);
        ini_set("max_execution_time", "-1");
        ini_set('memory_limit','-1');

              $product = DB::table('teachers')
            ->join('users', 'users.teacher_id', '=', 'teachers.id')
            ->select('teachers.first_name','teachers.last_name', 'users.email','users.view_password')
            ->get();

        $collect = new Collection;
        $count = 1; // Start the count from 1
        foreach ($product as $item) {
            $collect->push($item);
        }
        
        return $collect;
    }
}
