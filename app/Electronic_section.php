<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Electronic_section extends Model
{
    protected $table='electronic_sections';
    protected $fillable=['name_section','class_id'];

    public function classes()
    {
        return $this->belongsTo(Classe::class,'class_id');
    }

}