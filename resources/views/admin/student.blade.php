@extends('admin.master')

@section('style')
<link href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

<style>
    * {
        direction: rtl !important;
        /* text-align: center; */
    }

    button,
    a {
        color: white !important;
    }

    .form-group {
        text-align: right;
    }

    label {
        font-size: 20px;
        color: black;
    }

    input {
        font-size: 17px !important;
    }

    th {
        font-size: 20px;
    }

    td {
        font-size: 17px;
    }

    a.page-link {
        color: #7571f9 !important;
    }

    .pagination {
        justify-content: center;
    }

    .dropdown-item {
        color: black !important;
        width: auto !important;
    }

    .fa-folder {
        margin: 2px;
    }

    .dorat {
        color: blue !important;
    }

    img {
        border-radius: 50%;
    }

    /* ///////////////////////////////////// */


    .wrapper {
        display: inline-flex;
        background: #fff;
        height: 100px;
        width: 400px;
        align-items: center;
        justify-content: space-evenly;
        border-radius: 5px;
        padding: 20px 15px;
        margin-left: 25px;
        box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.2);
    }

    .wrapper .option {
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

    .wrapper .option .dot {
        height: 20px;
        width: 20px;
        background: #d9d9d9;
        border-radius: 50%;
        position: relative;
    }

    .wrapper .option .dot::before {
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

    .wrapper input[type="radio"] {
        display: none;
    }

    #option-1:checked:checked~.option-1,
    #option-2:checked:checked~.option-2 {
        border-color: #0069d9;
        background: #0069d9;
    }

    #option-1:checked:checked~.option-1 .dot,
    #option-2:checked:checked~.option-2 .dot {
        background: #fff;
    }

    #option-1:checked:checked~.option-1 .dot::before,
    #option-2:checked:checked~.option-2 .dot::before {
        opacity: 1;
        transform: scale(1);
    }

    .wrapper .option span {
        font-size: 20px;
        color: #808080;
    }

    #option-1:checked:checked~.option-1 span,
    #option-2:checked:checked~.option-2 span {
        color: #fff;
    }

    .wrapper_lang {
        display: inline-flex;
        background: #fff;
        height: 100px;
        width: 400px;
        align-items: center;
        justify-content: space-evenly;
        border-radius: 5px;
        padding: 20px 15px;
        margin-left: 25px;
        box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.2);
    }

    .wrapper_lang .option {
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

    .wrapper_lang .option .dot {
        height: 20px;
        width: 20px;
        background: #d9d9d9;
        border-radius: 50%;
        position: relative;
    }

    .wrapper_lang .option .dot::before {
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

    .wrapper_lang input[type="radio"] {
        display: none;
    }

    #option-lang1:checked:checked~.option-lang1,
    #option-lang2:checked:checked~.option-lang2 {
        border-color: #0069d9;
        background: #0069d9;
    }

    #option-lang1:checked:checked~.option-lang1 .dot,
    #option-lang2:checked:checked~.option-lang2 .dot {
        background: #fff;
    }

    #option-lang1:checked:checked~.option-lang1 .dot::before,
    #option-lang2:checked:checked~.option-lang2 .dot::before {
        opacity: 1;
        transform: scale(1);
    }

    .wrapper_lang .option span {
        font-size: 20px;
        color: #808080;
    }

    #option-lang1:checked:checked~.option-lang1 span,
    #option-lang2:checked:checked~.option-lang2 span {
        color: #fff;
    }

    th {
        font-size: 20px;
        border-bottom: 1px solid #008991 !important;
        text-align: center !important;
    }

    td {
        font-size: 17px;
        border-bottom: 1px solid #008991 !important;
        color: black;
        text-align: center;
    }
    .table .thead-light th {
    color: #495057;
    background-color: white;
    /* border-color: #dee2e6; */
}
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection

@section('breadcrumbs')

<nav class="breadcrumbs">
    <a class="breadcrumbs__item ">قسم شؤون الطلاب</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item is-active">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')

<!------------------------------------------------>

@php
$about = \App\Other::find(1);
@endphp
  @php
        $school_data = \App\School_data::first();
        @endphp
{{-- <div class=" col-12 col-lg-2" style="text-align: left;">
    <a class="btn btn-success" >  <a href="{{ route('export_student1') }}"></a>تصدير الطلاب </a>
</div> --}}

<div class="modal fade " id="delete_class">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="" action="{{ route('delete_student') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" hidden name="student_id" id="delete_class_id">
                <div class="modal-header" style="direction: rtl">
                    <h2 class="modal-title">حذف طالب</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                        style="padding: 0px;margin: 0px;">&times;</button>
                </div>
                <div class="modal-body" style="font-size: 25px;text-align: center;color: black">
                    <h3 id="h4_text" style="direction: ltr; color: red;"></h3>
                    <hr>
                    <h3>ادخل كلمة المرور للحذف</h3>
                    <input type="password" class="form-control" name="password" placeholder="كلمة المرور"
                        style="direction: rtl; border: 1px solid #ff053a;">
                </div>
                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                    <button class="btn btn-primary" type="submit">حذف</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="user_name_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    style="display: none; padding-right: 17px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" id="dvContainer">
                <div class="row">
                    <div class="col-lg-4 col-12">
                        <img src="{{  asset('storage/'. $school_data->logo)}}" style="width: inherit;height: inherit; border-radius: 0%">
                    </div>
                    <div class="col-lg-8 col-12">
                        <div style="height: 5%"></div>
                        <div class="form-group" style="height: 30%">
                            <label for=""
                                style="font-size: 30px;font-weight: 600;text-align: center;display: block;color: #001586">اسم
                                الطالب </label>
                            <p style="color: black;font-size: 20px;display: block;text-align: center" id="name_share">
                            </p>
                        </div>
                        <div class="form-group" style="height: 30%">
                            <label for=""
                                style="font-size: 30px;font-weight: 600;text-align: center;display: block;color: #001586">اسم
                                المستخدم </label>
                            <p style="color: black;font-size: 20px;display: block;text-align: center"
                                id="username_share"></p>
                        </div>
                        <div class="form-group" style="height: 30%">
                            <label for=""
                                style="font-size: 30px;font-weight: 600;text-align: center;display: block;color: #001586">كلمة
                                المرور </label>
                            <p style="color: black;font-size: 20px;display: block;text-align: center" id="pass_share">
                            </p>
                        </div>
                        <div style="height: 5%"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="direction: rtl;justify-content: right;">
                <a class="btn btn-info ml-2" data-dismiss="modal">اغلاق</a>
                <a class="btn btn-success ml-2" id="screenshot">تنزيل</a>
            </div>
        </div>
    </div>
