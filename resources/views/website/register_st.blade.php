@extends('website.layouts.header')

@section('css')
    <style>
        /*.border {
                                                                                                                                                                                                    border: 1px solid #dee2e6 !important;
                                                                                                                                                                                                }*/

        .p-3 {
            margin: auto;
            padding: 1rem !important;
        }

        .btn {
            background: #259797;
            color: #ffffff;
            border-radius: 0;
            font-weight: 600;
            font-size: 19px;
            -webkit-transition: 0.3s;
            transition: 0.3s;
            position: relative;
            height: 50px;
            padding-top: 10px;
        }

        .btn-primary {
            color: #fff;
            /* background-color: #0d6efd;
                                                                                                                                                                                                    border-color: #0d6efd; */
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border-radius: 0.25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            margin-bottom: 23px;

        }

        /* .btn:hover{
                                                                                                                                                                                                   background-color: #d6a800 !important;
                                                                                                                                                                                                   border: 2px solid #d6a800 !important;
                                                                                                                                                                                                }*/

        legend {
            float: left;
            width: 100%;
            padding: 0;
            margin-bottom: 0.5rem;
            font-size: calc(1.275rem + .3vw);
            line-height: inherit;
        }

        @media (min-width: 768px) {
            .col-md-3 {
                flex: 0 0 auto;
                width: 25%;
            }
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            background-color: transparent;
            /* border: 1px solid transparent;*/
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border-radius: 0.25rem;
            font-weight: bold !important;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .btn-primary {
            color: #fff;
            /* background-color: #0d6efd;
                                                                                                                                                                                                    border-color: #0d6efd; */
        }

        .btn {
            background: #155a79;
            color: #ffffff;
            border-radius: 0;
            font-weight: 600;
            font-size: 19px;
            -webkit-transition: 0.3s;
            transition: 0.3s;
            position: relative;
            padding-top: 8px
        }

        .btn:hover {
            background: #155a79 !important;
        }

        sub,
        sup {
            position: relative;
            font-size: .75em;
            line-height: 0;
            vertical-align: baseline;
        }

        .form-select {
            display: block;
            width: 100%;
            padding: 0.375rem 2.25rem 0.375rem 0.75rem;
            -moz-padding-start: calc(0.75rem - 3px);
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e);
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            /* border: 1px solid #ced4da;*/
            border-radius: 0.25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        label.required:before {
            color: #da6f5b;
            content: '';
            display: block;
            float: left;
            margin: 0 3px 0 0;
        }

        .form-control {
            height: 39px !important;
        }

        @media (min-width:300px) and (max-width:500px) {
            .filed_e {
                display: -webkit-box;
                display: -moz-box;
                display: -ms-flexbox;
                display: -webkit-flex;
                display: flex !important;

                /* Reverse Column Order */
                -webkit-flex-flow: column-reverse;
                flex-flow: column-reverse;
            }
        }
    </style>
@endsection
@section('content')



    <!-- Title Bar -->
    <div class="pbmit-title-bar-wrapper">
        <div class="container">
            <div class="pbmit-title-bar-content">
                <div class="pbmit-title-bar-content-inner">
                    <div class="pbmit-tbar">
                        <div class="pbmit-tbar-inner container">
                            <h1 class="pbmit-tbar-title">{{ __('site.Signup') }}</h1>
                        </div>
                    </div>
                    <div class="pbmit-breadcrumb">
                        <div class="pbmit-breadcrumb-inner">
                            <span><a title="" href="#"
                                    class="home"><span>{{ __('site.Aladham') }}</span></a></span>
                            <span class="sep">
                                <i class="pbmit-base-icon-angle-double-right"></i>
                            </span>
                            <span><span class="post-root post post-post current-item">{{ __('site.Signup') }}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Title Bar End-->

    @if (LaravelLocalization::setLocale() == 'ar')


        <div class="container contact-form-leftbox" style="text-align: right">
            <div class="row justify-content-right >
                <div>
                    <main class="page-content
                ar_con">
                <p></p>
                @if (session()->has('success'))
                    <div class="alert alert-success" style="    text-align: center;">
                        {{ session()->get('success') }}
                    </div>
                @endif

                <h4 style="color:#333333 !important;direction: rtl" class="pbmit-heading-subheading">
                    {{ __('site.Please complete this form and submit it by clicking on the button below') }}</h4>
                <p style="color:#333333 !important ;direction: rtl" class="pbmit-heading-subheading">
                    {{ __('site.Please make sure the information is accurate. We will contact you using one of the means mentioned in the form.') }}
                </p>
                <legend class="btn btn-primary">  بيانات الطالب </legend>
                <fieldset class="p-3 row filed_e">
                <form action="{{ route('stu_register') }}" method="post" enctype="multipart/form-data"
                    style="text-align: right;direction: rtl">
                    @csrf
                    <div class="row" style="text-align: right">
                        <div class="col-md-6">
                            <label for="first_name" class="  required ">الاسم الأول
                                <sup><svg style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                        viewBox="0 0 16 16">
                                        <path style="color: #ef0404;"
                                            d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></sup> <span style="font-size: small;"> (اجباري ) </span></label>
                            <input type="text" class="form-control" for="first_name" id="first_name"
                                placeholder="الاسم الأول" name="first_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="mother_name" class="  required ">كنية الطالب
                                <sup><svg style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                        viewBox="0 0 16 16">
                                        <path style="color: #ef0404;"
                                            d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></sup> <span style="font-size: small;"> (اجباري ) </span></label>

                            <input type="text" class="form-control" for="last_name" id="last_name"
                                placeholder="كنية الطالب" name="last_name" required>
                        </div>

                        <div class="col-md-6">
                            <label for="last_name" class="  required ">اسم الأب
                                <sup><svg style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                        viewBox="0 0 16 16">
                                        <path style="color: #ef0404;"
                                            d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></sup> <span style="font-size: small;"> (اجباري ) </span>
                            </label>
                            <input type="text" class="form-control" for="father_name" id="father_name"
                                placeholder="الاسم الأب" name="father_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="mather_name" class="  required ">اسم الأم
                                <sup><svg
                                         style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                         width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                         viewBox="0 0 16 16">
                                         <path style="color: #ef0404;"
                                             d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                     </svg></sup> <span style="font-size: small;"> (اجباري ) </span >
                               </label>
                            <input type="text" class="form-control" for="mather_name" id="mather_name"
                                placeholder="الاسم الأم" name="mather_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="date" class=" ">تاريخ الميلاد
                                <sup><svg style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                        viewBox="0 0 16 16">
                                        <path style="color: #ef0404;"
                                            d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></sup> <span style="font-size: small;"> (اجباري ) </span>
                            </label>
                            <input type="date" class="form-control" for="date" placeholder="تاريخ الميلاد"
                                name="date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="country" class="  required ">مكان الاقامة(حاليا)
                                <sup><svg style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                        viewBox="0 0 16 16">
                                        <path style="color: #ef0404;"
                                            d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></sup> <span style="font-size: small;"> (اجباري ) </span>
                            </label>


                            <select type="date" class=" form-control ldir" for="country" id="country"
                                placeholder="مكان الإقامة " name="country" required>
                                <option value="1"> اختر البلد </option>
     
                                <option value="SY">سوريا</option>
                                <option value="AE">الامارات العربية المتحدة</option>
                                <option value="SA">المملكة العربية السعودية</option>
                                <option value="LB">لبنان</option>
                                <option value="JO">الأردن</option>
                                <option value="VE">فنزويلا</option>
                                <option value="TR">تركيا</option>
                                <option value="TN">تونس</option>
                                <option value="US">الولايات المتحدة الأمريكية</option>
                                <option value="SE">السويد</option>
                                <option value="DE">ألمانيا</option>
                                <option value="NL">هولندا</option>

                                <option value="IQ">العراق</option>
                                <option value="PS">فلسطين</option>

                                <option value="AW">آروبا</option>
                                <option value="AZ">أذربيجان</option>
                                <option value="AM">أرمينيا</option>
                                <option value="ES">أسبانيا</option>
                                <option value="AU">أستراليا</option>
                                <option value="AF">أفغانستان</option>
                                <option value="AL">ألبانيا</option>

                                <option value="AG">أنتيجوا وبربودا</option>
                                <option value="AO">أنجولا</option>
                                <option value="AI">أنجويلا</option>
                                <option value="AD">أندورا</option>
                                <option value="UY">أورجواي</option>
                                <option value="UZ">أوزبكستان</option>
                                <option value="UG">أوغندا</option>
                                <option value="UA">أوكرانيا</option>
                                <option value="IE">أيرلندا</option>
                                <option value="IS">أيسلندا</option>
                                <option value="ET">اثيوبيا</option>
                                <option value="ER">اريتريا</option>
                                <option value="EE">استونيا</option>
                                <option value="AR">الأرجنتين</option>
                                <option value="EC">الاكوادور</option>
                                <option value="BS">الباهاما</option>
                                <option value="BH">البحرين</option>
                                <option value="BR">البرازيل</option>
                                <option value="PT">البرتغال</option>
                                <option value="BA">البوسنة والهرسك</option>
                                <option value="GA">الجابون</option>
                                <option value="ME">الجبل الأسود</option>
                                <option value="DZ">الجزائر</option>
                                <option value="DK">الدانمرك</option>
                                <option value="CV">الرأس الأخضر</option>
                                <option value="SV">السلفادور</option>
                                <option value="SN">السنغال</option>
                                <option value="SD">السودان</option>

                                <option value="EH">الصحراء الغربية</option>
                                <option value="SO">الصومال</option>
                                <option value="CN">الصين</option>
                                <option value="VA">الفاتيكان</option>
                                <option value="PH">الفيلبين</option>
                                <option value="AQ">القطب الجنوبي</option>
                                <option value="CM">الكاميرون</option>
                                <option value="CG">الكونغو - برازافيل</option>
                                <option value="KW">الكويت</option>
                                <option value="HU">المجر</option>
                                <option value="IO">المحيط الهندي البريطاني</option>
                                <option value="MA">المغرب</option>
                                <option value="TF">المقاطعات الجنوبية الفرنسية</option>
                                <option value="MX">المكسيك</option>
                                <option value="GB">المملكة المتحدة</option>
                                <option value="NO">النرويج</option>
                                <option value="AT">النمسا</option>
                                <option value="NE">النيجر</option>
                                <option value="IN">الهند</option>
                                <option value="JP">اليابان</option>
                                <option value="YE">اليمن</option>
                                <option value="GR">اليونان</option>
                                <option value="ID">اندونيسيا</option>
                                <option value="IR">ايران</option>
                                <option value="IT">ايطاليا</option>
                                <option value="PG">بابوا غينيا الجديدة</option>
                                <option value="PY">باراجواي</option>
                                <option value="PK">باكستان</option>
                                <option value="PW">بالاو</option>
                                <option value="BW">بتسوانا</option>
                                <option value="PN">بتكايرن</option>
                                <option value="BB">بربادوس</option>
                                <option value="BM">برمودا</option>
                                <option value="BN">بروناي</option>
                                <option value="BE">بلجيكا</option>
                                <option value="BG">بلغاريا</option>
                                <option value="BZ">بليز</option>
                                <option value="BD">بنجلاديش</option>
                                <option value="PA">بنما</option>
                                <option value="BJ">بنين</option>
                                <option value="BT">بوتان</option>
                                <option value="PR">بورتوريكو</option>
                                <option value="BF">بوركينا فاسو</option>
                                <option value="BI">بوروندي</option>
                                <option value="PL">بولندا</option>
                                <option value="BO">بوليفيا</option>
                                <option value="PF">بولينيزيا الفرنسية</option>
                                <option value="PE">بيرو</option>
                                <option value="TZ">تانزانيا</option>
                                <option value="TH">تايلند</option>
                                <option value="TW">تايوان</option>
                                <option value="TM">تركمانستان</option>

                                <option value="TT">ترينيداد وتوباغو</option>
                                <option value="TD">تشاد</option>
                                <option value="TG">توجو</option>
                                <option value="TV">توفالو</option>
                                <option value="TK">توكيلو</option>
                                <option value="TO">تونجا</option>
                                <option value="TL">تيمور الشرقية</option>
                                <option value="JM">جامايكا</option>
                                <option value="GI">جبل طارق</option>
                                <option value="GD">جرينادا</option>
                                <option value="GL">جرينلاند</option>
                                <option value="AX">جزر أولان</option>
                                <option value="AN">جزر الأنتيل الهولندية</option>
                                <option value="TC">جزر الترك وجايكوس</option>
                                <option value="KM">جزر القمر</option>
                                <option value="KY">جزر الكايمن</option>
                                <option value="MH">جزر المارشال</option>
                                <option value="MV">جزر الملديف</option>
                                <option value="UM">جزر الولايات المتحدة البعيدة الصغيرة</option>
                                <option value="SB">جزر سليمان</option>
                                <option value="FO">جزر فارو</option>
                                <option value="VI">جزر فرجين الأمريكية</option>
                                <option value="VG">جزر فرجين البريطانية</option>
                                <option value="FK">جزر فوكلاند</option>
                                <option value="CK">جزر كوك</option>
                                <option value="CC">جزر كوكوس</option>
                                <option value="MP">جزر ماريانا الشمالية</option>
                                <option value="WF">جزر والس وفوتونا</option>
                                <option value="CX">جزيرة الكريسماس</option>
                                <option value="BV">جزيرة بوفيه</option>
                                <option value="IM">جزيرة مان</option>
                                <option value="NF">جزيرة نورفوك</option>
                                <option value="HM">جزيرة هيرد وماكدونالد</option>
                                <option value="CF">جمهورية افريقيا الوسطى</option>
                                <option value="CZ">جمهورية التشيك</option>
                                <option value="DO">جمهورية الدومينيك</option>
                                <option value="CD">جمهورية الكونغو الديمقراطية</option>
                                <option value="ZA">جمهورية جنوب افريقيا</option>
                                <option value="GT">جواتيمالا</option>
                                <option value="GP">جوادلوب</option>
                                <option value="GU">جوام</option>
                                <option value="GE">جورجيا</option>
                                <option value="GS">جورجيا الجنوبية وجزر ساندويتش الجنوبية</option>
                                <option value="DJ">جيبوتي</option>
                                <option value="JE">جيرسي</option>
                                <option value="DM">دومينيكا</option>
                                <option value="RW">رواندا</option>
                                <option value="RU">روسيا</option>
                                <option value="BY">روسيا البيضاء</option>
                                <option value="RO">رومانيا</option>
                                <option value="RE">روينيون</option>
                                <option value="ZM">زامبيا</option>
                                <option value="ZW">زيمبابوي</option>
                                <option value="CI">ساحل العاج</option>
                                <option value="WS">ساموا</option>
                                <option value="AS">ساموا الأمريكية</option>
                                <option value="SM">سان مارينو</option>
                                <option value="PM">سانت بيير وميكولون</option>
                                <option value="VC">سانت فنسنت وغرنادين</option>
                                <option value="KN">سانت كيتس ونيفيس</option>
                                <option value="LC">سانت لوسيا</option>
                                <option value="MF">سانت مارتين</option>
                                <option value="SH">سانت هيلنا</option>
                                <option value="ST">ساو تومي وبرينسيبي</option>
                                <option value="LK">سريلانكا</option>
                                <option value="SJ">سفالبارد وجان مايان</option>
                                <option value="SK">سلوفاكيا</option>
                                <option value="SI">سلوفينيا</option>
                                <option value="SG">سنغافورة</option>
                                <option value="SZ">سوازيلاند</option>
                                <option value="SR">سورينام</option>
                                <option value="CH">سويسرا</option>
                                <option value="SL">سيراليون</option>
                                <option value="SC">سيشل</option>
                                <option value="CL">شيلي</option>
                                <option value="RS">صربيا</option>
                                <option value="CS">صربيا والجبل الأسود</option>
                                <option value="TJ">طاجكستان</option>
                                <option value="OM">عمان</option>
                                <option value="GM">غامبيا</option>
                                <option value="GH">غانا</option>
                                <option value="GF">غويانا</option>
                                <option value="GY">غيانا</option>
                                <option value="GN">غينيا</option>
                                <option value="GQ">غينيا الاستوائية</option>
                                <option value="GW">غينيا بيساو</option>
                                <option value="VU">فانواتو</option>
                                <option value="FR">فرنسا</option>
                                <option value="FI">فنلندا</option>
                                <option value="VN">فيتنام</option>
                                <option value="FJ">فيجي</option>
                                <option value="CY">قبرص</option>
                                <option value="KG">قرغيزستان</option>
                                <option value="QA">قطر</option>
                                <option value="KZ">كازاخستان</option>
                                <option value="NC">كاليدونيا الجديدة</option>
                                <option value="HR">كرواتيا</option>
                                <option value="KH">كمبوديا</option>
                                <option value="CA">كندا</option>
                                <option value="CU">كوبا</option>
                                <option value="KR">كوريا الجنوبية</option>
                                <option value="KP">كوريا الشمالية</option>
                                <option value="CR">كوستاريكا</option>
                                <option value="CO">كولومبيا</option>
                                <option value="KI">كيريباتي</option>
                                <option value="KE">كينيا</option>
                                <option value="LV">لاتفيا</option>
                                <option value="LA">لاوس</option>

                                <option value="LU">لوكسمبورج</option>
                                <option value="LY">ليبيا</option>
                                <option value="LR">ليبيريا</option>
                                <option value="LT">ليتوانيا</option>
                                <option value="LI">ليختنشتاين</option>
                                <option value="LS">ليسوتو</option>
                                <option value="MQ">مارتينيك</option>
                                <option value="MO">ماكاو الصينية</option>
                                <option value="MT">مالطا</option>
                                <option value="ML">مالي</option>
                                <option value="MY">ماليزيا</option>
                                <option value="YT">مايوت</option>
                                <option value="MG">مدغشقر</option>
                                <option value="EG">مصر</option>
                                <option value="MK">مقدونيا</option>
                                <option value="MW">ملاوي</option>
                                <option value="ZZ">منطقة غير معرفة</option>
                                <option value="MN">منغوليا</option>
                                <option value="MR">موريتانيا</option>
                                <option value="MU">موريشيوس</option>
                                <option value="MZ">موزمبيق</option>
                                <option value="MD">مولدافيا</option>
                                <option value="MC">موناكو</option>
                                <option value="MS">مونتسرات</option>
                                <option value="MM">ميانمار</option>
                                <option value="FM">ميكرونيزيا</option>
                                <option value="NA">ناميبيا</option>
                                <option value="NR">نورو</option>
                                <option value="NP">نيبال</option>
                                <option value="NG">نيجيريا</option>
                                <option value="NI">نيكاراجوا</option>
                                <option value="NZ">نيوزيلاندا</option>
                                <option value="NU">نيوي</option>
                                <option value="HT">هايتي</option>
                                <option value="HN">هندوراس</option>
                                <option value="HK">هونج كونج الصينية</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="email">البريد الالكتروني

                            </label>
                            <input type="email" class="form-control" placeholder="الايميل الالكتروني" name="email">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="  required ">رقم التواصل
                                <sup><svg style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                        viewBox="0 0 16 16">
                                        <path style="color: #ef0404;"
                                            d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></sup> <span style="font-size: small;"> (اجباري ) </span></label>
                            <input type="text" class="form-control" for="phone" id="phone"
                                placeholder="رقم التواصل" name="phone" required>
                        </div>

                        <div class="col-md-6">
                            <label for="class1" class="  required ">الصف الدراسي
                                <sup><svg style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                        viewBox="0 0 16 16">
                                        <path style="color: #ef0404;"
                                            d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></sup> <span style="font-size: small;"> (اجباري ) </span>
                            </label>
                            <select class="form-control ldir" aria-label="Class" name="class1" required=""
                                placeholder="اختر الصف ">
                                <option selected="">اختر الصف</option>
                                @foreach ($classes as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputState" class="  required "> الديانة
                                      <sup><svg
                                                  style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                                  width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                                viewBox="0 0 16 16">
                                                 <path style="color: #ef0404;"
                                                     d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                             </svg></sup> <span style="font-size: small;"> (اجباري ) </span ></label>
                                                     <select id="inputState" class="  form-control ldir" name="religion"
                                   required="">
                                   <option value="" selected="">اختر الديانة</option>
                                    <option value="0">مسلم</option>
                                    <option value="1">مسيحي</option>
                               </select>
                        </div>

                          <legend class="btn btn-primary"> الملفات الشخصية </legend>
                    <fieldset class="p-3 row filed_e">



                        <div class="col-xs-12 col-sm-12 col-md-3" >
                            <div class="form-group">
                                <label for="birthday" class=" " >  تحميل اخراج القيد \شهادة ميلاد </label>

                                <input type="file" value="" class="form-control" name="fourth_image">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3" >
                            <div class="form-group">
                                <label for="birthday" class=" " >  تحميل  صورة جواز السفر </label>

                                <input type="file" value="" class="form-control" name="passbord">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3" >
                            <div class="form-group">
                                <label for="birthday" class=" "> تحميل صورة الطالب /خلفية بيضاء / </label>
                                <input type="file" value="" class="form-control" name="personal_image">
                            </div>
                        </div>



                        <div class="col-xs-12 col-sm-12 col-md-3" >
                            <div class="form-group">
                                <label for="birthday" class=" "> تحميل اخر شهادة علمية <sup><svg
                                            style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                            width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                            viewBox="0 0 16 16">

                                        </svg></sup></label>
                               <input type="file" value="" class="form-control" name="certification">
                            </div>
                        </div>


                    </fieldset>
                    <legend class="btn btn-primary">  ملفات الأهل</legend>
                    <fieldset class="p-3 row filed_e">



                       <div class="col-xs-6 col-sm-6 col-md-6" >
                           <div class="form-group">
                               <label for="birthday" class=" "> تحميل صورة جواز سفر الأم </label>
                               <input type="file" value="" class="form-control" name="mather_page">
                           </div>
                       </div>
                       <div class="col-xs-6 col-sm-6 col-md-6" >
                           <div class="form-group">
                               <label for="birthday" class=" "> تحميل صورة جواز سفر الأب </label>
                               <input type="file" value="" class="form-control" name="father_page">
                           </div>
                       </div>

                    </fieldset>

                        <div class="col-sm-12">

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group ar_con">
                                    <label for="submit" style="text-align: center;"
                                        class="  required form-btn-loader fa fa-circle-o-notch fa-spin fa-fw margin-bottom d-none">رجاءً،
                                        تأكد من معلوماتك قبل الإرسال</label>
                                    <input type="submit"
                                        style="    background: #155a79;
        color: white;    margin: auto;"
                                        value="ارسال البيانات" class=" pbmit-btn">
                                </div>
                            </div>



                        </div>
                        <div class="col-md-12 col-lg-12 message-status"></div>
                    </div>
                </form>

                </main>


            </div>
        </div>
        </div>











        </fieldset>



        <div class="col-xs-12 col-sm-12 col-md-4">

        </div>


        </main>


        </div>
        </div>
        </div>
    @else
        <div class="container contact-form-leftbox" style="text-align: left">
            <div class="row justify-content-left >
            <div>
                <main class="page-content ar_con">
                <p></p>
                @if (session()->has('success'))
                    <div class="alert alert-success" style="    text-align: center;">
                        Thank you for your trust... Registration has been completed and we will contact you after the data
                        is accurate
                    </div>
                @endif

                <h4 style="color:#333333 !important;direction: ltr" class="pbmit-heading-subheading">
                    {{ __('site.Please complete this form and submit it by clicking on the button below') }}</h4>
                <p style="color:#333333 !important ;direction: ltr" class="pbmit-heading-subheading">
                    {{ __('site.Please make sure the information is accurate. We will contact you using one of the means mentioned in the form.') }}
                </p>
                <legend class="btn btn-primary"> Information student</legend>
                <fieldset class="p-3 row filed_e">
                <form action="{{ route('stu_register') }}" method="post" enctype="multipart/form-data"
                    style="text-align: left;direction: ltr">
                    @csrf
                    <div class="row" style="text-align: left">
                        <div class="col-md-6">
                            <label for="first_name" class="  required "> First Name
                                <sup><svg style="width: 11px;height: 11px;text-align: left"
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-asterisk" viewBox="0 0 16 16">
                                        <path style="color: #ef0404;"
                                            d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></sup> <span style="font-size: small;"> (Mandatory ) </span></label>
                            <input type="text" class="form-control" for="first_name" id="first_name"
                                placeholder="First Name " name="first_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="mother_name" class="  required ">Last Name
                                <sup><svg style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                        viewBox="0 0 16 16">
                                        <path style="color: #ef0404;"
                                            d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></sup> <span style="font-size: small;"> (Mandatory ) </span></label>

                            <input type="text" class="form-control" for="last_name" id="last_name"
                                placeholder="Last Name " name="last_name" required>
                        </div>

                        <div class="col-md-6">
                            <label for="father_name" class="  required ">Father Name
                                <sup><svg style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                        viewBox="0 0 16 16">
                                        <path style="color: #ef0404;"
                                            d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></sup> <span style="font-size: small;"> (Mandatory ) </span>
                            </label>
                            <input type="text" class="form-control" for="father_name" id="father_name"
                                placeholder=" Father Name" name="father_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="mather_name" class="  required "> Mather Name
                                <sup><svg
                                         style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                         width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                         viewBox="0 0 16 16">
                                         <path style="color: #ef0404;"
                                             d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                     </svg></sup> <span style="font-size: small;"> (Mandatory ) </span >
                               </label>
                            <input type="text" class="form-control" for="mather_name" id="mather_name"
                                placeholder="Mather Name  " name="mather_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="date" class=" "> Date of Birth
                                <sup><svg style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                        viewBox="0 0 16 16">
                                        <path style="color: #ef0404;"
                                            d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></sup> <span style="font-size: small;"> (Mandatory ) </span>
                            </label>
                            <input type="date" class="form-control" for="date" placeholder="تاريخ الميلاد"
                                name="date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="country" class="  required ">Country
                                <sup><svg style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                        viewBox="0 0 16 16">
                                        <path style="color: #ef0404;"
                                            d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></sup> <span style="font-size: small;"> (Mandatory ) </span>
                            </label>

                            <select class="form-control" id="country" name="country" placeholder="" required="">
                                <option value="">Select the country</option>
                                <!--@foreach ($countries_currencies as $item)
    @if ($item->active == 1)
    <option value="{{ $item->id }}"> {{ $item->name_en }}</option>
    @endif
    @endforeach-->
                                <option value="AF">Afghanistan</option>
                                <option value="AX">Aland Islands</option>
                                <option value="AL">Albania</option>
                                <option value="DZ">Algeria</option>
                                <option value="AS">American Samoa</option>
                                <option value="AD">Andorra</option>
                                <option value="AO">Angola</option>
                                <option value="AI">Anguilla</option>
                                <option value="AQ">Antarctica</option>
                                <option value="AG">Antigua and Barbuda</option>
                                <option value="AR">Argentina</option>
                                <option value="AM">Armenia</option>
                                <option value="AW">Aruba</option>
                                <option value="AU">Australia</option>
                                <option value="AT">Austria</option>
                                <option value="AZ">Azerbaijan</option>
                                <option value="BS">Bahamas</option>
                                <option value="BH">Bahrain</option>
                                <option value="BD">Bangladesh</option>
                                <option value="BB">Barbados</option>
                                <option value="BY">Belarus</option>
                                <option value="BE">Belgium</option>
                                <option value="BZ">Belize</option>
                                <option value="BJ">Benin</option>
                                <option value="BM">Bermuda</option>
                                <option value="BT">Bhutan</option>
                                <option value="BO">Bolivia</option>
                                <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                <option value="BA">Bosnia and Herzegovina</option>
                                <option value="BW">Botswana</option>
                                <option value="BV">Bouvet Island</option>
                                <option value="BR">Brazil</option>
                                <option value="IO">British Indian Ocean Territory</option>
                                <option value="BN">Brunei Darussalam</option>
                                <option value="BG">Bulgaria</option>
                                <option value="BF">Burkina Faso</option>
                                <option value="BI">Burundi</option>
                                <option value="KH">Cambodia</option>
                                <option value="CM">Cameroon</option>
                                <option value="CA">Canada</option>
                                <option value="CV">Cape Verde</option>
                                <option value="KY">Cayman Islands</option>
                                <option value="CF">Central African Republic</option>
                                <option value="TD">Chad</option>
                                <option value="CL">Chile</option>
                                <option value="CN">China</option>
                                <option value="CX">Christmas Island</option>
                                <option value="CC">Cocos (Keeling) Islands</option>
                                <option value="CO">Colombia</option>
                                <option value="KM">Comoros</option>
                                <option value="CG">Congo</option>
                                <option value="CD">Congo, Democratic Republic of the Congo</option>
                                <option value="CK">Cook Islands</option>
                                <option value="CR">Costa Rica</option>
                                <option value="CI">Cote D'Ivoire</option>
                                <option value="HR">Croatia</option>
                                <option value="CU">Cuba</option>
                                <option value="CW">Curacao</option>
                                <option value="CY">Cyprus</option>
                                <option value="CZ">Czech Republic</option>
                                <option value="DK">Denmark</option>
                                <option value="DJ">Djibouti</option>
                                <option value="DM">Dominica</option>
                                <option value="DO">Dominican Republic</option>
                                <option value="EC">Ecuador</option>
                                <option value="EG">Egypt</option>
                                <option value="SV">El Salvador</option>
                                <option value="GQ">Equatorial Guinea</option>
                                <option value="ER">Eritrea</option>
                                <option value="EE">Estonia</option>
                                <option value="ET">Ethiopia</option>
                                <option value="FK">Falkland Islands (Malvinas)</option>
                                <option value="FO">Faroe Islands</option>
                                <option value="FJ">Fiji</option>
                                <option value="FI">Finland</option>
                                <option value="FR">France</option>
                                <option value="GF">French Guiana</option>
                                <option value="PF">French Polynesia</option>
                                <option value="TF">French Southern Territories</option>
                                <option value="GA">Gabon</option>
                                <option value="GM">Gambia</option>
                                <option value="GE">Georgia</option>
                                <option value="DE">Germany</option>
                                <option value="GH">Ghana</option>
                                <option value="GI">Gibraltar</option>
                                <option value="GR">Greece</option>
                                <option value="GL">Greenland</option>
                                <option value="GD">Grenada</option>
                                <option value="GP">Guadeloupe</option>
                                <option value="GU">Guam</option>
                                <option value="GT">Guatemala</option>
                                <option value="GG">Guernsey</option>
                                <option value="GN">Guinea</option>
                                <option value="GW">Guinea-Bissau</option>
                                <option value="GY">Guyana</option>
                                <option value="HT">Haiti</option>
                                <option value="HM">Heard Island and Mcdonald Islands</option>
                                <option value="VA">Holy See (Vatican City State)</option>
                                <option value="HN">Honduras</option>
                                <option value="HK">Hong Kong</option>
                                <option value="HU">Hungary</option>
                                <option value="IS">Iceland</option>
                                <option value="IN">India</option>
                                <option value="ID">Indonesia</option>
                                <option value="IR">Iran, Islamic Republic of</option>
                                <option value="IQ">Iraq</option>
                                <option value="IE">Ireland</option>
                                <option value="IM">Isle of Man</option>
                                <option value="IL">Israel</option>
                                <option value="IT">Italy</option>
                                <option value="JM">Jamaica</option>
                                <option value="JP">Japan</option>
                                <option value="JE">Jersey</option>
                                <option value="JO">Jordan</option>
                                <option value="KZ">Kazakhstan</option>
                                <option value="KE">Kenya</option>
                                <option value="KI">Kiribati</option>
                                <option value="KP">Korea, Democratic People's Republic of</option>
                                <option value="KR">Korea, Republic of</option>
                                <option value="XK">Kosovo</option>
                                <option value="KW">Kuwait</option>
                                <option value="KG">Kyrgyzstan</option>
                                <option value="LA">Lao People's Democratic Republic</option>
                                <option value="LV">Latvia</option>
                                <option value="LB">Lebanon</option>
                                <option value="LS">Lesotho</option>
                                <option value="LR">Liberia</option>
                                <option value="LY">Libyan Arab Jamahiriya</option>
                                <option value="LI">Liechtenstein</option>
                                <option value="LT">Lithuania</option>
                                <option value="LU">Luxembourg</option>
                                <option value="MO">Macao</option>
                                <option value="MK">Macedonia, the Former Yugoslav Republic of</option>
                                <option value="MG">Madagascar</option>
                                <option value="MW">Malawi</option>
                                <option value="MY">Malaysia</option>
                                <option value="MV">Maldives</option>
                                <option value="ML">Mali</option>
                                <option value="MT">Malta</option>
                                <option value="MH">Marshall Islands</option>
                                <option value="MQ">Martinique</option>
                                <option value="MR">Mauritania</option>
                                <option value="MU">Mauritius</option>
                                <option value="YT">Mayotte</option>
                                <option value="MX">Mexico</option>
                                <option value="FM">Micronesia, Federated States of</option>
                                <option value="MD">Moldova, Republic of</option>
                                <option value="MC">Monaco</option>
                                <option value="MN">Mongolia</option>
                                <option value="ME">Montenegro</option>
                                <option value="MS">Montserrat</option>
                                <option value="MA">Morocco</option>
                                <option value="MZ">Mozambique</option>
                                <option value="MM">Myanmar</option>
                                <option value="NA">Namibia</option>
                                <option value="NR">Nauru</option>
                                <option value="NP">Nepal</option>
                                <option value="NL">Netherlands</option>
                                <option value="AN">Netherlands Antilles</option>
                                <option value="NC">New Caledonia</option>
                                <option value="NZ">New Zealand</option>
                                <option value="NI">Nicaragua</option>
                                <option value="NE">Niger</option>
                                <option value="NG">Nigeria</option>
                                <option value="NU">Niue</option>
                                <option value="NF">Norfolk Island</option>
                                <option value="MP">Northern Mariana Islands</option>
                                <option value="NO">Norway</option>
                                <option value="OM">Oman</option>
                                <option value="PK">Pakistan</option>
                                <option value="PW">Palau</option>
                                <option value="PS">Palestinian Territory, Occupied</option>
                                <option value="PA">Panama</option>
                                <option value="PG">Papua New Guinea</option>
                                <option value="PY">Paraguay</option>
                                <option value="PE">Peru</option>
                                <option value="PH">Philippines</option>
                                <option value="PN">Pitcairn</option>
                                <option value="PL">Poland</option>
                                <option value="PT">Portugal</option>
                                <option value="PR">Puerto Rico</option>
                                <option value="QA">Qatar</option>
                                <option value="RE">Reunion</option>
                                <option value="RO">Romania</option>
                                <option value="RU">Russian Federation</option>
                                <option value="RW">Rwanda</option>
                                <option value="BL">Saint Barthelemy</option>
                                <option value="SH">Saint Helena</option>
                                <option value="KN">Saint Kitts and Nevis</option>
                                <option value="LC">Saint Lucia</option>
                                <option value="MF">Saint Martin</option>
                                <option value="PM">Saint Pierre and Miquelon</option>
                                <option value="VC">Saint Vincent and the Grenadines</option>
                                <option value="WS">Samoa</option>
                                <option value="SM">San Marino</option>
                                <option value="ST">Sao Tome and Principe</option>
                                <option value="SA">Saudi Arabia</option>
                                <option value="SN">Senegal</option>
                                <option value="RS">Serbia</option>
                                <option value="CS">Serbia and Montenegro</option>
                                <option value="SC">Seychelles</option>
                                <option value="SL">Sierra Leone</option>
                                <option value="SG">Singapore</option>
                                <option value="SX">Sint Maarten</option>
                                <option value="SK">Slovakia</option>
                                <option value="SI">Slovenia</option>
                                <option value="SB">Solomon Islands</option>
                                <option value="SO">Somalia</option>
                                <option value="ZA">South Africa</option>
                                <option value="GS">South Georgia and the South Sandwich Islands</option>
                                <option value="SS">South Sudan</option>
                                <option value="ES">Spain</option>
                                <option value="LK">Sri Lanka</option>
                                <option value="SD">Sudan</option>
                                <option value="SR">Suriname</option>
                                <option value="SJ">Svalbard and Jan Mayen</option>
                                <option value="SZ">Swaziland</option>
                                <option value="SE">Sweden</option>
                                <option value="CH">Switzerland</option>
                                <option value="SY">Syrian Arab Republic</option>
                                <option value="TW">Taiwan, Province of China</option>
                                <option value="TJ">Tajikistan</option>
                                <option value="TZ">Tanzania, United Republic of</option>
                                <option value="TH">Thailand</option>
                                <option value="TL">Timor-Leste</option>
                                <option value="TG">Togo</option>
                                <option value="TK">Tokelau</option>
                                <option value="TO">Tonga</option>
                                <option value="TT">Trinidad and Tobago</option>
                                <option value="TN">Tunisia</option>
                                <option value="TR">Turkey</option>
                                <option value="TM">Turkmenistan</option>
                                <option value="TC">Turks and Caicos Islands</option>
                                <option value="TV">Tuvalu</option>
                                <option value="UG">Uganda</option>
                                <option value="UA">Ukraine</option>
                                <option value="AE">United Arab Emirates</option>
                                <option value="GB">United Kingdom</option>
                                <option value="US">United States</option>
                                <option value="UM">United States Minor Outlying Islands</option>
                                <option value="UY">Uruguay</option>
                                <option value="UZ">Uzbekistan</option>
                                <option value="VU">Vanuatu</option>
                                <option value="VE">Venezuela</option>
                                <option value="VN">Viet Nam</option>
                                <option value="VG">Virgin Islands, British</option>
                                <option value="VI">Virgin Islands, U.s.</option>
                                <option value="WF">Wallis and Futuna</option>
                                <option value="EH">Western Sahara</option>
                                <option value="YE">Yemen</option>
                                <option value="ZM">Zambia</option>
                                <option value="ZW">Zimbabwe</option>

                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email

                            </label>
                            <input type="email" class="form-control" placeholder="Email" name="email">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="  required ">Phone Number
                                <sup><svg style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                        viewBox="0 0 16 16">
                                        <path style="color: #ef0404;"
                                            d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></sup> <span style="font-size: small;"> (Mandatory ) </span></label>
                            <input type="text" class="form-control" for="phone" id="phone"
                                placeholder="Phone Number" name="phone" required>
                        </div>

                        <div class="col-md-6">
                            <label for="class1" class="  required ">Class
                                <sup><svg style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                        viewBox="0 0 16 16">
                                        <path style="color: #ef0404;"
                                            d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></sup> <span style="font-size: small;"> (Mandatory ) </span>
                            </label>
                            <select class="form-control ldir" aria-label="Class" name="class1" required=""
                                placeholder="اختر الصف ">
                                <option selected="">Select Class</option>
                                @foreach ($classes as $item)
                                    <option value="{{ $item->id }}">{{ $item->name_en }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputState" class="  required "> Religion
                                      <sup><svg
                                                  style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                                  width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                                viewBox="0 0 16 16">
                                                 <path style="color: #ef0404;"
                                                     d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                             </svg></sup> <span style="font-size: small;"> (Mandatory ) </span ></label>
                                                     <select id="inputState" class="  form-control ldir" name="religion"
                                   required="">
                                   <option value="" selected="">Select Religion </option>
                                    <option value="0">Muslim</option>
                                    <option value="1">Christian</option>
                               </select>
                        </div>
                        <legend class="btn btn-primary"> Personal files</legend>
                        <fieldset class="p-3 row filed_e">



                            <div class="col-xs-12 col-sm-12 col-md-3" >
                                <div class="form-group">
                                    <label for="birthday" class=" " >the registration certificate</label>

                                    <input type="file" value="" class="form-control" name="fourth_image">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3" >
                                <div class="form-group">
                                    <label for="birthday" class=" " >a passport photo        </label>

                                    <input type="file" value="" class="form-control" name="passbord">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3" >
                                <div class="form-group">
                                    <label for="birthday" class=" ">the student’s photo</label>
                                    <input type="file" value="" class="form-control" name="personal_image">
                                </div>
                            </div>



                            <div class="col-xs-12 col-sm-12 col-md-3" >
                                <div class="form-group">
                                    <label for="birthday" class=" ">the latest academic certificate<sup><svg
                                                style="width: 11px;height: 11px;" xmlns="http://www.w3.org/2000/svg"
                                                width="16" height="16" fill="currentColor" class="bi bi-asterisk"
                                                viewBox="0 0 16 16">

                                            </svg></sup></label>
                                   <input type="file" value="" class="form-control" name="certification">
                                </div>
                            </div>


                        </fieldset>

                        <fieldset class="p-3 row filed_e">

                            <legend class="btn btn-primary"> Parent files</legend>

                           <div class="col-xs-6 col-sm-6 col-md-6" >
                               <div class="form-group">
                                   <label for="birthday" class=" ">a photo of the mother’s passport</label>
                                   <input type="file" value="" class="form-control" name="mather_page">
                               </div>
                           </div>
                           <div class="col-xs-6 col-sm-6 col-md-6" >
                               <div class="form-group">
                                   <label for="birthday" class=" ">a photo of the father's passport</label>
                                   <input type="file" value="" class="form-control" name="father_page">
                               </div>
                           </div>

                        </fieldset>

                        <div class="col-sm-12">

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group ar_con">
                                    <label for="submit"
                                        class="  required  form-btn-loader fa fa-circle-o-notch fa-spin fa-fw margin-bottom d-none"
                                        style="text-align: center;">Please,
                                        verify your information before submitting</label>
                                    <input type="submit" value="send data" class="pbmit-btn"
                                        style="background: #155a79;
    color: white;    margin: auto;">
                                </div>
                            </div>


                        </div>
                        <div class="col-md-12 col-lg-12 message-status"></div>
                    </div>
                </form>


                </main>


            </div>
        </div>
        </div>











        </fieldset>



        <div class="col-xs-12 col-sm-12 col-md-4">

        </div>


        </main>


        </div>
        </div>
        </div>
    @endif
@endsection
