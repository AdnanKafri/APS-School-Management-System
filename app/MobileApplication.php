<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobileApplication extends Model
{
    protected $fillable = ['key', 'audience', 'current_release_id'];

    protected $casts = ['current_release_id' => 'integer'];

    public function releases()
    {
        return $this->hasMany(MobileApplicationRelease::class, 'application_id');
    }

    public function currentRelease()
    {
        return $this->belongsTo(MobileApplicationRelease::class, 'current_release_id');
    }

    public static function ensureFixedApplications()
    {
        foreach (config('mobile_applications.applications', []) as $key => $metadata) {
            static::updateOrCreate(
                ['key' => $key],
                ['audience' => $metadata['audience']]
            );
        }
    }
}
