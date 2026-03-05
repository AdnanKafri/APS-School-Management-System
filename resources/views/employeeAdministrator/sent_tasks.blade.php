 @extends('employeeAdministrator.layouts.master')
@section('content')
<!-- Styles -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- Or for RTL support -->
 
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

    <div class="container">
        <div class="row">
            <section class="vh-100 gradient-custom-2">
                <div class="container py-5 h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-md-12 col-xl-10">

                            <div class="card mask-custom">
                                <div class="card-body p-4 text-white">

                                    <div class="text-center pt-3 pb-2">
                                        <!--<img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-todo-list/check1.webp"-->
                                        <!--    alt="Check" width="60">-->
                                        <h2 class="my-4"style="color:black">المهام المرسلة</h2>
                                    </div>

                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addTaskEmployeeModal">
                                            ارسال مهمة لموظف داخل القسم
                                    </button>
                                    
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addTaskOtherEmployeeModal">
                                            ارسال مهمة لموظف قسم اخر
                                    </button>

                                    
                                    <table class="table text-white mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col"> المستقبل</th>
                                                <th scope="col">التاسك</th>
                                                <th scope="col">الفرع</th>
                                                <th scope="col">الحالة</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sent_tasks as $item)
                                            <tr class="fw-normal">
                                                <th>
                                                    
                                     
                                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                                alt="avatar 1" style="width: 45px; height: auto;">
                                                <span class="ms-2">{{$item->employee_recv->first_name . ' ' . $item->employee_recv->last_name }}</span>
                                                
                                                 </th>
                                                <td class="align-middle">
                                                    <span>{{$item->description}}</span>
                                                </td>
                                               
                                               
                                                   <td class="align-middle">
                                                    <span>{{$item->admin_recv->mainDepartment->name}}</span>
                                                </td>
                                               
                                                <td class="align-middle" id="status_{{$item->id}}">
                                                    @if($item->is_done=='1')
                                                 
                                                               <h6 class="mb-0"><span
                                                            class="badge bg-success">تم الحل</span></h6>
                                                            @else 
                                                            
                                                               <h6 class="mb-0"><span
                                                            class="badge bg-danger"> لم يتم الحل   </span></h6>
                                                            @endif
                                                </td>
   
                                            </tr>
                                            
                                            @endforeach
                                            <!-- More task rows here -->
                                        </tbody>
                                    </table>
                                    {{ $sent_tasks->links() }}

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade" id="addTaskEmployeeModal" tabindex="-1" aria-labelledby="addTaskModalLabel"
        aria-hidden="true" style="direction:rtl">
        <div class="modal-dialog">
            <div class="modal-content">
   <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">إنشاء مهمة</h2>
                     </button>
                </div>
                <div class="modal-body">
 
 
                   <form method="post" action="{{route('dashboard.store_inside_employee_task')}}">
                       
                       @csrf
                       
                    <div class="form-group">
                        <label>الوصف</label>
                        <input type="text" name="description" class="form-control a" style="direction:rtl"
                            value="" maxlength="20"
                            placeholder=" الوصف" required>
                    </div>


                <div class="form-group">
                <label>المدير</label>
                <select name="recv_id" class="form-select"  id="my-employees"   data-placeholder="اختر الموظف">
                    <option value="">اختر المدير..</option>
                     @foreach($myEmployees as $item)
                    <option value="{{$item->id}}">{{$item->first_name}}</option>
                    @endforeach
                </select>
                </div>

   
                </div>
                <div class="modal-footer">
                     <button type="submit" class="btn btn-primary">Save Task</button>
                </div>
                
                                   </form>

            </div>
        </div>
    </div>
    
    
    
    
        <div class="modal fade" id="addTaskOtherEmployeeModal" tabindex="-1" aria-labelledby="addTaskModalLabel"
        aria-hidden="true" style="direction:rtl">
        <div class="modal-dialog">
            <div class="modal-content">
   <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">إنشاء مهمة</h2>
                     </button>
                </div>
                <div class="modal-body">
                   
                   <form method="post" action="{{route('dashboard.store_outside_employee_task')}}">
                       
                       @csrf
                       
                    <div class="form-group">
                        <label>الوصف</label>
                        <input type="text" name="description" class="form-control a" style="direction:rtl"
                            value="" maxlength="20"
                            placeholder=" الوصف" required>
                    </div>

 

                <div class="form-group">
                <label>الموظف</label>
                <select name="recv_id" class="form-select" id="other-employees" data-placeholder="اختر الموظف">
                     @foreach($otherEmployees as $item)
                    <option value="{{$item->id}}">{{$item->first_name}}</option>
                    @endforeach
                </select>
                </div>



                </div>
                <div class="modal-footer">
                     <button type="submit" class="btn btn-primary">Save Task</button>
                </div>
                
               </form>

            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script>
        $( '#other-employees' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
             dropdownParent: $('#addTaskOtherEmployeeModal')

} );


        $( '#my-employees' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
             dropdownParent: $('#addTaskEmployeeModal')

} );

    </script>
 
  @endsection