<?php

namespace App\Http\Controllers;
use App\Task;
use App\Adminstrator;
use App\SubDepartment;
use App\AdminEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
 
class employeeAdministratorController extends Controller
{
        
    
    public function dashboard_employeeAdmin(){
 $adminEmployee= AdminEmployee::find(auth()->user()->adminEmployee_id);
             $recv_tasks = Task::with(['admin_sender.mainDepartment','send_task_employee'])->where('recv_id',auth()->user()->adminEmployee_id)->where('is_admin_recv_approve','1')->orderBy('id','desc')->paginate(10);
 
        return view('employeeAdministrator.index',compact('recv_tasks','adminEmployee'));
    }
    



        public function changeStatusTaskEmp(Request $request){
        
            $task=Task::find($request->task_id);
     $task->is_done = $task->is_done == '1' ? '0' : '1';
    $task->save();

    return response()->json(['success' => true, 'status' => $task->is_done], 200);
        }
        
        
            public function employeeAdmin_sent_tasks(){
    
               $sent_tasks = Task::with(['employee_recv','admin_recv.mainDepartment'])->where('is_admin_sender','!=','1')->where('sender_id',auth()->user()->adminEmployee_id)->orderBy('id','desc')->paginate(10);
       
                $subDepartment_id=AdminEmployee::find(auth()->user()->adminEmployee_id)->subDepartment_id;
                $mainDepartment_id=SubDepartment::find($subDepartment_id)->mainDepartment_id;
                $mySubdepartment_ids=SubDepartment::where('mainDepartment_id',$mainDepartment_id)->pluck('id');
                $otherSubdepartment_ids=SubDepartment::where('mainDepartment_id','!=',$mainDepartment_id)->pluck('id');
                $myEmployees = AdminEmployee::whereIn('subDepartment_id',$mySubdepartment_ids)->where('id','!=',auth()->user()->adminEmployee_id)->get();
                $otherEmployees = AdminEmployee::whereIn('subDepartment_id',$otherSubdepartment_ids)->get();
              
               $adminEmployee= AdminEmployee::find(auth()->user()->adminEmployee_id);

              
              return view('employeeAdministrator.sent_tasks',compact('sent_tasks','myEmployees','otherEmployees','adminEmployee'));


    }
    
    public function store_inside_employee_task(Request $request){


         $myMaindepartment= AdminEmployee::find(auth()->user()->adminEmployee_id)->subdepartment->maindepartment;
        $myAsdmin= Adminstrator::where('mainDepartment_id',$myMaindepartment->id)->first();

            $item = new Task;
            $item->description= $request->description;
            $item->sender_id= auth()->user()->adminEmployee_id;
            $item->admin_send_id= $myAsdmin->id;
            $item->admin_recv_id= $myAsdmin->id;
            $item->recv_id= $request->recv_id;
            $item->is_admin_recv_approve= '1';
            $item->is_admin_recv_approve= '1';
            $item->save();
          return redirect()->back()->with('success', 'تم التخزين بنجاح');
  
    }
    
    public function store_outside_employee_task(Request $request){
            
             $myMaindepartment= AdminEmployee::find(auth()->user()->adminEmployee_id)->subdepartment->maindepartment;
             $otherMaindepartment= AdminEmployee::find($request->recv_id)->subdepartment->maindepartment;
              $myAsdmin= Adminstrator::where('mainDepartment_id',$myMaindepartment->id)->first();
              $otherAsdmin=Adminstrator::where('mainDepartment_id',$otherMaindepartment->id)->first(); 
            $item = new Task;
            $item->description= $request->description;
            $item->sender_id= auth()->user()->adminEmployee_id;
            $item->admin_send_id= $myAsdmin->id;
            $item->admin_recv_id= $otherAsdmin->id ;
            $item->recv_id= $request->recv_id;
            $item->is_admin_recv_approve= '0';
            $item->is_admin_recv_approve= '0';
            $item->save();
           return redirect()->back()->with('success', 'تم التخزين بنجاح');

    
    }
    
        
        
}