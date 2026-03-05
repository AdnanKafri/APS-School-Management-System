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
    text-align: center !important;hs
    color: black
    }
    td{
        font-size: 17px;
        border-bottom: 1px solid #008991 !important;
        color: black;
        text-align: center !important;
    }


</style>

@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم النجاح والرسوب - الشعب - </a>
    <a href="{{ route('classes.graduation') }}" class="breadcrumbs__item "> قسم النجاح و الرسوب - الصفوف </a>
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
        {{-- <a href=".createRoomModal" class=" btn btn-success" data-toggle="modal"
        data-id=""><i class="material-icons" data-toggle="tooltip">انشاء شعبة جديدة</i></a> --}}

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

                    <!--<td>-->
                    <!--  <div class="avatar-group">-->
                    <!--    <a href="#" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="Ryan Tompson">-->
                    <!--      <img alt="Image placeholder" src="{{asset('assets/img/theme/team-1.jpg')}}">-->
                    <!--    </a>-->

                    <!--  </div>-->
                    <!--</td>-->



                    <td class="">

                      {{-- <a class="btn btn-primary" href="roomlessons/{{$id}}/{{$item->id}}">المواد</a> --}}
                      <a class="btn btn-success" href={{ route("room.student.graduate",[$item->id ])}}>الطلاب</a>
                    <!--  <a href=".singleRoomGraduate" style="color: white !important;background: #0f739b !important;border-color: #0e8dbe !important"-->
                    <!--      class="graduate btn btn-success"-->
                    <!--      data-name="{{ $item->name }}"  data-id="{{ $item->id }}"  data-toggle="modal" >-->
                    <!--          استصدار الجلاء-->
                    <!--  </a>-->
                    <!--  <a href=".deleteRoomGraduate" class="delete btn btn-warning text-light " style="color: white !important;background: #09516d !important;border-color: #008CC4 !important"-->
                    <!--   data-name="{{ $item->name }}"  data-id="{{ $item->id }}"  data-toggle="modal" >-->
                    <!--    تراجع عن استصدار الجلاء-->
                    <!--</a>-->
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






            <div class="modal fade singleRoomGraduate">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="" action="{{ route('class_store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header">
                                <h4 class="modal-title">استصدار الجلاء المدرسي   </h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:right">
                                    <label> سيتم استصدار الجلاء  للشعبة التالية </label>
                                    <input type="text" name="room_name" class="form-control room_name"
                                        value="" style="direction: rtl"
                                      readonly> <br>
                                      <label>يرجى الانتباه.. عند تصدير الجلاء لا يمكن التعديل على العلامات        </label>
                                    {{-- <input type="text" name="information" class="form-control"
                                    value="" style="direction: rtl;color: #c44800"
                                    placeholder="عند تصدير الجلاء لا يمكن التعديل على العلامات" readonly> --}}
                                    <input type="hidden" name="room_id" class="form-control room_id" value="" readonly>
                            </div>

                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-dark" style="color: #fff" data-dismiss="modal">الغاء</a>
                                <button class="btn btn-primary">متابعة</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>





                {{-- delete room  --}}


                <div class="modal fade deleteRoomGraduate">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="form_delete" action="{{ route('class_delete') }}" method="POST" autocomplete="off">

                                @csrf
                                <input type="hidden" name="class_id_delete" id="class_id_delete" required>

                                <div class="modal-header" >
                                    <h4 class="modal-title" style="color: #f00"> إلغاء استصدار الجلاء</h4>
                                    <button type="button" class="close"
                                    style="color: #f00" data-dismiss="modal"
                                        aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">

                                    <div class="form-group" style="text-align:right">
                                        <label style="font-size: 18px; font-weight:bold"> أدخل كود الإلغاء للتأكيد  </label>


                                        <input type="password" style="direction:rtl" id="delete_code" name="delete_code" class="form-control a"
                                            value=""
                                            placeholder="أدخل كود التأكيد  "  required>
                                    </div>

                                </div>
                                <div class="modal-footer" style="justify-content: right;">
                                    <a class="btn btn-dark" data-dismiss="modal">الغاء </a>
                                    <button class="btn btn-danger">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- end delete room  --}}

<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>


<script>
    $(document).on('click', '.graduate', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('.room_name').val(name);
    $('.room_id').val(id);




});
$(document).on('click', '.delete', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('#name_delete').val(name);
    $('#room_id_delete').val(id);
});
</script>


@endsection
