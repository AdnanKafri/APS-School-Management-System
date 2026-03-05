<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Students_mark extends Model
{
    protected $table='students_marks';
    protected $fillable=['id','student_id','room_id','mark','mark2','result1','result2','result','term_result','year_result',
     'status','year_id','created_at','updated_at','lang','worke_degree','notes','religion'];

    public function student(){

        return $this->belongsTo(Student::class);
    }
}
