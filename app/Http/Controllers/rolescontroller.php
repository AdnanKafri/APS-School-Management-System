<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Classe;
use App\Room;
use App\Year;
use App\Classes_Rooms_Roles;
use Illuminate\Support\Facades\Auth;
use Artisan;
use Carbon\Carbon;
use App\Classes_room_role_exam;
use App\Classe_role_secret_keeper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Shuttle_Dumper;
use Shuttle_Exception;

class rolescontroller extends Controller
{

    public function __construct()
{
    include app_path() . '/BackupDataBase.php';
}



public function databasebackup()
    {
        try {
            $world_dumper = Shuttle_Dumper::create(array(
                'host' => 'localhost',
                'username' => 'smartsyrianschoo_school',
                'password' => '.G4WVt,_-0ak',
                'db_name' => 'smartsyrianschoo_smartsyrianschool3',
                //'include_tables' => array('country', 'city'), // only include those tables
                //'exclude_tables' => array('city'),
            ));

            // $world_dumper->dump('cep.sql.gz');
            $path = base_path('backup') . '/backup_' . Carbon::now()->format('Y-m-d')
            . '_' . Carbon::now()->format('H')
            . '_' . Carbon::now()->format('m')
            . '_' . Carbon::now()->format('i') .'_.sql';
            $world_dumper->dump($path);
            header('Content-Type: application/octet-stream');
            header("Content-Transfer-Encoding: Binary");
            header("Content-disposition: attachment; filename=\"" . basename($path) . "\"");
            readfile($path);
            Session::flash('success', 'تم أخذ نسخة احتياطية بنجاح');
            return redirect()->back();
        } catch (Shuttle_Exception $e) {
            echo "Couldn't dump database: " . $e->getMessage();
        }
    }

public function importedatabase(Request $request)
    {
        $this->validate($request, [
            'sql' => 'required',
        ]);

        $sql = $request->file('sql');
        $filename = $sql->getClientOriginalName();
        $path = base_path('backup/') . $filename;
        DB::unprepared(file_get_contents($path));
        Session::flash('success', 'تمت العملية بنجاح');
        return redirect('/backup_view');
    }




    public function index() {

        $roles=Role::all();
        $class=Classe::all();
        return view('roles.index',compact('roles','class'));
    }
     public function role_add() {
        $roles=Role::all();
        $class=Classe::all();
        return view('roles.add',compact('roles','class'));
    }
    