</div>


{{-- ////////// --}}

<div class="modal fade createStudentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('student_store') }}" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">إنشاء طالب</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>الإسم الأول بالعربية</label>
                        <input type="text" name="first_name" class="form-control a" style="direction:rtl" value=""
                            maxlength="20" placeholder="الإسم الأول" required>
                    </div>

                    <div class="form-group">
                        <label>الكنية بالعربية</label>
                        <input type="text" name="last_name" class="form-control b" value="" maxlength="20"
                            style="direction:rtl" placeholder="الكنية" required>
                    </div>
                    <div class="form-group">
                        <label>الإسم الأول بالانكليزية</label>
                        <input type="text" name="first_name_en" class="form-control a english_name"
                            style="direction:rtl" value="" maxlength="20" placeholder="الإسم الأول" required>
                    </div>

                    <div class="form-group">
                        <label> الكنية بالانكليزية</label>
                        <input type="text" name="last_name_en" class="form-control b english_name" value=""
                            maxlength="20" style="direction:rtl" placeholder="الكنية" required>
                    </div>

                    <div class="form-group">
                        <label>اسم الأب </label>
                        <input type="text" name="father_name" class="form-control b" value="" maxlength="20"
                            style="direction:rtl" placeholder="اسم الأب " required>
                    </div>

{{--
                    <div class="form-group">
                        <label>رقم الأب</label>
                        <input type="text" name="father_phone" class="form-control b" value="" maxlength="20"
                            style="direction:rtl" placeholder="رقم الأب ">
                    </div> --}}


                    <div class="form-group">
                        <label>اسم الأم</label>
                        <input type="text" name="mother_name" class="form-control b" value="" maxlength="20"
                            style="direction:rtl" placeholder="اسم الأم">
                    </div>


                    {{-- <div class="form-group">
                        <label>رقم الأم</label>
                        <input type="text" name="mother_phone" class="form-control b" value="" maxlength="20"
                            style="direction:rtl" placeholder="رقم الأم ">
                    </div> --}}


                    {{-- <div class="form-group">
                        <label>مكان الولادة</label>
                        <input type="text" name="place_birth" class="form-control b"
                            value="" maxlength="100"style="direction:rtl"
                            placeholder="مكان الولادة">
                    </div> --}}



                    <div class="form-group">
                        <label>تاريخ الولادة</label>
                        <input type="date" name="date_birth" class="form-control b" value="" style="direction:rtl"
                            placeholder="تاريخ الولادة">
                    </div>

                    <div class="form-group">
                        <label>الديانة</label>

                        <select name="religion" id="classes" class="form-control dep"
                            style="min-height: 36px;direction: rtl">
                            <option value="0">مسلم</option>
                            <option value="1">مسيحي</option>
                        </select>

                    </div>



                 <div class="form-group">
                        <label>العنوان الحالي</label>
                        <input type="text" name="address" class="form-control b" style="direction:rtl" value=""
                            maxlength="100" placeholder="االعنوان الحالي">
                    </div> 

                    <div class="form-group">
                        <label>رقم الهاتف المعتمد</label>
                        <input type="text" name="phone" class="form-control b" style="direction:rtl" value=""
                            maxlength="20" placeholder="رقم الهاتف المعتمد" required>
                    </div>
                          <div class="form-group">
                        <label>الدولة   </label>
                        

                        <select class="form-control ldir" for="country" id="country" placeholder="مكان الإقامة" name="country" required>
                            <option value="اختر البلد">اختر البلد</option>
                            <option value="سوريا">سوريا</option>
                            <option value="الامارات العربية المتحدة">الامارات العربية المتحدة</option>
                            <option value="المملكة العربية السعودية">المملكة العربية السعودية</option>
                            <option value="لبنان">لبنان</option>
                            <option value="الأردن">الأردن</option>
                            <option value="فنزويلا">فنزويلا</option>
                            <option value="تركيا">تركيا</option>
                            <option value="تونس">تونس</option>
                            <option value="الولايات المتحدة الأمريكية">الولايات المتحدة الأمريكية</option>
                            <option value="السويد">السويد</option>
                            <option value="ألمانيا">ألمانيا</option>
                            <option value="هولندا">هولندا</option>
                            <option value="العراق">العراق</option>
                            <option value="فلسطين">فلسطين</option>
                            <option value="آروبا">آروبا</option>
                            <option value="أذربيجان">أذربيجان</option>
                            <option value="أرمينيا">أرمينيا</option>
                            <option value="أسبانيا">أسبانيا</option>
                            <option value="أستراليا">أستراليا</option>
                            <option value="أفغانستان">أفغانستان</option>
                            <option value="ألبانيا">ألبانيا</option>
                            <option value="أنتيجوا وبربودا">أنتيجوا وبربودا</option>
                            <option value="أنجولا">أنجولا</option>
                            <option value="أنجويلا">أنجويلا</option>
                            <option value="أندورا">أندورا</option>
                            <option value="أورجواي">أورجواي</option>
                            <option value="أوزبكستان">أوزبكستان</option>
                            <option value="أوغندا">أوغندا</option>
                            <option value="أوكرانيا">أوكرانيا</option>
                            <option value="أيرلندا">أيرلندا</option>
                            <option value="أيسلندا">أيسلندا</option>
                            <option value="اثيوبيا">اثيوبيا</option>
                            <option value="اريتريا">اريتريا</option>
                            <option value="استونيا">استونيا</option>
                            <option value="الأرجنتين">الأرجنتين</option>
                            <option value="الاكوادور">الاكوادور</option>
                            <option value="الباهاما">الباهاما</option>
                            <option value="البحرين">البحرين</option>
                            <option value="البرازيل">البرازيل</option>
                            <option value="البرتغال">البرتغال</option>
                            <option value="البوسنة والهرسك">البوسنة والهرسك</option>
                            <option value="الجابون">الجابون</option>
                            <option value="الجبل الأسود">الجبل الأسود</option>
                            <option value="الجزائر">الجزائر</option>
                            <option value="الدانمرك">الدانمرك</option>
                            <option value="الرأس الأخضر">الرأس الأخضر</option>
                            <option value="السلفادور">السلفادور</option>
                            <option value="السنغال">السنغال</option>
                            <option value="السودان">السودان</option>
                            <option value="الصحراء الغربية">الصحراء الغربية</option>
                            <option value="الصومال">الصومال</option>
                            <option value="الصين">الصين</option>
                            <option value="الفاتيكان">الفاتيكان</option>
                            <option value="الفيلبين">الفيلبين</option>
                            <option value="القطب الجنوبي">القطب الجنوبي</option>
                            <option value="الكاميرون">الكاميرون</option>
                            <option value="الكونغو - برازافيل">الكونغو - برازافيل</option>
                            <option value="الكويت">الكويت</option>
                            <option value="المجر">المجر</option>
                            <option value="المحيط الهندي البريطاني">المحيط الهندي البريطاني</option>
                            <option value="المغرب">المغرب</option>
                            <option value="المقاطعات الجنوبية الفرنسية">المقاطعات الجنوبية الفرنسية</option>
                            <option value="المكسيك">المكسيك</option>
                            <option value="المملكة المتحدة">المملكة المتحدة</option>
                            <option value="النرويج">النرويج</option>
                            <option value="النمسا">النمسا</option>
                            <option value="النيجر">النيجر</option>
                            <option value="الهند">الهند</option>
                            <option value="اليابان">اليابان</option>
                            <option value="اليمن">اليمن</option>
                            <option value="اليونان">اليونان</option>
                            <option value="اندونيسيا">اندونيسيا</option>
                            <option value="ايران">ايران</option>
                            <option value="ايطاليا">ايطاليا</option>
                            <option value="بابوا غينيا الجديدة">بابوا غينيا الجديدة</option>
                            <option value="باراجواي">باراجواي</option>
                            <option value="باكستان">باكستان</option>
                            <option value="بالاو">بالاو</option>
                            <option value="بتسوانا">بتسوانا</option>
                            <option value="بتكايرن">بتكايرن</option>
                            <option value="بربادوس">بربادوس</option>
                            <option value="برمودا">برمودا</option>
                            <option value="بروناي">بروناي</option>
                            <option value="بلجيكا">بلجيكا</option>
                            <option value="بلغاريا">بلغاريا</option>
                            <option value="بليز">بليز</option>
                            <option value="بنجلاديش">بنجلاديش</option>
                            <option value="بنما">بنما</option>
                            <option value="بنين">بنين</option>
                            <option value="بوتان">بوتان</option>
                            <option value="بورتوريكو">بورتوريكو</option>
                            <option value="بوركينا فاسو">بوركينا فاسو</option>
                            <option value="بوروندي">بوروندي</option>
                            <option value="بولندا">بولندا</option>
                            <option value="بوليفيا">بوليفيا</option>
                            <option value="بولينيزيا الفرنسية">بولينيزيا الفرنسية</option>
                            <option value="بيرو">بيرو</option>
                            <option value="تانزانيا">تانزانيا</option>
                            <option value="تايلند">تايلند</option>
                            <option value="تايوان">تايوان</option>
                            <option value="تركمانستان">تركمانستان</option>
                            <option value="ترينيداد وتوباغو">ترينيداد وتوباغو</option>
                            <option value="تشاد">تشاد</option>
                            <option value="توجو">توجو</option>
                            <option value="توفالو">توفالو</option>
                            <option value="توكيلو">توكيلو</option>
                            <option value="تونجا">تونجا</option>
                            <option value="تيمور الشرقية">تيمور الشرقية</option>
                            <option value="جامايكا">جامايكا</option>
                            <option value="جبل طارق">جبل طارق</option>
                            <option value="جرينادا">جرينادا</option>
                            <option value="جرينلاند">جرينلاند</option>
                            <option value="جزر أولان">جزر أولان</option>
                            <option value="جزر الأنتيل الهولندية">جزر الأنتيل الهولندية</option>
                            <option value="جزر الترك وجايكوس">جزر الترك وجايكوس</option>
                            <option value="جزر القمر">جزر القمر</option>
                            <option value="جزر الكايمن">جزر الكايمن</option>
                            <option value="جزر المارشال">جزر المارشال</option>
                            <option value="جزر الملديف">جزر الملديف</option>
                            <option value="جزر الولايات المتحدة البعيدة الصغيرة">جزر الولايات المتحدة البعيدة الصغيرة</option>
                            <option value="جزر سليمان">جزر سليمان</option>
                            <option value="جزر فارو">جزر فارو</option>
                            <option value="جزر فارو">جزر فارو</option>
                            <option value="جزر كوك">جزر كوك</option>
                            <option value="جزر كريسماس">جزر كريسماس</option>
                            <option value="جزر نافيبي">جزر نافيبي</option>
                            <option value="جزر هاواي">جزر هاواي</option>
                            <option value="جواتيمالا">جواتيمالا</option>
                            <option value="جيبوتي">جيبوتي</option>
                            <option value="جمهورية الكونغو الديمقراطية">جمهورية الكونغو الديمقراطية</option>
                            <option value="جزر المالديف">جزر المالديف</option>
                            <option value="جيبوتي">جيبوتي</option>
                            <option value="جمهورية التشيك">جمهورية التشيك</option>
                            <option value="جنوب السودان">جنوب السودان</option>
                            <option value="جنوب أفريقيا">جنوب أفريقيا</option>
                            <option value="غابون">غابون</option>
                            <option value="غامبيا">غامبيا</option>
                            <option value="غينيا">غينيا</option>
                            <option value="غينيا بيساو">غينيا بيساو</option>
                            <option value="فانواتو">فانواتو</option>
                            <option value="فرنسا">فرنسا</option>
                            <option value="فلسطين">فلسطين</option>
                            <option value="فيتنام">فيتنام</option>
                            <option value="فنلندا">فنلندا</option>
                            <option value="فنزويلا">فنزويلا</option>
                            <option value="كابو فيردي">كابو فيردي</option>
                            <option value="كازاخستان">كازاخستان</option>
                            <option value="كاليدونيا الجديدة">كاليدونيا الجديدة</option>
                            <option value="كامبوديا">كامبوديا</option>
                            <option value="كانادا">كانادا</option>
                            <option value="كرواتيا">كرواتيا</option>
                            <option value="كوبا">كوبا</option>
                            <option value="كولومبيا">كولومبيا</option>
                            <option value="كويت">الكويت</option>
                            <option value="كيريباتي">كيريباتي</option>
                            <option value="كولومبيا">كولومبيا</option>
                            <option value="كوسوفو">كوسوفو</option>
                            <option value="كوت ديفوار">كوت ديفوار</option>
                            <option value="لاتفيا">لاتفيا</option>
                            <option value="لبنان">لبنان</option>
                            <option value="ليبيا">ليبيا</option>
                            <option value="ليتوانيا">ليتوانيا</option>
                            <option value="مالاوي">مالاوي</option>
                            <option value="ماليزيا">ماليزيا</option>
                            <option value="مالي">مالي</option>
                            <option value="ماروكو">ماروكو</option>
                            <option value="مارتينيك">مارتينيك</option>
                            <option value="ماكاو">ماكاو</option>
                            <option value="مدغشقر">مدغشقر</option>
                            <option value="مصر">مصر</option>
                            <option value="موزمبيق">موزمبيق</option>
                            <option value="مولدوفا">مولدوفا</option>
                            <option value="مونتينيغرو">مونتينيغرو</option>
                            <option value="موريشيوس">موريشيوس</option>
                            <option value="موريتانيا">موريتانيا</option>
                            <option value="موريشيوس">موريشيوس</option>
                            <option value="مملكة البحرين">مملكة البحرين</option>
                            <option value="مملكة هولندا">مملكة هولندا</option>
                            <option value="منغوليا">منغوليا</option>
                            <option value="موزمبيق">موزمبيق</option>
                            <option value="مقدونيا">مقدونيا</option>
                            <option value="مالي">مالي</option>
                            <option value="ميانمار">ميانمار</option>
                            <option value="ناميبيا">ناميبيا</option>
                            <option value="نيوزيلندا">نيوزيلندا</option>
                            <option value="نيجر">نيجر</option>
                            <option value="نيجيريا">نيجيريا</option>
                            <option value="هندوراس">هندوراس</option>
                            <option value="هايتي">هايتي</option>
                            <option value="هونج كونج الصينية">هونج كونج الصينية</option>
                            <option value="يابان">يابان</option>
                        </select>
                        

                    </div>



                    {{-- <div class="form-group" style="text-align: center">
                        <label>من داخل سوريا</label>
                        <input type="radio" name="place" class="form-control place"
                            value="inside"
                            placeholder="من داخل سوريا" required>

                            <label>من خارج سوريا</label>

                            <input type="radio" name="place" class="form-control place"
                            value="outside"
                            placeholder="من خارج سوريا" required>
                    </div> --}}


                    {{-- <hr>


                    <div class="form-group" style="text-align: center">
                        <label>صف أول ابتدائي</label>
                        <input type="radio" name="status" class="form-control status"
                            value="new"
                            placeholder="Type phone" required>

                            <label>غير ذلك (طالب منقول من مدرسة أخرى)</label>

                            <input type="radio" name="status" class="form-control status"
                            value="transported"
                            placeholder="Type phone" required>
                    </div> --}}


                    {{--
                    <div id="mydiv1">

                    </div> --}}
                    {{--
                    <div class="form-group">
                        <label>الصورة الشخصية </label>

                        <div class="custom-file">
                            <input type="file" name="image" class="form-control" id="customFileLang"  >
                        </div>
                    </div> --}}




                    <div class="form-group">
                        <label>الصف</label>

                        <select name="class_id" id="classes" class="form-control dep"
                            style="min-height: 36px;direction: rtl" required>
                            <option value="">اختر الصف الدراسي</option>
                            @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach

                        </select>

                    </div>

                    <div class="form-group" id="">
                        <label>الشعبة</label>

                        <select name="room_id" id="class_room" class="form-control dep"
                            style="min-height: 36px;direction: rtl" required>
                            <option value="">اختر الشعبة الدراسية</option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label>رقم السجل العام </label>
                        <input type="text" name="public_record_number" class="form-control public_record_number"style="direction:rtl"
                            value="" maxlength="20"
                            placeholder="رقم السجل  العام" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                    <button class="btn btn-info" id="save" type="submit">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade changeStudentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('student_change') }}" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title"> &nbsp; <span class="student_name"
                            style="font-weight: bold; font-size: 20px"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">



                    <input type="hidden" name="student_id" id="student_id">
                    <input type="hidden" name="old_class_id" id="old_class_id2">

                    <input type="hidden" name="year_id" id="years" value={{$year2->id}}>

                    <div class="wrapper">
                        <input type="radio" name="select" id="option-1" value="0" checked>
                        <input type="radio" name="select" id="option-2" value="1">
                        <label for="option-1" class="option option-1">
                            <div class="dot"></div>
                            <span>راسب</span>
                        </label>
                        <label for="option-2" class="option option-2">
                            <div class="dot"></div>
                            <span>ناجح</span>
                        </label>
                    </div>
                    <div id="mydivclass">

                    </div>
                    <div class="form-group" id="mydivroom" style="text-align:right">
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


