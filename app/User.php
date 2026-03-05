<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */



    protected $fillable = [
        'name', 'email', 'password','mobile','age','address','phone','view_password','type','role_id',
        'teacher_id','student_id','supervisor_id','coordinator_id','type_id','acadsupervisor_id','adminstrator_id','adminEmployee_id'
    ];

    public function hasAbility($permissions){

        $role=$this->role;

        if (! $role) {
            return false;
        }

        foreach ($role->permissions as $permission) {

            if (is_array($permissions) && in_array($permission, $permissions)) {

                return true;
            }
            else if(is_string($permissions) && strcmp($permissions, $permission) == 0) {
return true;
            }
        }
        return false;
    }

    public function student(){

        return $this->belongsTo(Student::class,'student_id');
    }

    public function teacher(){

        return $this->belongsTo(Teacher::class,'teacher_id');
    }


    public function supervisor(){

        return $this->belongsTo(Supervisor::class,'supervisor_id');
    }

    public function acadsupervisor(){

        return $this->belongsTo(Acadsupervisor::class,'acadsupervisor_id');
    }

     public function coordinator(){

        return $this->belongsTo(Coordinator::class,'coordinator_id');
    }

    public function role(){

        return $this->belongsTo(Role::class,'role_id');
    }

    public function chats(){

        return $this->hasMany(Chat::class,'from','id')->where('to',auth()->user()->id)->where('isread',0);

    }

    public function student_schedule_tracer(){
        return $this->hasMany(Student_schedule_tracer::class,'user_id','id');
    }


    /**
     * The attributes that should be hidden for arrays / JSON serialization.
     *
     * NOTE — view_password:
     *   This column stores the user's initial plaintext password so admins
     *   can share login credentials via the UI. It is an intentional feature.
     *   It is added to $hidden so it is NEVER serialized to JSON / API responses.
     *   Blade admin views that display it are protected by roleadmin middleware.
     *   Long-term plan: replace with a one-time token system.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'view_password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
