@extends('admin.master')
@section('style')
    <style>
        *{
            direction: rtl !important;
        }
        .content-body{
                min-height: auto !important;
        }
    </style>
@endsection

@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item ">قسم النسخ الاحتياطي</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item is-active">الصفحة الرئيسية</a>
</nav>

@endsection


@section('content')
    <div class="card" style="margin: 30px">


            <!-- Card header -->
            <div class="card-header border-0">
              <h2 class="mb-0" style="text-align: center;color: #001586">جدول النسخ الاحتياطية</h2>

            </div>
            <div class="table-responsive" style="text-align: right;">
                <a href="{{ route('get-backup') }}" class=" btn btn-success"
                data-id=""><i class="material-icons" data-toggle="tooltip">انشاء نسخة جديدة </i></a>
                <!--<a  class=" btn btn-success" data-toggle="modal" data-target="#modal_import" >  تبديل قاعدة البيانات </a>-->

              <table class="table align-items-center table-flush" style="text-align: center">
                <thead class="">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget">الملف</th>
                    <th scope="col" class="sort" data-sort="status">تاريخ الانشاء</th>
                    <th scope="col" class="sort" data-sort="status">العمليات </th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">
                @foreach ($backups as $item)

               <tr id="lesson_{{$item->id}}">

                    <td class="budget">
                        <a href="{{ route('zip',$item) }}"><i class="fa fa-download fa-3x"></i></a>
                  </td>

                    <td class="budget">
                    {{$item->created_at}}

                  </td>

                  <td class="budget">
                    <div class="dropdown show">
                        <a class="btn btn-danger dropdown-toggle" style="background: #F13D45;border-color: #F13D45" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          حذف
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" >لا</a>
                            <form action="{{ route('backup_del') }}" method="POST">
                                @csrf
                                <input type="text" value="{{ $item->id }}" name="id" hidden>
                                <button type="submit" class="dropdown-item" >نعم</button>
                            </form>
                        </div>
                      </div>
                  </td>

                  </tr>


               @endforeach



                </tbody>
              </table>

            </div>


<div class="modal fade" id="modal_import" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content bg-gradient-danger">
        <form id="form_delete"  action="{{ route('importedatabase') }}" method="POST">
            @csrf
            @method('post')
          <div class="modal-header">
              <h4 class="modal-title" id="modal-title-notification">تبديل قاعدة البيانات</h4>
              <a type="button" class="close" data-dismiss="modal" aria-label="Close" style="float: left;margin: 0px;padding: 0px">
                  <span aria-hidden="true" class="close">×</span>
              </a>
          </div>

          <div class="modal-body" style="text-align: right">

              <div class="py-3 text-center">
                  <i class="ni ni-bell-55 ni-3x"></i>
                  <h2 class="heading mt-4" style="color: red">! يجب ان تقرأ هذا</h2>
                  <h4>هل انت متاكد من تبديل قاعدة البيانات سوف تفقد جميع البيانات</h4>
              </div>

              <div class="form-group">
                <label class="w-25" style="font-size: 20px">قاعدة البيانات الجديدة </label>
                <input type="file" name="sql" class="form-control w-50" style="display: inline-block">
              </div>
              <div class="form-group">
                <label class="w-25" style="font-size: 20px"> كلمة المرور </label>
                <input type="text" name="password" class="form-control w-50" style="display: inline-block">
              </div>

          </div>

          <div class="modal-footer">
              <button type="submit"  class="btn btn-success "> موافق</button>
              <a class="btn btn-link text-white ml-auto" data-dismiss="modal">الغاء</a>
          </div>
        </form>
      </div>
  </div>
</div>







<div class="col-md-4" class="delete_modal">
    {{-- <button type="button" class="btn btn-block btn-warning mb-3" data-toggle="modal" data-target="#modal-notification">Notification</button> --}}
    <div class="modal fade active_result" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
  <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
      <div class="modal-content bg-gradient-danger">
        <form id="form_delete" method="POST">
            @csrf
            @method('delete')
          <div class="modal-header">
              <h6 class="modal-title" id="modal-title-notification">يرجى الانتباه</h6>
              <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="close">×</span>
              </a>
          </div>

          <div class="modal-body">

              <div class="py-3 text-center">
                  <i class="ni ni-bell-55 ni-3x"></i>
                  <h4 class="heading mt-4">! يجب ان تقرأ هذا</h4>
                  <p>هل انت متاكد من حذف هذا العنصر ؟</p>
              </div>

          </div>

          <div class="modal-footer">
              <a  class="btn btn-white delete_event" id="delete_event" data-id="" href="">نعم , موافق</a>
              <a class="btn btn-link text-white ml-auto" data-dismiss="modal">الغاء</a>
          </div>
        </form>
      </div>
  </div>
</div>

</div>



    </div>


                <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>


<script>
    $(document).on('click' , '.one' , function () {

var id=$(this).data('id');


$('.delete_event').data('id',id);

});

$(document).on('click','.delete_event',function(e){
    e.preventDefault();

    var id=$(this).data('id');

$.ajax({

    type:'post',
    url:"{{ route('backup_del') }}",
    enctype:'multipart/form-data',
    data:{
        '_token':"{{ csrf_token() }}",
        'id':id,

    },

    success:function(data){
$(`#lesson_${id}`).remove();
        $(".modal").modal('hide');

swal({
  title: "حسناً",
  text: "! تمت العملية بنجاح",
  icon: "success",
  button: "OK",
  timer: 2000

});
    },
    error: function (xhr) {

}

});


});

</script>


@endsection
