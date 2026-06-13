<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blogs_website extends Model
{

    protected $table='blogs_website';

    protected $fillable=['id','title_ar','title_en','description_ar','description_en','image'];

    public function getImageUrlAttribute()
    {
        $path = trim((string) $this->image);

        if ($path === '') {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Str::startsWith(ltrim($path, '/'), 'storage/')) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/' . ltrim($path, '/'));
    }

}