<div class="modal fade" id="update_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('teacher_update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="teacher_id" id="edit_teacher_id" hidden>
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">تعديل معلومات مدرس</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>الاسم الأول</label>
                        <input type="text" name="first_name" id="edit_first_name" class="form-control a" value=""
                            placeholder="اكتب اسمك الأول" maxlength="30" style="direction:rtl" required="">
                    </div>

                    <div class="form-group">
                        <label>الكنية</label>
                        <input type="text" name="last_name" id="edit_last_name" class="form-control b" value=""
                            placeholder="اكتب الكنية" maxlength="30" style="direction:rtl" required="">
                    </div>


                    <div class="form-group">
                        <label>تاريخ الولادة</label>
                        <input type="date" name="date_birth" id="edit_date_birth" class="form-control b" value=""
                            style="direction:rtl" placeholder="Type last name">
                    </div>

                    <div class="form-group">
                        <label>العنوان</label>
                        <input type="text" name="address" id="edit_address" class="form-control b" value=""
                            maxlength="100" placeholder="اكتب العنوان" style="direction:rtl">
                    </div>

                    <div class="form-group">
                        <label>الهاتف</label>
                        <input type="text" name="phone" id="edit_phone" class="form-control b" value=""
                            placeholder="اكتب رقم الهاتف" style="direction:rtl" maxlength="20" required="">
                    </div>

                    <div class="form-group">
                        <label>البريد الإلكتروني</label>
                        <input type="email" name="email" id="edit_email" class="form-control b email" value=""
                            maxlength="50" placeholder="اكتب البريد الالكتروني " required="">
                        <span class="text-danger error validate_email"></span>
                    </div>

                    <label for="" style="float: right;">كلمة المرور</label>
                    <br>
                    <small id="alert" style="color: #f00;"></small>


                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                        </div>
                        <input name="password" id="edit_password" type="password" value="" size="15"
                            class="input form-control" id="password" placeholder="اكتب كلمة المرور"
                            aria-label="password" aria-describedby="basic-addon1">
                    </div>

                    <label style="float: right;">تأكيد كلمة المرور</label>
                    <br>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                        </div>
                        <input name="password_confirmation" id="edit_password_confirmation" type="password" value=""
                            size="15" class="input form-control" id="password-confirm"
                            placeholder="أعد كتابة كلمة المرور" aria-label="password" aria-describedby="basic-addon1">
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


