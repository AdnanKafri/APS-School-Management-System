<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Electronic_file extends Model
{
    protected $table = 'electronic_files';

    public function electronic_section()
    {
        return $this->belongsTo(Electronic_section::class, 'section_id');
    }
}


