<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradebookTemplateVersion extends Model
{
    public $timestamps = false;
    protected $guarded = ['*'];
    protected $casts = ['payload'=>'array', 'number'=>'integer', 'draft_revision'=>'integer'];

    protected static function boot()
    {
        parent::boot();
        static::updating(function () { throw new \LogicException('Published versions are immutable.'); });
        static::deleting(function () { throw new \LogicException('Published versions are immutable.'); });
    }

    public function template() { return $this->belongsTo(GradebookTemplate::class, 'template_id'); }
}