<div class="modal fade financialaccountModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('invoice_store') }}" enctype="multipart/form-data">
                @csrf

                <div class="modal-header" style="direction:rtl">
                    <h4 class="modal-title">الحساب المالي &nbsp; <span class="student_name"
                            style="font-weight: bold; font-size: 20px"></span></h4>

                    <a class="btn btn-danger btn-sm details" style="    margin-right: 10rem;">تفاصيل</a>


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
                            <label style="padding: 20px;font-size: 20px" id="full_account"
                                class="badge badge-primary"></label>
                        </div>

                        <div class="col-4">
                            <label for="" style="padding: 20px;font-size: 20px" class="badge badge-success"
                                id="amount_paid"></label>

                        </div>

                        <div class="col-4">
                            <label for="" style="padding: 20px;font-size: 20px" class="badge badge-warning"
                                id="remaining_account"></label>

                        </div>
                    </div>

                    <br>

                    <button type="button" class="btn btn-primary btn-block add_reciept" data-toggle="collapse"
                        data-target="#demo"> اضافة فاتورة</button>
                    <div id="demo" class="collapse">

                        <br>

                        <div class="form-group" style="text-align:right">
                            <label>رقم الفاتورة</label>
                            <input type="text" name="invoice_number" class="form-control b" value="" maxlength="20">
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label>المبلغ المدفوع</label>
                            <input type="number" name="invoice_amount" class="form-control" id="invoice_amount"
                                value="">
                        </div>
                                  <div class="form-group" style="text-align:right">
                            <label>نوع الدفع </label>
                            <input type="text" name="payment_type" class="form-control" id="payment_type"
                                value="">
                        </div>
                        <div class="form-group" style="text-align:right">
                            <label> اسم البنك</label>
                            <input type="text" name="bank_name" class="form-control" id="bank_name"
                                value="">
                        </div>

                        <div class="modal-footer">
                            <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                            <button class="btn btn-info">حفظ</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade changeLangModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{route('change_lang')}}" enctype="multipart/form-data">
                @csrf

                <div class="modal-header" style="direction:rtl">
                    <h4 class="modal-title"> تغيير لغة الطالب &nbsp; <span class="student_name"
                            style="font-weight: bold; font-size: 20px"></span></h4>

                    <button type="button" class="close" style=" margin: -1rem -1rem auto;" data-dismiss="modal"
                        aria-hidden="true">&times;</button>

                </div>
                <div class="modal-body">

                    <input type="hidden" name="student_id" id="student_change_lang_id">

                    <div class="wrapper_lang">
                        <input type="radio" class="select_lang" name="select_lang" id="option-lang1" value="0" required>
                        <input type="radio" class="select_lang" name="select_lang" id="option-lang2" value="1" required>

                        <label for="option-lang2" class="option option-lang2">
                            <div class="dot"></div>
                            <span>روسي </span>

                        </label>

                        <label for="option-lang1" class="option option-lang1">
                            <div class="dot"></div>
                            <span> فرنسي</span>

                        </label>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" data-dismiss="modal">إالغاء</a>
                        <button class="btn btn-info">إرسال</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade sendMessageModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('send_message') }}" enctype="multipart/form-data">
                @csrf

                <div class="modal-header" style="direction:rtl">
                    <h4 class="modal-title">إرسال رسالة &nbsp; <span class="student_name"
                            style="font-weight: bold; font-size: 20px"></span></h4>
                    <button type="button" class="close" style=" margin: -1rem -1rem auto;" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="student_id" id="student_send_message_id">
                    <div class="form-group">

                        <textarea name="message" style="direction:rtl; text-alighn:right" class="form-control" autofocus
                            id="" cols="30" rows="6">

                            </textarea>

                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" data-dismiss="modal">إالغاء</a>
                        <button class="btn btn-info">إرسال</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="create_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('teacher_store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">إنشاء مدرس</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>الاسم الأول</label>
                        <input type="text" name="first_name" class="form-control a" value=""
                            placeholder="اكتب اسمك الأول" maxlength="30" style="direction:rtl" required="">
                    </div>

                    <div class="form-group">
                        <label>الكنية</label>
                        <input type="text" name="last_name" class="form-control b" value="" placeholder="اكتب الكنية"
                            maxlength="30" style="direction:rtl" required="">
                    </div>


                    <div class="form-group">
                        <label>تاريخ الولادة</label>
                        <input type="date" name="date_birth" class="form-control b" value="" style="direction:rtl"
                            placeholder="Type last name">
                    </div>

                    <div class="form-group">
                        <label>العنوان</label>
                        <input type="text" name="address" class="form-control b" value="" maxlength="100"
                            placeholder="اكتب العنوان" style="direction:rtl">
                    </div>

                    <div class="form-group">
                        <label>الهاتف</label>
                        <input type="text" name="phone" class="form-control b" value="" placeholder="اكتب رقم الهاتف"
                            style="direction:rtl" maxlength="20" required="">
                    </div>

                    <div class="form-group">
                        <label>البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control b email" value="" maxlength="50"
                            placeholder="اكتب البريد الالكتروني " required="">
                        <span class="text-danger error validate_email"></span>
                    </div>

                    <label for="" style="float: right;">كلمة المرور</label>
                    <br>
                    <small id="alert" style="color: #f00;"></small>


                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                        </div>
                        <input name="password" type="password" value="" size="15" class="input form-control"
                            id="password" placeholder="اكتب كلمة المرور" required="true" aria-label="password"
                            aria-describedby="basic-addon1">
                    </div>

                    <label style="float: right;">تأكيد كلمة المرور</label>
                    <br>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                        </div>
                        <input name="password_confirmation" type="password" value="" size="15"
                            class="input form-control" id="password-confirm" placeholder="أعد كتابة كلمة المرور"
                            required="true" aria-label="password" aria-describedby="basic-addon1">
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
    <div class="card-body" style="text-align: right;">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول الطلاب</h1>
        </div>
         @can('create_student')
        <a  class="btn  btn-success" data-toggle="modal" data-target=".createStudentModal"
            >إنشاء طالب</a>
            {{-- <a   target="_blank" href="{{ route('st_import') }}" class="btn  btn-success"
            > إدخال الطلاب </a> --}}
           @endcan

             {{-- @can('export_student')
            <a class="btn btn-success" data-target="#selectexport" data-toggle="modal"> تصدير الطلاب
            </a>
             @endcan --}}
               {{-- @can('student_details_department')
             <a class="btn btn-success"   href="{{ route('student_details_department') }}"    >   اضافة قسم للادخال
             </a>
              @endcan --}}
            <br>
        <br>
        <br>
        <div class="row">

            {{-- <select class="form-control col-12 col-lg-3" id="stage_id_filter">
                <option value="0">اختر المرحلة </option>
                @foreach ($stages as $stage)
                <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                @endforeach
            </select> --}}
            <select class="form-control col-12 col-lg-3" id="class_id_filter">
                <option value="">اختر صف</option>

                @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>

            <select class="form-control col-12 col-lg-3" id="room_id_filter">
                <option value="">اختر شعبة</option>
            </select>
        </div>
               @can('student_phone')
                    <input type="hidden"  id="hidden_student_phone" value="1">
                        @endcan
         <div class="table-responsive" style="overflow-x: scroll;">
            <table class="table align-items-center" id="table_xx">
                <thead class="thead-light">
                    <tr>
                        <!--<th scope="col" class="sort" data-sort="budget">رقم الطالب  </th>-->
                        <th scope="col" class="sort" data-sort="budget">رقم السجل العام   </th>
                        <th scope="col" class="sort" data-sort="budget">الإسم الأول</th>
                        <th scope="col" class="sort" data-sort="status">الكنية</th>
                        <th scope="col" class="sort" data-sort="completion">العنوان</th>
                                       @can('student_phone')
                        <th scope="col" class="sort" data-sort="completion">الهاتف</th>
                       @endcan
                        <th scope="col" class="sort" data-sort="completion">الصورة</th>
                        <th scope="col" class="sort" data-sort="completion">الصف</th>
                        <th scope="col" class="sort" data-sort="completion">الشعبة</th>
                        <th scope="col" class="sort" data-sort="completion">العمليات</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>
