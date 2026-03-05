@extends('admin.master')

@section('content')
<div class="col" style="direction:rtl;text-align:right">
    <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0 text-primary">جدول مواد الشعبة</h3>
            </div>
<div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget"> الاسم</th>

                    <!--<th scope="col" class="sort" data-sort="budget"> Type</th>-->

                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list">




                   @foreach ($lessons as $lesson)

                   <tr>
                   <!--<th scope="row">-->
                   <!-- {{$lesson->id}}-->
                   <!-- </th>-->



                    <td class="budget" style="font-weight:bold;font-size:15px">

                    {{$lesson->name}}

                    </td>

                    <!--<td class="budget">-->

                    <!--    {{$lesson->type}}-->

                    <!--    </td>-->

                    <td class="text-right">
                        <!--<div class="dropdown">-->
                        <!--  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                        <!--    <i class="fas fa-ellipsis-v"></i>-->
                        <!--  </a>-->
                        <!--  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">-->
                        <!--  <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"-->
                        <!--    data-id="{{$lesson->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"-->
                        <!--        title="Delete">&#xE872; Delete</i></a>-->
                        <!--    <a class="dropdown-item" href="#">Another action</a>-->
                        <!--    <a class="dropdown-item" href="#">Something else here</a>-->
                        <!--  </div>-->
                        <!--</div>-->
                        <a class="btn btn-success" style="display: table-caption;" href="{{ url('SMT/admin/classroom/StudentsRoomLesson', ['room_id' =>$room_id ,'lesson_id' => $lesson->id]) }}">الطلاب</a>

                      </td>


                    </tr>
                   @endforeach









               <div class="modal fade deleteEmployeeModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="form_delete" method="POST">
                                        @csrf
                                        @method('delete')
                                        <div class="modal-header">
                                            <h4 class="modal-title">Delete element</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete these Records?</p>
                                            <p class="text-warning"><small>This action cannot be undone.</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn btn-default" data-dismiss="modal"
                                                value="Cancel">

                                            <button class="btn btn-danger">Delete</button>


                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                </tbody>
              </table>

            </div>





            <div class="clearfix" style="padding-left:10px">
                    <div class="hint-text">Showing
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/paginate_num) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-10">
                            {{ $lessons->links() }}
                        </div>
                    </div>
                </div>
    </div>
</div>


                <script>

$(document).ready(function () {

$('.delete').on('click', function () {
    var id = $(this).data('id');
    var url = "{{URL::to('SMARMANger/admin/students')}}";
    $('#form_delete').attr("action", url);


});

});
</script>

@endsection
