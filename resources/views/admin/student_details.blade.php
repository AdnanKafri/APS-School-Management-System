@extends('admin.master')
@section('style')
<style>
    * {
        direction: rtl !important;
    }

    .form-group {
        direction: rtl !important;
        text-align: right;
    }

    .heading-small {
        text-align: center !important;
        color: #001586 !important;
        font-size: 20px
    }
</style>
<style>
    .custom-file-label {
        display: none;
    }

    .pl-lg-4 label {
        font-size: 20px;
        font-weight: 600;
        color: black !important;
    }
</style>
@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a class="breadcrumbs__item is-active "> تعديل طالب </a>
    <a href="{{ route('students') }}" class="breadcrumbs__item "> شؤون الطلاب الطلاب</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')

@if(session()->has('success'))

<div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    {{ session()->get('success') }}
</div>
@endif



<div class="row">


    <div class="modal fade " id="change_password">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="" action="{{ route('change_password') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" hidden name="user_id" value="{{ $student->user->id }}">
                    <div class="modal-header" style="direction: rtl">
                        <h2 class="modal-title"> تغيير كلمة المرور</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                            style="padding: 0px;margin: 0px;">&times;</button>
                    </div>
                    <div class="modal-body" style="font-size: 25px;text-align: center;color: black">
                        <div class="form-group">
                            <label for="">البريد الالكتروني</label>
                            <input type="email" name="email" value="{{  $student->user->email }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">كلمة المرور</label>
                            <input type="text" name="password" class="form-control" autocomplete="false">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                        <button class="btn btn-primary" type="submit">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="col-xl-1 col-lg-1 col-12"></div>
    <div class="col-xl-10 col-lg-10 col-12">
        <div class="card" style="margin: 30px">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-7">
                        <h2 class="mb-0" style="color: #001586"> تعديل طالب </h2>
                    </div>
                    <!--<div class="col-6 text-right">-->
                    <!--  <span  class="btn btn-lg btn-primary">-->

                    <!--      @if ($student->place=='inside')-->
                    <!--      داخلي-->
                    <!--      @else-->
                    <!--      خارجي-->
                    <!--      @endif-->
                    <!--  </span>-->

                    <!--  <span  class="btn btn-lg btn-warning">-->

                    <!--      @if ($student->transparent=='new')-->
                    <!--      قديم-->
                    <!--      @else-->
                    <!--      منقول-->
                    <!--      @endif-->
                    <!--  </span>-->
                    <!--</div>-->
                </div>
            </div>






            <div class="card-body" style="text-align:right">
                <a class="btn btn-danger" data-target="#change_password" data-toggle="modal" style="color:white;"> تغيير
                    كلمة المرور </a>
                <form method="post" action="{{ route('student_update',$student->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <h1 class="heading-small text-muted mb-4" style="font-size: 30px">المعلومات الشخصية</h1>
                    <div class="pl-lg-4">

                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">البريد الإلكتروني</label>
                                    <input type="email" id="input-email" name="email" required
                                        class="form-control email" value="{{ $student->user->email }}">

                                    @error('email')
                                    <div class="error er" style="color: red">عذرا , الايميل موجود مسبقا</div>
                                    @enderror

                                    <span class="text-danger error validate_email">


                                    </span>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-last-name">تاريخ الميلاد</label>
                                    <input type="date" id="input-last-name" name="date_birth" class="form-control"
                                        value="{{ $student->date_birth }}">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-first-name">الإسم الأول
                                        بالعربية</label>
                                    <input type="text" id="input-first-name" name="first_name" required
                                        class="form-control" value="{{ $student->first_name }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-last-name">الكنية بالعربية</label>
                                    <input type="text" id="input-last-name" name="last_name" required
                                        class="form-control" value="{{ $student->last_name }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-first-name">الإسم الأول
                                        بالانكليزية</label>
                                    <input type="text" id="input-first-name_en" name="first_name_en" required
                                        class="form-control" value="{{ $student->first_name_en }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-last-name">الكنية بالانكليزية</label>
                                    <input type="text" id="input-last-name_en" name="last_name_en" required
                                        class="form-control" value="{{ $student->last_name_en }}">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-first-name">اسم الأب</label>
                                    <input type="text" id="input-first-name" name="father_name"
                                        class="form-control" value="{{ $student_detail->father_name }}">
                                </div>
                            </div>
                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-first-name">اسم الجد</label>
                                    <input type="text" id="input-grandfather-name" name="grandfather_name"
                                        class="form-control" value="{{ $student_detail->grandfather_name }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-first-name">رقم الأب</label>
                                    <input type="text" id="input-father-phone" name="father_phone"
                                        class="form-control" value="{{ $student_detail->father_phone }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-last-name">اسم الأم</label>
                                    <input type="text" id="input-last-name" name="mother_name" class="form-control"
                                        value="{{ $student_detail->mother_name }}">
                                </div>
                            </div>
                                <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-last-name">كنية الأم</label>
                                    <input type="text" id="input-last-name" name="last_mother_name" class="form-control"
                                        value="{{ $student_detail->last_mother_name }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-last-name"> رقم الأم</label>
                                    <input type="text" id="input-mother-phone" name="mother_phone" class="form-control"
                                        value="{{ $student_detail->mother_phone }}">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group">
                                   <label class="form-control-label" for="input-last-name">عمل الأم</label>
                                    <input type="text" name="mother_job" class="form-control"
                                        value="{{ $student_detail->mother_job }}">
                                </div>
                           </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-last-name"> عمل الأب</label>
                                    <input type="text" name="father_job" class="form-control"
                                        value="{{ $student_detail->father_job }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                  <label class="form-control-label" for="input-country">الرقم في السجل العام</label>
                                  <input type="text" id="input-public_record_number" name="public_record_number" class="form-control public_record_number" value="{{$student->public_record_number }}">
                                </div>
                              </div>








                            <!-- <div class="col-lg-12">
                    <div class="form-group">
                        <label>الصف</label>

                        <select name="class_id" id="classes" class="form-control dep"
                            style="min-height: 36px;direction: rtl" required>
                            <option value="">اختر الصف الدراسي</option>

                        @foreach ($classes as $class)

                        <option value="{{ $class->id }}"  {{ $student->room[0]->classes->id  ==  $class->id   ? 'selected' :''}}

                            >{{ $class->name }}</option>
                        @endforeach

                        </select>

                    </div>
                  </div> -->

                            <input type="hidden" name="class_id" value="{{ $student->room[0]->classes->id}}">
                             <input type="hidden" name="gender" value="{{ $student->gender}}">
                             <input type="hidden" name="religion" value="{{ $student->religion}}">



                            <div class="col-lg-6">

                                <div class="form-group" id="class_room">

                                    <label>الشعبة</label>

                                    <select name="room_id" id="" class="form-control"
                                        style="min-height: 36px;direction: rtl" required>
                                        <option value="">اختر الشعبة الدراسي</option>

                                        @foreach ($rooms as $room)

                                        <option value="{{ $room->id }}"
                                            {{ $student->room[0]->id  ==  $room->id   ? 'selected' :''}}>
                                            {{ $room->name }}</option>
                                        @endforeach

                                    </select>


                                </div>
                            </div>
                            
                                        <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-address">العنوان الحالي </label>
                                    <input id="input-address"  class="form-control" name="address" placeholder="العنوان الحالي "
                                        value="{{ $student->address }}" type="text">
                                </div>
                            </div>

                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label>الدولة   </label>

                                    <select class="form-control ldir" for="country" id="country" placeholder="الدولة " name="country" required>
                                        <option value="{{ $student->country }}">{{ $student->country }} </option>
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



                          

                        </div>
                        
                    </div>
                    <hr class="my-4">
                    <!-- Address -->
                    <h6 class="heading-small text-muted mb-4">معلومات التواصل</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-address">الدولة </label>
                                    <input id="input-address" class="form-control" name="address"
                                        placeholder="عنوان السكن" value="
                                    @if($student->address  == " AF") Afghanistan @elseif($student->address == "AX")
                                    Aland Islands
                                    @elseif($student->address == "AL")
                                    Albania
                                    @elseif($student->address == "DZ")
                                    Algeria
                                    @elseif($student->address == "AS")
                                    American Samoa
                                    @elseif($student->address == "AD")
                                    Andorra
                                    @elseif($student->address == "AO")
                                    Angola
                                    @elseif($student->address == "AI")
                                    Anguilla
                                    @elseif($student->address == "AQ")
                                    Antarctica
                                    @elseif($student->address == "AG")
                                    Anguilla
                                    @elseif($student->address == "AR")
                                    Argentina
                                    @elseif($student->address == "AW")
                                    Aruba
                                    @elseif($student->address == "AM")
                                    Armenia
                                    @elseif($student->address == "AU")
                                    Australia
                                    @elseif($student->address == "AT")
                                    Austria
                                    @elseif($student->address == "AZ")
                                    Azerbaijan
                                    @elseif($student->address == "BS")
                                    Bahamas
                                    @elseif($student->address == "BH")
                                    Bahrain
                                    @elseif($student->address == "BD")
                                    Bangladesh
                                    @elseif($student->address == "BB")
                                    Barbados
                                    @elseif($student->address == "BY")
                                    Belarus
                                    @elseif($student->address == "BE")
                                    Belgium
                                    @elseif($student->address == "BZ")
                                    Belize
                                    @elseif($student->address == "BJ")
                                    Benin
                                    @elseif($student->address == "BM")
                                    Bermuda
                                    @elseif($student->address == "BT")
                                    Bhutan
                                    @elseif($student->address == "BO")
                                    Bolivia
                                    @elseif($student->address == "BQ")
                                    Bonaire, Sint Eustatius and Saba
                                    @elseif($student->address == "BA")
                                    Bosnia and Herzegovina
                                    @elseif($student->address == "BW")
                                    Botswana
                                    @elseif($student->address == "BV")
                                    Bouvet Island
                                    @elseif($student->address == "BR")
                                    Brazil
                                    @elseif($student->address == "IO")
                                    British Indian Ocean Territory
                                    @elseif($student->address == "BN")
                                    Brunei Darussalam
                                    @elseif($student->address == "BG")
                                    Bulgaria
                                    @elseif($student->address == "BF")
                                    Burkina Faso
                                    @elseif($student->address == "BI")
                                    Burundi
                                    @elseif($student->address == "KH")
                                    Cambodia
                                    @elseif($student->address == "CM")
                                    Cameroon
                                    @elseif($student->address == "CA")
                                    Canada
                                    @elseif($student->address == "CV")
                                    Cape Verde
                                    @elseif($student->address == "KY")
                                    Cayman Islands
                                    @elseif($student->address == "CF")
                                    Central African Republic
                                    @elseif($student->address == "TD")
                                    Chad
                                    @elseif($student->address == "CL")
                                    Chile
                                    @elseif($student->address == "CN")
                                    China
                                    @elseif($student->address == "CX")
                                    Christmas Island
                                    @elseif($student->address == "CC")
                                    Cocos (Keeling) Islands
                                    @elseif($student->address == "CO")
                                    Colombia
                                    @elseif($student->address == "KM")
                                    Comoros
                                    @elseif($student->address == "CG")
                                    Congo
                                    @elseif($student->address == "CD")
                                    Congo, Democratic Republic of the Congo
                                    @elseif($student->address == "CK")
                                    Cook Islands
                                    @elseif($student->address == "CR")
                                    Costa Rica
                                    @elseif($student->address == "CI")
                                    Cote D'Ivoire
                                    @elseif($student->address == "HR")
                                    Croatia
                                    @elseif($student->address == "CU")
                                    Cuba
                                    @elseif($student->address == "CW")
                                    Curacao
                                    @elseif($student->address == "CY")
                                    Cyprus
                                    @elseif($student->address == "CZ")
                                    Czech Republic
                                    @elseif($student->address == "DK")
                                    Denmark
                                    @elseif($student->address == "DJ")
                                    Djibouti
                                    @elseif($student->address == "DM")
                                    Dominica
                                    @elseif($student->address == "DO")
                                    Dominican Republic
                                    @elseif($student->address == "EC")
                                    Ecuador
                                    @elseif($student->address == "EG")
                                    Egypt
                                    @elseif($student->address == "SV")
                                    El Salvador
                                    @elseif($student->address == "GQ")
                                    Equatorial Guinea
                                    @elseif($student->address == "ER")
                                    Eritrea
                                    @elseif($student->address == "EE")
                                    Estonia @elseif($student->address == "ET")
                                    Ethiopia @elseif($student->address == "FK")
                                    Falkland Islands (Malvinas)
                                    @elseif($student->address == "FO")
                                    Faroe Islands
                                    @elseif($student->address == "FJ")
                                    Fiji
                                    @elseif($student->address == "FI")
                                    Finland
                                    @elseif($student->address == "FR")
                                    France
                                    @elseif($student->address == "GF")
                                    French Guiana
                                    @elseif($student->address == "PF")
                                    French Polynesia
                                    @elseif($student->address == "TF")
                                    French Southern Territories
                                    @elseif($student->address == "GA")
                                    Gabon
                                    @elseif($student->address == "GM")
                                    Gambia
                                    @elseif($student->address == "GE")
                                    Georgia
                                    @elseif($student->address == "DE")
                                    Germany
                                    @elseif($student->address == "GH")
                                    Ghana
                                    @elseif($student->address == "GI")
                                    Gibraltar
                                    @elseif($student->address == "GR")
                                    Greece
                                    @elseif($student->address == "GL")
                                    Greenland
                                    @elseif($student->address == "GD")
                                    Grenada
                                    @elseif($student->address == "GP")
                                    Guadeloupe
                                    @elseif($student->address == "GU")
                                    Guam
                                    @elseif($student->address == "GT")
                                    Guatemala
                                    @elseif($student->address == "GG")
                                    Guernsey
                                    @elseif($student->address == "GN")
                                    Guinea
                                    @elseif($student->address == "GW")
                                    Guinea-Bissau
                                    @elseif($student->address == "GY")
                                    Guyana
                                    @elseif($student->address == "HT")
                                    Haiti
                                    @elseif($student->address == "HN")
                                    Honduras
                                    @elseif($student->address == "HM")
                                    Heard Island and Mcdonald Islands
                                    @elseif($student->address == "VA")
                                    Holy See (Vatican City State)
                                    @elseif($student->address == "HK")
                                    Hong Kong
                                    @elseif($student->address == "HU")
                                    Hungary
                                    @elseif($student->address == "IS")
                                    Iceland
                                    @elseif($student->address == "IN")
                                    India
                                    @elseif($student->address == "ID")
                                    Indonesia
                                    @elseif($student->address == "IR")
                                    Iran, Islamic Republic of
                                    @elseif($student->address == "IQ")
                                    Iraq
                                    @elseif($student->address == "IE")
                                    Ireland
                                    @elseif($student->address == "IM")
                                    Isle of Man
                                    @elseif($student->address == "IL")
                                    Israel
                                    @elseif($student->address == "IT")
                                    Italy
                                    @elseif($student->address == "JM")
                                    Jamaica
                                    @elseif($student->address == "JP")
                                    Japan
                                    @elseif($student->address == "JE")
                                    Jersey
                                    @elseif($student->address == "JO")
                                    Jordan
                                    @elseif($student->address == "KZ")
                                    Kazakhstan
                                    @elseif($student->address == "KE")
                                    Kenya
                                    @elseif($student->address == "KI")
                                    Kiribati
                                    @elseif($student->address == "KP")
                                    Korea, Democratic People's Republic of
                                    @elseif($student->address == "KR")
                                    Korea, Republic of
                                    @elseif($student->address == "XK")
                                    Kosovo
                                    @elseif($student->address == "KW")
                                    Kuwait
                                    @elseif($student->address == "KG")
                                    Kyrgyzstan
                                    @elseif($student->address == "LA")
                                    Lao People's Democratic Republic
                                    @elseif($student->address == "LV")
                                    Latvia
                                    @elseif($student->address == "LB")
                                    Lebanon
                                     @elseif($student->address == "LC")
                                    Saint Lucia
                                    @elseif($student->address == "LS")
                                    Lesotho
                                    @elseif($student->address == "LR")
                                    Liberia
                                    @elseif($student->address == "LY")
                                    Libyan Arab Jamahiriya
                                    @elseif($student->address == "LI")
                                    Liechtenstein
                                    @elseif($student->address == "LT")
                                    Lithuania
                                    @elseif($student->address == "LU")
                                    Luxembourg
                                    @elseif($student->address == "MO")
                                    Macao
                                    @elseif($student->address == "MK")
                                    Macedonia, the Former Yugoslav Republic of
                                    @elseif($student->address == "MG")
                                    Madagascar
                                    @elseif($student->address == "MW")
                                    Malawi
                                    @elseif($student->address == "MY")
                                    Malaysia
                                    @elseif($student->address == "MV")
                                    Maldives
                                    @elseif($student->address == "ML")
                                    Mali
                                    @elseif($student->address == "MT")
                                    Malta
                                    @elseif($student->address == "MH")
                                    Marshall Islands
                                    @elseif($student->address == "MQ")
                                    Martinique
                                    @elseif($student->address == "MR")
                                    Mauritania
                                    @elseif($student->address == "MU")
                                    Mayotte
                                    @elseif($student->address == "MX")
                                    Mexico
                                    @elseif($student->address == "FM")
                                    Micronesia, Federated States of
                                    @elseif($student->address == "MD")
                                    Moldova, Republic of
                                    @elseif($student->address == "MC")
                                    Monaco
                                    @elseif($student->address == "MN")
                                    Mongolia
                                    @elseif($student->address == "ME")
                                    Montenegro

                                    @elseif($student->address == "MS")
                                    Montserrat

                                    @elseif($student->address == "MA")
                                    Morocco
                                    @elseif($student->address == "MZ")
                                    Mozambique
                                    @elseif($student->address == "MM")
                                    Myanmar
                                    @elseif($student->address == "NA")
                                    Namibia
                                    @elseif($student->address == "NR")
                                    Nauru
                                    @elseif($student->address == "NP")
                                    Nepal
                                    @elseif($student->address == "NL")
                                    Netherlands
                                    @elseif($student->address == "AN")
                                    Netherlands Antilles
                                    @elseif($student->address == "NC")
                                    New Caledonia
                                    @elseif($student->address == "NZ")
                                    New Zealand
                                    @elseif($student->address == "NI")
                                    Nicaragua
                                    @elseif($student->address == "NE")
                                    Niger
                                    @elseif($student->address == "NG")
                                    Nigeria
                                    @elseif($student->address == "NU")
                                    Niue
                                    @elseif($student->address == "NF")
                                    Norfolk Island
                                    @elseif($student->address == "MP")
                                    Northern Mariana Islands
                                    @elseif($student->address == "NO")
                                    Norway
                                    @elseif($student->address == "OM")
                                    Oman
                                    @elseif($student->address == "PK")
                                    Pakistan
                                    @elseif($student->address == "PW")
                                    Palau
                                    @elseif($student->address == "PS")
                                    Palestinian Territory, Occupied
                                    @elseif($student->address == "PA")
                                    Panama
                                    @elseif($student->address == "PG")
                                    Papua New Guinea
                                    @elseif($student->address == "PY")
                                    Paraguay
                                    @elseif($student->address == "PE")
                                    Peru
                                    @elseif($student->address == "PH")
                                    Philippines
                                    @elseif($student->address == "PN")
                                    Pitcairn
                                    @elseif($student->address == "PL")
                                    Poland
                                    @elseif($student->address == "PT")
                                    Portugal
                                    @elseif($student->address == "PR")
                                    Puerto Rico
                                    @elseif($student->address == "QA")
                                    Qatar
                                    @elseif($student->address == "RE")
                                    Reunion
                                    @elseif($student->address == "RO")
                                    Romania
                                    @elseif($student->address == "RU")
                                    Russian Federation
                                    @elseif($student->address == "RW")
                                    Rwanda
                                    @elseif($student->address == "BL")
                                    Saint Barthelemy
                                    @elseif($student->address == "SH")
                                    Saint Helena
                                    @elseif($student->address == "KN")
                                    Saint Kitts and Nevis
                                    @elseif($student->address == "SH")
                                    Saint Lucia
                                    @elseif($student->address == "MF")
                                    Saint Martin
                                    @elseif($student->address == "PM")
                                    Saint Pierre and Miquelon
                                    @elseif($student->address == "VC")
                                    Saint Vincent and the Grenadines
                                    @elseif($student->address == "WS")
                                    Samoa
                                    @elseif($student->address == "SM")
                                    San Marino

                                    @elseif($student->address == "ST")
                                    Sao Tome and Principe
                                    @elseif($student->address == "SA")
                                    Saudi Arabia
                                    @elseif($student->address == "SN")
                                    Senegal
                                    @elseif($student->address == "RS")
                                    Serbia
                                    @elseif($student->address == "CS")
                                    Serbia and Montenegro
                                    @elseif($student->address == "SC")
                                    Seychelles
                                    @elseif($student->address == "SL")
                                    Sierra Leone
                                    @elseif($student->address == "SX")
                                    Sint Maarten
                                    @elseif($student->address == "SK")
                                    Slovakia
                                    @elseif($student->address == "SI")
                                    Slovenia
                                    @elseif($student->address == "SB")
                                    Solomon Islands
                                    @elseif($student->address == "SO")
                                    Somalia
                                    @elseif($student->address == "ZA")
                                    South Africa
                                    @elseif($student->address == "GS")
                                    South Georgia and the South Sandwich Islands
                                    @elseif($student->address == "SS")
                                    South Sudan
                                    @elseif($student->address == "ES")
                                    Spain
                                    @elseif($student->address == "LK")
                                    Sri Lanka
                                    @elseif($student->address == "SD")
                                    Sudan

                                    @elseif($student->address == "SR")
                                    Suriname
                                    @elseif($student->address == "SJ")
                                    Svalbard and Jan Mayen
                                    @elseif($student->address == "SZ")
                                    Swaziland
                                    @elseif($student->address == "SE")
                                    Sweden
                                    @elseif($student->address == "CH")
                                    Switzerland
                                    @elseif($student->address == "SY")
                                    Syrian Arab Republic
                                    @elseif($student->address == "TW")
                                    Taiwan, Province of China
                                    @elseif($student->address == "TJ")
                                    Tajikistan
                                    @elseif($student->address == "TZ")
                                    Tanzania, United Republic of
                                    @elseif($student->address == "TH")
                                    Thailand
                                    @elseif($student->address == "TL")
                                    Timor-Leste
                                    @elseif($student->address == "TG")
                                    Togo
                                    @elseif($student->address == "TK")
                                    Tokelau
                                    @elseif($student->address == "TO")
                                    Tonga
                                    @elseif($student->address == "TN")
                                    Trinidad and Tobago
                                    @elseif($student->address == "TR")
                                    Turkey
                                    @elseif($student->address == "TM")
                                    Turkmenistan
                                    @elseif($student->address == "TC")
                                    Turks and Caicos Islands
                                    @elseif($student->address == "TV")
                                    Tuvalu
                                    @elseif($student->address == "UG")
                                    Uganda
                                    @elseif($student->address == "UA")
                                    Ukraine
                                    @elseif($student->address == "AE")
                                    United Arab Emirates
                                    @elseif($student->address == "GB")
                                    United Kingdom
                                    @elseif($student->address == "US")
                                    United States
                                    @elseif($student->address == "UM")

                                    United States Minor Outlying Islands
                                    @elseif($student->address == "UY")

                                    Uruguay
                                    @elseif($student->address == "UZ")

                                    Uzbekistan
                                    @elseif($student->address == "VU")
                                    Vanuatu
                                    @elseif($student->address == "VE")
                                    Venezuela
                                    @elseif($student->address == "VN")
                                    Viet Nam
                                    @elseif($student->address == "VG")
                                    Virgin Islands, British
                                    @elseif($student->address == "VI")
                                    Virgin Islands, U.s.
                                    @elseif($student->address == "WF")
                                    Wallis and Futuna
                                    @elseif($student->address == "EH")
                                    Western Sahara
                                    @elseif($student->address == "EH")
                                    Yemen
                                    @elseif($student->address == "ZM")
                                    Zambia
                                    @elseif($student->address == "ZW")
                                    Zimbabwe
                                    @else
                                    {{$student->address}}


                                    @endif

                                    " type="text">
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-address">العنوان الدائم </label>
                                    <input id="input-address" class="form-control" name="city" placeholder="العنوان الدائم "
                                        value="{{ $student_detail->city }}" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-city_alt">العنوان البديل </label>
                                    <input id="input-city_alt" class="form-control" name="city_alt" placeholder="العنوان البديل "
                                        value="{{ $student_detail->city_alt }}" type="text">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-the_previous_school">ادراج اسم المدرسة أو المدارس التي التحقت بها حتى تاريخ الحالي </label>
                                    <input id="input-the_previous_school" class="form-control" name="the_previous_school" placeholder=" ادراج اسم المدرسة أو المدارس التي التحقت بها حتى تاريخ الحالي "
                                        value="{{ $student_detail->the_previous_school }}" type="text">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-student_brather_and_sister">الأخوة والأخوات الطالبة </label>
                                    <input id="input-student_brather_and_sister" class="form-control" name="student_brather_and_sister" placeholder="الأخوة والأخوات الطالبة"
                                        value="{{ $student_detail->student_brather_and_sister }}" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-city">الجنسية</label>
                                    <input type="text" id="input-city" name="nationality" class="form-control"
                                        placeholder="الجنسية"
                                        value="{{ $student->nationality }}">

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label> الجنس</label>

                                    <select name="gender" id="" class="form-control dep"
                                        style="min-height: 36px;direction: rtl">

                                        <option value=""> حدد جنس الطالب </option>
                                        <option value="1" {{ $student_detail->gender == '1' ? 'selected' :''}}>
                                            ذكر
                                        </option>


                                        <option value="2" {{ $student_detail->gender == '2'  ? 'selected' :''}}>
                                            انثى
                                        </option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-country">مكان الولادة</label>
                                    <input type="text" id="input-country" name="place_birth" class="form-control"
                                        value="{{ $student->place_birth }}">
                                </div>
                            </div>
                            
                            
                                                 <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-country"> زمرة الدم  </label>
                                    <input type="text" id="input-country" name="blood_type" class="form-control"
                                        value="{{ $student_detail->blood_type }}">
                                </div>
                            </div>
                            
                            
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-country">الخانة</label>
                                    <input type="number" id="input-postal-code" name="box_birth" class="form-control"
                                        value="{{ $student->box_birth }}">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-country">شعبة التجنيد</label>
                                    <input type="text" id="input-postal-code" name="army_room" class="form-control"
                                        value="{{ $student->army_room }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-country"> رقم جواز السفر</label>
                                    <input type="text" id="input-postal-code" name="passport_number"
                                        class="form-control" value="{{ $student_detail->passport_number }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-country"> رقم الوطني</label>
                                    <input type="text" id="input-postal-code" name="the_ID_number" class="form-control"
                                        value="{{ $student_detail->the_ID_number }}">
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-country">الهاتف</label>
                                    <input type="text" id="input-phone" name="phone" class="form-control"
                                        value="{{ $student_detail->phone }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-country">رقم موبايل لقريب من الدرجة الأولى</label>
                                    <input type="text" id="input-phone" name="other_phone" class="form-control"
                                        value="{{ $student_detail->other_phone }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-other_name">اسم قريب من الدرجة الأولى</label>
                                    <input type="text" id="input-other_name" name="other_name" class="form-control"
                                        value="{{ $student_detail->other_name }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label> المرحلة</label>

                                    <select name="stage" id="" class="form-control dep"
                                        style="min-height: 36px;direction: rtl">

                                        <option value=""> حدد مرحللة الطالب </option>
                                        <option value="1" {{ $student_detail->stage == '1' ? 'selected' :''}}>
                                            رياض أطفال
                                        </option>


                                        <option value="2" {{ $student_detail->stage == '2'  ? 'selected' :''}}>
                                            ابتدائي
                                        </option>
                                        <option value="3" {{ $student_detail->stage == '3'  ? 'selected' :''}}>
                                            اعدادي
                                        </option>
                                        <option value="4" {{ $student_detail->stage == '4'  ? 'selected' :''}}>
                                            ثانوي
                                        </option>
                                    </select>

                                </div>
                            </div>

                        </div>
                    </div>
                      @foreach ( $student_details_departments as  $student_details_department)
                    <hr class="my-4">
                    <!-- Address -->
                    <h6 class="heading-small text-muted mb-4"> {{ $student_details_department->name}}</h6>
                    <div class="pl-lg-4">
                        <div class="row">

                            @foreach ( $student_details_department->student_details_department_field as  $student_details_department_field)
                            <div class="col-md-6">
                                <div class="form-group">
                                    @if($student_details_department_field->type ==1)

                                    <label class="form-control-label" for="input-country"> {{$student_details_department_field->name}}   </label>
                                    @if (count($student_details_department_field->student_details_field_value)>0)
                                    <input type="text" id="" name="val[{{$student_details_department_field->id}}]" class="form-control"
                                        value="{{$student_details_department_field->student_details_field_value[0]->value}}">
                                        @else
                                        <input type="text" id="" name="val[{{$student_details_department_field->id}}]" class="form-control"
                                        value="">
                                        @endif
                                    @elseif ($student_details_department_field->type ==2)
                                    <label class="form-control-label" for="input-country"> {{$student_details_department_field->name}}   </label>
                                    @if (count($student_details_department_field->student_details_field_value)>0)
                                    <input type="date" id="input-phone" name="val[{{$student_details_department_field->id}}]" class="form-control"
                                        value="{{$student_details_department_field->student_details_field_value[0]->value}}">
                                        @else
                                        <input type="date" id="input-phone" name="val[{{$student_details_department_field->id}}]" class="form-control"
                                        value="">
                                        @endif
                                        @elseif ($student_details_department_field->type ==3)

                                    <label class="form-control-label" for="input-country"> {{$student_details_department_field->name}}   </label>
                                    <br>
                                    @foreach ( json_decode($student_details_department_field->type_radio) as  $type_radio)


                                    <label class="form-control-label" for="{{$type_radio}}"> {{$type_radio}}   </label>
                                    @if (count($student_details_department_field->student_details_field_value)>0)
                                    @if($student_details_department_field->student_details_field_value[0]->value == $type_radio)
                                    <input type="radio" id="{{$type_radio}}" checked  name="val[{{$student_details_department_field->id}}]" class=""
                                        value="{{$type_radio}}">
                                        @else
                                        <input type="radio" id="{{$type_radio}}"  name="val[{{$student_details_department_field->id}}]" class=""
                                        value="{{$type_radio}}">
                                        @endif

                                        @else
                                        <input type="radio" id="{{$type_radio}}"  name="val[{{$student_details_department_field->id}}]" class=""
                                        value="{{$type_radio}}">
                                        @endif
                                    @endforeach
                                        @elseif ($student_details_department_field->type ==4)
                                        @if (isset($student_details_department_field->student_details_field_value[0]->value))
                                        <a href="{{ asset('storage/'.$student_details_department_field->student_details_field_value[0]->value) }}" download="{{ $student->first_name }} {{ $student->last_name }}.jpg">
                                         <img src="{{ asset('storage/'.$student_details_department_field->student_details_field_value[0]->value) }}"
                                               class="del_edit_img rounded-circle" id="image6" alt="Not found" width="100" alt="">
                                           </a>


                                         @endif
                                        <label class="form-control-label" for="input-country"> {{$student_details_department_field->name}}   </label>
                                    <input type="file" id="input-phone" name="val[{{$student_details_department_field->id}}]" class="form-control"
                                        value="">
                                    @endif


                                </div>



                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach

                    <!-- Description -->
                     <h6 class="heading-small text-muted mb-4">الوثائق</h6>
                    {{-- <a class="btn btn-danger"  href="{{route('all_documents',$student->id)}}" style="color:white;">
                        تنزيل جميع وثائق الطالب   </a> --}}
                    <div class="row">
                    <div class="pl-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-country"> الصورة الشخصية</label>
                            <br>
                            <input type="hidden" class="del" name="del_img6" value="del_img6" disabled="disabled">

                            @if ($student_detail->personal_image!=null)
                           <a href="{{ asset('storage/'.$student_detail->personal_image) }}" download="{{ $student->first_name }} {{ $student->last_name }}.jpg">
                            <img src="{{ asset('storage/'.$student_detail->personal_image) }}"
                                  class="del_edit_img rounded-circle" id="image6" alt="Not found" width="100" alt="">
                              </a>


                            @endif

                            <input type="file" name="personal_image" onchange="loadFile_edit(event)"
                                class="form-control input_image" id="input_edit_image6" lang="en">
                            <label class="custom-file-label" for="customFileLang"></label>

                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none" src="" width="200px" alt="">
                        </div>
                    </div>



                    <div class="pl-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-country">دفتر العائلة</label>
                            <br>
                            <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">

                            @if ($student_detail->family_book!=null)
                           <a href="{{ asset('storage/'.$student_detail->family_book) }}" download="{{ $student->first_name }} {{ $student->last_name }}.jpg">
                            <img src="{{ asset('storage/'.$student_detail->family_book) }}" class="del_edit_img"
                                id="image1" alt="Not found" width="100" alt="">
                                </a>

                            @endif
                            <input type="file" name="family_book" onchange="loadFile_edit(event)"
                                class="form-control input_image" id="input_edit_image1" lang="en">
                            <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none" src="" width="200px" alt="">
                        </div>
                    </div>


                    <div class="pl-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-country">صورة هوية الأم</label>
                            <br>
                            <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">

                            @if ($student_detail->mother_image!=null)
                             <a href="{{ asset('storage/'.$student_detail->mother_image) }}" download="{{ $student->first_name }} {{ $student->last_name }}.jpg">
                            <img src="{{ asset('storage/'.$student_detail->mother_image) }}" class="del_edit_img"
                                id="image1" alt="Not found" width="100" alt="">
                                </a>

                            @endif
                            <input type="file" name="mother_image" onchange="loadFile_edit(event)"
                                class="form-control input_image" id="input_edit_image1" lang="en">
                            <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none" src="" width="200px" alt="">
                        </div>
                    </div>



                    <div class="pl-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-country">صورة هوية الأب</label>
                            <br>
                            <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">

                            @if ($student_detail->father_image!=null)
                            <a href="{{ asset('storage/'.$student_detail->father_image) }}" download="{{ $student->first_name }} {{ $student->last_name }}.jpg">

                            <img src="{{ asset('storage/'.$student_detail->father_image) }}" class="del_edit_img"
                                id="image1" alt="Not found" width="100" alt="">
                                </a>

                            @endif
                            <input type="file" name="father_image" onchange="loadFile_edit(event)"
                                class="form-control input_image" id="input_edit_image1" lang="en">
                            <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none" src="" width="200px" alt="">
                        </div>
                    </div>


                    <div class="pl-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-country">اخراج القيد</label>
                            <br>
                            <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">

                            @if ($student_detail->fourth_image!=null)
                             <a href="{{ asset('storage/'.$student_detail->fourth_image) }}" download="{{ $student->first_name }} {{ $student->last_name }}.jpg">

                            <img src="{{ asset('storage/'.$student_detail->fourth_image) }}" class="del_edit_img"
                                id="image1" alt="Not found" width="100" alt="">
                                </a>

                            @endif
                            <input type="file" name="fourth_image" onchange="loadFile_edit(event)"
                                class="form-control input_image" id="input_edit_image1" lang="en">
                            <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none" src="" width="200px" alt="">
                        </div>
                    </div>


                    <div class="pl-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-country"> جواز السفر </label>
                            <br>
                            <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">

                            @if ($student_detail->passport!=null)
                            <a href="{{ asset('storage/'.$student_detail->passport) }}" download="{{ $student->first_name }} {{ $student->last_name }}.jpg">

                            <img src="{{ asset('storage/'.$student_detail->passport) }}" class="del_edit_img"
                                id="image1" alt="Not found" width="100" alt="">
                                </a>

                            @endif
                            <input type="file" name="passport" onchange="loadFile_edit(event)"
                                class="form-control input_image" id="input_edit_image1" lang="en">
                            <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none" src="" width="200px" alt="">
                        </div>
                    </div>



                    <div class="pl-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-country">جواز سفر الام </label>
                            <br>
                            <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">

                            @if ($student_detail->mother_page!=null)
                            <a href="{{ asset('storage/'.$student_detail->mother_page) }}" download="{{ $student->first_name }} {{ $student->last_name }}.jpg">

                            <img src="{{ asset('storage/'.$student_detail->mother_page) }}" class="del_edit_img"
                                id="image1" alt="Not found" width="100" alt="">
                                </a>

                            @endif
                            <input type="file" name="mother_page" onchange="loadFile_edit(event)"
                                class="form-control input_image" id="input_edit_image1" lang="en">
                            <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none" src="" width="200px" alt="">
                        </div>
                    </div>


                    <div class="pl-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-country">   جواز سفر الاب </label>
                            <br>
                            <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">

                            @if ($student_detail->father_page!=null)
                              <a href="{{ asset('storage/'.$student_detail->father_page) }}" download="{{ $student->first_name }} {{ $student->last_name }}.jpg">

                            <img src="{{ asset('storage/'.$student_detail->father_page) }}" class="del_edit_img"
                                id="image1" alt="Not found" width="100" alt="">
                                </a>

                            @endif
                            <input type="file" name="father_page" onchange="loadFile_edit(event)"
                                class="form-control input_image" id="input_edit_image1" lang="en">
                            <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none" src="" width="200px" alt="">
                        </div>
                    </div>


                    <div class="pl-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-country">تسلسل دراسي</label>
                            <br>
                            <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">

                            @if ($student_detail->study_sequence!=null)
                            <a href="{{ asset('storage/'.$student_detail->study_sequence) }}" download="{{ $student->first_name }} {{ $student->last_name }}.jpg">
                            <img src="{{ asset('storage/'.$student_detail->study_sequence) }}" class="del_edit_img"
                                id="image1" alt="Not found" width="100" alt="">
                                </a>

                            @endif
                            <input type="file" name="study_sequence" onchange="loadFile_edit(event)"
                                class="form-control input_image" id="input_edit_image1" lang="en">
                            <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none" src="" width="200px" alt="">
                        </div>
                    </div>

                    <div class="pl-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-country">اخر شهادة</label>
                            <br>
                            <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">
                            @if ($student_detail->certification!=null)
                             <a href="{{ asset('storage/'.$student_detail->certification) }}" download="{{ $student->first_name }} {{ $student->last_name }}.jpg">

                            <img src="{{ asset('storage/'.$student_detail->certification) }}" class="del_edit_img"
                                id="image1" alt="Not found" width="100" alt="">
                                </a>

                            @endif
                            <input type="file" name="certification" onchange="loadFile_edit(event)"
                                class="form-control input_image" id="input_edit_image1" lang="en">
                            <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none" src="" width="200px" alt="">
                        </div>
                    </div>

                    <div class="pl-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-country"> شهادة التاسع</label>
                            <br>
                            <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">
                            @if ($student_detail->certification_nine!=null)
                             <a href="{{ asset('storage/'.$student_detail->certification_nine) }}"
                                download="{{ $student->first_name }} {{ $student->last_name }}.jpg">

                            <img src="{{ asset('storage/'.$student_detail->certification_nine) }}" class="del_edit_img"
                                id="image1" alt="Not found" width="100" alt="">
                                </a>

                            @endif
                            <input type="file" name="certification_nine" onchange="loadFile_edit(event)"
                                class="form-control input_image" id="input_edit_image1" lang="en">
                            <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none" src="" width="200px" alt="">
                        </div>
                    </div>

                    <div class="pl-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-country">وثيقة انتقال التعليم الاساسي</label>
                            <br>
                            <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">
                            @if ($student_detail->basic_transger_file!=null)
                             <a href="{{ asset('storage/'.$student_detail->basic_transger_file) }}"
                                 download="{{ $student->first_name }} {{ $student->last_name }}.jpg">

                            <img src="{{ asset('storage/'.$student_detail->basic_transger_file) }}" class="del_edit_img"
                                id="image1" alt="Not found" width="100" alt="">
                                </a>
                                <br>
                                <br>

                            @endif
                            <input type="file" name="basic_transger_file" onchange="loadFile_edit(event)"
                                class="form-control input_image" id="input_edit_image1" lang="en">
                            <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none" src="" width="200px" alt="">
                        </div>
                    </div>

                    <div class="pl-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-country">وثيقة انتقال التعليم الثانوي</label>
                            <br>
                            <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">
                            @if ($student_detail->secondary_transfer_file!=null)
                             <a href="{{ asset('storage/'.$student_detail->secondary_transfer_file) }}"
                                 download="{{ $student->first_name }} {{ $student->last_name }}.jpg">

                             <img src="{{ asset('storage/'.$student_detail->secondary_transfer_file) }}" class="del_edit_img"
                                id="image1" alt="Not found" width="100" alt="">
                                </a>
                                <br>
                                <br>

                            @endif
                            <input type="file" name="secondary_transfer_file" onchange="loadFile_edit(event)"
                                class="form-control input_image" id="input_edit_image1" lang="en">
                            <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none" src="" width="200px" alt="">
                        </div>
                    </div>

                    <div class="pl-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-country">وثيقة اتمام مرحلة للصف السادس</label>
                            <br>
                            <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">
                            @if ($student_detail->phase_class6!=null)
                             <a href="{{ asset('storage/'.$student_detail->phase_class6) }}"
                                 download="{{ $student->first_name }} {{ $student->last_name }}.jpg">

                            <img src="{{ asset('storage/'.$student_detail->phase_class6) }}" class="del_edit_img"
                                id="image1" alt="Not found" width="100" alt="">
                                </a>
                                <br>
                                <br>

                            @endif
                            <input type="file" name="phase_class6" onchange="loadFile_edit(event)"
                                class="form-control input_image" id="input_edit_image1" lang="en">
                            <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none" src="" width="200px" alt="">
                        </div>
                    </div>

                    <div class="pl-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-country">وثيقة اتمام مرحلة للصف التاسع</label>
                            <br>
                            <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">
                            @if ($student_detail->phase_class9!=null)
                             <a href="{{ asset('storage/'.$student_detail->phase_class9) }}"
                                 download="{{ $student->first_name }} {{ $student->last_name }}.jpg">

                             <img src="{{ asset('storage/'.$student_detail->phase_class9) }}" class="del_edit_img"
                                id="image1" alt="Not found" width="100" alt="">
                                </a>
                                <br>
                                <br>

                            @endif
                            <input type="file" name="phase_class9" onchange="loadFile_edit(event)"
                                class="form-control input_image" id="input_edit_image1" lang="en">
                            <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none" src="" width="200px" alt="">
                        </div>
                    </div>

                    <div class="pl-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="input-country"> اتمام مرحلة للصف البكالوريا</label>
                            <br>
                            <input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">
                            @if ($student_detail->phase_class12!=null)
                             <a href="{{ asset('storage/'.$student_detail->phase_class12) }}"
                                 download="{{ $student->first_name }} {{ $student->last_name }}.jpg">

                            <img src="{{ asset('storage/'.$student_detail->phase_class12) }}" class="del_edit_img"
                                id="image1" alt="Not found" width="100" alt="">
                                </a>
                                <br>
                                <br>

                            @endif
                            <input type="file" name="phase_class12" onchange="loadFile_edit(event)"
                                class="form-control input_image" id="input_edit_image1" lang="en">
                            <label class="custom-file-label" for="customFileLang"></label>


                            <span class="close-btn del_img" title="الغاء" id=""
                                style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none" src="" width="200px" alt="">
                        </div>
                    </div>



                </div>


                    <button class="btn btn-success btn-block "
                        style="background: #6ABAA3;border-color: #6ABAA3;color: white">تحديث </button>
                </form>
            </div>





        </div>
    </div>
    <div class="col-xl-1 col-lg-1 col-12"></div>


