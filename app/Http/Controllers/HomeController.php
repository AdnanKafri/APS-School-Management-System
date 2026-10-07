<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if ((string) auth()->user()->type === \App\Services\ComplaintAccess::OFFICER_TYPE) {
            return redirect()->route('complaint-portal.index');
        }
        // return view('home');
    }
}
