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
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection

@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم الطلاب المحتاجين للسبر</a>
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
                        <label>رقم الأب</label>
                        <input readonly type="text" id="edit_father_phone" class="form-control b"
                            value="" maxlength="20"style="direction:rtl"
                            placeholder="رقم الأب " >
                    </div>


                    <div class="form-group col-12 col-lg-6">
                        <label>اسم الأم</label>
                        <input readonly type="text" id="edit_mother_name" class="form-control b"
                            value="" maxlength="20"style="direction:rtl"
                            placeholder="اسم الأم" >
                    </div>
                     <div class="form-group col-12 col-lg-6">
                        <label>كنية الأم</label>
                        <input readonly type="text" id="edit_last_mother_name" class="form-control b"
                            value="" maxlength="20"style="direction:rtl"
                            placeholder="كنية الأم" >
                    </div>


                    <div class="form-group col-12 col-lg-6">
                        <label>رقم الأم</label>
                        <input readonly type="text" id="edit_mother_phone" class="form-control b"
                            value="" maxlength="20"style="direction:rtl"
                            placeholder="رقم الأم " >
                    </div>


                    <div class="form-group col-12 col-lg-6">
                        <label>تاريخ الولادة</label>
                        <input readonly type="date" id="edit_date_birth" class="form-control b"
                            value=""style="direction:rtl"
                            placeholder="تاريخ الولادة" >
                    </div>

                    <div class="form-group col-12 col-lg-6">
                        <label>العنوان</label>
                        <input readonly type="text" id="edit_address" class="form-control b"style="direction:rtl"
                            value="" maxlength="100"
                            placeholder="العنوان">
                    </div>

                    <div class="form-group col-12 col-lg-6">
                        <label>الهاتف</label>
                        <input readonly type="text" id="edit_phone" class="form-control b"style="direction:rtl"
                            value="" maxlength="20"
                            placeholder="الهاتف" >
                    </div>



                    <div class="form-group col-12 col-lg-6">
                        <label>الصف الحالي</label>
                        <input readonly type="text" id="edit_calss" class="form-control b"style="direction:rtl"
                            value="" maxlength="20" >
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label>الصف</label>
                        <input readonly type="text" id="edit_calss2" class="form-control b"style="direction:rtl"
                            value="" maxlength="20" >
                    </div>
                    <div class="form-group col-12 col-lg-6">
                    </div>

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
                        <label style="text-align:center;display:block" >صفحة الأم في دقتر العائلة</label>
                        <a href="" id="edit_mather_page" target="_blank">
                            <img style="border-radius: 0%;" width="200" src="" alt="" >
                        </a>
                    </div>

                    <div style="display:none;text-align: center" class="form-group col-12 col-lg-6 ">
                        <label style="text-align:center;display:block" >صفحة الأب في دقتر العائلة</label>
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
            <h1 style="text-align: center;color: #001586">جدول الطلاب المحتاجين للسبر</h1>
            <a class="delete_selected_student btn btn-danger btn-sm"  data-target=".deleteSelectedStudentModal" data-toggLe="modal"
            style="padding-right:8px !important;font-size:22px;float:right;visibility:hidden;background:#e15b5bdb !important ">
                حذف الطلبات المحددة
            </a><br>
            <div class="row" >
                <div class="col-12 col-lg-3">
                    <select  id="filter_class"  class="form-control" >
                            <option value="">جميع الصفوف</option>
                            @foreach ($classes as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                    </select>
                </div>
                <div class="col-12 col-lg-3">
                    <input class="form-control" placeholder="الصف الحالي" id="filter_current" >
                </div>
            </div>
        </div>
        <div class="m-4">
            <form action="{{ route('delete_multiple_student') }}" class="multiple-select-form" method="POST">
                @csrf
                <table class="table align-items-center" id="table_xx">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="budget">تحديد </th>
                            <th scope="col" class="sort" data-sort="budget">الإسم الأول</th>
                            <th scope="col" class="sort" data-sort="status">الكنية</th>
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

var table_test = $('#table_xx').DataTable({
        processing: true,
        oLanguage: {
            sProcessing: "<h1>Proccessing</h1>"
        },
        serverSide: true,
        "pageLength": 10,
        "ajax": {
            "type": "GET",
            "url": "{{ route('getstudentsprobe') }}",
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
                }
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
                    return `
                        <a class="detail_student btn" data-data='${JSON.stringify(full)}' data-target=".createStudentModal" data-toggLe="modal" style="padding-left:8px !important;font-size:22px ">
                            <i class="fa fa-eye fa-x" style="color: #008CC4"></i>
                        </a>
                        <a class="delete_student btn" data-data='${JSON.stringify(full)}' data-target=".deleteStudentModal" data-toggLe="modal" style="padding-right:8px !important;font-size:22px  ">
                            <i class="fa fa-trash fa-x" style="color: #e15b5bdb"></i>
                        </a>
                    `;
                }
            },

        ]
    });

        $('#filter_class').change(function () {
                table_test.draw();
        })
        $('#filter_current').keyup(function () {
                table_test.draw();
        })


    table_test.on('order.dt search.dt', function () {
        let i = 1;

        table_test.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();


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
            $('.selectd_student_ul').append(`
                <li id="${id}" style="list-style: inside;"> ${name}</li>
            `);

            }else{
                  let id = $(this).val();
                  $(`#${id}`).remove() ;
                  if ( $('input.checkStudent:checked').length < 1 ){
                    $('.delete_selected_student').css('visibility','hidden')
                  }
            }


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

        $('#edit_last_mother_name').val(data.last_mother_name);
        $('#studentreg_id').val(data.id);
        $('#studentpro_id').val(data.id);
        $('#edit_first_name').val(data.first_name);
        $('#edit_last_name').val(data.last_name);
        $('#edit_father_name').val(data.father_name);
        $('#edit_father_phone').val(data.father_phone);
        $('#edit_mother_name').val(data.mather_name);
        $('#edit_mother_phone').val(data.mather_phone);
        $('#edit_date_birth').val(data.date);
        $('#edit_address').val(data.country);
        $('#edit_phone').val(data.phone);
        $('#edit_calss').val(data.current_class);
        $('#edit_calss2').val(data.class1);

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
