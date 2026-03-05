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
use stdClass;

use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

class RoomImport implements ToModel, WithHeadingRow
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



            $room= new Room();
              $room->name = $item['name'];
              $room->class_id = $item['classe'];
               $room->year_id =2;
                 $room->save();
              
           
            }

    

}
