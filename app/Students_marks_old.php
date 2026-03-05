<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Student;
class Students_mark extends Model
{
    protected $table='students_marks';
    protected $fillable=['id','student_id','room_id','lesson_id','oral','homework','activities',
    'quize','exam','status','created_at','updated_at'];

    public function student(){

        return $this->belongsTo(Student::class);
    }
}
