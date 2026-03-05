@extends('employeeAdministrator.layouts.master')
@section('content')
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
                                        <h2 class="my-4"style="color:black">Task List</h2>
                                    </div>
   <!-- Button trigger modal -->
                                    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"-->
                                    <!--    data-bs-target="#addTaskModal">-->
                                    <!--    Add Task-->
                                    <!--</button>-->
                                    <table class="table text-white mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">المرسل</th>
                                                <th scope="col">التاسك</th>
                                                <th scope="col">الفرع</th>
                                                <th scope="col">الحالة</th>
                                                <th scope="col">العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recv_tasks as $item)
                                            <tr class="fw-normal">
                                                <th>
                                             @if($item->is_admin_sender!=1)
                                                    <span class="ms-2">{{$item->send_task_employee->first_name . ' ' . $item->send_task_employee->last_name }}</span>
                                               
                                               @else
                                                    <span>{{$item->admin_sender->first_name . ' '. $item->admin_sender->last_name }}</span>

                                               @endif
                                                </th>
                                                <td class="align-middle">
                                                    <span>{{$item->description}}</span>
                                                </td>
                                               
                                               
                                                   <td class="align-middle">
                                                    <span>{{$item->admin_sender->mainDepartment->name}}</span>
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
                                                <td class="align-middle">
                                                   <!-- Switch container -->
<label class="switch">
    
    @if($item->is_done=='1')
    
     <input type="checkbox" data-id="{{$item->id}}" id="changeStatus" checked >
     <span class="slider round"></span>
@else


     <input type="checkbox" data-id="{{$item->id}}" id="changeStatus"  >
     <span class="slider round"></span>

     @endif
</label>
                                                </td>
                                            </tr>
                                            
                                            @endforeach
                                            <!-- More task rows here -->
                                        </tbody>
                                    </table>
                                    {{ $recv_tasks->links() }}

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


  
 

<script>
    $(document).on('change','#changeStatus',function(){
        var taskId = $(this).data('id');
        
        $.ajax({
            type: 'POST',
            url: "{{route('changeStatusTaskEmp')}}",
            data: {
                'task_id': taskId // Pass the task id to the server
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // If using Laravel CSRF protection
            },
            success: function (response) {
                // Check the response status
                if(response.success) {
                    // Toggle the status badge based on the updated status
                    if(response.status === '1') {
                        $('#status_' + taskId).html('<h6 class="mb-0"><span class="badge bg-success">تم الحل</span></h6>');
                    } else {
                        $('#status_' + taskId).html('<h6 class="mb-0"><span class="badge bg-danger"> لم يتم الحل </span></h6>');
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
        
    });
</script>

@endsection
