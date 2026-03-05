<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Bus_lines;
use App\Buses;
use App\User;
use App\Bus_supervisor;
use App\Bus_driver;
use App\Year;
use App\Classe;
use App\Student;
use App\Transport_invoice;
use Session;


class TransportationController extends Controller
{
    public function transportation(){

        $bus_lines=Bus_lines::paginate(paginate_num);
        $count = Bus_lines::count();

       return view('admin.transportation.transportations', compact('bus_lines', 'count'));

    }

    public function bus_lines_store(Request $request){

        $item = new Bus_lines;
        $item->name= $request->name;
        $item->annual_cost= $request->annual_cost;
        $item->save();


        return redirect()->back()->with('success', 'تم التخزين بنجاح');


       }
    public function bus_lines_update(Request $request){
 
          $item = Bus_lines::find($request->id);
        $item->name= $request->name;
        $item->annual_cost= $request->annual_cost;
        $item->first_payment= $request->first_payment;
        $item->first_payment_date= $request->first_payment_date;
        $item->second_payment= $request->second_payment;
        $item->second_payment_date= $request->second_payment_date;
        $item->third_payment= $request->third_payment;
        $item->third_payment_date= $request->third_payment_date;
         $item->save();


        return redirect()->back()->with('success', 'تم التخزين بنجاح');


       }


       public function buses($id){

        $buses=Buses::where('bus_lines_id', $id)->paginate(paginate_num);
        $id= $id;
        $count = Buses::count();

       return view('admin.transportation.buses', compact('buses', 'count','id'));

    }

    public function buses_store(Request $request){

        $item = new Buses;
        $item->name= $request->name;
        $item->students_count= $request->students_count;
        $item->bus_lines_id= $request->bus_lines_id;
        $item->save();


        return redirect()->back()->with('success', 'تم التخزين بنجاح');


       }
    public function buses_update(Request $request){


        $item = Buses::find($request->id);
        $item->name= $request->name;
        $item->students_count= $request->students_count;
        $item->bus_lines_id= $request->bus_lines_id;
        $item->save();


        return redirect()->back()->with('success', 'تم التخزين بنجاح');


       }







       public function bus_supervisor(){


        $bus_supervisor=Bus_supervisor::with('bus')->paginate(paginate_num);
        $count = Bus_supervisor::count();
        $buses=Buses::get();

       return view('admin.transportation.bus_supervisors', compact('bus_supervisor','buses', 'count'));

    }

    public function bus_supervisor_store(Request $request){

           // $year= Year::where('current_year','1')->first();

           $request->validate([
            'name' => 'required|max:30',
            'phone' => 'required|max:20'
        ]);

        $bus_supervisor = Bus_supervisor::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'bus_id' => $request->bus_id,
        ]);

 

        $bus_supervisor->save();
        Session::flash('success', '! تمت العملية بنجاح');
        return redirect()->back();
    }



    public function bus_supervisor_update(Request $request)
{
       $bus_supervisor = Bus_supervisor::find($request->supervisor_id);
    $bus_supervisor->update([
        
        'name'=> $request->name,
        'address'=> $request->address,
        'phone'=> $request->phone,
        'bus_id'=> $request->bus_id,
    ]);
 
    return redirect()->back()->with('success', '! تمت العملية بنجاح');
}
    public function bus_supervisor_delete(Request $request)
    {

        $bus_supervisor =Bus_supervisor::findOrFail($request->class_id_delete);
        $bus_supervisor->delete();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }

















    
    public function bus_driver(){


         $bus_driver=Bus_driver::with('bus')->paginate(paginate_num);
        $count = Bus_driver::count();
        $buses=Buses::get();

       return view('admin.transportation.bus_driver', compact('bus_driver','buses', 'count'));

    }

    public function bus_driver_store(Request $request){

           // $year= Year::where('current_year','1')->first();

           $request->validate([
            'name' => 'required|max:30',
            'phone' => 'required|max:20'
        ]);

        $bus_driver = Bus_driver::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'bus_id' => $request->bus_id,
        ]);

        Session::flash('success', '! تمت العملية بنجاح');
        return redirect()->back();
    }



    public function Bus_driver_update(Request $request)
{
 
    $Bus_driver = Bus_driver::find($request->driver_id);
    $Bus_driver->update([
        
        'name'=> $request->name,
        'address'=> $request->address,
        'phone'=> $request->phone,
        'bus_id'=> $request->bus_id,
    ]);
 
     return redirect()->back()->with('success', '! تمت العملية بنجاح');
}
    public function bus_driver_delete(Request $request)
    {

        $bus_driver =Bus_driver::findOrFail($request->class_id_delete);
        $bus_driver->delete();
        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }



