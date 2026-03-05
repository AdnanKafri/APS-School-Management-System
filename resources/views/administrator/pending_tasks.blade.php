 
@extends('administrator.layouts.master')
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
                                        <h2 class="my-4"style="color:black">قائمة المهام</h2>
                                    </div>
   <!-- Button trigger modal -->
                                   
                                    <table class="table text-white mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">المرسل</th>
                                                <th scope="col">المستقبل</th>
                                                <th scope="col">التاسك</th>
                                                <th scope="col">الفرع المرسل</th>
                                                <th scope="col">الفرع المستقبل</th>
                                                <th scope="col">الحالة</th>
                                                <th scope="col">العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pending_tasks as $item)
                                            <tr class="fw-normal">
                                                <th>
                                                    <!--<img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"-->
                                                    <!--    alt="avatar 1" style="width: 45px; height: auto;">-->
                                                    <span class="ms-2">{{$item->employee_send->first_name . ' ' . $item->employee_send->last_name }}</span>
                                                </th>
                                              
                                              
                                                <td class="align-middle">
                                                    <span class="ms-2">{{$item->employee_recv->first_name . ' ' . $item->employee_recv->last_name }}</span>

                                                </td>
                                                
                                                 <td class="align-middle">
                                                    <span>{{$item->description}}</span>
                                                </td>
                                                
                                                    <td class="align-middle">
                                                    <span>{{$item->admin_sender->mainDepartment->name}}</span>
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
                                                <td class="align-middle">
                                                   <!-- Switch container -->
<label class="switch">
    
    @if(($item->is_admin_send_approve=='1' && $item->admin_send_id==auth()->user()->adminstrator_id ) || ($item->is_admin_recv_approve=='1' && $item->admin_recv_id==auth()->user()->adminstrator_id )  )
    
     <input type="checkbox" data-id="{{$item->id}}" id="changeStatus" checked disabled>
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
                                    {{ $pending_tasks->links() }}

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Add Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add your form elements for adding a task here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save Task</button>
                </div>
            </div>
        </div>
    </div>
 
<script>
    $(document).on('change','#changeStatus',function(){
        var taskId = $(this).data('id');
        
        $.ajax({
            type: 'POST',
            url: "{{route('dashboard.approveTask')}}",
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
                      alert('ok')
                    } else {
                      alert('No')
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