</div>
<div class="modal fade" id="selectexport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="min-width: 50%">
    <form action="{{ route('export_student1') }}" method="post">
        @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">تصدير طلاب</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                <div class="row" >
                    <div class="col-12 col-lg-4">
                    <select class="form-control "   name="stage" id="stage_id_filter1">
                        <option value="0">  جميع المراحل </option>
                        @foreach ($stages as $stage)
                        <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                        @endforeach
                    </select>
                </div>
                    <div class="col-12 col-lg-4">


                        <select  name="classes" id="classes_select" class="form-control" >
                            <option value="0"> جميع الصفوف </option>
                            @foreach ($classes as $item)
                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-4">
                        <select  name="rooms" id="rooms_classes" class="form-control" >
                            <option value="0"> جميع الشعب </option>
                        </select>
                    </div>
                </div>
        </div>
        <div class="modal-footer" style="display: flex;justify-content: flex-start;" >
          <a class="btn btn-secondary" data-dismiss="modal">اغلاق</a>
          <button type="submit" class="btn btn-primary note_disabled">تصدير</button>
        </div>
    </div>
    </form>
    </div>
  </div>
@endsection

@section('js')







<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script>

    var i=0;
    var v=0;
var x=[];
var obj ={ };
var obj1={ };

console.log(obj);
if($('#hidden_student_phone').val()==1){
    var table_test = $('#table_xx').DataTable({

        processing: true,
        oLanguage: {
            sProcessing: "<h1>Proccessing</h1>"
        },
        serverSide: true,
        "pageLength": 10,
        "ajax": {
            "type": "GET",
            "url": "{{ route('getstudents') }}",
            data: function (d) {
                d.class_id = $('#class_id_filter').val();
                d.room_id = $('#room_id_filter').val();
                d.stage_id = $('#stage_id_filter').val();

            },
            "type": "GET",
            "dataSrc": function (json) {
                console.log(json.aaData);

                return json.aaData;
            }
        },

        columns: [
            // {

            //     data: 'id',
            //     render: function (data, type, full) {

            //         if(full.room[0].id==v  && (full.id in obj)!=true ){
            //             i= i+1;

            //             console.log(i);
            //           obj[full.id]=i;
            //             obj1[full.room[0].id]=obj;
            //             }else if((full.id in obj)!=true && jQuery.inArray(full.room[0].id,x)==-1) {

            //                 i=1;
            //                  x.push(full.room[0].id)
            //                 obj[full.id]=i;
            //                  obj1[full.room[0].id]=obj;
            //                                       ;

            //             }

            //                                         console.log(obj1);

            //         return `${obj[full.id]}`;
            //     },orderable : false
            //     },

               {

                data: 'id',
                render: function (data, type, full) {
                    return  `${full.public_record_number}`;
                },orderable : false
            },

        {

                data: 'id',
                render: function (data, type, full) {
                    return  `${full.first_name}`;
                },orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.last_name}`;
                },orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.address}`;
                },orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `   ${full.details.phone != null ? full.details.phone : ''} `;
                },orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.details.personal_image != null ? `<img width="80" height="80" src="{!! asset('storage') !!}/${full.details.personal_image}" >` : ""}`;
                },orderable : false
            },

            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.room[0] != null ? full.room[0].classes.name : ""}`;
                },orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                     return `${full.room[0] != null ? full.room[0].name : ""}`;
                },orderable : false
            },
            {

                data: 'id',
                render: function (data, type, full) {
                    return ` @can('update_student')
                    <div class="dropdown" style="display: inline-block;">
                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
        <a href=".financialaccountModal" class="dropdown-item financial_account" data-toggle="modal" data-id="${full.id}" data-name="${ full.first_name+" "+full.last_name }" data-class="${ full.room[0] != null ? full.room[0].classes.id : '0' }" style="
                    direction: ltr;"><i class="fa fa-folder"></i>الحساب المالي</a>
                    

                    <a href=".changeLangModal" class="dropdown-item change_lang" data-toggle="modal" data-id="${full.id}" data-lang="${ full.lang }" style="direction: ltr;"><i class="fa fa-folder"></i> تغيير لغة الطالب</a>
                </div>
                </div>
                @endcan

           
                @can('update_student')
                <a href="{{ url('SMT/admin/students/student_details') }}/${full.id}"  style="color: #0083FF"><i class="fa fa-eye fa-2x" style="color: #008CC4;font-size: medium"></i></a>
             
                                    <a href="{{ url('SMT/admin/students/student_vaccines') }}/${full.id}"  style="color: #0083FF"><i class="fa fa-heartbeat" style="color: #008CC4"></i></a>

                 @endcan
                @can('Account_Information_student')
                <a class="share_teacher" data-toggle="modal" data-target="#user_name_modal" data-username="${ full.user.email }" data-name="${ full.first_name+" "+full.last_name }" data-pass="${ full.user.view_password }" > <i class="fa fa-send fa-2x" style="color: #0083FF;font-size: medium"></i> </a>
                   @endcan



                </a>
                 @can('delete_student')
                <a class="delete_class_modal" data-toggle="modal" data-target="#delete_class" data-name="${ full.first_name+" "+full.last_name }" data-id="${ full.id }"  > <i class="fa fa-trash-alt fa-2x" style="color: red;font-size: medium"></i> </a>
                @endcan `;
                },orderable : false
            },

        ],
        // dom: 'Bfrtip',
        buttons: [

            'excelHtml5',

        ]


    });
}
else{
      var table_test = $('#table_xx').DataTable({

        processing: true,
        oLanguage: {
            sProcessing: "<h1>Proccessing</h1>"
        },
        serverSide: true,
        "pageLength": 10,
        "ajax": {
            "type": "GET",
            "url": "{{ route('getstudents') }}",
            data: function (d) {
                d.class_id = $('#class_id_filter').val();
                d.room_id = $('#room_id_filter').val();
                d.stage_id = $('#stage_id_filter').val();
            },
            "type": "GET",
            "dataSrc": function (json) {
                console.log(json.aaData);

                return json.aaData;
            }
        },

        columns: [
            // {

            //     data: 'id',
            //     render: function (data, type, full) {

            //         if(full.room[0].id==v  && (full.id in obj)!=true ){
            //             i= i+1;

            //             console.log(i);
            //           obj[full.id]=i;
            //             obj1[full.room[0].id]=obj;
            //             }else if((full.id in obj)!=true && jQuery.inArray(full.room[0].id,x)==-1) {

            //                 i=1;
            //                  x.push(full.room[0].id)
            //                 obj[full.id]=i;
            //                  obj1[full.room[0].id]=obj;
            //                                       ;

            //             }

            //                                         console.log(obj1);

            //         return `${obj[full.id]}`;
            //     },orderable : false
            //     },

               {

                data: 'id',
                render: function (data, type, full) {
                    return  `${full.id}`;
                },orderable : false
            },

        {

                data: 'id',
                render: function (data, type, full) {
                    return  `${full.first_name}`;
                },orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.last_name}`;
                },orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.address}`;
                },orderable : false
            },

            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.details.personal_image != null ? `<img width="80" height="80" src="{!! asset('storage') !!}/${full.details.personal_image}" >` : ""}`;
                },orderable : false
            },

            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.room[0] != null ? full.room[0].classes.name : ""}`;
                },orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    v=full.room[0].id;
                    return `${full.room[0] != null ? full.room[0].name : ""}`;
                },orderable : false
            },
            {

                data: 'id',
                render: function (data, type, full) {
                    return ` @can('update_student')
                    <div class="dropdown" style="display: inline-block;">
                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">

        <a href=".financialaccountModal" class="dropdown-item financial_account" data-toggle="modal" data-id="${full.id}" data-name="${ full.first_name+" "+full.last_name }" data-class="${ full.room[0] != null ? full.room[0].classes.id : '0' }" style="
                    direction: ltr;"><i class="fa fa-folder"></i>الحساب المالي</a>
                    
                    <a href=".changeLangModal" class="dropdown-item change_lang" data-toggle="modal" data-id="${full.id}" data-lang="${ full.lang }" style="direction: ltr;"><i class="fa fa-folder"></i> تغيير لغة الطالب</a>
                </div>
                </div>
                @endcan

                 <a style="" href="{{ url('SMT/admin/student_attendance_month') }}/${full.id}/${ full.room[0] != null ? full.room[0].id : '0' }" class=" " title="دفتر الحضور">
                            <i class="fa fa-check-square fa-2x" style="color: #1964aa;font-size: medium"></i>
                </a>
                @can('update_student')
                <a href="{{ url('SMT/admin/students/student_details') }}/${full.id}"  style="color: #0083FF"><i class="fa fa-eye fa-2x" style="color: #008CC4;font-size: medium"></i></a>
              <a href="{{ url('SMT/admin/students/student_vaccines') }}/${full.id}"  style="color: #0083FF"><i class="fa fa-heartbeat" style="color: #008CC4"></i></a>

                 @endcan
                @can('Account_Information_student')
                <a class="share_teacher" data-toggle="modal" data-target="#user_name_modal" data-username="${ full.user.email }" data-name="${ full.first_name+" "+full.last_name }" data-pass="${ full.user.view_password }" > <i class="fa fa-send fa-2x" style="color: #0083FF;font-size: medium"></i> </a>
                   @endcan

                 @can('delete_student')
                <a class="delete_class_modal" data-toggle="modal" data-target="#delete_class" data-name="${ full.first_name+" "+full.last_name }" data-id="${ full.id }"  > <i class="fa fa-trash-alt fa-2x" style="color: red;font-size: medium"></i> </a>
                @endcan `;
                },orderable : false
            },

        ],
        // dom: 'Bfrtip',
        buttons: [

            'excelHtml5',

        ]


    });
}



    $('#room_id_filter,#stage_id_filter').change(function () {
        table_test.draw();
    })



    $(document).on('click', '.delete_class_modal', function (e) {
        $('#delete_class_id').val($(this).data('id'));
        $('#h4_text').text(" هل انت متأكد من حذف الطالب " + " " + $(this).data('name'));
    });


    $(document).on('click', '.change_lang', function () {

        $('#student_change_lang_id').val($(this).data('id'));

        if ($(this).data('lang') == '0') {
            $('#option-lang1').prop("checked", true);

        } else if ($(this).data('lang') == '1') {
            $('#option-lang2').prop("checked", true);
        }

    });


    $(document).on('click', '.edit_teacher', function (e) {
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



    $(document).on('click', '.financial_account', function () {
        var student_id = $(this).data('id');
        var class_id = $(this).data('class');
        var student_name = $(this).data('name');

        $('#student_financial_id').val($(this).data('id'));
        $('#class_id').val($(this).data('class'));
        $('.student_name').text($(this).data('name'));

        var url = "{{ URL::to('SMT/admin/students/invoices_details')}}/" + student_id;
        $('.details').attr('href',url);
        var url = "{{ URL::to('SMT/admin/students/remain_account') }}/" + student_id + "/" + class_id;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
console.log(data);
                $('#full_account').text(data.full_amount);
                $('#remaining_account').text(data.remain_amount);
                $('#amount_paid').text(data.amount_paid);

                $('#invoice_amount').attr('max', data.remain_amount);

                if (data.remain_amount == 0) {

                    $('.add_reciept').hide();

                } else {
                    $('.add_reciept').show();

                }

            },

        });

    });



    $(document).on('change', '#classes', function () {
        var class_id = $(this).val();

        var url = "{{ URL::to('SMT/admin/classes/rooms') }}/" + class_id;
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


    $(document).on('change', '#class_id_filter', function () {

        var year_id = $('#years').val();
        var class_id = $(this).val();
        var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id + "/" + year_id;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
                $('#room_id_filter').empty();
                $('#room_id_filter').append(`<option value="">اختر الشعبة </option>`);
                $.each(data, function (key, value) {
                    $('#room_id_filter').append(
                        `<option value="${value.id}">${value.name}</option>`);
                });
                 table_test.draw();
            },


        });

    });
    $(document).on('change', '#stage_id_filter', function () {

// var year_id = $('#years').val();
var stage_id = $(this).val();
var url = "{{ URL::to('SMT/admin/stages_class') }}/" + stage_id ;
$.ajax({
    url: url,
    type: "get",
    contentType: 'application/json',
    success: function (data) {
        $('#class_id_filter').empty();
        $('#class_id_filter').append(`<option value="">اختر  الصف  </option>`);
        $.each(data, function (key, value) {
            $('#class_id_filter').append(
                `<option value="${value.id}">${value.name}</option>`);
        });
    },


});
});
$(document).on('change', '#stage_id_filter1', function () {

// var year_id = $('#years').val();
var stage_id = $(this).val();
var url = "{{ URL::to('SMT/admin/stages_class') }}/" + stage_id ;
$.ajax({
    url: url,
    type: "get",
    contentType: 'application/json',
    success: function (data) {
        $('#classes_select').empty();
        $('#classes_select').append(`<option value="">اختر  الصف  </option>`);
        $.each(data, function (key, value) {
            $('#classes_select').append(
                `<option value="${value.id}">${value.name}</option>`);
        });
    },


});
});




    $(document).on('change', '#classes_change', function () {
        $('#mydivroom').empty();

        var year_id = $('#years').val();
        var class_id = $(this).val();

        var type = "";

        var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id + "/" + year_id;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
                var type = `
                <label>الشعبة</label>

                <select name="rooms" id="" class="form-control dep"
                    style="min-height: 36px;direction:rtl" required>
                    <option value="">اختر الشعبة الدراسية</option>

                    `;

                $.each(data, function (key, value) {
                    type += `<option value="${value.id}">${value.name}</option>`;
                });

                type += `</select>`;
                $('#mydivroom').append(type);
            },


        });
    });


    $('input:radio[name=select]').on('click', function () {
        $('#mydivclass').empty();
        var val = $(this).val();
        var type = "";
        type += `
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



    $(document).on('click', '.change_student', function () {

        $('#student_id').val($(this).data('id'));

        var student_id = $(this).data('id');
        var student_name = $(this).data('name');
        var url = "{{ URL::to('SMARMANger/admin/students/student_detail_prev') }}/" + student_id;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
                $('.student_name').text(student_name + " عام " + data.year_name + " كان" +
                    " في الصف  " + data.class_name + " " + data.room_name);
            },
            error: function (xhr) {

            }

        });

    });



    $(document).on('click', '.student_less', function (e) {
        var student_id = $(this).data('id');
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: "{{ route('student.less') }}",
            enctype: 'multipart/form-data',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': student_id,
            },
            success: function (data) {
                $(`#super_${student_id}`).attr('style', 'color:blue');
                $(`#super_${student_id}`).parent().attr('class', 'student_super')
            },
        });
    });

    $(document).on('click', '.student_super', function (e) {
        var student_id = $(this).data('id');
        e.preventDefault();
        $.ajax({

            type: 'post',
            url: "{{ route('student.super') }}",
            enctype: 'multipart/form-data',
            data: {
                '_token': "{{ csrf_token() }}",
                'id': student_id,
            },


            success: function (data) {
                $(`#super_${student_id}`).attr('style', 'color:green');
                $(`#super_${student_id}`).parent().attr('class', 'student_less')
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
<script>
    $(document).on("click", ".share_teacher", function () {
        $('#pass_share').text($(this).data("pass"));
        $('#username_share').text($(this).data("username"));
        $('#name_share').text($(this).data("name"));
    });

    $(document).on("click", "#screenshot", function () {
        html2canvas(document.querySelector("#dvContainer")).then(canvas => {
            a = document.createElement('a');
            document.body.appendChild(a);
            a.download = $('#name_share').text() + ".png";
            a.href = canvas.toDataURL();
            a.click();
        });
    });

    $(document).on('change', '#classes_select', function () {

var year_id=$('#years').val();
var class_id=$(this).val();
var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id +"/"+ year_id;
$('#rooms_classes').empty();
$('#rooms_classes').append(`<option value="0">جميع الشعب</option>`);
$.ajax({
    url: url,
    type: "get",
    contentType: 'application/json',
    success: function (data) {
        $.each(data, function (key, value) {
            $('#rooms_classes').append(`<option value="${value.id}">${value.name}</option>`);
        });
    },


});
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

                // if(data.remain_amount==0){

                //     $('.add_reciept').hide();

                // }else{
                //     $('.add_reciept').show();

                // }

            },

        });

});



    $(document).on('click', '.edit_teacher', function (e) {
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
    $(".english_name").keypress(function (event) {
        var ew = event.which;
        if (ew == 32)
            return true;
        if (48 <= ew && ew <= 57)
            return true;
        if (65 <= ew && ew <= 90)
            return true;
        if (97 <= ew && ew <= 122)
            return true;
        return false;
    });
</script>


@endsection
