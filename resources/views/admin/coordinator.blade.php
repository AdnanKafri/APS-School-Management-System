@extends('admin.master')
@section('style')
    <style>
    th{
        font-size: 20px;
        border: 0px  !important;
        text-align: center;
        color: black;
    }
    td{
        font-size: 17px;
        color: black;
        border: 0px !important;
        text-align: center;
    }
    tr{
        border-bottom: 1px solid #008991 !important;
        border-top: 1px solid #008991 !important;
    }
    a.page-link{
        color: #7571f9 !important;
    }
    .pagination{
        justify-content: center;
    }
    #table_xx_wrapper{
    overflow: auto;
}
.modal-header .close {
    padding: 1rem;
    margin: -1rem 18rem -1rem auto;
}
    </style>
@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم  مشرفي المدرسة</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')


@php
$about = \App\Other::find(1);
@endphp
  @php
        $school_data = \App\School_data::first();
        @endphp
<div class="modal fade" id="user_name_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" id="dvContainer">
                <div class="row">
                    <div class="col-lg-4 col-12" >
                        <img src="{{asset("storage/")}}/{{$school_data->logo}}" style="width: inherit;height: inherit;">
                    </div>
                    <div class="col-lg-8 col-12">
                        <div style="height: 5%"></div>
                        <div class="form-group" style="height: 30%">
                            <label for="" style="font-size: 30px;font-weight: 600;text-align: center;display: block;color: #001586">اسم مشرف المدرسة </label>
                            <p style="color: black;font-size: 20px;display: block;text-align: center" id="name_share"></p>
                        </div>
                        <div class="form-group" style="height: 30%">
                            <label for="" style="font-size: 30px;font-weight: 600;text-align: center;display: block;color: #001586">اسم المستخدم </label>
                            <p style="color: black;font-size: 20px;display: block;text-align: center" id="username_share"></p>
                        </div>
                        <div class="form-group" style="height: 30%">
                            <label for="" style="font-size: 30px;font-weight: 600;text-align: center;display: block;color: #001586">كلمة المرور  </label>
                            <p style="color: black;font-size: 20px;display: block;text-align: center" id="pass_share"></p>
                        </div>
                        <div style="height: 5%"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="direction: rtl;justify-content: right;">
                <a class="btn btn-info ml-2" data-dismiss="modal" style="color:#eff0f1">اغلاق</a>
                <a class="btn btn-success ml-2" id="screenshot">تنزيل</a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="update_coordinator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('coordinator_update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="coordinator_id" id="edit_coordinator_id" hidden>
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">تعديل معلومات مشرف  المدرسي</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align: right;">
                        <div class="form-group">
                            <label>الاسم الأول</label>
                            <input type="text" name="first_name" id="edit_first_name" class="form-control a" value="" placeholder="اكتب اسمك الأول" maxlength="30" style="direction:rtl" required="">
                        </div>

                        <div class="form-group">
                            <label>الكنية</label>
                            <input type="text" name="last_name" id="edit_last_name" class="form-control b" value="" placeholder="اكتب الكنية" maxlength="30" style="direction:rtl" required="">
                        </div>


                        <div class="form-group">
                            <label>تاريخ الولادة</label>
                            <input type="date" name="date_birth" id="edit_date_birth" class="form-control b" value="" style="direction:rtl" placeholder="Type last name">
                        </div>

                        <div class="form-group">
                            <label>العنوان</label>
                            <input type="text" name="address" id="edit_address" class="form-control b" value="" maxlength="100" placeholder="اكتب العنوان" style="direction:rtl">
                        </div>

                        <div class="form-group">
                            <label>الهاتف</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control b" value="" placeholder="اكتب رقم الهاتف" style="direction:rtl" maxlength="20" required="">
                        </div>

                        <div class="form-group">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" id="edit_email" class="form-control b email" value="" maxlength="50" placeholder="اكتب البريد الالكتروني " required="">
                            <span class="text-danger error validate_email"></span>
                        </div>

                        <label for="" style="float: right;">كلمة المرور</label>
                        <br>
                        <small id="alert" style="color: #f00;"></small>


                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input name="password" id="edit_password" type="password" value="" size="15" class="input form-control" id="password" placeholder="اكتب كلمة المرور"  aria-label="password" aria-describedby="basic-addon1">
                        </div>

                        <label  style="float: right;">تأكيد كلمة المرور</label>
                        <br>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input name="password_confirmation" id="edit_password_confirmation" type="password" value="" size="15"  class="input form-control" id="password-confirm" placeholder="أعد كتابة كلمة المرور" aria-label="password" aria-describedby="basic-addon1">
                        </div>

                        <div class="form-group">
                                <label for="">صورة المشرف</label>
                                <input type="file" name="image" id="edit_image" class="form-control">
                        </div>
                </div>
                <div class="modal-footer" style="text-align: right;direction: rtl;display: block;">
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</a>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="create_coordinator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('coordinator_store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5>إنشاء مشرف مدرسي</h5>
                   
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                   
                </div>

                <div class="modal-body" style="text-align: right;">
                        <div class="form-group">
                            <label>الاسم الأول باللغة العربية </label>
                            <input type="text" name="first_name" class="form-control a" value="" placeholder="اكتب اسمك الأول" maxlength="30" style="direction:rtl" required="">
                        </div>

                        <div class="form-group">
                            <label>الكنية باللغة العربية </label>
                            <input type="text" name="last_name" class="form-control b" value="" placeholder="اكتب الكنية" maxlength="30" style="direction:rtl" required="">
                        </div>
                        <div class="form-group">
                            <label>الاسم الأول بالللغة الانكليزية</label>
                            <input type="text" name="first_name_en" class="form-control a english_name" value="" placeholder="اكتب اسمك الأول" maxlength="30" style="direction:rtl" required="">
                        </div>

                        <div class="form-group">
                            <label> الكنية باللغة الانكليزية</label>
                            <input type="text" name="last_name_en" class="form-control b english_name" value="" placeholder="اكتب الكنية" maxlength="30" style="direction:rtl" required="">
                        </div>

                        <div class="form-group">
                            <label>تاريخ الولادة</label>
                            <input type="date" name="date_birth" class="form-control b" value="" style="direction:rtl" placeholder="Type last name">
                        </div>

                        <div class="form-group">
                            <label>العنوان</label>
                            <input type="text" name="address" class="form-control b" value="" maxlength="100" placeholder="اكتب العنوان" style="direction:rtl">
                        </div>

                        <div class="form-group">
                            <label>الهاتف</label>
                            <input type="text" name="phone" class="form-control b" value="" placeholder="اكتب رقم الهاتف" style="direction:rtl" maxlength="20" required="">
                        </div>

                        <div class="form-group">
                                <label for="">صورة المشرف المدرسي</label>
                                <input type="file" name="image" class="form-control">
                        </div>
                </div>
                <div class="modal-footer" style="text-align: right;direction: rtl;display: block;">
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</a>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="card" style="margin: 30px">
    <div class="card-body">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول مشرفي المدرسة</h1>
        </div>
         @can('create_coordinators')
        <button type="button" class="btn mb-1 btn-success" data-toggle="modal" data-target="#create_coordinator" style="font-size: 19px;font-weight: 600;float: right;background: #6ABAA3;border-color: #6ABAA3">إنشاء مشرف مدرسي</button>
       @endcan
        <div class="table-responsive">
            <table class="table align-items-center ">
                <thead style="color: black">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">الرقم</th>-->
                    <th scope="col" class="sort" data-sort="budget">الاسم الأول</th>
                    <th scope="col" class="sort" data-sort="status">الكنية</th>
                    <th scope="col" class="sort" data-sort="status">تاريخ الميلاد</th>
                    <th scope="col" class="sort" data-sort="completion">العنوان</th>
                    <th scope="col" class="sort" data-sort="completion">الهاتف</th>
                    <th scope="col" class="sort" data-sort="completion">الصورة </th>
                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">


            @foreach ($coordinators as $item)
               <tr>
                    <td class="budget" style="font-weight:bold; font-size:15px">
                        {{$item->first_name}}
                    </td>
                    <td class="budget" style="font-weight:bold;font-size:15px">
                        {{$item->last_name}}
                    </td>
                    <td class="budget">
                        {{$item->date_birth}}
                    </td>
                    <td class="budget">
                        {{$item->address}}
                    </td>
                    <td class="budget">
                        {{$item->phone}}
                    </td>
                    <td>
                        @if($item->image != null)
                            <div class="avatar-group">
                                <a href="#" class="avatar avatar-sm rounded-circle" style="width: 100px;height:100px;" data-toggle="tooltip" data-original-title="">
                                <img alt="Image placeholder" style="width: 100px;height:100px;" src="{{asset('storage/'.$item->image)}}"></a>
                            </div>
                        @endif
                    </td>
                    <td>

                        @can('update_coordinators')
                        <a data-id="{{ $item->id }}"
                             data-data="{{ $item }}"
                              class="edit_coordinator btn btn-info btn-sm" data-toggle="modal" data-target="#update_coordinator" title="تعديل معلومات مشرف" >
                            <i class="fa fa-eye fa-x" style="color: #eff0f1"></i>
                        </a>
                        @endcan
                         @can('Account_coordinators')
                        <a class="share_coordinator btn btn-info btn-sm"
                        data-toggle="modal" data-target="#user_name_modal"
                          data-username="{{ $item->user->email }}"
                          data-name="{{ $item->first_name." ".$item->last_name }}"
                           data-pass="{{ $item->user->view_password }}" title = "معلومات الأيميل">
                             <i class="fa fa-send fa-x" style="color: #eff0f1"></i>
                        </a>
                         @endcan
                          @can('set_coordinators')
                        <a href="{{ route('set_coordinator_task',$item->id) }} " target="_blank" class="btn btn-success ">تحديد مهام</a>
                            @endcan
                             @can('update_task_coordinators')
                        <a href="{{ route('edit_coordinator_task',$item->id) }}" target="_blank" class="btn btn-warning" style="color: white">تعديل المهام</a>
                           @endcan
                    </td>
                </tr>
               @endforeach

                </tbody>
              </table>

              <div class="bootstrap-pagination">
                {{-- <nav> --}}
                    {{ $coordinators->links() }}
                {{-- </nav> --}}
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
<script >


$(document).on("click",".share_coordinator",function () {
    $('#pass_share').text($(this).data("pass"));
    $('#username_share').text($(this).data("username"));
    $('#name_share').text($(this).data("name"));
});

$(document).on("click","#screenshot",function () {
    html2canvas(document.querySelector("#dvContainer")).then(canvas => {
		a = document.createElement('a');
		document.body.appendChild(a);
		a.download = $('#name_share').text()+".png";
		a.href =  canvas.toDataURL();
		a.click();
	});
 });


$(document).on('click','.edit_coordinator',function (e) {
    var data = $(this).data('data');

    $('#edit_coordinator_id').val(data.id);
    $('#edit_first_name').val(data.first_name);
    $('#edit_last_name').val(data.last_name);
    $('#edit_date_birth').val(data.date_birth);
    $('#edit_address').val(data.address);
    $('#edit_phone').val(data.phone);
    $('#edit_email').val(data.email);

    console.log(data.id);
});
 $(".english_name").keypress(function(event){
    var ew = event.which;
    if(ew == 32)
        return true;
    if(48 <= ew && ew <= 57)
        return true;
    if(65 <= ew && ew <= 90)
        return true;
    if(97 <= ew && ew <= 122)
        return true;
    return false;
});
</script>

@endsection
