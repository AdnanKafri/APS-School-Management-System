<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function questions() {

        return $this->hasMany(Question::class,'section_id');

    }
}
