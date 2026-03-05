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
    }
    td{
        font-size: 17px;
    }
    a.page-link{
        color: #7571f9 !important;
    }
    .pagination{
        justify-content: center;
    }
    .dropdown-item{
        color: black !important;
        width: auto !important;
    }
    .fa-folder{
        margin: 2px;
    }
    .dorat{
        color: blue !important;
    }
    img{
        border-radius:50%;
    }
    /* ///////////////////////////////////// */


.wrapper{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper input[type="radio"]{
  display: none;
}
#option-1:checked:checked ~ .option-1,
#option-2:checked:checked ~ .option-2{
  border-color: #0069d9;
  background: #0069d9;
}
#option-1:checked:checked ~ .option-1 .dot,
#option-2:checked:checked ~ .option-2 .dot{
  background: #fff;
}
#option-1:checked:checked ~ .option-1 .dot::before,
#option-2:checked:checked ~ .option-2 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper .option span{
  font-size: 20px;
  color: #808080;
}
#option-1:checked:checked ~ .option-1 span,
#option-2:checked:checked ~ .option-2 span{
  color: #fff;
}








.wrapper_lang{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper_lang .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper_lang .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper_lang .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper_lang input[type="radio"]{
  display: none;
}
#option-lang1:checked:checked ~ .option-lang1,
#option-lang2:checked:checked ~ .option-lang2{
  border-color: #0069d9;
  background: #0069d9;
}
#option-lang1:checked:checked ~ .option-lang1 .dot,
#option-lang2:checked:checked ~ .option-lang2 .dot{
  background: #fff;
}
#option-lang1:checked:checked ~ .option-lang1 .dot::before,
#option-lang2:checked:checked ~ .option-lang2 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper_lang .option span{
  font-size: 20px;
  color: #808080;
}
#option-lang1:checked:checked ~ .option-lang1 span,
#option-lang2:checked:checked ~ .option-lang2 span{
  color: #fff;
}

th{
    font-size: 20px;
    border-bottom: 1px solid #008991 !important;
    text-align: center !important;
}
td{
    font-size: 17px;
    border-bottom: 1px solid #008991 !important;
    color: black;
    text-align: center;
}
input:read-only {
  color: black !important;
  font-size: 17px !important;
}
#table_xx_wrapper{
    overflow: auto;
}
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection

@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم قبول الطلاب</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')


<!------------------------------------------------>

