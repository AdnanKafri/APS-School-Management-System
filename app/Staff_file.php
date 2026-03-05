<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff_file extends Model
{
    protected $table = 'staff_files';

    public function school_staff()
    {
        return $this->belongsTo(School_staff::class, 'staf_id');
    }
}


