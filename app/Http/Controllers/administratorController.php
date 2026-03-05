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
 
class administratorController extends Controller
{
        
    
    public function dashboard_administrator(){
 
              $recv_tasks = Task::with(['send_task_admin.mainDepartment','recv_task_admin.mainDepartment'])->where('recv_id',auth()->user()->adminstrator_id)->where('is_admin_send_approve','1')->where('is_admin_sender','1')->orderBy('id','desc')->paginate(10);
 
                $admin= Adminstrator::find(auth()->user()->adminstrator_id);

        return view('administrator.index',compact('recv_tasks','admin'));
    }
    
    public function administrator_sent_tasks(){
    
                     $sent_tasks = Task::with(['employee_recv','admin_recv.mainDepartment'])->where('sender_id',auth()->user()->adminstrator_id)->where('is_admin_sender','1')->orderBy('id','desc')->paginate(10);
                
               $mainDepartment_id=Adminstrator::find(auth()->user()->adminstrator_id)->mainDepartment_id;
               $administrators = Adminstrator::where('id','!=',auth()->user()->adminstrator_id)->get();
                 $subdepartment_ids=SubDepartment::where('mainDepartment_id',$mainDepartment_id)->pluck('id');
                $employees = AdminEmployee::whereIn('subDepartment_id',$subdepartment_ids)->get();
                               $admin= Adminstrator::find(auth()->user()->adminstrator_id);

               
              return view('administrator.sent_tasks',compact('sent_tasks','administrators','employees','admin'));


    }
    
    
    public function administrator_pending_tasks(){
   $pending_sender_tasks = Task::where('admin_send_id', auth()->user()->adminstrator_id)

    ->orderBy('id', 'desc');

$pending_recv_tasks = Task::where('admin_recv_id', auth()->user()->adminstrator_id)
    ->where('is_admin_send_approve', '1')->where('recv_id','!=',auth()->user()->adminstrator_id)
    ->orderBy('id', 'desc');

$pending_tasks = $pending_sender_tasks->union($pending_recv_tasks)->paginate(10);
              
                      $admin= Adminstrator::find(auth()->user()->adminstrator_id);

              
              return view('administrator.pending_tasks',compact('pending_tasks','admin'));
    }
    
    
        public function pending_tasks_administrator(){
        
        $pending_sender_tasks = Task::where('admin_send_id',auth()->user()->adminstrator_id)->orderBy('id','desc')->paginate(10);
        $pending_recv_tasks = Task::where('admin_recv_id',auth()->user()->adminstrator_id)->where('is_admin_send_approve','1')->orderBy('id','desc')->paginate(10);
              
        $admin= Adminstrator::find(auth()->user()->adminstrator_id);

              return view('administrator.pending_tasks',compact('pending_sender_tasks','pending_sender_tasks','admin'));
    }


        public function changeStatusTask(Request $request){
        
            $task=Task::find($request->task_id);
     $task->is_done = $task->is_done == '1' ? '0' : '1';
    $task->save();

    return response()->json(['success' => true, 'status' => $task->is_done], 200);
        }
        
        
                public function approveTask(Request $request){
        
            $task=Task::find($request->task_id);
            if($task->admin_send_id==auth()->user()->adminstrator_id){
                 $task->is_admin_send_approve = '1';
            }else{
                                 $task->is_admin_recv_approve = '1';

                
            } 

            $task->save();
            
            return response()->json(['success' => true, 'status' =>'1'], 200);
              }
        
        
        public function store_admin_task(Request $request){
            
            $item = new Task;
            $item->description= $request->description;
            $item->sender_id= auth()->user()->adminstrator_id;
            $item->admin_send_id= auth()->user()->adminstrator_id;
            $item->admin_recv_id= $request->recv_id;
            $item->recv_id= $request->recv_id;
            $item->is_admin_recv_approve= '1';
            $item->is_admin_send_approve= '1';
            $item->is_admin_sender= '1';
            $item->save();
            
            return redirect()->back()->with('success','تمت العملية بنجاح !');
        }
        
        
                public function store_employee_task(Request $request){
            
            $item = new Task;
            $item->description= $request->description;
            $item->sender_id= auth()->user()->adminstrator_id;
            $item->admin_send_id= auth()->user()->adminstrator_id;
            $item->admin_recv_id= auth()->user()->adminstrator_id;
            $item->recv_id= $request->recv_id;
            $item->is_admin_recv_approve= '1';
            $item->is_admin_recv_approve= '1';
                        $item->is_admin_sender= '1';

            $item->save();
            
            return redirect()->back()->with('success','تمت العملية بنجاح !');
        }
        
        
        
 
        

}