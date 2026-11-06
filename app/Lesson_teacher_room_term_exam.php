<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson_teacher_room_term_exam extends Model
{
    use \App\Concerns\PreservesAssessmentResults;
    protected $table='lesson_teacher_room_term_exam';
    protected $fillable=['lesson_id','teacher_id','room_id','term_id','video','test','quize','exam'];
    protected $hidden = ['upload_request_hash', 'upload_payload_hash', 'upload_revision', 'upload_deleted_at', 'privateAttachments'];
    public $allowsPrivateMutation = false;

    protected static function boot()
    {
        parent::boot();
        $guard = function ($content) {
            abort_if(($content->isPrivateLessonContent() || $content->getRawOriginal('upload_request_hash'))
                && !$content->allowsPrivateMutation, 409, __('lesson_content.managed_only'));
        };
        static::creating($guard);
        static::updating($guard);
        static::deleting($guard);
    }

    public function privateAttachments()
    {
        return $this->hasMany(LessonContentAttachment::class, 'content_id')->orderBy('position');
    }

    public function isPrivateLessonContent()
    {
        return !empty($this->attributes['upload_request_hash']);
    }

    public function toArray()
    {
        $data = parent::toArray();
        // Legacy API serializers keep their keys; private Web notes/files are never included.
        if ($this->isPrivateLessonContent() && array_key_exists('note', $data)) $data['note'] = null;
        return $data;
    }
       public function room()
{
    return $this->belongsTo(Room::class,'room_id');
}
public function lecture()
{
    return $this->belongsTo(Lecture::class,'lecture_id');
}
public function exam_resullt()
{
    return $this->hasMany(Exam_result::class, 'exam_id');
}


  public function lesson(){

return $this->belongsTo(Lesson::class,'lesson_id');
}
}
