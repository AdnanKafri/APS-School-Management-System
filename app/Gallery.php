<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gallery extends Model
{

    protected $table='gallery_website';

    protected $fillable=['id','image'];

    public function getImageUrlAttribute()
    {
        $path = trim((string) $this->image);
        if ($path === '') {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        $clean = ltrim($path, '/');
        if (Str::startsWith($clean, 'public/')) {
            $clean = ltrim(substr($clean, strlen('public/')), '/');
        }
        if (Str::startsWith($clean, 'storage/')) {
            $clean = ltrim(substr($clean, strlen('storage/')), '/');
        }
        $candidates = [
            public_path($clean),
            public_path('storage/' . $clean),
            storage_path('app/public/' . $clean),
            storage_path($clean),
        ];

        foreach ($candidates as $candidate) {
            if (is_string($candidate) && file_exists($candidate)) {
                return route('gallery.media', ['path' => $clean]);
            }
        }

        return null;
    }


}