<div class="modal fade createStudentModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">معلومات الطالب</h4>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="form-group col-12 col-lg-6">
                        <label>الإسم الأول</label>
                        <input readonly type="text" id="edit_first_name" class="form-control a" style="direction:rtl"
                            value="" maxlength="20"
                            placeholder="الإسم الأول" required>
                    </div>

                    <div class="form-group col-12 col-lg-6">
                        <label>الكنية</label>
                        <input readonly type="text" id="edit_last_name" class="form-control b"
                            value="" maxlength="20"style="direction:rtl"
                            placeholder="الكنية" required>
                    </div>

                    <div class="form-group col-12 col-lg-6">
                        <label>اسم الأب </label>
                        <input readonly type="text" id="edit_father_name" class="form-control b"
                            value="" maxlength="20"style="direction:rtl"
                            placeholder="اسم الأب " required>
                    </div>

                    <div class="form-group col-12 col-lg-6">
                        <label>اسم الأم</label>
                        <input readonly type="text" id="edit_mother_name" class="form-control b"
                            value="" maxlength="20"style="direction:rtl"
                            placeholder="اسم الأم" >
                    </div>
                     {{-- <div class="form-group col-12 col-lg-6">
                        <label>كنية الأم</label>
                        <input readonly type="text" id="edit_last_mother_name" class="form-control b"
                            value="" maxlength="20"style="direction:rtl"
                            placeholder="كنية الأم" >
                    </div> --}}




                    <div class="form-group col-12 col-lg-6">
                        <label>تاريخ الولادة</label>
                        <input readonly type="date" id="edit_date_birth" class="form-control b"
                            value=""style="direction:rtl"
                            placeholder="تاريخ الولادة" >
                    </div>
                    {{-- <div class="form-group col-12 col-lg-6">
                        <label>مكان الولادة
                           </label>
                        <input readonly type="text" id="edit_place" class="form-control b"style="direction:rtl"
                            value="" maxlength="100"
                            placeholder="مكان الولادة">
                    </div> --}}
                    {{-- <div class="form-group col-12 col-lg-6">
                        <label> الجنس
                           </label>
                        <input readonly type="text" id="edit_gender" class="form-control b"style="direction:rtl"
                            value="" maxlength="100"
                            placeholder="الجنس">
                    </div> --}}
                    <div class="form-group col-12 col-lg-6">
                        <label> الديانة
                           </label>
                        <input readonly type="text" id="edit_religion" class="form-control b"style="direction:rtl"
                            value="" maxlength="100"
                            placeholder="الديانة ">
                    </div>
                    {{-- <div class="form-group col-12 col-lg-6">
                        <label> الجنسية
                           </label>
                        <input readonly type="text" id="edit_nationality" class="form-control b"style="direction:rtl"
                            value="" maxlength="100"
                            placeholder="الجنسية">
                    </div> --}}
                    {{-- <div class="form-group col-12 col-lg-6">
                        <label> رقم جواز السفر
                           </label>
                        <input readonly type="text" id="edit_pas_number" class="form-control b"style="direction:rtl"
                            value="" maxlength="100"
                            placeholder="رقم جواز السفر">
                    </div> --}}
                    {{-- <div class="form-group col-12 col-lg-6">
                        <label>   الرقم الوطني
                           </label>
                        <input readonly type="text" id="edit_number" class="form-control b"style="direction:rtl"
                            value="" maxlength="100"
                            placeholder="الرقم الوطني">
                    </div> --}}
                    <div class="form-group col-12 col-lg-6">
                        <label>البريد الالكتروني</label>
                        <input readonly type="text" id="edit_email" class="form-control b"
                            value=""style="direction:rtl"
                            placeholder="البريد الالكتروني" >
                    </div>

                    <div class="form-group col-12 col-lg-6">
                        <label>البلد </label>
                        <input readonly type="text" id="edit_address" class="form-control b"style="direction:rtl"
                            value="" maxlength="100"
                            placeholder="البلد">
                    </div>
                    {{-- <div class="form-group col-12 col-lg-6">
                        <label>المدينة </label>
                        <input readonly type="text" id="edit_city" class="form-control b"style="direction:rtl"
                            value="" maxlength="100"
                            placeholder=" المدينة ">
                    </div> --}}


                    <div class="form-group col-12 col-lg-6">
                        <label>الهاتف</label>
                        <input readonly type="text" id="edit_phone" class="form-control b"style="direction:rtl"
                            value="" maxlength="20"
                            placeholder="الهاتف" >
                    </div>
                    {{-- <div class="form-group col-12 col-lg-6">
                        <label>   الهاتف 2  </label>
                        <input readonly type="text" id="edit_other_phone" class="form-control b"style="direction:rtl"
                            value="" maxlength="20"
                            placeholder="الهاتف الذي ينوب عن الأهل" >
                    </div> --}}



                    <div class="form-group col-12 col-lg-6">
                        <label>الصف</label>
                        <input readonly type="text" id="edit_calss2" class="form-control b"style="direction:rtl"
                            value="" maxlength="20" >
                    </div>







                    <!--<div class="form-group col-12 col-lg-6">-->
                    <!--</div>-->

                    <div style="display:none;text-align: center" class="form-group col-12 col-lg-6 ">
                        <label style="text-align:center;display:block" >الصورة الشخصية</label>
                        <a href="" id="edit_personal_image" target="_blank">
                            <img style="border-radius: 0%;" width="200" src="" alt="" >
                        </a>
                    </div>

                    <div style="display:none;text-align: center" class="form-group col-12 col-lg-6 ">
                        <label style="text-align:center;display:block" >دفتر العائلة</label>
                        <a href="" id="edit_family_book" target="_blank">
                            <img style="border-radius: 0%;" width="200" src="" alt="" >
                        </a>
                    </div>

                    <div style="display:none;text-align: center" class="form-group col-12 col-lg-6 ">
                        <label style="text-align:center;display:block" >هوية الأم</label>
                        <a href="" id="edit_mother_image" target="_blank">
                            <img style="border-radius: 0%;" width="200" src="" alt="" >
                        </a>
                    </div>

                    <div style="display:none;text-align: center" class="form-group col-12 col-lg-6 ">
                        <label style="text-align:center;display:block" >هوية الأب</label>
                        <a href="" id="edit_father_image" target="_blank">
                            <img style="border-radius: 0%;" width="200" src="" alt="" >
                        </a>
                    </div>

                    <div style="display:none;text-align: center" class="form-group col-12 col-lg-6 ">
                        <label style="text-align:center;display:block" >اخراج قيد</label>
                        <a href="" id="edit_fourth_image" target="_blank">
                            <img style="border-radius: 0%;" width="200" src="" alt="" >
                        </a>
                    </div>

                    <div style="display:none;text-align: center" class="form-group col-12 col-lg-6 ">
                        <label style="text-align:center;display:block" >جواز السفر</label>
                        <a href="" id="edit_passbord" target="_blank">
                            <img style="border-radius: 0%;" width="200" src="" alt="" >
                        </a>
                    </div>

                    <div style="display:none;text-align: center" class="form-group col-12 col-lg-6 ">
                        <label style="text-align:center;display:block" > صورة جواز سفر الام</label>
                        <a href="" id="edit_mather_page" target="_blank">
                            <img style="border-radius: 0%;" width="200" src="" alt="" >
                        </a>
                    </div>

                    <div style="display:none;text-align: center" class="form-group col-12 col-lg-6 ">
                        <label style="text-align:center;display:block" > صورة جواز سفر الاب </label>
                        <a href="" id="edit_father_page" target="_blank">
                            <img style="border-radius: 0%;" width="200" src="" alt="" >
                        </a>
                    </div>

                    <div style="display:none;text-align: center" class="form-group col-12 col-lg-6 ">
                        <label style="text-align:center;display:block" >تسلسل دراسي</label>
                        <a href="" id="edit_study_sequence" target="_blank">
                            <img style="border-radius: 0%;" width="200" src="" alt="" >
                        </a>
                    </div>

                    <div style="display:none;text-align: center" class="form-group col-12 col-lg-6 ">
                        <label style="text-align:center;display:block" >اخر شهادة</label>
                        <a href="" id="edit_certification" target="_blank">
                            <img style="border-radius: 0%;" width="200" src="" alt="" >
                        </a>
                    </div>

                    <div style="display:none;text-align: center" class="form-group col-12 col-lg-6 ">
                        <label style="text-align:center;display:block" >شهادة التاسع</label>
                        <a href="" id="edit_certification_nine" target="_blank">
                            <img style="border-radius: 0%;" width="200" src="" alt="" >
                        </a>
                    </div>


                    <hr style="width: 100%;border-width: 3px">
                    <form action="{{ route('approve_student') }}" method="post" class="w-100">
                        @csrf
                        <input type="text" name="student_id" id="studentreg_id" hidden>
                        <div class="row">
                            @can('accept_register')
                            <div style="text-align: center" class="form-group col-12 col-lg-6 ">
                                <label style="text-align:center;display:block" >الصف</label>
                                <select name="class_id" id="approve_class_id" class="form-control w-75" style="display: inline-block;" required>
                                    <option value="">اختر صف</option>
                                    @foreach ($classes as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="text-align: center" class="form-group col-12 col-lg-6 " >
                                <label style="text-align:center;display:block" >الشعبة</label>
                                <select name="room_id" id="approve_room_id" class="form-control w-75" style="display: inline-block;" required>

                                </select>
                            </div>
                            <div class="col-12" style="text-align: center">

                                <input type="submit" class="btn btn-success" value="قبول" style="color:white !important;">

                            </div>
                              @endcan
                        </div>
                    </form>




                    {{-- <div class="form-group col-12 ">
                        <label>ملاحظة</label>
                        <textarea id="edit_note" cols="30" rows="5"></textarea>
                    </div> --}}

                    </div>
                </div>
                <div class="modal-footer" style="justify-content: right">
                    <a class="btn btn-primary" data-dismiss="modal" style="float: right">الغاء</a>
                </div>
            </div>
        </div>
    </div>



<div class="modal fade financialaccountModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('invoice_store') }}" enctype="multipart/form-data">
                @csrf

                <div class="modal-header" style="direction:rtl">
                    <h4 class="modal-title">الحساب المالي  &nbsp; <span class="student_name" style="font-weight: bold; font-size: 20px"></span></h4>

                    <a  target="_blanke" class="btn btn-danger btn-sm details" style="    margin-right: 10rem;">تفاصيل</a>


                    <button type="button" class="close" style="margin: -1rem -1rem auto;" data-dismiss="modal"
                        aria-hidden="true">&times;</button>


                </div>
                <div class="modal-body">


                    <input type="hidden" name="student_id" id="student_financial_id">
                    <input type="hidden" name="class_id" id="class_id">

                    <div class="row" style="text-align: center">
                        <div class="col-4">
                            <label style="font-weight: bold; font-size: 18px; " class="text-primary">الكامل</label>

                        </div>

                        <div class="col-4">
                            <label style="font-weight: bold; font-size: 18px; " class="text-success"> المدفوع</label>
                        </div>
                        <div class="col-4">
                            <label style="font-weight: bold; font-size: 16px; " class="text-warning"> المتبقي</label>

                        </div>
                    </div>

                    <div class="row" style="text-align: center">
                        <div class="col-4">
                            <label  style="padding: 20px;font-size: 20px" id="full_account" class="badge badge-primary"></label>
                        </div>

                        <div class="col-4">
                            <label for="" style="padding: 20px;font-size: 20px" class="badge badge-success" id="amount_paid"></label>

                        </div>

                        <div class="col-4">
                            <label for="" style="padding: 20px;font-size: 20px" class="badge badge-warning" id="remaining_account"></label>

                        </div>
                    </div>

                    <br>

                    <button type="button" class="btn btn-primary btn-block add_reciept" data-toggle="collapse" data-target="#demo"> اضافة فاتورة</button>
                    <div id="demo" class="collapse">

                        <br>

                        <div class="form-group" style="text-align:right">
                            <label>رقم الفاتورة</label>
                            <input type="text" name="invoice_number" class="form-control b"
                                value="" maxlength="20"
                              >
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label>المبلغ المدفوع</label>
                            <input type="number" name="invoice_amount" class="form-control" id="invoice_amount"
                                value=""
                              >
                        </div>

                        <div class="modal-footer">
                            <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                            <button class="btn btn-info" >حفظ</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade deleteStudentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{route('delete_student_request')}}" enctype="multipart/form-data">
                @csrf

                <div class="modal-header" style="direction:rtl">
                    <h4 class="modal-title">  حذف طلب التسجيل   &nbsp; <span class="student_name" style="font-weight: bold; font-size: 20px"></span></h4>

                    <button type="button" class="close" style=" margin: -1rem -1rem auto;" data-dismiss="modal"
                        aria-hidden="true">&times;</button>

                </div>
                <div class="modal-body">

                        <input type="hidden" name="student_id_delete" id="student_id_delete">
                        <div class="form-group" style="text-align:right">
                            <label> اسم مقدم الطلب</label>
                            <input type="text" name="" class="form-control" id="student_name_delete" value="">
                        </div>

                        <div class="modal-footer">
                            <a class="btn btn-default" data-dismiss="modal">إالغاء</a>
                            <button class="btn btn-info" >تأكيد</button>
                        </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade deleteSelectedStudentModal">
    <div class="modal-dialog">
        <div class="modal-content">


                <div class="modal-header" style="direction:rtl">
                    <h2 class="modal-title">  حذف طلبات التسجيل المحددة  &nbsp; <span class="student_name" style="font-weight: bold; font-size: 20px"></span></h2>

                    <button type="button" class="close" style=" margin: -1rem -1rem auto;" data-dismiss="modal"
                        aria-hidden="true">&times;</button>

                </div>
                <div class="modal-body">

                        <input type="hidden" name="student_id_delete" id="student_id_delete">

                        <div class="form-group" style="text-align:right">
                            <label> سيتم حذف  الطلبات التالية  </label>
                            <ul role="list" class="selectd_student_ul" ></ul>
                        </div>

                        <div class="modal-footer" >
                            <button class="btn btn-danger btn-block go-ahead"  >تأكيد</button>
                            <button class="btn btn-dark btn-block   " data-dismiss="modal" style="margin-top: 0 !important;margin-right:5px">إالغاء</button>
                        </div>
                </div>

        </div>
    </div>
</div>


