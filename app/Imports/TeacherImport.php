<?php

namespace App\Imports;

use App\Room;
use App\Classe;
use App\Student;
use App\Invoice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Student_detail;
use App\user;
use App\Year;
use App\Lesson;
use App\Students_mark;
use App\Room_student;
use App\Teacher;
use stdClass;

use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class TeacherImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    // public function rules(): array
    // {
    //     return [
    //         'name' => 'required',
    //     ];
    // }

    public function model(array $item)
    {



            $teacher= new Teacher();
            $teacher->first_name = $item['first_name_ar'];
            $teacher->last_name = $item['last_name_ar'];
            // $teacher->first_name_en = $item['first_name_en'];
            // $teacher->last_name_en = $item['last_name_en'];
// $time = strtotime($item['date_birth']);
 
//             $teacher->date_birth =date('Y-m-d',$time);

        if($item['date_birth']){
                 $teacher->date_birth =\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item['date_birth']);
            }
           

            $teacher->phone = $item['phone'];
            $teacher->salary = $item['salary'];
            $teacher->address = $item['address'];

            $teacher->save();
            $user = User::create([
                'name'=>$item['first_name_ar'],
                'email'=>"a@app.com",
                'mobile'=>$item['phone'],
                'password'=>Hash::make(5),
                'view_password'=>5,
                'type'=>'1',
                'teacher_id'=>$teacher->id,
            ]);

            $email = str_replace(" ", "", $item['first_name_en']).str_replace(" ", "", $item['last_name_en']).rand(1,1000)."@aladham.com";
            if (strlen($item['first_name_en']) > 2) {
                $namee = substr($item['first_name_en'], 0, 3);
            }else{
                $namee = "aladham";
            }
            $password = $namee."@".rand(100000,900000);
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->view_password = $password;
            $user->save();

            $teacher->email = $email;
            $teacher->save();
         
    }
}