    public function store(Request $request) {
        $this->validate($request, [
            'permissions' => 'required',
        ],[
            'permissions.require' => 'يرجى إدخال السماحيات',
        ]);
        

        $year = Year::where('current_year', '1')->first();
        if (!isset($request->permissions)){
            $request->permissions = [] ;
        }
        $role=new Role;
        $role->name = $request->name;
        $role->permissions = json_encode($request->permissions);
        $role->save();

      
        $classes=[];
        if($request->classes){
            // if($request->classes || $request->classes_exam  ||  $request->classes_quize )
            //       return redirect()->back()->with('error', '! يرجى اختيار   الصف    ');
            foreach($request->classes as $classes_it){
                if($classes_it =="0"){
                    $room=Room::where('year_id', $year->id)->get();
                  
                  foreach ($room as $item) {
                      $message = new Classes_Rooms_Roles;
                      $message->class_id  = $item->class_id  ;
                      $message->year_id  = $year->id ;  
                      $message->room_id = $item->id;
                      $message->roles = "message_student";
                      $message->role_id = $role->id;
                      $message->save();
          
                  }
              
                       }
          
                       else{
                   
                        $classes[]=$classes_it;
          
                      }}
        }
        $rooms=[];
        if($request->rooms){
           foreach($request->rooms as $rooms_it){
               if($rooms_it=="0"){
                   $room=Room::whereIn("class_id",$classes)->where('year_id', $year->id)->get();    
                foreach ($room as $item) {
                    $message = new Classes_Rooms_Roles;
                    $message->class_id  = $item->class_id  ;
                    $message->year_id  = $year->id ;  
                    $message->room_id = $item->id;
                    $message->roles = "message_student";
                    $message->role_id = $role->id;
                    $message->save();
                }
              
               }
               else{

                   $rooms[]=$rooms_it;
               

               }
             }
            //  if( count($rooms)==0){
            //   return redirect()->back()->with('success', '! تمت العملية بنجاح ');
            //  }
                    
        }


        else{
            //     if($request->classes && count($rooms)==0 )
            //       return redirect()->back()->with('error', '! يرجى اختيار الشعبة   ');
            //   }
        }
         if($rooms){                   
            $room=Room::WhereIn("id",$rooms)->where('year_id', $year->id)->get();
            foreach ($room as $item) {
                $message = new Classes_Rooms_Roles;
                $message->class_id  = $item->class_id  ;
                $message->year_id  = $year->id ;  
                $message->room_id = $item->id;
                $message->roles = "message_student";
                $message->role_id = $role->id;
                $message->save();          
                
                }
                
            }
       $classes_exam=[];
        if($request->classes_exam){
            foreach($request->classes_exam as $classes_it_exam){
                if($classes_it_exam =="0"){
                    $room_exam=Room::where('year_id', $year->id)->get();
                  
                  foreach ($room_exam as $item_exam) {
                      $exam = new Classes_room_role_exam;
                      $exam->class_id  = $item_exam->class_id  ;
                      $exam->year_id  = $year->id ;  
                      $exam->room_id = $item_exam->id;
                      $exam->roles = "exams";
                      $exam->role_id = $role->id;
                      $exam->save();
          
                  }
                
                       }
          
                       else{
                   
                        $classes_exam[]=$classes_it_exam;
          
                      }}
        }
        $rooms_exam=[];
         
        if($request->rooms_exam){
           foreach($request->rooms_exam as $rooms_it_exam){
               if($rooms_it_exam=="0"){
                   $room_exam=Room::whereIn("class_id",$classes_exam)->where('year_id', $year->id)->get();    
                foreach ($room_exam as $item_exam) {
                    $exam = new Classes_room_role_exam;
                    $exam->class_id  = $item_exam->class_id  ;
                    $exam->year_id  = $year->id ;  
                    $exam->room_id = $item_exam->id;
                    $exam->roles = "exams";
                    $exam->role_id = $role->id;
                    $exam->save();
                }
              
               }
               else{

                   $rooms_exam[]=$rooms_it_exam;
               

               }
             }
            //  if( count($rooms_exam)==0){
            //   return redirect()->back()->with('success', '! تمت العملية بنجاح ');
            //  }
                    
        }


        else{
                // if($request->classes_exam && count($rooms_exam)==0 )
                //   return redirect()->back()->with('error', '! يرجى اختيار الشعبة   ');
               }
         if($rooms_exam){                   
            $room_exam=Room::WhereIn("id",$rooms_exam)->where('year_id', $year->id)->get();
            foreach ($room_exam as $item_exam) {
                $exam = new Classes_room_role_exam;
                $exam->class_id  = $item_exam->class_id  ;
                $exam->year_id  = $year->id ;  
                $exam->room_id = $item_exam->id;
                $exam->roles = "exams";
                $exam->role_id = $role->id;
                $exam->save();          
                
                }
                
            }
            
             $classes_quize=[];
            
        if($request->classes_quize){
            foreach($request->classes_quize as $classes_it_quize){
                if($classes_it_quize =="0"){
                    $room_quize=Room::where('year_id', $year->id)->get();
                  
                  foreach ($room_quize as $item_quize) {
                      $quize = new Classes_room_role_exam;
                      $quize->class_id  = $item_quize->class_id  ;
                      $quize->year_id  = $year->id ;  
                      $quize->room_id = $item_quize->id;
                      $quize->roles = "quizes";
                      $quize->role_id = $role->id;
                      $quize->save();
          
                  }
               
                       }
          
                       else{
                   
                        $classes_quize[]=$classes_it_quize;
          
                      }}
        }
        $rooms_quize=[];
        
        if($request->rooms_quize){
           foreach($request->rooms_quize as $rooms_it_quize){
               if($rooms_it_quize=="0"){
                   $room_quize=Room::whereIn("class_id",$classes_quize)->where('year_id', $year->id)->get();    
                foreach ($room_quize as $item_quize) {
                    $quize = new Classes_room_role_exam;
                    $quize->class_id  = $item_quize->class_id  ;
                    $quize->year_id  = $year->id ;  
                    $quize->room_id = $item_quize->id;
                    $quize->roles = "quizes";
                    $quize->role_id = $role->id;
                    $quize->save();
                }
              
               }
               else{

                   $rooms_quize[]=$rooms_it_quize;
               

               }
             }
            
            //  if( count($rooms_exam)==0){
            //   return redirect()->back()->with('success', '! تمت العملية بنجاح ');
            //  }
                    
        }

   
        else{
                // if($request->classes_exam && count($rooms_exam)==0 )
                //   return redirect()->back()->with('error', '! يرجى اختيار الشعبة   ');
               }
         if($rooms_quize){   
             
            $room_quize=Room::WhereIn("id",$rooms_quize)->where('year_id', $year->id)->get();
            foreach ($room_quize as $item_quize) {
                $quize = new Classes_room_role_exam;
                $quize->class_id  = $item_quize->class_id  ;
                $quize->year_id  = $year->id ;  
                $quize->room_id = $item_quize->id;
                $quize->roles = "quizes";
                $quize->role_id = $role->id;
                $quize->save();          
                
                }
                
            }
            
           $classes_secret_keeper=[];
        if($request->classes_secret_keeper){
             if(in_array("0", $request->classes_secret_keeper)){
                  $classes_secret=Classe::all();
                  
                  foreach ($classes_secret as $item_secret) {
                      $secret_keeper = new Classe_role_secret_keeper;
                      $secret_keeper->class_id  = $item_secret->id  ;
                      $secret_keeper->year_id  = $year->id ;  
                      $secret_keeper->roles = "secret_keeper";
                      $secret_keeper->role_id = $role->id;
                      $secret_keeper->save();
          
                  }
             }
             else{
                foreach($request->classes_secret_keeper as $classes_secret_keeper){
                      $secret_keeper = new Classe_role_secret_keeper;
                      $secret_keeper->class_id  = $classes_secret_keeper  ;
                      $secret_keeper->year_id  = $year->id ;  
                      $secret_keeper->roles = "secret_keeper";
                      $secret_keeper->role_id = $role->id;
                      $secret_keeper->save();
                       }  
             }
           
        }    
            
        return redirect()->back()->with('success','! تمت العملية بنجاح');


    }


