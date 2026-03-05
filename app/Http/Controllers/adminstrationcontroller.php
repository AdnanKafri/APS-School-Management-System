<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MainDepartment;
use App\SubDepartment;
use App\AdminEmployee;
use App\Adminstrator;
use Illuminate\Support\Facades\Hash;
use App\School_data;
 
use App\User;
class adminstrationcontroller extends Controller
{
    public function mainDepartments(){
        $mainDepartments = MainDepartment::paginate(paginate_num);
         $count = MainDepartment::count();

        return view('admin.adminstration.mainDepartments', compact('mainDepartments', 'count'));
       }

       public function mainDepartment_store(Request $request){

        $item = new MainDepartment;
        $item->name= $request->name;
        $item->save();
        return redirect()->back()->with('success', 'تم التخزين بنجاح');


       }


       public function subDepartments($mainDepartment_id){
        $subDepartments = SubDepartment::where('mainDepartment_id',$mainDepartment_id)->paginate(paginate_num);
         $count = SubDepartment::where('mainDepartment_id',$mainDepartment_id)->count();

        return view('admin.adminstration.subDepartments', compact('subDepartments', 'count','mainDepartment_id'));
       }

       public function subDepartment_store(Request $request){

        $item = new SubDepartment;
        $item->name= $request->name;
        $item->mainDepartment_id= $request->mainDepartment_id;
        $item->save();
        return redirect()->back()->with('success', 'تم التخزين بنجاح');


       }


    //    ----------------------



    public function adminEmployees($subDepartment_id){
          $adminEmployees = AdminEmployee::with(['subDepartment','user'])->where('subDepartment_id',$subDepartment_id)->paginate(paginate_num);
         $count = AdminEmployee::where('subDepartment_id',$subDepartment_id)->count();
        $school_data = School_data::first();

        return view('admin.adminstration.adminEmployees', compact('adminEmployees', 'count','subDepartment_id','school_data'));
       }

       public function adminEmployee_store(Request $request){

        $item = new AdminEmployee;
        $item->first_name= $request->first_name;
        $item->last_name= $request->last_name;
        $item->phone= $request->phone;
        $item->subDepartment_id= $request->subDepartment_id;
        $item->save();

        $user = User::create([
            'name' => $request->name_en,
            'email' => "a@app.com",
            'mobile' => $request->phone,
            'password' => Hash::make(5),
            'view_password' => 5,
            'type' => '7',
            'adminEmployee_id' => $item->id,
        ]);

        $email = str_replace(" ", "", $request->name_en) . str_replace(" ", "", $request->name_en) . rand(1, 1000) . "@adham.com";
        if (strlen($request->name_en) > 2) {
            $namee = substr($request->name_en, 0, 3);
        } else {
            $namee = "aladham";
        }
        $password = $namee . "@" . rand(100000, 900000);
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->view_password = $password;
        $user->save();

        return redirect()->back()->with('success', 'تم التخزين بنجاح');


       }


    //    --------------------


 

       public function adminEmployee_update(Request $request){
         $item =    AdminEmployee::find($request->id);
        $item->first_name= $request->first_name;
        $item->last_name= $request->last_name;
        $item->phone= $request->phone;
        $item->subDepartment_id= $request->subDepartment_id;
        $item->save();

        return redirect()->back()->with('success', 'تم التخزين بنجاح');


       }
       


    //    --------------------
    
    public function adminstrators(){
         $adminstrators = Adminstrator::with(['mainDepartment','user'])->paginate(paginate_num);
         $count = Adminstrator::count();
          $mainDepartments = MainDepartment::whereDoesntHave('administrators')->get();
                  $school_data = School_data::first();

        return view('admin.adminstration.adminstrators', compact('adminstrators', 'count','mainDepartments','school_data'));
       }

       public function adminstrator_store(Request $request){

        $item = new Adminstrator;
        $item->first_name= $request->first_name;
        $item->last_name= $request->last_name;
        $item->phone= $request->phone;
        $item->mainDepartment_id= $request->mainDepartment_id;
        $item->save();

        $user = User::create([
            'name' => $request->name_en,
            'email' => "a@app.com",
            'mobile' => $request->phone,
            'password' => Hash::make(5),
            'view_password' => 5,
            'type' => '6',
            'adminstrator_id' => $item->id,
        ]);

        $email = str_replace(" ", "", $request->name_en) . str_replace(" ", "", $request->name_en) . rand(1, 1000) . "@adham.com";
        if (strlen($request->name_en) > 2) {
            $namee = substr($request->name_en, 0, 3);
        } else {
            $namee = "aladham";
        }
        $password = $namee . "@" . rand(100000, 900000);
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->view_password = $password;
        $user->save();

        return redirect()->back()->with('success', 'تم التخزين بنجاح');


       }
}