<div class="card" style="margin: 30px">
    <div class="card-body">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول قبول الطلاب</h1>
             @can('delete_register')
            <a class="delete_selected_student btn btn-danger btn-sm"  data-target=".deleteSelectedStudentModal" data-toggLe="modal"
            style="padding-right:8px !important;font-size:22px;float:right;visibility:hidden;background:#e15b5bdb !important ">
                حذف الطلبات المحددة
            </a>
              @endcan
              <form method="POST" action="{{route('export_register_student')}}" enctype="multipart/form-data">

                @csrf
                <div class="export">

                </div>

                 <button type="submit" class="export_selected_student btn btn-success"
            style="padding-right:8px !important;font-size:22px; visibility:hidden;">
                  تصدير الطلبات المحددة
            </button>

            </form>

            <br>
              <button  class="select_all btn "
                    style="color: black !important;
                    visibility: hidden;
                    padding-right: 8px !important;
                    background: #f0f8ff08;
                    border: 1px dashed;">
                    تحديد الكل
            </button>
            {{-- <div class="row" >
                <div class="col-12 col-lg-3">
                    <select  id="filter_class"  class="form-control" >

                                <option style="text-align: center;" value="">اختر الصف</option>
                              <option style="text-align: center;" value="1">  الصف الاول  </option>
                              <option style="text-align: center;" value="2" >  الصف الثاني  </option>
                              <option style="text-align: center;" value="3" >  الصف الثالث  </option>
                              <option style="text-align: center;" value="4" >  الصف الرابع  </option>
                              <option style="text-align: center;" value="5" >  الصف الخامس  </option>
                              <option style="text-align: center;" value="6" >  الصف السادس  </option>
                              <option style="text-align: center;" value="7" >  الصف السابع  </option>
                              <option style="text-align: center;" value="8" >  الصف الثامن  </option>
                              <option style="text-align: center;" value="9" >   الصف العاشر  </option>
                              <option style="text-align: center;" value="11" >  الصف الحادي عشر  </option>
                              <option style="text-align: center;" value="12">  الصف الثاني عشر  </option>

                    </select>
                </div>

            </div> --}}
        </div>
        <div class="m-4">
            <form action="{{ route('delete_multiple_student') }}" class="multiple-select-form" method="POST">
                @csrf
                <table class="table align-items-center" id="table_xx">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="budget">تحديد </th>
                             <th scope="col" class="sort" data-sort="budget">ترتيب التسجيل  </th>
                            <th scope="col" class="sort" data-sort="budget">الإسم الأول</th>
                            <th scope="col" class="sort" data-sort="status">الكنية</th>
                           <th scope="col" class="sort" data-sort="status">تاريخ التسجيل</th>
                            <th scope="col" class="sort" data-sort="status">وقت التسجيل</th>
                            <th scope="col" class="sort" data-sort="completion">العمليات</th>
                        </tr>
                    </thead>
                    <tbody >

                    </tbody>
                </table>
            </form>

        </div>
    </div>
</div>

@endsection

@section('js')
<script>
  var i=0;
    var v=0;