// -------------------------
    public function bus_students($bus_id){

   $year=Year::where('current_year','1')->first();
         $bus=Buses::find($bus_id);
               $students=Buses::find($bus_id)->students()->with(['details','room.classes','room'=>function($q)use($year){
              $q->where('room_student.year_id',$year->id);
              
                 
             }])->paginate(paginate_num);
         $count = count($students);
      $all_students=Student::with(['room.classes','room'=>function($q)use($year){
              $q->where('room_student.year_id',$year->id);
              
                 
             }])->get();
       return view('admin.transportation.bus_students', compact('students','all_students', 'count','bus'));

    }
    
    
    // -------------------------
    public function bus_students_store (Request $request){

  $year=Year::where('current_year','1')->first();
foreach($request->student_ids as $item){
    
    $student= Student::find($item);
    $student->bus_id= $request->bus_id;
    $student->save();
    
    
}
        return redirect()->back()->with('success', '! تمت العملية بنجاح');


    }
    

    public function bus_students_delete(Request $request)
    {

        $student =Student::findOrFail($request->class_id_delete);
        $student->bus_id=null;
        $student->save();

        return redirect()->back()->with('success', '! تمت العملية بنجاح');
    }





    public function students_financial_transport ()
    {



        $year = Year::where('current_year', '1')->first();
        $classes = Classe::all();
   $students = Student::with(['room.classes', 'room' => function($q) use ($year) {
    $q->where('room_student.year_id', $year->id);
}, 'bus.bus_lines'])
->whereHas('bus', function($q) {
    // You can add additional constraints here if needed
})
->paginate(paginate_num);
                      $count = count($students);

        return view('admin.transportation.finastudent_transport', compact('year','count', 'classes','students'));
    }
    
    
    
       public function financial_transport_student_filter(Request $request)
    {
        $year = Year::where('current_year', '1')->first();

        if ($request->has('name') ) {
          $students=  Student::with(['room.classes', 'room' => function($q) use ($year) {
    $q->where('room_student.year_id', $year->id);
}, 'bus.bus_lines'])
->whereHas('bus', function($q) {
    // You can add additional constraints here if needed
})
->where('first_name', 'like', '%' . $request->get('name') . '%')->orWhere('last_name', 'like', '%' . $request->get('name') . '%')->get();
        } 
 
  

        return view('admin.transportation.ajax.student_table', compact('students'));
    }
    
    


    public function transport_invoices ($student_id)
    { 
         $year = Year::where('current_year', '1')->first();
          $invoices=Transport_invoice::with('student')->where('student_id',$student_id)->where('year_id',$year->id)->paginate(paginate_num);
 
   $student=Student::with('bus.bus_lines')->find($student_id);

           $sum_invoices=Transport_invoice::with('student')->where('student_id',$student_id)->where('year_id',$year->id)->sum('invoice_amount');
                 $remain_invoices= $student->bus->bus_lines->annual_cost-$sum_invoices;
                        $count = Transport_invoice::with('student')->where('student_id',$student_id)->where('year_id',$year->id)->count();

 
        return view('admin.transportation.invoices', compact('year','count','invoices','student','remain_invoices'));
    }



    public function transport_invoice_store (Request $request)
    { 
          $year = Year::where('current_year', '1')->first();
          $item=new Transport_invoice;
    $item->student_id = $request->student_id ;
    $item->year_id = $year->id;
    $item->bus_line_id = $request->bus_line_id ;
    $item->invoice_number = $request->invoice_number ;
    $item->invoice_amount = $request->invoice_amount ;
 $item->save();
 
        return redirect()->back()->with('success', '! تمت العملية بنجاح');

    }



}