    public function role_edit($id) {
        
        $year = Year::where('current_year', '1')->first();
        $rooms=[];
         $class=Classe::all();
        $role=Role::with('classes_rooms_roles')->with('Classes_room_role_exam')->with('Classe_role_secret_keeper')->find($id);
        $permissions= $role->permissions;
        $class1=[];
        $rooms1=[];
        $class_exam=[];
        $rooms_exam=[];
        $class_quize=[];
        $rooms_quize=[];
        foreach($role['classes_rooms_roles'] as $item){
            $rooms1[]=$item->room_id;
            $class1[]=$item->class_id;
        
        }
        $class_secret_keeper=[];
        foreach($role['classe_role_secret_keeper'] as $item){
            
            $class_secret_keeper[]=$item->class_id;
        
        }
        foreach($role['Classes_room_role_exam'] as $item){
            if($item->roles=="exams"){
                $rooms_exam[]=$item->room_id;
                $class_exam[]=$item->class_id;
            }
            elseif($item->roles=="quizes"){
                $rooms_quize[]=$item->room_id;
                $class_quize[]=$item->class_id;
            }
        }

        $room_exam10=[];
        $rooms_quize10=[];
        if(count($class1)>0){
            $rooms=Room::with('classes')->whereIn('class_id',$class1)->where('year_id', $year->id)->get();
        }
        if(count($class_exam)>0){
            $room_exam10=Room::with('classes')->whereIn('class_id',$class_exam)->where('year_id', $year->id)->get();
        }

        if(count($class_quize)>0){
            $rooms_quize10=Room::with('classes')->whereIn('class_id',$class_quize)->where('year_id', $year->id)->get();
        }
        $status= true;
        $view=view('roles.ajax')->with('permissions',$permissions)->with('rooms',$rooms)->with('rooms1',$rooms1)->with('class1',$class1)->with('class',$class)->renderSections();
 
        $classes_rooms_roles=$role['classes_rooms_roles'];
            // return response()->json([
            // 'status'=>true,
            // 'data'=>$view['content'],
            // 'classes_rooms_roles'=>$role['classes_rooms_roles'],
            // 'rooms'=>$rooms,
            // 'class'=>$class,

            // ]);
        return view('roles.edit',compact('permissions','class1','rooms1','classes_rooms_roles','class_secret_keeper','rooms','class','role','rooms_quize','class_quize','class_exam','room_exam10','rooms_quize10','rooms_exam'));

}





