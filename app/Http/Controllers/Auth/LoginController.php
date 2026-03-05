<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Studentfcmtoken;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    public function redirectTo()
{            

     if (auth()->user()->type=='2') {
                   
        return ('SMT/admin/index');

    }elseif(auth()->user()->type=='1'){
 
        return ('SMARMANger/dashboard/teacher');

    }elseif(auth()->user()->type=='0' && strpos(url()->previous(), "SMARMANger")){
        $a=strrchr( url()->previous(), 'SMARMANger/' );
        $b=strstr($a,'/');
        $room_id=ltrim($b,'/');
        return ('room_detail/'.$room_id);

    }
    elseif(auth()->user()->type=='0' && strpos(url()->previous(), "SMARMANger")){
 
        return ('SMARMANger/dashboard/student');

    }
    elseif(auth()->user()->type=='0'){
 
        return ('SMARMANger/dashboard/student');

    }
        elseif(auth()->user()->type=='3'){
        return ('SMARMANger/dashboard/supervisor');

    }
     elseif(auth()->user()->type=='4'){
        return ('SMARMANger/dashboard/coordinator');

    }
    
    dd(url()->previous());
}
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {   
        if(auth()->check() && auth()->user()->type=='0'){
            $old_tokens = Studentfcmtoken::where('s_fk',auth()->user()->student_id)->delete();
            Auth::logout();
        }
        $this->middleware('guest')->except('logout');
    }


}