</div>



<script src="{{ asset('students/js/jquery-3.2.1.min.js') }}"></script>





<script>
    $(document).on('focusout', '.email', function () {

        $('.er').hide();
        $('.validate_email').text('');
        var email = $(this).val();
        $.ajax({
            url: "{{ URL::to('SMARMANger/admin/validate_email1') }}",
            type: "get",
            contentType: 'application/json',
            data: {
                '_token': "{{ csrf_token() }}",
                'email': email,
            },
            success: function (data) {

            },
            error: function (xhr) {
                $('.validate_email').html("<div >! عذرا , هذا الايميل موجود مسبقا</div> ");

            }

        });



    });


    var loadFile = function (event) {
        var id = event.target.id;
        var input_image = document.getElementById(id);
        var output = input_image.nextElementSibling.nextElementSibling.nextElementSibling;
        var del_img = input_image.nextElementSibling.nextElementSibling;
        output.setAttribute('src', URL.createObjectURL(event.target.files[0]));
        output.onload = function () {

            output.setAttribute('style', 'display:inline');
            del_img.setAttribute('style',
                'display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
        };

    };


    var loadFile_edit = function (event) {
        var id = event.target.id;
        var input_image = document.getElementById(id);
        var output = input_image.nextElementSibling.nextElementSibling.nextElementSibling;
        var del_img = input_image.nextElementSibling.nextElementSibling;
        input_image.previousElementSibling.setAttribute('style', 'display:none');
        input_image.previousElementSibling.previousElementSibling.setAttribute('style', 'display:none');

        output.setAttribute('src', URL.createObjectURL(event.target.files[0]));
        output.onload = function () {

            output.setAttribute('style', 'display:inline');
            del_img.setAttribute('style',
                'display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
        };

    };


    $(document).on('click', '.del_img', function () {
        $(this).nextAll('.output').attr('style', 'display:none;');
        $(this).prevAll('.input_image:first').val('');
        $(this).hide();

    });

    $(document).on('click', '.del_icon', function () {
        $(this).prevAll('.del:first').attr('disabled', false);
        $(this).prevAll('.del_edit_img:first').hide();
        $(this).hide();

    });




























    $('.alert-success').hide(3000);



    function pppassword_show_hide() {
        var x = document.getElementById("pppassword");
        var show_eye = document.getElementById("ssshow_eye");
        var hide_eye = document.getElementById("hhhide_eye");
        hide_eye.classList.remove("d-none");
        if (x.type === "password") {
            x.type = "text";
            show_eye.style.display = "none";
            hide_eye.style.display = "block";
        } else {
            x.type = "password";
            show_eye.style.display = "block";
            hide_eye.style.display = "none";
        }
    }




    function pppassword_show_hide2() {
        var x = document.getElementById("pppassword-confirm");
        var show_eye = document.getElementById("ssshow_eye2");
        var hide_eye = document.getElementById("hhhide_eye2");
        hide_eye.classList.remove("d-none");
        if (x.type === "password") {
            x.type = "text";
            show_eye.style.display = "none";
            hide_eye.style.display = "block";
        } else {
            x.type = "password";
            show_eye.style.display = "block";
            hide_eye.style.display = "none";
        }
    }
</script>

<script>
    $(document).ready(function () {



        $(document).on('change', '#classes', function () {
            var class_id = $(this).val();

            var url = "{{ URL::to('SMARMANger/admin/classes/rooms') }}/" + class_id;
            $.ajax({
                url: url,
                type: "get",
                contentType: 'application/json',
                success: function (data) {

                    $('#class_room').empty();
                    var type = `
            <label>الشعبة</label>

            <select name="room_id" id="" class="form-control dep"
                style="min-height: 36px;direction:rtl">
                <option value="">اختر الشعبة الدراسية</option>

                `;

                    $.each(data, function (key, value) {


                        type += `
<option value="${value.id}">${value.name}</option>

                  `;

                    });

                    type += `
                </select>
                      `;
                    $('#class_room').append(type);

                },
                error: function (xhr) {

                }

            });
        });







    });
</script>



@endsection