    public function edit($id) {
        
        $year = Year::where('current_year', '1')->first();
        $rooms=[];
         $class=Classe::all();
        $role=Role::with('classes_rooms_roles')->find($id);
$permissions= $role->permissions;
$class1=[];
$rooms1=[];
foreach($role['classes_rooms_roles'] as $item){
    $rooms1[]=$item->room_id;
    $class1[]=$item->class_id;

}
if(count($class1)>0){
    $rooms=Room::with('classes')->whereIn('class_id',$class1)->where('year_id', $year->id)->get();
}

 $view=view('roles.ajax')->with('permissions',$permissions)->with('rooms',$rooms)->with('rooms1',$rooms1)->with('class1',$class1)->with('class',$class)->renderSections();
            return response()->json([
            'status'=>true,
            'data'=>$view['content'],
            'classes_rooms_roles'=>$role['classes_rooms_roles'],
            'rooms'=>$rooms,
            'class'=>$class,

            ]);

}

public function update(Request $request) {
    $this->validate($request, [
        'permissions' => 'required',
    ],[
        'permissions.require' => 'يرجى إدخال السماحيات',
    ]);
    $year = Year::where('current_year', '1')->first();
    $role=Role::find($request->role_id);
    $role->name=$request->name;
    $role->permissions = json_encode($request->permissions);
    $role->save();
    

     $to_delete =Classes_Rooms_Roles::where('role_id',$request->role_id)->get();
    if($to_delete){
        foreach($to_delete as $x){
    
            $x->delete();
         }
    }
     $to_delete1 =Classes_room_role_exam::where('role_id',$request->role_id)->get();
    if($to_delete1){
        foreach($to_delete1 as $x){
    
            $x->delete();
         }
    }
      $to_delete2 =Classe_role_secret_keeper::where('role_id',$request->role_id)->get();
    if($to_delete2){
        foreach($to_delete2 as $x){
    
            $x->delete();
         }
    }
 $classes=[];
        if($request->classes){
            // if($request->classes || $request->classes_exam  ||  $request->classes_quize )
            //       return redirect()->back()->with('error', '! يرجى اختيار   الصف    ');
            foreach($request->classes as $classes_it){
                if($classes_it =="0"){
                    $room=Room::where('year_id', $year->id)->get();
                  
                  foreach ($room as $item) {
                      $message = new Classes_Rooms_Roles;
                      $message->class_id  = $item->class_id  ;
                      $message->year_id  = $year->id ;  
                      $message->room_id = $item->id;
                      $message->roles = "message_student";
                      $message->role_id = $role->id;
                      $message->save();
          
                  }
              
                       }
          
                       else{
                   
                        $classes[]=$classes_it;
          
                      }}
        }
        $rooms=[];
        if($request->rooms){
           foreach($request->rooms as $rooms_it){
               if($rooms_it=="0"){
                   $room=Room::whereIn("class_id",$classes)->where('year_id', $year->id)->get();    
                foreach ($room as $item) {
                    $message = new Classes_Rooms_Roles;
                    $message->class_id  = $item->class_id  ;
                    $message->year_id  = $year->id ;  
                    $message->room_id = $item->id;
                    $message->roles = "message_student";
                    $message->role_id = $role->id;
                    $message->save();
                }
              
               }
               else{

                   $rooms[]=$rooms_it;
               

               }
             }
            //  if( count($rooms)==0){
            //   return redirect()->back()->with('success', '! تمت العملية بنجاح ');
            //  }
                    
        }


        else{
            //     if($request->classes && count($rooms)==0 )
            //       return redirect()->back()->with('error', '! يرجى اختيار الشعبة   ');
            //   }
        }
         if($rooms){                   
            $room=Room::WhereIn("id",$rooms)->where('year_id', $year->id)->get();
            foreach ($room as $item) {
                $message = new Classes_Rooms_Roles;
                $message->class_id  = $item->class_id  ;
                $message->year_id  = $year->id ;  
                $message->room_id = $item->id;
                $message->roles = "message_student";
                $message->role_id = $role->id;
                $message->save();          
                
                }
                
            }
       $classes_exam=[];
        if($request->classes_exam){
            foreach($request->classes_exam as $classes_it_exam){
                if($classes_it_exam =="0"){
                    $room_exam=Room::where('year_id', $year->id)->get();
                  
                  foreach ($room_exam as $item_exam) {
                      $exam = new Classes_room_role_exam;
                      $exam->class_id  = $item_exam->class_id  ;
                      $exam->year_id  = $year->id ;  
                      $exam->room_id = $item_exam->id;
                      $exam->roles = "exams";
                      $exam->role_id = $role->id;
                      $exam->save();
          
                  }
                
                       }
          
                       else{
                   
                        $classes_exam[]=$classes_it_exam;
          
                      }}
        }
        $rooms_exam=[];
         
        if($request->rooms_exam){
           foreach($request->rooms_exam as $rooms_it_exam){
               if($rooms_it_exam=="0"){
                   $room_exam=Room::whereIn("class_id",$classes_exam)->where('year_id', $year->id)->get();    
                foreach ($room_exam as $item_exam) {
                    $exam = new Classes_room_role_exam;
                    $exam->class_id  = $item_exam->class_id  ;
                    $exam->year_id  = $year->id ;  
                    $exam->room_id = $item_exam->id;
                    $exam->roles = "exams";
                    $exam->role_id = $role->id;
                    $exam->save();
                }
              
               }
               else{

                   $rooms_exam[]=$rooms_it_exam;
               

               }
             }
            //  if( count($rooms_exam)==0){
            //   return redirect()->back()->with('success', '! تمت العملية بنجاح ');
            //  }
                    
        }


        else{
                // if($request->classes_exam && count($rooms_exam)==0 )
                //   return redirect()->back()->with('error', '! يرجى اختيار الشعبة   ');
               }
         if($rooms_exam){                   
            $room_exam=Room::WhereIn("id",$rooms_exam)->where('year_id', $year->id)->get();
            foreach ($room_exam as $item_exam) {
                $exam = new Classes_room_role_exam;
                $exam->class_id  = $item_exam->class_id  ;
                $exam->year_id  = $year->id ;  
                $exam->room_id = $item_exam->id;
                $exam->roles = "exams";
                $exam->role_id = $role->id;
                $exam->save();          
                
                }
                
            }
            
             $classes_quize=[];
            
        if($request->classes_quize){
            foreach($request->classes_quize as $classes_it_quize){
                if($classes_it_quize =="0"){
                    $room_quize=Room::where('year_id', $year->id)->get();
                  
                  foreach ($room_quize as $item_quize) {
                      $quize = new Classes_room_role_exam;
                      $quize->class_id  = $item_quize->class_id  ;
                      $quize->year_id  = $year->id ;  
                      $quize->room_id = $item_quize->id;
                      $quize->roles = "quizes";
                      $quize->role_id = $role->id;
                      $quize->save();
          
                  }
               
                       }
          
                       else{
                   
                        $classes_quize[]=$classes_it_quize;
          
                      }}
        }
        $rooms_quize=[];
        
        if($request->rooms_quize){
           foreach($request->rooms_quize as $rooms_it_quize){
               if($rooms_it_quize=="0"){
                   $room_quize=Room::whereIn("class_id",$classes_quize)->where('year_id', $year->id)->get();    
                foreach ($room_quize as $item_quize) {
                    $quize = new Classes_room_role_exam;
                    $quize->class_id  = $item_quize->class_id  ;
                    $quize->year_id  = $year->id ;  
                    $quize->room_id = $item_quize->id;
                    $quize->roles = "quizes";
                    $quize->role_id = $role->id;
                    $quize->save();
                }
              
               }
               else{

                   $rooms_quize[]=$rooms_it_quize;
               

               }
             }
            
            //  if( count($rooms_exam)==0){
            //   return redirect()->back()->with('success', '! تمت العملية بنجاح ');
            //  }
                    
        }

   
        else{
                // if($request->classes_exam && count($rooms_exam)==0 )
                //   return redirect()->back()->with('error', '! يرجى اختيار الشعبة   ');
               }
         if($rooms_quize){   
             
            $room_quize=Room::WhereIn("id",$rooms_quize)->where('year_id', $year->id)->get();
            foreach ($room_quize as $item_quize) {
                $quize = new Classes_room_role_exam;
                $quize->class_id  = $item_quize->class_id  ;
                $quize->year_id  = $year->id ;  
                $quize->room_id = $item_quize->id;
                $quize->roles = "quizes";
                $quize->role_id = $role->id;
                $quize->save();          
                
                }
                
            }
          $classes_secret_keeper=[];
        if($request->classes_secret_keeper){
             if(in_array("0", $request->classes_secret_keeper)){
                  $classes_secret=Classe::all();
                  
                  foreach ($classes_secret as $item_secret) {
                      $secret_keeper = new Classe_role_secret_keeper;
                      $secret_keeper->class_id  = $item_secret->id  ;
                      $secret_keeper->year_id  = $year->id ;  
                      $secret_keeper->roles = "secret_keeper";
                      $secret_keeper->role_id = $role->id;
                      $secret_keeper->save();
          
                  }
             }
             else{
                foreach($request->classes_secret_keeper as $classes_secret_keeper){
                      $secret_keeper = new Classe_role_secret_keeper;
                      $secret_keeper->class_id  = $classes_secret_keeper  ;
                      $secret_keeper->year_id  = $year->id ;  
                      $secret_keeper->roles = "secret_keeper";
                      $secret_keeper->role_id = $role->id;
                      $secret_keeper->save();
                       }  
             }
           
        }   
    return redirect()->back()->with('success','! تمت العملية بنجاح');

}

}
