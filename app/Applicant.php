<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{

    protected $table = 'applicants';

    protected $fillable = ['id','first_name','last_name','email','phone','file_cv','job_id'];

    public function job(){

        return $this->belongsTo(Job::class,'job_id','id');
    }
}
