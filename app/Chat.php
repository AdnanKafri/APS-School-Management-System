<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{

    protected $table='chats';
    
    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}