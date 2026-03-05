<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table='jobs2';

    protected $fillable = ['id','title','description'];


    public function applicants(){

        return $this->hasMany(Applicant::class,'job_id','id');
    }
}
