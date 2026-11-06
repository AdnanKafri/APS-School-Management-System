<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradebookEvent extends Model
{
    public $timestamps = false;
    protected $guarded = ['*'];
    protected $casts = ['metadata'=>'array'];

    protected static function boot()
    {
        parent::boot();
        static::updating(function () { throw new \LogicException('Gradebook audit events are append-only.'); });
        static::deleting(function () { throw new \LogicException('Gradebook audit events are append-only.'); });
    }
}