var x=[];
var obj ={ };
var obj1={ };
var table_test = $('#table_xx').DataTable({
        processing: true,
        oLanguage: {
            sProcessing: "<h1>Proccessing</h1>"
        },
        serverSide: true,
        "pageLength": 10,
        "ajax": {
            "type": "GET",
            "url": "{{ route('getstudentsapprove') }}",
            "type": "GET",
            data : function (d) {
                d.class_id = $('#filter_class').val();
                d.current_class= $('#filter_current').val();
            },
            "dataSrc": function (json) {
                console.log(json.aaData);
                return json.aaData;
            }
        },
        columns: [
             {
                data: 'id',
                render: function (data, type, full) {
                    return `<input type="checkbox" name="selected_stu[]" class="checkStudent" style="margin-left:8px" value="${full.id2}" data-name="${full.first_name+ ' '+ full.last_name}">
                            <i class="fas fa-user-alt"></i>
                    `;
                },
                orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                      if(( full.id in obj)!=true ){
                        obj[full.id]=i+1;

                        }


                    return `${full.id}`;
                },
                orderable : false
            },
            {

                data: 'id',
                render: function (data, type, full) {
                    return `

                            ${full.first_name}`;
                }
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.last_name}`;
                }
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.date2}`;
                }
            },
             {
                data: 'id',
                render: function (data, type, full) {
                    v=full.id;
                    return `${full.time}`;
                },
                 orderable : false
            },

            {
                data: 'id',
                render: function (data, type, full) {
                    return `
                        <a class="detail_student btn" data-data='${JSON.stringify(full)}' data-target=".createStudentModal" data-toggLe="modal" style="padding-left:8px !important;font-size:22px ">
                            <i class="fa fa-eye fa-x" style="color: #008CC4"></i>
                        </a>
                        @can('delete_register')
                        <a class="delete_student btn" data-data='${JSON.stringify(full)}' data-target=".deleteStudentModal" data-toggLe="modal" style="padding-right:8px !important;font-size:22px  ">
                            <i class="fa fa-trash fa-x" style="color: #e15b5bdb"></i>
                        </a>
                          @endcan
                    `;
                },
                orderable : false
            },

        ]
    });

        $('#filter_class').change(function () {
                table_test.draw();
        })
        $('#filter_current').keyup(function () {
                table_test.draw();
        })


    // table_test.on('order.dt search.dt', function () {
    //     let i = 1;

    //     table_test.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
    //         this.data(i++);
    //     });
    // }).draw();


    $(document).on('change', '#approve_class_id', function () {
        var class_id = $(this).val();
        var url = "{{ URL::to('SMT/admin/classes/rooms') }}/" + class_id ;
        var type="";
        $(this).addClass('w');
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data)  {
                console.log(data);
                $('#approve_room_id').empty();
                $.each(data, function (key, value) {
                    $('#approve_room_id').prepend(`<option value="${value.id}">${value.name}</option>`);
                });
            },
        });

    })


    $(document).on('change','.checkStudent',function(){
        // $(".checkbox").change(function() {
            if(this.checked) {
                let name = $(this).data('name');
                let id = $(this).val();
            $('.delete_selected_student').css('visibility','visible');
             $('.export_selected_student').css('visibility','visible');
               $('.select_all').css('visibility','visible');


            $('.selectd_student_ul').append(`
                <li id="${id}" style="list-style: inside;"> ${name}</li>
            `);
             $('.export').append(`
              <input class="${id}" type="text" hidden name="student[]" value="${id}">
            `);
             $('.export_selected_student').removeAttr('disabled');


            }else{
                  let id = $(this).val();
                  $(`#${id}`).remove() ;
                   $(`.${id}`).remove() ;
                  if ( $('input.checkStudent:checked').length < 1 ){
                    $('.delete_selected_student').css('visibility','hidden')
                  }
                  if ( $('input.checkStudent:checked').length < 1 ){

                    $('.export_selected_student').css('visibility','hidden')
                     $('.select_all').css('visibility','hidden')
                  }
                   $('.export_selected_student').removeAttr('disabled');

            }


    });


   $(document).on('click','.select_all',function(){
      $.each($('input.checkStudent'), function (key, value) {

        this.setAttribute("checked", ""); // For IE
this.removeAttribute("checked"); // For other browsers
this.checked = false;

      })

      $.each($('input.checkStudent'), function (key, value) {
        let name = $(value).data('name');
        let id = $(value).val();
        this.setAttribute("checked", "checked");
        this.checked = true;
        $('.selectd_student_ul').append(`
                <li id="${id}" style="list-style: inside;"> ${name}</li>
            `);
             $('.export').append(`
              <input class="${id}" type="text" hidden name="student[]" value="${id}">
            `);
             $('.export_selected_student').removeAttr('disabled');

      })


    });
  $(document).on('click','.export_selected_student',function(){
        $(this).removeAttr('disabled');
    });
    $(document).on('click','.go-ahead',function(){
        $('.multiple-select-form').submit();
    });

    $(document).on('click','.detail_student',function(){
        var data = $(this).data("data");

        $('#edit_certification_nine').parent().hide();
        $('#edit_certification').parent().hide();
        $('#edit_study_sequence').parent().hide();
        $('#edit_father_page').parent().hide();
        $('#edit_mather_page').parent().hide();
        $('#edit_passbord').parent().hide();
        $('#edit_fourth_image').parent().hide();
        $('#edit_father_image').parent().hide();
        $('#edit_mother_image').parent().hide();
        $('#edit_family_book').parent().hide();
        $('#edit_personal_image').parent().hide();


        $('#studentreg_id').val(data.id);
        $('#studentpro_id').val(data.id);
        $('#edit_first_name').val(data.first_name);
        $('#edit_last_name').val(data.last_name);
        $('#edit_father_name').val(data.father_name);
        $('#edit_father_phone').val(data.father_phone);
        $('#edit_mother_name').val(data.mather_name);
        $('#edit_mother_phone').val(data.mather_phone);
        $('#edit_mother_job').val(data.mather_job);
        $('#edit_father_job').val(data.father_job);
        $('#edit_email').val(data.email);
        $('#edit_phone').val(data.phone);
         $('#edit_last_mother_name').val(data.last_mother_name);
        $('#edit_date_birth').val(data.date);
        if(data.country == "AF")
         country=  'Afghanistan';
     else if(data.country == "AX")
     country='Aland Islands';
    else if(data.country == "AL")
    country='Albania';
    else if(data.country == "DZ")
    country='Algeria';
    else if(data.country == "AS")
     country='American Samoa';
    else if(data.country == "AD")
             country='Andorra';
            else if(data.country == "AO")
            country='Angola';

            else if(data.country == "AI")
            country='Anguilla';

            else if(data.country == "AQ") country=
        'Antarctica';
            else if(data.country == "AG") country=
        'Anguilla';
            else if(data.country == "AR") country=
        'Argentina'
      else if(data.country == "AW") country=
      'Aruba';
      else if(data.country == "AM") country=
      'Armenia';
        else if(data.country == "AU") country=
      'Australia';
        else if(data.country == "AT") country=
      'Austria';
       else if(data.country == "AZ") country=
      'Azerbaijan';
         else if(data.country == "BS") country=
      'Bahamas';
       else if(data.country == "BH") country=
      'Bahrain';
       else if(data.country == "BD") country=
      'Bangladesh';
       else if(data.country == "BB") country=
      'Barbados';
           else if(data.country == "BY") country=
      'Belarus';
        else if(data.country == "BE") country=
      'Belgium';
             else if(data.country == "BZ") country=
      'Belize';
         else if(data.country == "BJ") country=
      'Benin';
       else if(data.country == "BM") country=
      'Bermuda';
        else if(data.country == "BT") country=
      'Bhutan';
       else if(data.country == "BO") country=
      'Bolivia';
           else if(data.country == "BQ") country='Bonaire, Sint Eustatius and Saba';
         else if(data.country == "BA") country=
     'Bosnia and Herzegovina';
 else if(data.country == "BW") country=
    'Botswana';
     else if(data.country == "BV") country=
    'Bouvet Island';
         else if(data.country == "BR") country=
    'Brazil';
      else if(data.country == "IO") country=
   'British Indian Ocean Territory';
     else if(data.country == "BN") country=
 'Brunei Darussalam';
    else if(data.country == "BG") country=
'Bulgaria';
  else if(data.country == "BF") country=
'Burkina Faso';
  else if(data.country == "BI") country=
'Burundi';
  else if(data.country == "KH") country=
'Cambodia';
  else if(data.country == "CM") country=
'Cameroon';
 else if(data.country == "CA") country=
'Canada';
 else if(data.country == "CV") country=
'Cape Verde';
 else if(data.country == "KY") country=
'Cayman Islands';
 else if(data.country == "CF") country=
'Central African Republic';
 else if(data.country == "TD") country=
'Chad';
else if(data.country == "CL") country=
'Chile';
else if(data.country == "CN") country=
'China';
else if(data.country == "CX") country=
'Christmas Island';
else if(data.country == "CC") country=
'Cocos (Keeling) Islands';
else if(data.country == "CO") country=
'Colombia';
else if(data.country == "KM") country=
'Comoros';
else if(data.country == "CG") country=
'Congo';
else if(data.country == "CD") country=
'Congo, Democratic Republic of the Congo';
else if(data.country == "CK") country=
'Cook Islands';
else if(data.country == "CR") country=
'Costa Rica';
else if(data.country == "CI") country=
"Cote D'Ivoire";
else if(data.country == "HR") country=
'Croatia';
else if(data.country == "CU") country=
'Cuba';
else if(data.country == "CW") country=
'Curacao';
else if(data.country == "CY") country=
'Cyprus';
else if(data.country == "CZ") country=
'Czech Republic';
else if(data.country == "DK") country=
'Denmark';
else if(data.country == "DJ") country=
'Djibouti';
else if(data.country == "DM") country=
'Dominica';
else if(data.country == "DO") country=
'Dominican Republic';
else if(data.country == "EC") country=
'Ecuador';
else if(data.country == "EG") country=
'Egypt';
   else if(data.country == "SV") country=
'El Salvador';
   else if(data.country == "GQ") country=
'Equatorial Guinea';
   else if(data.country == "ER") country=
'Eritrea';
     else if(data.country == "EE") country=

'Estonia';
else if(data.country == "ET") country=
'Ethiopia';
 else if(data.country == "FK") country=
'Falkland Islands (Malvinas)';
else if(data.country == "FO") country=
'Faroe Islands';
else if(data.country == "FJ") country=
'Fiji';
else if(data.country == "FI") country=
'Finland';
else if(data.country == "FR") country=
'France';
else if(data.country == "GF") country=
'French Guiana';
else if(data.country == "PF") country=
'French Polynesia';
else if(data.country == "TF") country=
'French Southern Territories';
else if(data.country == "GA") country=
'Gabon';
else if(data.country == "GM") country=
'Gambia';
else if(data.country == "GE") country=
'Georgia';
else if(data.country == "DE") country=
'Germany';
else if(data.country == "GH") country=
'Ghana';
else if(data.country == "GI") country=
'Gibraltar';
else if(data.country == "GR") country=
'Greece';
else if(data.country == "GL") country=
'Greenland';
   else if(data.country == "GD") country=
'Grenada';
else if(data.country == "GP") country=
'Guadeloupe';
else if(data.country == "GU") country=
'Guam';
else if(data.country == "GT") country=
'Guatemala';
else if(data.country == "GG") country=
'Guernsey';
else if(data.country == "GN") country=
'Guinea';
else if(data.country == "GW") country=
'Guinea-Bissau';
else if(data.country == "GY") country=
'Guyana';
else if(data.country == "HT") country=
'Haiti';
else if(data.country == "HN") country=
'Honduras';
else if(data.country == "HM") country=
'Heard Island and Mcdonald Islands';
else if(data.country == "VA") country=
'Holy See (Vatican City State)';
else if(data.country == "HK") country=
'Hong Kong';
else if(data.country == "HU") country=
'Hungary';
else if(data.country == "IS") country=
'Iceland';
else if(data.country == "IN") country=
'India';
else if(data.country == "ID") country=
'Indonesia';
else if(data.country == "IR") country=
'Iran, Islamic Republic of';
else if(data.country == "IQ") country=
'Iraq';
else if(data.country == "IE") country=
'Ireland';
else if(data.country == "IM") country=
'Isle of Man';
else if(data.country == "IL") country=
'Israel';
else if(data.country == "IT") country=
'Italy';
else if(data.country == "JM") country=
'Jamaica';
  else if(data.country == "JP") country=
'Japan';
  else if(data.country == "JE") country=
'Jersey';
  else if(data.country == "JO") country=
'Jordan';
   else if(data.country == "KZ") country=
'Kazakhstan';
else if(data.country == "KE") country=
'Kenya';
else if(data.country == "KI") country=
'Kiribati';
else if(data.country == "KP") country=
"Korea, Democratic People's Republic of";
else if(data.country == "KR") country=
'Korea, Republic of';
else if(data.country == "XK") country=
'Kosovo';
else if(data.country == "KW") country=
'Kuwait';
else if(data.country == "KG") country=
'Kyrgyzstan';
else if(data.country == "LA") country=
"Lao People's Democratic Republic";
else if(data.country == "LV") country=
'Latvia';
else if(data.country == "LB") country=
'Lebanon';
else if(data.country == "LC") con_sch=
'Saint Lucia';
else if(data.country == "LS") country=
'Lesotho';
else if(data.country == "LR") country=
'Liberia';
else if(data.country == "LY") country=
'Libyan Arab Jamahiriya';
else if(data.country == "LI") country=
'Liechtenstein';
else if(data.country == "LT") country=
'Lithuania';
else if(data.country == "LU") country=
'Luxembourg';
else if(data.country == "MO") country=
'Macao';
else if(data.country == "MK") country=
'Macedonia, the Former Yugoslav Republic of';
else if(data.country == "MG") country=
'Madagascar';
else if(data.country == "MW") country=
'Malawi';
else if(data.country == "MY") country=
'Malaysia';
else if(data.country == "MV") country=
'Maldives';
else if(data.country == "ML") country=
'Mali';
else if(data.country == "MT") country=
'Malta';
else if(data.country == "MH") country=
'Marshall Islands';
else if(data.country == "MQ") country=
'Martinique';
else if(data.country == "MR") country=
'Mauritania';
else if(data.country == "MU") country=
'Mayotte';
else if(data.country == "MX") country=
'Mexico';
else if(data.country == "FM") country=
'Micronesia, Federated States of';
 else if(data.country == "MD") country=
'Moldova, Republic of';
else if(data.country == "MC") country=
'Monaco';
else if(data.country == "MN") country=
'Mongolia';
else if(data.country == "ME") country=
'Montenegro';

else if(data.country == "MS") country=
'Montserrat';

else if(data.country == "MA") country=
'Morocco';
else if(data.country == "MZ") country=
'Mozambique';
else if(data.country == "MM") country=
'Myanmar';
else if(data.country == "NA") country=
'Namibia';
else if(data.country == "NR") country=
'Nauru';
else if(data.country == "NP") country=
'Nepal';
else if(data.country == "NL") country=
'Netherlands';
else if(data.country == "AN") country=
'Netherlands Antilles';
else if(data.country == "NC") country=
'New Caledonia';
else if(data.country == "NZ") country=
'New Zealand';
else if(data.country == "NI") country=
'Nicaragua';
else if(data.country == "NE") country=
'Niger';
else if(data.country == "NG") country=
'Nigeria';
else if(data.country == "NU") country=
'Niue';
else if(data.country == "NF") country=
'Norfolk Island';
else if(data.country == "MP") country=
'Northern Mariana Islands';
else if(data.country == "NO") country=
'Norway';
else if(data.country == "OM") country=
'Oman';
else if(data.country == "PK") country=
'Pakistan';
else if(data.country == "PW") country=
'Palau';
else if(data.country == "PS") country=
'Palestinian Territory, Occupied';
else if(data.country == "PA") country=
'Panama';
else if(data.country == "PG") country=
'Papua New Guinea';
else if(data.country == "PY") country=
'Paraguay';
else if(data.country == "PE") country=
'Peru';
else if(data.country == "PH") country=
'Philippines';
else if(data.country == "PN") country=
'Pitcairn';
else if(data.country == "PL") country=
'Poland';
else if(data.country == "PT") country=
'Portugal';
else if(data.country == "PR") country=
'Puerto Rico';
else if(data.country == "QA") country=
'Qatar';
else if(data.country == "RE") country=
'Reunion';
else if(data.country == "RO") country=
'Romania';
else if(data.country == "RU") country=
'Russian Federation';
else if(data.country == "RW") country=
'Rwanda';
else if(data.country == "BL") country=
'Saint Barthelemy';
else if(data.country == "SH") country=
'Saint Helena';
else if(data.country == "KN") country=
'Saint Kitts and Nevis';
else if(data.country == "SH") country=
'Saint Lucia';
else if(data.country == "MF") country=
'Saint Martin';
else if(data.country == "PM") country=
'Saint Pierre and Miquelon';
else if(data.country == "VC") country=
'Saint Vincent and the Grenadines';
else if(data.country == "WS") country=
'Samoa';
else if(data.country == "SM") country=
'San Marino';

else if(data.country == "ST") country=
'Sao Tome and Principe';
else if(data.country == "SA") country=
'Saudi Arabia';
else if(data.country == "SN") country=
'Senegal';
else if(data.country == "RS") country=
'Serbia';
else if(data.country == "CS") country=
'Serbia and Montenegro';
else if(data.country == "SC") country=
'Seychelles';
else if(data.country == "SL") country=
'Sierra Leone';
else if(data.country == "SX") country=
'Sint Maarten';
else if(data.country == "SK") country=
'Slovakia';
else if(data.country == "SI") country=
'Slovenia';
else if(data.country == "SB") country=
'Solomon Islands';
else if(data.country == "SO") country=
'Somalia';
else if(data.country == "ZA") country=
'South Africa';
else if(data.country == "GS") country=
'South Georgia and the South Sandwich Islands';
 else if(data.country == "SS") country=
'South Sudan';
    else if(data.country == "ES") country='Spain';
 else if(data.country == "LK") country='Sri Lanka';
 else if(data.country == "SD") country=
'Sudan';

  else if(data.country == "SR") country=
'Suriname';
 else if(data.country == "SJ") country=
'Svalbard and Jan Mayen';
 else if(data.country == "SZ") country=
'Swaziland';
else if(data.country == "SE") country=
'Sweden';
else if(data.country == "CH") country=
'Switzerland';
else if(data.country == "SY") country=
'Syrian Arab Republic';
else if(data.country == "TW") country=
"Taiwan, Province of China";
else if(data.country == "TJ") country=
"Tajikistan";
else if(data.country == "TZ") country=
"Tanzania, United Republic of";
else if(data.country == "TH") country=
"Thailand";
else if(data.country == "TL") country=
"Timor-Leste";
else if(data.country == "TG") country=
"Togo";
else if(data.country == "TK") country=
"Tokelau";
else if(data.country == "TO") country=
"Tonga";
else if(data.country == "TN") country=
"Trinidad and Tobago";
else if(data.country == "TR") country=
"Turkey";
else if(data.country == "TM") country=
"Turkmenistan";
else if(data.country == "TC") country=
"Turks and Caicos Islands";
else if(data.country == "TV") country=
"Tuvalu";
else if(data.country == "UG") country=
"Uganda";
else if(data.country == "UA") country=
"Ukraine";
else if(data.country == "AE") country=
"United Arab Emirates";
else if(data.country == "GB") country=
"United Kingdom";
else if(data.country == "US") country=
"United States";
else if(data.country == "UM") country=

"United States Minor Outlying Islands";
else if(data.country == "UY") country="Uruguay";

else if(data.country == "UZ") country="Uzbekistan";
else if(data.country == "VU") country=
'Vanuatu';
else if(data.country == "VE") country=
'Venezuela';
else if(data.country == "VN") country=
'Viet Nam';
else if(data.country == "VG") country=
'Virgin Islands, British';
else if(data.country == "VI") country=
'Virgin Islands, U.s.';
else if(data.country == "WF") country=
'Wallis and Futuna';
else if(data.country == "EH") country=
"Western Sahara";
else if(data.country == "EH")
country="Yemen";

else if(data.country == "ZM")
country="Zambia";
else if(data.country == "ZW") country=
"Zimbabwe" ;


if(data.nationality == "AF")
         nationality=  'Afghanistan';
     else if(data.nationality == "AX")
     nationality='Aland Islands';
    else if(data.nationality == "AL")
    nationality='Albania';
    else if(data.nationality == "DZ")
    nationality='Algeria';
    else if(data.nationality == "AS")
     nationality='American Samoa';
    else if(data.nationality == "AD")
             nationality='Andorra';
            else if(data.nationality == "AO")
            nationality='Angola';

            else if(data.nationality == "AI")
            nationality='Anguilla';

            else if(data.nationality == "AQ") nationality=
        'Antarctica';
            else if(data.nationality == "AG") nationality=
        'Anguilla';
            else if(data.nationality == "AR") nationality=
        'Argentina'
      else if(data.nationality == "AW") nationality=
      'Aruba';
      else if(data.nationality == "AM") nationality=
      'Armenia';
        else if(data.nationality == "AU") nationality=
      'Australia';
        else if(data.nationality == "AT") nationality=
      'Austria';
       else if(data.nationality == "AZ") nationality=
      'Azerbaijan';
         else if(data.nationality == "BS") nationality=
      'Bahamas';
       else if(data.nationality == "BH") nationality=
      'Bahrain';
       else if(data.nationality == "BD") nationality=
      'Bangladesh';
       else if(data.nationality == "BB") nationality=
      'Barbados';
           else if(data.nationality == "BY") nationality=
      'Belarus';
        else if(data.nationality == "BE") nationality=
      'Belgium';
             else if(data.nationality == "BZ") nationality=
      'Belize';
         else if(data.nationality == "BJ") nationality=
      'Benin';
       else if(data.nationality == "BM") nationality=
      'Bermuda';
        else if(data.nationality == "BT") nationality=
      'Bhutan';
       else if(data.nationality == "BO") nationality=
      'Bolivia';
           else if(data.nationality == "BQ") nationality='Bonaire, Sint Eustatius and Saba';
         else if(data.nationality == "BA") nationality=
     'Bosnia and Herzegovina';
 else if(data.nationality == "BW") nationality=
    'Botswana';
     else if(data.nationality == "BV") nationality=
    'Bouvet Island';
         else if(data.nationality == "BR") nationality=
    'Brazil';
      else if(data.nationality == "IO") nationality=
   'British Indian Ocean Territory';
     else if(data.nationality == "BN") nationality=
 'Brunei Darussalam';
    else if(data.nationality == "BG") nationality=
'Bulgaria';
  else if(data.nationality == "BF") nationality=
'Burkina Faso';
  else if(data.nationality == "BI") nationality=
'Burundi';
  else if(data.nationality == "KH") nationality=
'Cambodia';
  else if(data.nationality == "CM") nationality=
'Cameroon';
 else if(data.nationality == "CA") nationality=
'Canada';
 else if(data.nationality == "CV") nationality=
'Cape Verde';
 else if(data.nationality == "KY") nationality=
'Cayman Islands';
 else if(data.nationality == "CF") nationality=
'Central African Republic';
 else if(data.nationality == "TD") nationality=
'Chad';
else if(data.nationality == "CL") nationality=
'Chile';
else if(data.nationality == "CN") nationality=
'China';
else if(data.nationality == "CX") nationality=
'Christmas Island';
else if(data.nationality == "CC") nationality=
'Cocos (Keeling) Islands';
else if(data.nationality == "CO") nationality=
'Colombia';
else if(data.nationality == "KM") nationality=
'Comoros';
else if(data.nationality == "CG") nationality=
'Congo';
else if(data.nationality == "CD") nationality=
'Congo, Democratic Republic of the Congo';
else if(data.nationality == "CK") nationality=
'Cook Islands';
else if(data.nationality == "CR") nationality=
'Costa Rica';
else if(data.nationality == "CI") nationality=
"Cote D'Ivoire";
else if(data.nationality == "HR") nationality=
'Croatia';
else if(data.nationality == "CU") nationality=
'Cuba';
else if(data.nationality == "CW") nationality=
'Curacao';
else if(data.nationality == "CY") nationality=
'Cyprus';
else if(data.nationality == "CZ") nationality=
'Czech Republic';
else if(data.nationality == "DK") nationality=
'Denmark';
else if(data.nationality == "DJ") nationality=
'Djibouti';
else if(data.nationality == "DM") nationality=
'Dominica';
else if(data.nationality == "DO") nationality=
'Dominican Republic';
else if(data.nationality == "EC") nationality=
'Ecuador';
else if(data.nationality == "EG") nationality=
'Egypt';
   else if(data.nationality == "SV") nationality=
'El Salvador';
   else if(data.nationality == "GQ") nationality=
'Equatorial Guinea';
   else if(data.nationality == "ER") nationality=
'Eritrea';
     else if(data.nationality == "EE") nationality=

'Estonia';
else if(data.nationality == "ET") nationality=
'Ethiopia';
 else if(data.nationality == "FK") nationality=
'Falkland Islands (Malvinas)';
else if(data.nationality == "FO") nationality=
'Faroe Islands';
else if(data.nationality == "FJ") nationality=
'Fiji';
else if(data.nationality == "FI") nationality=
'Finland';
else if(data.nationality == "FR") nationality=
'France';
else if(data.nationality == "GF") nationality=
'French Guiana';
else if(data.nationality == "PF") nationality=
'French Polynesia';
else if(data.nationality == "TF") nationality=
'French Southern Territories';
else if(data.nationality == "GA") nationality=
'Gabon';
else if(data.nationality == "GM") nationality=
'Gambia';
else if(data.nationality == "GE") nationality=
'Georgia';
else if(data.nationality == "DE") nationality=
'Germany';
else if(data.nationality == "GH") nationality=
'Ghana';
else if(data.nationality == "GI") nationality=
'Gibraltar';
else if(data.nationality == "GR") nationality=
'Greece';
else if(data.nationality == "GL") nationality=
'Greenland';
   else if(data.nationality == "GD") nationality=
'Grenada';
else if(data.nationality == "GP") nationality=
'Guadeloupe';
else if(data.nationality == "GU") nationality=
'Guam';
else if(data.nationality == "GT") nationality=
'Guatemala';
else if(data.nationality == "GG") nationality=
'Guernsey';
else if(data.nationality == "GN") nationality=
'Guinea';
else if(data.nationality == "GW") nationality=
'Guinea-Bissau';
else if(data.nationality == "GY") nationality=
'Guyana';
else if(data.nationality == "HT") nationality=
'Haiti';
else if(data.nationality == "HN") nationality=
'Honduras';
else if(data.nationality == "HM") nationality=
'Heard Island and Mcdonald Islands';
else if(data.nationality == "VA") nationality=
'Holy See (Vatican City State)';
else if(data.nationality == "HK") nationality=
'Hong Kong';
else if(data.nationality == "HU") nationality=
'Hungary';
else if(data.nationality == "IS") nationality=
'Iceland';
else if(data.nationality == "IN") nationality=
'India';
else if(data.nationality == "ID") nationality=
'Indonesia';
else if(data.nationality == "IR") nationality=
'Iran, Islamic Republic of';
else if(data.nationality == "IQ") nationality=
'Iraq';
else if(data.nationality == "IE") nationality=
'Ireland';
else if(data.nationality == "IM") nationality=
'Isle of Man';
else if(data.nationality == "IL") nationality=
'Israel';
else if(data.nationality == "IT") nationality=
'Italy';
else if(data.nationality == "JM") nationality=
'Jamaica';
  else if(data.nationality == "JP") nationality=
'Japan';
  else if(data.nationality == "JE") nationality=
'Jersey';
  else if(data.nationality == "JO") nationality=
'Jordan';
   else if(data.nationality == "KZ") nationality=
'Kazakhstan';
else if(data.nationality == "KE") nationality=
'Kenya';
else if(data.nationality == "KI") nationality=
'Kiribati';
else if(data.nationality == "KP") nationality=
"Korea, Democratic People's Republic of";
else if(data.nationality == "KR") nationality=
'Korea, Republic of';
else if(data.nationality == "XK") nationality=
'Kosovo';
else if(data.nationality == "KW") nationality=
'Kuwait';
else if(data.nationality == "KG") nationality=
'Kyrgyzstan';
else if(data.nationality == "LA") nationality=
"Lao People's Democratic Republic";
else if(data.nationality == "LV") nationality=
'Latvia';
else if(data.nationality == "LB") nationality=
'Lebanon';
else if(data.nationality == "LC") con_sch=
'Saint Lucia';
else if(data.nationality == "LS") nationality=
'Lesotho';
else if(data.nationality == "LR") nationality=
'Liberia';
else if(data.nationality == "LY") nationality=
'Libyan Arab Jamahiriya';
else if(data.nationality == "LI") nationality=
'Liechtenstein';
else if(data.nationality == "LT") nationality=
'Lithuania';
else if(data.nationality == "LU") nationality=
'Luxembourg';
else if(data.nationality == "MO") nationality=
'Macao';
else if(data.nationality == "MK") nationality=
'Macedonia, the Former Yugoslav Republic of';
else if(data.nationality == "MG") nationality=
'Madagascar';
else if(data.nationality == "MW") nationality=
'Malawi';
else if(data.nationality == "MY") nationality=
'Malaysia';
else if(data.nationality == "MV") nationality=
'Maldives';
else if(data.nationality == "ML") nationality=
'Mali';
else if(data.nationality == "MT") nationality=
'Malta';
else if(data.nationality == "MH") nationality=
'Marshall Islands';
else if(data.nationality == "MQ") nationality=
'Martinique';
else if(data.nationality == "MR") nationality=
'Mauritania';
else if(data.nationality == "MU") nationality=
'Mayotte';
else if(data.nationality == "MX") nationality=
'Mexico';
else if(data.nationality == "FM") nationality=
'Micronesia, Federated States of';
 else if(data.nationality == "MD") nationality=
'Moldova, Republic of';
else if(data.nationality == "MC") nationality=
'Monaco';
else if(data.nationality == "MN") nationality=
'Mongolia';
else if(data.nationality == "ME") nationality=
'Montenegro';

else if(data.nationality == "MS") nationality=
'Montserrat';

else if(data.nationality == "MA") nationality=
'Morocco';
else if(data.nationality == "MZ") nationality=
'Mozambique';
else if(data.nationality == "MM") nationality=
'Myanmar';
else if(data.nationality == "NA") nationality=
'Namibia';
else if(data.nationality == "NR") nationality=
'Nauru';
else if(data.nationality == "NP") nationality=
'Nepal';
else if(data.nationality == "NL") nationality=
'Netherlands';
else if(data.nationality == "AN") nationality=
'Netherlands Antilles';
else if(data.nationality == "NC") nationality=
'New Caledonia';
else if(data.nationality == "NZ") nationality=
'New Zealand';
else if(data.nationality == "NI") nationality=
'Nicaragua';
else if(data.nationality == "NE") nationality=
'Niger';
else if(data.nationality == "NG") nationality=
'Nigeria';
else if(data.nationality == "NU") nationality=
'Niue';
else if(data.nationality == "NF") nationality=
'Norfolk Island';
else if(data.nationality == "MP") nationality=
'Northern Mariana Islands';
else if(data.nationality == "NO") nationality=
'Norway';
else if(data.nationality == "OM") nationality=
'Oman';
else if(data.nationality == "PK") nationality=
'Pakistan';
else if(data.nationality == "PW") nationality=
'Palau';
else if(data.nationality == "PS") nationality=
'Palestinian Territory, Occupied';
else if(data.nationality == "PA") nationality=
'Panama';
else if(data.nationality == "PG") nationality=
'Papua New Guinea';
else if(data.nationality == "PY") nationality=
'Paraguay';
else if(data.nationality == "PE") nationality=
'Peru';
else if(data.nationality == "PH") nationality=
'Philippines';
else if(data.nationality == "PN") nationality=
'Pitcairn';
else if(data.nationality == "PL") nationality=
'Poland';
else if(data.nationality == "PT") nationality=
'Portugal';
else if(data.nationality == "PR") nationality=
'Puerto Rico';
else if(data.nationality == "QA") nationality=
'Qatar';
else if(data.nationality == "RE") nationality=
'Reunion';
else if(data.nationality == "RO") nationality=
'Romania';
else if(data.nationality == "RU") nationality=
'Russian Federation';
else if(data.nationality == "RW") nationality=
'Rwanda';
else if(data.nationality == "BL") nationality=
'Saint Barthelemy';
else if(data.nationality == "SH") nationality=
'Saint Helena';
else if(data.nationality == "KN") nationality=
'Saint Kitts and Nevis';
else if(data.nationality == "SH") nationality=
'Saint Lucia';
else if(data.nationality == "MF") nationality=
'Saint Martin';
else if(data.nationality == "PM") nationality=
'Saint Pierre and Miquelon';
else if(data.nationality == "VC") nationality=
'Saint Vincent and the Grenadines';
else if(data.nationality == "WS") nationality=
'Samoa';
else if(data.nationality == "SM") nationality=
'San Marino';

else if(data.nationality == "ST") nationality=
'Sao Tome and Principe';
else if(data.nationality == "SA") nationality=
'Saudi Arabia';
else if(data.nationality == "SN") nationality=
'Senegal';
else if(data.nationality == "RS") nationality=
'Serbia';
else if(data.nationality == "CS") nationality=
'Serbia and Montenegro';
else if(data.nationality == "SC") nationality=
'Seychelles';
else if(data.nationality == "SL") nationality=
'Sierra Leone';
else if(data.nationality == "SX") nationality=
'Sint Maarten';
else if(data.nationality == "SK") nationality=
'Slovakia';
else if(data.nationality == "SI") nationality=
'Slovenia';
else if(data.nationality == "SB") nationality=
'Solomon Islands';
else if(data.nationality == "SO") nationality=
'Somalia';
else if(data.nationality == "ZA") nationality=
'South Africa';
else if(data.nationality == "GS") nationality=
'South Georgia and the South Sandwich Islands';
 else if(data.nationality == "SS") nationality=
'South Sudan';
    else if(data.nationality == "ES") nationality='Spain';
 else if(data.nationality == "LK") nationality='Sri Lanka';
 else if(data.nationality == "SD") nationality=
'Sudan';

  else if(data.nationality == "SR") nationality=
'Suriname';
 else if(data.nationality == "SJ") nationality=
'Svalbard and Jan Mayen';
 else if(data.nationality == "SZ") nationality=
'Swaziland';
else if(data.nationality == "SE") nationality=
'Sweden';
else if(data.nationality == "CH") nationality=
'Switzerland';
else if(data.nationality == "SY") nationality=
'Syrian Arab Republic';
else if(data.nationality == "TW") nationality=
"Taiwan, Province of China";
else if(data.nationality == "TJ") nationality=
"Tajikistan";
else if(data.nationality == "TZ") nationality=
"Tanzania, United Republic of";
else if(data.nationality == "TH") nationality=
"Thailand";
else if(data.nationality == "TL") nationality=
"Timor-Leste";
else if(data.nationality == "TG") nationality=
"Togo";
else if(data.nationality == "TK") nationality=
"Tokelau";
else if(data.nationality == "TO") nationality=
"Tonga";
else if(data.nationality == "TN") nationality=
"Trinidad and Tobago";
else if(data.nationality == "TR") nationality=
"Turkey";
else if(data.nationality == "TM") nationality=
"Turkmenistan";
else if(data.nationality == "TC") nationality=
"Turks and Caicos Islands";
else if(data.nationality == "TV") nationality=
"Tuvalu";
else if(data.nationality == "UG") nationality=
"Uganda";
else if(data.nationality == "UA") nationality=
"Ukraine";
else if(data.nationality == "AE") nationality=
"United Arab Emirates";
else if(data.nationality == "GB") nationality=
"United Kingdom";
else if(data.nationality == "US") nationality=
"United States";
else if(data.nationality == "UM") nationality=

"United States Minor Outlying Islands";
else if(data.nationality == "UY") nationality="Uruguay";

else if(data.nationality == "UZ") nationality="Uzbekistan";
else if(data.nationality == "VU") nationality=
'Vanuatu';
else if(data.nationality == "VE") nationality=
'Venezuela';
else if(data.nationality == "VN") nationality=
'Viet Nam';
else if(data.nationality == "VG") nationality=
'Virgin Islands, British';
else if(data.nationality == "VI") nationality=
'Virgin Islands, U.s.';
else if(data.nationality == "WF") nationality=
'Wallis and Futuna';
else if(data.nationality == "EH") nationality=
"Western Sahara";
else if(data.nationality == "EH")
nationality="Yemen";

else if(data.nationality == "ZM")
nationality="Zambia";
else if(data.nationality == "ZW") nationality=
"Zimbabwe" ;

if(data.gender==1)
{
    gender="ذكر";
}
else{
    gender="انثى";
}

if(data.religion==0)
{
    religion="مسلم";
}
else{
    religion="مسيحي";
}
$('#edit_calss2').val(data.class.name);

          $('#edit_address').val(country);
        $('#edit_city').val(data.city);
        $('#edit_pas_number').val(data.passport_number);
        $('#edit_nationality').val(data.nationality);
        $('#edit_number').val(data.the_ID_number);
        $('#edit_religion').val(religion);
        $('#edit_gender').val(gender);
        $('#edit_phone').val(data.phone);
        $('#edit_school').val(data.the_previous_school);
        // $('#edit_schoolnational').val(con_sch);
        $('#edit_place').val(data.place_of_birth);
        $('#edit_other_phone').val(data.other_phone);
        $('#edit_calss').val(data.current_class);
        $('.edit_result_status').empty();
        if(data.status == 11){
                    $('#edit_status').text("منقطع عن الدراسة");
                    if(data.write_or == 1){
                        $('.edit_result_status').append(`
                            <label style="text-align: center;font-size: 30px;width: 100%;" > يجيد القراءة والكتابة والرياضيات </label>
                        `);
                    }else{
                        $('.edit_result_status').append(`
                            <label style="text-align: center;font-size: 30px;width: 100%;" > لا يجيد القراءة والكتابة والرياضيات </label>
                        `);
                    }

        }else{
                    $('#edit_status').text("غير منقطع عن الدراسة");
                        $('.edit_result_status').append(`
                            <label>الصف الحالي</label>
                        <input readonly type="text" class="form-control b"style="direction:rtl"
                            value="${data.current_class}" maxlength="20" >
                        `);
        }

        if (data.certification_nine != null) {
            $('#edit_certification_nine').parent().css('display','block');
            $('#edit_certification_nine').children().prop('src',`{{ asset('storage')}}/${data.certification_nine}`);
            $('#edit_certification_nine').prop('href',`{{ asset('storage')}}/${data.certification_nine}`);
        }
        if (data.certification != null) {
            $('#edit_certification').parent().css('display','block');
            $('#edit_certification').children().prop('src',`{{ asset('storage')}}/${data.certification}`);
            $('#edit_certification').prop('href',`{{ asset('storage')}}/${data.certification}`);
        }
        if (data.study_sequence != null) {
            $('#edit_study_sequence').parent().css('display','block');
            $('#edit_study_sequence').children().prop('src',`{{ asset('storage')}}/${data.study_sequence}`);
            $('#edit_study_sequence').prop('href',`{{ asset('storage')}}/${data.study_sequence}`);
        }
        if (data.father_page != null) {
            $('#edit_father_page').parent().css('display','block');
            $('#edit_father_page').children().prop('src',`{{ asset('storage')}}/${data.father_page}`);
            $('#edit_father_page').prop('href',`{{ asset('storage')}}/${data.father_page}`);
        }
        if (data.mather_page != null) {
            $('#edit_mather_page').parent().css('display','block');
            $('#edit_mather_page').children().prop('src',`{{ asset('storage')}}/${data.mather_page}`);
            $('#edit_mather_page').prop('href',`{{ asset('storage')}}/${data.mather_page}`);
        }
        if (data.passbord != null) {
            $('#edit_passbord').parent().css('display','block');
            $('#edit_passbord').children().prop('src',`{{ asset('storage')}}/${data.passbord}`);
            $('#edit_passbord').prop('href',`{{ asset('storage')}}/${data.passbord}`);
        }
        if (data.fourth_image != null) {
            $('#edit_fourth_image').parent().css('display','block');
            $('#edit_fourth_image').children().prop('src',`{{ asset('storage')}}/${data.fourth_image}`);
            $('#edit_fourth_image').prop('href',`{{ asset('storage')}}/${data.fourth_image}`);
        }
        if (data.father_image != null) {
            $('#edit_father_image').parent().css('display','block');
            $('#edit_father_image').children().prop('src',`{{ asset('storage')}}/${data.father_image}`);
            $('#edit_father_image').prop('href',`{{ asset('storage')}}/${data.father_image}`);
        }
        if (data.mother_image != null) {
            $('#edit_mother_image').parent().css('display','block');
            $('#edit_mother_image').children().prop('src',`{{ asset('storage')}}/${data.mother_image}`);
            $('#edit_mother_image').prop('href',`{{ asset('storage')}}/${data.mother_image}`);
        }
        if (data.family_book != null) {
            $('#edit_family_book').parent().css('display','block');
            $('#edit_family_book').children().prop('src',`{{ asset('storage')}}/${data.family_book}`);
            $('#edit_family_book').prop('href',`{{ asset('storage')}}/${data.family_book}`);
        }
        if (data.personal_image != null) {
            $('#edit_personal_image').parent().css('display','block');
            $('#edit_personal_image').children().prop('src',`{{ asset('storage')}}/${data.personal_image}`);
            $('#edit_personal_image').prop('href',`{{ asset('storage')}}/${data.personal_image}`);
        }

    });
    $(document).on('click','.change_lang',function(){

        $('#student_change_lang_id').val($(this).data('id'));

        if($(this).data('lang')=='0') {
        $('#option-lang1').prop("checked", true);

        }else if($(this).data('lang')=='1'){
            $('#option-lang2').prop("checked", true);
        }

    });
    $(document).on('click','.delete_student',function(){
        var data = $(this).data("data");

        $('#student_id_delete').val(data.id);
        $('#student_name_delete').val(data.first_name+ ' '+data.last_name);


    });






