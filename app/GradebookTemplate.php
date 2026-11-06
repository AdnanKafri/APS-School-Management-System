<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradebookTemplate extends Model
{
    protected $guarded = ['*'];
    protected $casts = ['draft_payload'=>'array', 'draft_revision'=>'integer', 'last_version'=>'integer'];

    protected static function boot()
    {
        parent::boot();
        static::updating(function ($model) {
            foreach (['identity', 'year_id', 'lesson_id', 'class_id', 'created_by'] as $key) {
                if ($model->isDirty($key)) throw new \LogicException('Template scope/identity is immutable.');
            }
        });
        static::deleting(function () { throw new \LogicException('Discard drafts; do not delete template history.'); });
    }

    public function year() { return $this->belongsTo(Year::class); }
    public function grade() { return $this->belongsTo(Classe::class, 'class_id'); }
    public function lesson() { return $this->belongsTo(Lesson::class); }
    public function versions() { return $this->hasMany(GradebookTemplateVersion::class, 'template_id'); }
    public function events() { return $this->hasMany(GradebookEvent::class, 'template_id'); }
}
