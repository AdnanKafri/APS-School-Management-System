<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bus_lines;

class Buses extends Model
{
    protected $table = 'buses';
    protected $fillable = ['name','bus_lines_id','student_id'];


    public function bus_lines(){

        return $this->belongsTo(Bus_lines::class,'bus_lines_id');
    }
    public function bus_supervisor(){

        return $this->hasMany(Bus_supervisor::class,'bus_id');
    }
    public function bus_driver(){

        return $this->hasMany(Bus_driver::class,'bus_id');
    }
    
    
       public function students(){

        return $this->hasMany(Student::class,'bus_id');
    }
    


}