$(document).on('click', '.financial_account', function () {
        var student_id = $(this).data('id');
        var class_id = $(this).data('class');
        var student_name = $(this).data('name');

        $('#student_financial_id').val($(this).data('id'));
        $('#class_id').val($(this).data('class'));
        $('.student_name').text($(this).data('name'));

        var url ="{{ URL::to('SMT/admin/students/invoices_details')}}/"+student_id;
        // $('.details').attr('href',url);
        var url = "{{ URL::to('SMT/admin/students/remain_account') }}/" + student_id +"/"+ class_id;
        $.ajax({
        url: url,
        type: "get",
        contentType: 'application/json',
        success: function (data) {

                $('#full_account').text(data.full_amount);
                $('#remaining_account').text(data.remain_amount);
                $('#amount_paid').text(data.amount_paid);

                $('#invoice_amount').attr('max',data.remain_amount);

                if(data.remain_amount==0){

                    $('.add_reciept').hide();

                }else{
                    $('.add_reciept').show();

                }

            },

        });

});



$(document).on('change', '#classes', function () {
        var class_id = $(this).val();

        var url = "{{ URL::to('SMT/admin/classes/rooms') }}/" + class_id ;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {

                $('#class_room').empty();
                var type = `

                    <option value="">اختر الشعبة الدراسية</option>

                    `;

                $.each(data, function (key, value) {


                    type += `
<option value="${value.id}">${value.name}</option>

                      `;

                });


                $('#class_room').append(type);

            },
            error: function (xhr) {

            }

        });
    });




    $(document).on('change', '#classes_change', function () {
        $('#mydivroom').empty();

        var year_id=$('#years').val();
        var class_id=$(this).val();

        var type="";

        var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id +"/"+ year_id;
       $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
                var type = `
                <label>الشعبة</label>

                <select name="room_change_id" id="" class="form-control dep"
                    style="min-height: 36px;direction:rtl" required>
                    <option value="">اختر الشعبة الدراسية</option>

                    `;

                $.each(data, function (key, value) {
                    type += `<option value="${value.id}">${value.name}</option>`;
                });

                type+=`</select>`;
                $('#mydivroom').append(type);
            },


        });
    });


    $('input:radio[name=select]').on('click', function () {

        $('#mydivclass').empty();

        var val=$(this).val();
        var type="";
        type+=`
                <br>
                <div class="form-group" style="text-align:right">
                <label >الصف</label>

                <select name="class_change_id" id="classes_change" class="form-control dep"
                    style="min-height: 36px;direction: rtl" required>
                    <option value="">اختر الصف الدراسي</option>

                @foreach ($classes as $class)

                <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach

                </select>

            </div>
        `;
        $('#mydivclass').append(type);

    });



