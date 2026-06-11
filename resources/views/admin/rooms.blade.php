@extends('admin.layouts.v2')

@section('page_title', 'الشعب')
@section('page_subtitle', 'إدارة الشعب التابعة للصف الدراسي')
@section('style')
<style>
    .class-rooms-v2 {
        direction: rtl;
        text-align: right;
    }
    .v2-bc { display:flex; align-items:center; gap:.4rem; font-size:.9rem; flex-wrap:wrap; direction:rtl; }
    .v2-bc a { color:#8a869a; font-weight:700; text-decoration:none; }
    .v2-bc a:hover { color:#5B4B8A; }
    .v2-bc .sep { color:#b2aec0; font-weight:700; }
    .v2-bc .active { color:#2f2b3a; font-weight:700; }
    .v2-section-card {
        border-radius: 18px;
        border: 1px solid rgba(91,75,138,0.12);
        box-shadow: 0 12px 32px rgba(36,30,62,0.08);
        background: #fff;
        overflow: hidden;
    }
    .v2-section-card .card-header {
        padding: 1.25rem 1.5rem !important;
        border-bottom: 1px solid rgba(91,75,138,0.1) !important;
        background: #fff !important;
    }
    .v2-section-card .card-header h3,
    .v2-section-card .card-header h2 {
        margin: 0 !important;
        font-weight: 800 !important;
        color: #2f2b3a !important;
        font-size: 1.1rem !important;
        text-align: right !important;
    }
    .v2-card-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        padding: 0 1.5rem 1rem;
    }
    .v2-card-toolbar__summary {
        color: #7b768f;
        font-size: .92rem;
        font-weight: 700;
    }
    .v2-table th {
        background: #f8f7fc !important;
        color: #2f2b3a !important;
        font-weight: 800 !important;
        font-size: .88rem !important;
        border-bottom: 2px solid rgba(91,75,138,0.1) !important;
        padding: .85rem !important;
        text-align: right !important;
        white-space: nowrap;
    }
    .v2-table td {
        vertical-align: middle !important;
        color: #3a3550 !important;
        font-size: .9rem !important;
        padding: .85rem !important;
        border-bottom: 1px solid rgba(91,75,138,0.06) !important;
        text-align: right !important;
    }
    .v2-table > tbody > tr:last-child > td { border-bottom: 0 !important; }
    .v2-table td.room-actions-cell { text-align: center !important; }
    .v2-section-card .btn { border-radius: 12px !important; font-weight: 700 !important; font-size: .85rem !important; margin-bottom: .2rem; }
    .room-actions {
        display: grid;
        grid-template-columns: repeat(2, minmax(110px, 1fr));
        gap: .5rem;
        min-width: 240px;
    }
    .room-actions .btn {
        width: 100%;
        min-height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 !important;
        padding: .55rem .75rem;
    }
    .modal .modal-content { border-radius:16px; overflow:hidden; direction:rtl; text-align:right; box-shadow:0 20px 60px rgba(0,0,0,.18); }
    .modal .modal-header { padding:1rem 1.5rem; border-bottom:1px solid #e9ecef; align-items:center; }
    .modal .modal-header h4, .modal .modal-title { font-size:1rem; font-weight:700; color:#2f2b3a; margin:0; }
    .modal .modal-body { padding:1.5rem; }
    .modal .form-group { margin-bottom:1rem; }
    .modal .form-group label { font-weight:600; color:#3a3550; margin-bottom:.4rem; display:block; }
    .modal .form-control { border-radius:8px; border-color:#d0d5dd; padding:.45rem .75rem; font-size:.9rem; }
    .modal .form-control:focus { border-color:#7B67B2; box-shadow:0 0 0 3px rgba(91,75,138,.15); }
    .modal .modal-footer {
        padding:1rem 1.5rem;
        border-top:1px solid #e9ecef;
        gap:.6rem;
        display:flex;
        flex-wrap:wrap;
        align-items:center;
        justify-content:flex-start;
    }
    .modal .modal-footer .btn { min-height:40px; min-width:100px; font-weight:600; border-radius:10px; padding:.45rem 1.1rem; }
    .pagination { justify-content:center !important; }
    button.close { margin:0 !important; padding:0 !important; }
    .custom-file-label { display:none !important; }
    @media (max-width: 991px) {
        .v2-card-toolbar { align-items: stretch; }
        .room-actions { grid-template-columns: 1fr; min-width: 0; }
    }
</style>
@endsection


@section('breadcrumbs')
<nav class="v2-bc" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}">لوحة التحكم</a>
    <span class="sep">/</span>
    <a href="{{ route('classes') }}">قسم الصفوف</a>
    <span class="sep">/</span>
    <span class="active">الشعب</span>
</nav>
@endsection


@section('content')
<div class="class-rooms-v2">
    <div class="v2-section-card" style="margin: 1.25rem;">
        <div class="card-header border-0">
          <h3 class="mb-0">جدول الشعب</h3>
        </div>
        <div class="v2-card-toolbar">
            <div class="v2-card-toolbar__summary">Showing {{ $rooms->count() }} rooms</div>
            @can('create_room')
            <a href=".createRoomModal" class="btn btn-success" data-toggle="modal" data-id=""><i class="material-icons" data-toggle="tooltip">انشاء شعبة جديدة</i></a>
            @endcan
        </div>
    <div class="table-responsive">
              <table class="table v2-table">
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

                    <!--<td>-->
                    <!--  <div class="avatar-group">-->
                    <!--    <a href="#" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="Ryan Tompson">-->
                    <!--      <img alt="Image placeholder" src="{{asset('assets/img/theme/team-1.jpg')}}">-->
                    <!--    </a>-->

                    <!--  </div>-->
                    <!--</td>-->



                    <td class="room-actions-cell">
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


                      <div class="room-actions">
                      <a class="btn btn-primary" href="{{ route('roomlessons', [$id, $item->id]) }}">المواد</a>
                      <a class="btn btn-success" href="{{ route('roomstudent', [$item->id, $id]) }}">الطلاب</a>
                      <a class="btn btn-warning" href="{{ route('roomteachers', [$id, $item->id]) }}" style="color: white;background: #0083FF;border-color: #0083FF">المدرسين</a>
                      @can('workschedule')
                      <a class="btn btn-success" href="{{ route('workschedule',$item->id) }}" style="color: white;background: #008CC4 !important;border-color: #008CC4 !important">البرنامج</a>
                      @endcan
                       @can('update_room')
                      <a href=".editroomModal" style="color: white !important;background: #0f739b !important;border-color: #0e8dbe !important"
                          class="edit btn btn-success"  data-class1="{{ $item->classes->id }}"
                          data-name="{{ $item->name }}"  data-id="{{ $item->id }}"  data-toggle="modal" >
                          {{-- <i class="ni ni-settings"></i> --}}
                              تعديل
                      </a>
                      @endcan
                        @can('delete_room')
                      <a href=".deleteRoomModal" class="delete btn btn-warning text-light " style="color: white !important;background: #09516d !important;border-color: #008CC4 !important"
                       data-name="{{ $item->name }}"  data-id="{{ $item->id }}"  data-toggle="modal" >
                        {{-- <i class="fa fa-trash" style="font-size: 30px;color: #af686e"></i> --}}
                        حذف
                    </a>
                    @endcan
                    </div>
                    </td>


                  </tr>


               @endforeach


                </tbody>
              </table>

            </div>





            <div class="clearfix" style="padding-left:10px;text-align: center">
                    <div class="hint-text">Showing
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/paginate_num) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-12">
                            {{ $rooms->links() }}
                        </div>
                    </div>
                </div>

        </div>
    </div>





               <div class="modal fade deleteEmployeeModal">
                            <div class="modal-dialog modal-dialog-centered">
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
                    <div class="modal-dialog modal-dialog-centered">
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
                                    <div class="form-group" style="text-align: right;">
                                        <label >الاسم بالعربية</label>
                                        <input type="text" id="name" name="name" style="direction: rtl" class="form-control a"
                                            value=""
                                            placeholder="ضع اسما هنا" maxlength="30" required>
                                    </div>

                                </div>

                               <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>





                <div class="modal fade createRoomModal">
                    <div class="modal-dialog modal-dialog-centered">
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

                {{-- delete room  --}}

                <div class="modal fade deleteRoomModal">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="form_delete" action="{{ route('room_delete') }}" method="POST" autocomplete="off">

                                @csrf
                                <input type="hidden" name="room_id_delete" id="room_id_delete" required>

                                <div class="modal-header" >
                                    <h4 class="modal-title" style="color: #f00">حذف شعبة</h4>
                                    <button type="button" class="close"
                                    style="color: #f00" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">

                                    <div class="form-group" style="text-align:right">
                                        <label style="font-size: 18px; font-weight:bold"> أدخل كود الحذف للتأكيد </label>


                                        <input type="password" style="direction:rtl" id="delete_code" name="delete_code" class="form-control a"
                                            value=""
                                            placeholder="أدخل كود الحذف  "  required>
                                    </div>

                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn " data-dismiss="modal">الغاء </a>
                                    <button class="btn btn-danger">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- end delete room  --}}

<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>


<script>
    $(document).on('click', '.edit', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('#name').val(name);
    $('#room_id').val(id);




});
$(document).on('click', '.delete', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('#name_delete').val(name);
    $('#room_id_delete').val(id);
});
</script>


@endsection





