<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobileApplicationRelease extends Model
{
    protected $fillable = [
        'application_id', 'version', 'file_path', 'original_filename',
        'file_size', 'mime_type', 'sha256', 'release_notes',
        'published_at', 'uploaded_by',
    ];

    protected $casts = ['published_at' => 'datetime'];

    public function application()
    {
        return $this->belongsTo(MobileApplication::class, 'application_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