$(document).on('click','.change_student',function(){

$('#student_id').val($(this).data('id'));

        var student_id = $(this).data('id');
        var student_name = $(this).data('name');
        var url = "{{ URL::to('SMARMANger/admin/students/student_detail_prev') }}/" + student_id;
$.ajax({
url: url,
type: "get",
contentType: 'application/json',
success: function (data) {
        $('.student_name').text(student_name+ " عام "+ data.year_name  +" كان" + " في الصف  " + data.class_name + " " + data.room_name);
    },
error: function (xhr) {

}

});

});



    $(document).on('click','.student_less',function(e){
        var student_id=$(this).data('id');
        e.preventDefault();
        $.ajax({
            type:'post',
            url:"{{ route('student.less') }}",
            enctype:'multipart/form-data',
            data:{
                '_token':"{{ csrf_token() }}",
                'id':student_id,
            },
            success:function(data){
            $(`#super_${student_id}`).attr('style','color:blue');
            $(`#super_${student_id}`).parent().attr('class','student_super')
            },
        });
    });

    $(document).on('click','.student_super',function(e){
        var student_id=$(this).data('id');
        e.preventDefault();
        $.ajax({

            type:'post',
            url:"{{ route('student.super') }}",
            enctype:'multipart/form-data',
            data:{
                '_token':"{{ csrf_token() }}",
                'id':student_id,
            },


            success:function(data){
            $(`#super_${student_id}`).attr('style','color:green');
            $(`#super_${student_id}`).parent().attr('class','student_less')
                    swal({
                        title: "حسناً",
                        text: "! تمت العملية بنجاح",
                        icon: "success",
                        button: "OK",
                        timer: 2000
                    });
            },

        });

    });

</script>

@endsection
