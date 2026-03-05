<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rewards_and_sanction extends Model
{

    protected $table='rewards_and_sanctions';

    public function Rewad_and_sanction_student(){

        return $this->hasMany(Rewad_and_sanction_student::class,'Rewad_and_sanction_id');
    }
}
