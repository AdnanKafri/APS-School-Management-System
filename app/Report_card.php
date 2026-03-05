<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report_card extends Model
{

    protected $table='report_cards';

    protected $fillable=['id','teacher','teacher_notes','final_result','manager_notes','parent_notes','class'];

    // public function teacher(){
    //     return $this->belongsTo(Teacher::class,'teacher_id')->select(['id','first_name','last_name']);
    // }
    // public function classe(){
    //     return $this->belongsTo(Classe::class,'class_id')->select(['id','name']);
    // }

}
