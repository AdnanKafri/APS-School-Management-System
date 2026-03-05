@extends('admin.master')
@section('style')

<style>
.custom-file-label{
display:none !important;
}
    .custom-file-label{
        display:none;
    }
    .pagination{
        justify-content: center !important;
    }
    th{
    font-size: 20px;
    border-bottom: 1px solid #008991 !important;
    text-align: center !important;
    color: black
    }
    td{
        font-size: 17px;
        border-bottom: 1px solid #008991 !important;
        color: black;
        text-align: center !important;
    }
    button.close{
    margin: 0px !important;
    padding: 0px !important;
    float: left !important;
}
.modal-header{
    direction: rtl;
}

</style>

@endsection

@section('breadcrumbs')


<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم الشعب </a>
    <a href="{{ route('classes.manager') }}" class="breadcrumbs__item "> قسم متابعة الحصص مباشرة </a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>
@endsection

@section('content')
<div class="col" style="direction:rtl;text-align:right">
    <div class="card" style="margin: 30px">
            <!-- Card header -->
            <div class="card-header border-0" style="">
              <h3 class="mb-0" style="text-align: center;color: #001586">جدول الشعب</h3>
              <br>

            </div>
    <div class="table-responsive">

              <table class="table align-items-center table-flush">
                <thead class="">
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

                    <td class="">
                      <a class="btn btn-success" href="{{ route('workschedule_manager',$item->id) }}" style="color: white;background: #3d93e4  !important;border-color: #27b4ec !important">  البرنامج الاسبوعي</a>
                    </td>


                  </tr>


               @endforeach


                </tbody>
              </table>

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
                            <form id="form_update" action="{{ route('room_update') }}" method="POST" enctype="multipart/form-data">
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
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>





                <div class="modal fade createRoomModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('room_store') }}" enctype="multipart/form-data">
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
                                    <button class="btn btn-primary">حفظ</button>
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
