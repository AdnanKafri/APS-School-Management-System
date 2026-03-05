@extends('admin.master')

@section('style')
<style>
    *{
        direction: rtl !important;
        /* text-align: center; */
    }
    button,a{
        color: white !important;
    }
    .form-group{
        text-align: right;
    }
    label{
        font-size: 20px;
        color: black;
    }
    input{
        font-size: 17px !important;
    }
    th{
        font-size: 20px;
        border: 0px  !important;
        text-align: center;
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
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection

@section('content')


<div class="modal fade" id="update_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('teacher_update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="teacher_id" id="edit_teacher_id" hidden>
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">تعديل معلومات مدرس</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
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
                                <label for="">صورة المدرس</label>
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



<div class="modal fade" id="create_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('teacher_store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">إنشاء مدرس</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label>الاسم الأول</label>
                            <input type="text" name="first_name" class="form-control a" value="" placeholder="اكتب اسمك الأول" maxlength="30" style="direction:rtl" required="">
                        </div>

                        <div class="form-group">
                            <label>الكنية</label>
                            <input type="text" name="last_name" class="form-control b" value="" placeholder="اكتب الكنية" maxlength="30" style="direction:rtl" required="">
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
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control b email" value="" maxlength="50" placeholder="اكتب البريد الالكتروني " required="">
                            <span class="text-danger error validate_email"></span>
                        </div>

                        <label for="" style="float: right;">كلمة المرور</label>
                        <br>
                        <small id="alert" style="color: #f00;"></small>


                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input name="password" type="password" value="" size="15"  class="input form-control" id="password" placeholder="اكتب كلمة المرور" required="true" aria-label="password" aria-describedby="basic-addon1">
                        </div>

                        <label  style="float: right;">تأكيد كلمة المرور</label>
                        <br>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                            </div>
                            <input name="password_confirmation" type="password" value="" size="15"  class="input form-control" id="password-confirm" placeholder="أعد كتابة كلمة المرور" required="true" aria-label="password" aria-describedby="basic-addon1">
                        </div>

                        <div class="form-group">
                                <label for="">صورة المدرس</label>
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
            <h1 style="text-align: center;color: #001586">جدول المدرسين</h1>
        </div>
        <button type="button" class="btn mb-1 btn-success" data-toggle="modal" data-target="#create_teacher" style="font-size: 25px;font-weight: 600;float: right;background: #6ABAA3;border-color: #6ABAA3">إنشاء مدرس</button>
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


            @foreach ($teachers as $item)
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
                        <a href="{{ route('admin.teacher_schedule',$item->id) }}" >
                            <i class="fa fa-table fa-2x" style="color: #0083FF"></i>
                        </a>
                        <a data-id="{{ $item->id }}" data-data="{{ $item }}" class="edit_teacher" data-toggle="modal" data-target="#update_teacher">
                        <i class="fa fa-eye fa-2x" style="color: #008CC4"></i>
                        </a>
                    </td>
                </tr>
               @endforeach

                </tbody>
              </table>

              <div class="bootstrap-pagination">
                {{-- <nav> --}}
                    {{ $teachers->links() }}
                {{-- </nav> --}}
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')
<script>

$(document).on('click','.edit_teacher',function (e) {
    var data = $(this).data('data');

    $('#edit_teacher_id').val(data.id);
    $('#edit_first_name').val(data.first_name);
    $('#edit_last_name').val(data.last_name);
    $('#edit_date_birth').val(data.date_birth);
    $('#edit_address').val(data.address);
    $('#edit_phone').val(data.phone);
    $('#edit_email').val(data.email);

    console.log(data.id);
});
</script>

@endsection
