@extends('admin.layouts.app')

@section('content')
<div class="col" style="direction:rtl;text-align:right">
    <div class="card">
            <!-- Card header -->
            <div class="card-header border-0" style="">
              <h3 class="mb-0">جدول الشعب</h3>
              <br>

            </div>
<div class="table-responsive">
    <a href=".createRoomModal" class=" btn btn-success" data-toggle="modal"
    data-id=""><i class="material-icons" data-toggle="tooltip">انشاء شعبة جديدة</i></a>

              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget">اسم الشعبة</th>
                    <th scope="col" class="sort" data-sort="status">الصف</th>
                    <th scope="col" class="sort" data-sort="status">العام الدراسي</th>
                    <!--<th scope="col" class="sort" data-sort="status">Image</th>-->

                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list">
                @foreach ($rooms as $item)

               <tr>
                    <!--<th scope="row">-->
                    <!--{{$item->id}}-->
                    <!--</th>-->



                    <td class="budget" style="font-weight:bold;font-size:15px">

                    {{$item->name}}

                    </td>

                  <td class="budget">
                  {{$item->classes->name}}


                  </td>

                  <td class="budget">
                  {{$item->year->name}}

                  </td>

                    <!--<td>-->
                    <!--  <div class="avatar-group">-->
                    <!--    <a href="#" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="Ryan Tompson">-->
                    <!--      <img alt="Image placeholder" src="{{asset('assets/img/theme/team-1.jpg')}}">-->
                    <!--    </a>-->

                    <!--  </div>-->
                    <!--</td>-->



                    <td class="text-right">
                      <!--<div class="dropdown">-->
                      <!--  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                      <!--    <i class="fas fa-ellipsis-v"></i>-->
                      <!--  </a>-->
                      <!--  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">-->
                      <!--  <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"-->
                      <!--    data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"-->
                      <!--        title="Delete">&#xE872; Delete</i></a>-->
                      <!--    <a class="dropdown-item" href="#">Another action</a>-->
                      <!--    <a class="dropdown-item" href="#">Something else here</a>-->
                      <!--  </div>-->
                      <!--</div>-->
                    <a href=".editroomModal" class="edit"  data-class1="{{ $item->classes->id }}"
                    data-name="{{ $item->name }}"  data-id="{{ $item->id }}"  data-toggle="modal" >
                    <i class="ni ni-settings"></i>
                    
                    
                    </a>
                       
                      <a class="btn btn-primary" href="roomlessons/{{$id}}/{{$item->id}}">المواد</a>
                      <a class="btn btn-warning" href="roomteachers/{{$id}}/{{$item->id}}">المدرسين</a>

                      <a class="btn btn-success" href="roomstudent/{{$item->id}}/{{$id}}">الطلاب</a>
                    </td>


                  </tr>


               @endforeach


                </tbody>
              </table>

            </div>





            <div class="clearfix" style="padding-left:10px">
                    <div class="hint-text">Showing
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/paginate_num) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-10">
                            {{ $rooms->links() }}
                        </div>
                    </div>
                </div>













    </div>
</div>





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




                <div class="modal fade editroomModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_update" action="{{ route('admin.room_update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="room_id" id="room_id">
                                <div class="modal-header">
                                    <h4 class="modal-title">تعديل الشعبة</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>الاسم بالعربية</label>
                                        <input type="text" id="name" name="name" style="direction: rtl" class="form-control a"
                                            value=""
                                            placeholder="ضع اسما هنا" maxlength="30" required>
                                    </div>









                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                    <button class="btn btn-info">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                
                
                
                
                <div class="modal fade createRoomModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('admin.room_store') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="class_id"  value="{{ $id }}">
                                <div class="modal-header">
                                    <h4 class="modal-title">انشاء شعبة</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group" style="text-align:right">
                                        <label>اسم الشعبىة</label>
                                        <input type="text" name="room_name" class="form-control "
                                            value="" style="direction: rtl"
                                            placeholder="مثال: الشعبة الأولى" required>
                                    </div>






                                    <div class="form-group" style="text-align:right">
                                        <label>العام الدراسي</label>

                                        <select name="year_id" id="" class="form-control"
                                            style="min-height: 36px;direction: rtl" required>
                                            <option value="">اختر العام الدراسي</option>

                                        @foreach ($years as $year)

                                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                                        @endforeach

                                        </select>

                                    </div>



                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                    <button class="btn btn-info">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>


<script>
    $(document).on('click', '.edit', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('#name').val(name);
    $('#room_id').val(id);




});
</script>


@endsection
