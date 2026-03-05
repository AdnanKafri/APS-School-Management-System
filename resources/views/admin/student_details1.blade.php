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
    <a href="{{ route('secret_keeper') }}" class="breadcrumbs__item ">امين السر الاكتروني </a>
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

                            <div class="col-lg-12">
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


                            <!--<div class="col-lg-6">-->
                            <!--    <div class="form-group">-->
                            <!--        <label class="form-control-label" for="input-last-name">عمل الأم</label>-->
                            <!--        <input type="text" name="mother_job" class="form-control"-->
                            <!--            value="{{ $student_detail->mother_job }}">-->
                            <!--    </div>-->
                            <!--</div>-->

                            <!--<div class="col-lg-6">-->
                            <!--    <div class="form-group">-->
                            <!--        <label class="form-control-label" for="input-last-name"> عمل الأب</label>-->
                            <!--        <input type="text" name="father_job" class="form-control"-->
                            <!--            value="{{ $student_detail->father_job }}">-->
                            <!--    </div>-->
                            <!--</div>-->

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-last-name">تاريخ الميلاد</label>
                                    <input type="date" id="input-last-name" name="date_birth" class="form-control"
                                        value="{{ $student->date_birth }}">
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>الديانة</label>

                                    <select name="religion" id="" class="form-control dep"
                                        style="min-height: 36px;direction: rtl" required>

                                        <option value=""> حدد ديانة الطالب </option>
                                        <option value="0" {{ $student->religion == '0' ? 'selected' :''}}>
                                            اسلامية
                                        </option>


                                        <option value="1" {{ $student->religion == '1'  ? 'selected' :''}}>
                                            مسيحية
                                        </option>
                                    </select>

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

                            <div class="col-lg-12">

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
                             <div class="col-lg-12">
                            <div class="form-group">
                              <label class="form-control-label" for="input-country">الرقم في السجل العام</label>
                              <input type="text" id="input-public_record_number" name="public_record_number" class="form-control public_record_number" value="{{$student->public_record_number }}">
                            </div>
                          </div>
                          <div class="col-lg-12">
                            <div class="form-group">
                          <label>دولة الدفع  </label>
                          <select name="country_currency" id="classes" class="form-control dep"
                            style="min-height: 36px;direction: rtl" required>
                            <option value="" >   اختر الدولة</option>
                            @foreach ($country_currency as $item )
                           
                            <option value="{{$item->id}}"  {{ $student->country_currency  ==  $item->id   ? 'selected' :''}}>{{$item->name_ar}}</option>
                           
                            @endforeach
                           
                            
                        </select>
                            </div>
                          </div>

                            {{-- ------------------------------------- --}}

                        </div>
                    </div>
                    <hr class="my-4">
                    <!-- Address -->
                    <h6 class="heading-small text-muted mb-4">معلومات التواصل</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-md-6">
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
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-address">المدينة </label>
                                    <input id="input-address" class="form-control" name="city" placeholder="عنوان السكن"
                                        value="{{ $student_detail->city }}" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-city">الجنسية</label>
                                    <input type="text" id="input-city" name="nationality" class="form-control"
                                        placeholder="الجنسية"
                                        value="@if($student->nationality  == " AF") Afghanistan @elseif($student->nationality == "AX")
                                    Aland Islands
                                    @elseif($student->nationality == "AL")
                                    Albania
                                    @elseif($student->nationality == "DZ")
                                    Algeria
                                    @elseif($student->nationality == "AS")
                                    American Samoa
                                    @elseif($student->nationality == "AD")
                                    Andorra
                                    @elseif($student->nationality == "AO")
                                    Angola
                                    @elseif($student->nationality == "AI")
                                    Anguilla
                                    @elseif($student->nationality == "AQ")
                                    Antarctica
                                    @elseif($student->nationality == "AG")
                                    Anguilla
                                    @elseif($student->nationality == "AR")
                                    Argentina
                                    @elseif($student->nationality == "AW")
                                    Aruba
                                    @elseif($student->nationality == "AM")
                                    Armenia
                                    @elseif($student->nationality == "AU")
                                    Australia
                                    @elseif($student->nationality == "AT")
                                    Austria
                                    @elseif($student->nationality == "AZ")
                                    Azerbaijan
                                    @elseif($student->nationality == "BS")
                                    Bahamas
                                    @elseif($student->nationality == "BH")
                                    Bahrain
                                    @elseif($student->nationality == "BD")
                                    Bangladesh
                                    @elseif($student->nationality == "BB")
                                    Barbados
                                    @elseif($student->nationality == "BY")
                                    Belarus
                                    @elseif($student->nationality == "BE")
                                    Belgium
                                    @elseif($student->nationality == "BZ")
                                    Belize
                                    @elseif($student->nationality == "BJ")
                                    Benin
                                    @elseif($student->nationality == "BM")
                                    Bermuda
                                    @elseif($student->nationality == "BT")
                                    Bhutan
                                    @elseif($student->nationality == "BO")
                                    Bolivia
                                    @elseif($student->nationality == "BQ")
                                    Bonaire, Sint Eustatius and Saba
                                    @elseif($student->nationality == "BA")
                                    Bosnia and Herzegovina
                                    @elseif($student->nationality == "BW")
                                    Botswana
                                    @elseif($student->nationality == "BV")
                                    Bouvet Island
                                    @elseif($student->nationality == "BR")
                                    Brazil
                                    @elseif($student->nationality == "IO")
                                    British Indian Ocean Territory
                                    @elseif($student->nationality == "BN")
                                    Brunei Darussalam
                                    @elseif($student->nationality == "BG")
                                    Bulgaria
                                    @elseif($student->nationality == "BF")
                                    Burkina Faso
                                    @elseif($student->nationality == "BI")
                                    Burundi
                                    @elseif($student->nationality == "KH")
                                    Cambodia
                                    @elseif($student->nationality == "CM")
                                    Cameroon
                                    @elseif($student->nationality == "CA")
                                    Canada
                                    @elseif($student->nationality == "CV")
                                    Cape Verde
                                    @elseif($student->nationality == "KY")
                                    Cayman Islands
                                    @elseif($student->nationality == "CF")
                                    Central African Republic
                                    @elseif($student->nationality == "TD")
                                    Chad
                                    @elseif($student->nationality == "CL")
                                    Chile
                                    @elseif($student->nationality == "CN")
                                    China
                                    @elseif($student->nationality == "CX")
                                    Christmas Island
                                    @elseif($student->nationality == "CC")
                                    Cocos (Keeling) Islands
                                    @elseif($student->nationality == "CO")
                                    Colombia
                                    @elseif($student->nationality == "KM")
                                    Comoros
                                    @elseif($student->nationality == "CG")
                                    Congo
                                    @elseif($student->nationality == "CD")
                                    Congo, Democratic Republic of the Congo
                                    @elseif($student->nationality == "CK")
                                    Cook Islands
                                    @elseif($student->nationality == "CR")
                                    Costa Rica
                                    @elseif($student->nationality == "CI")
                                    Cote D'Ivoire
                                    @elseif($student->nationality == "HR")
                                    Croatia
                                    @elseif($student->nationality == "CU")
                                    Cuba
                                    @elseif($student->nationality == "CW")
                                    Curacao
                                    @elseif($student->nationality == "CY")
                                    Cyprus
                                    @elseif($student->nationality == "CZ")
                                    Czech Republic
                                    @elseif($student->nationality == "DK")
                                    Denmark
                                    @elseif($student->nationality == "DJ")
                                    Djibouti
                                    @elseif($student->nationality == "DM")
                                    Dominica
                                    @elseif($student->nationality == "DO")
                                    Dominican Republic
                                    @elseif($student->nationality == "EC")
                                    Ecuador
                                    @elseif($student->nationality == "EG")
                                    Egypt
                                    @elseif($student->nationality == "SV")
                                    El Salvador
                                    @elseif($student->nationality == "GQ")
                                    Equatorial Guinea
                                    @elseif($student->nationality == "ER")
                                    Eritrea
                                    @elseif($student->nationality == "EE")
                                    Estonia @elseif($student->nationality == "ET")
                                    Ethiopia @elseif($student->nationality == "FK")
                                    Falkland Islands (Malvinas)
                                    @elseif($student->nationality == "FO")
                                    Faroe Islands
                                    @elseif($student->nationality == "FJ")
                                    Fiji
                                    @elseif($student->nationality == "FI")
                                    Finland
                                    @elseif($student->nationality == "FR")
                                    France
                                    @elseif($student->nationality == "GF")
                                    French Guiana
                                    @elseif($student->nationality == "PF")
                                    French Polynesia
                                    @elseif($student->nationality == "TF")
                                    French Southern Territories
                                    @elseif($student->nationality == "GA")
                                    Gabon
                                    @elseif($student->nationality == "GM")
                                    Gambia
                                    @elseif($student->nationality == "GE")
                                    Georgia
                                    @elseif($student->nationality == "DE")
                                    Germany
                                    @elseif($student->nationality == "GH")
                                    Ghana
                                    @elseif($student->nationality == "GI")
                                    Gibraltar
                                    @elseif($student->nationality == "GR")
                                    Greece
                                    @elseif($student->nationality == "GL")
                                    Greenland
                                    @elseif($student->nationality == "GD")
                                    Grenada
                                    @elseif($student->nationality == "GP")
                                    Guadeloupe
                                    @elseif($student->nationality == "GU")
                                    Guam
                                    @elseif($student->nationality == "GT")
                                    Guatemala
                                    @elseif($student->nationality == "GG")
                                    Guernsey
                                    @elseif($student->nationality == "GN")
                                    Guinea
                                    @elseif($student->nationality == "GW")
                                    Guinea-Bissau
                                    @elseif($student->nationality == "GY")
                                    Guyana
                                    @elseif($student->nationality == "HT")
                                    Haiti
                                    @elseif($student->nationality == "HN")
                                    Honduras
                                    @elseif($student->nationality == "HM")
                                    Heard Island and Mcdonald Islands
                                    @elseif($student->nationality == "VA")
                                    Holy See (Vatican City State)
                                    @elseif($student->nationality == "HK")
                                    Hong Kong
                                    @elseif($student->nationality == "HU")
                                    Hungary
                                    @elseif($student->nationality == "IS")
                                    Iceland
                                    @elseif($student->nationality == "IN")
                                    India
                                    @elseif($student->nationality == "ID")
                                    Indonesia
                                    @elseif($student->nationality == "IR")
                                    Iran, Islamic Republic of
                                    @elseif($student->nationality == "IQ")
                                    Iraq
                                    @elseif($student->nationality == "IE")
                                    Ireland
                                    @elseif($student->nationality == "IM")
                                    Isle of Man
                                    @elseif($student->nationality == "IL")
                                    Israel
                                    @elseif($student->nationality == "IT")
                                    Italy
                                    @elseif($student->nationality == "JM")
                                    Jamaica
                                    @elseif($student->nationality == "JP")
                                    Japan
                                    @elseif($student->nationality == "JE")
                                    Jersey
                                    @elseif($student->nationality == "JO")
                                    Jordan
                                    @elseif($student->nationality == "KZ")
                                    Kazakhstan
                                    @elseif($student->nationality == "KE")
                                    Kenya
                                    @elseif($student->nationality == "KI")
                                    Kiribati
                                    @elseif($student->nationality == "KP")
                                    Korea, Democratic People's Republic of
                                    @elseif($student->nationality == "KR")
                                    Korea, Republic of
                                    @elseif($student->nationality == "XK")
                                    Kosovo
                                    @elseif($student->nationality == "KW")
                                    Kuwait
                                    @elseif($student->nationality == "KG")
                                    Kyrgyzstan
                                    @elseif($student->nationality == "LA")
                                    Lao People's Democratic Republic
                                    @elseif($student->nationality == "LV")
                                    Latvia
                                    @elseif($student->nationality == "LB")
                                    Lebanon
                                    @elseif($student->nationality == "LS")
                                    Lesotho
                                    @elseif($student->nationality == "LR")
                                    Liberia
                                    @elseif($student->nationality == "LY")
                                    Libyan Arab Jamahiriya
                                    @elseif($student->nationality == "LI")
                                    Liechtenstein
                                    @elseif($student->nationality == "LT")
                                    Lithuania
                                    @elseif($student->nationality == "LU")
                                    Luxembourg
                                      @elseif($student->nationality == "LC")
                                    Saint Lucia
                                    @elseif($student->nationality == "MO")
                                    Macao
                                    @elseif($student->nationality == "MK")
                                    Macedonia, the Former Yugoslav Republic of
                                    @elseif($student->nationality == "MG")
                                    Madagascar
                                    @elseif($student->nationality == "MW")
                                    Malawi
                                    @elseif($student->nationality == "MY")
                                    Malaysia
                                    @elseif($student->nationality == "MV")
                                    Maldives
                                    @elseif($student->nationality == "ML")
                                    Mali
                                    @elseif($student->nationality == "MT")
                                    Malta
                                    @elseif($student->nationality == "MH")
                                    Marshall Islands
                                    @elseif($student->nationality == "MQ")
                                    Martinique
                                    @elseif($student->nationality == "MR")
                                    Mauritania
                                    @elseif($student->nationality == "MU")
                                    Mayotte
                                    @elseif($student->nationality == "MX")
                                    Mexico
                                    @elseif($student->nationality == "FM")
                                    Micronesia, Federated States of
                                    @elseif($student->nationality == "MD")
                                    Moldova, Republic of
                                    @elseif($student->nationality == "MC")
                                    Monaco
                                    @elseif($student->nationality == "MN")
                                    Mongolia
                                    @elseif($student->nationality == "ME")
                                    Montenegro

                                    @elseif($student->nationality == "MS")
                                    Montserrat

                                    @elseif($student->nationality == "MA")
                                    Morocco
                                    @elseif($student->nationality == "MZ")
                                    Mozambique
                                    @elseif($student->nationality == "MM")
                                    Myanmar
                                    @elseif($student->nationality == "NA")
                                    Namibia
                                    @elseif($student->nationality == "NR")
                                    Nauru
                                    @elseif($student->nationality == "NP")
                                    Nepal
                                    @elseif($student->nationality == "NL")
                                    Netherlands
                                    @elseif($student->nationality == "AN")
                                    Netherlands Antilles
                                    @elseif($student->nationality == "NC")
                                    New Caledonia
                                    @elseif($student->nationality == "NZ")
                                    New Zealand
                                    @elseif($student->nationality == "NI")
                                    Nicaragua
                                    @elseif($student->nationality == "NE")
                                    Niger
                                    @elseif($student->nationality == "NG")
                                    Nigeria
                                    @elseif($student->nationality == "NU")
                                    Niue
                                    @elseif($student->nationality == "NF")
                                    Norfolk Island
                                    @elseif($student->nationality == "MP")
                                    Northern Mariana Islands
                                    @elseif($student->nationality == "NO")
                                    Norway
                                    @elseif($student->nationality == "OM")
                                    Oman
                                    @elseif($student->nationality == "PK")
                                    Pakistan
                                    @elseif($student->nationality == "PW")
                                    Palau
                                    @elseif($student->nationality == "PS")
                                    Palestinian Territory, Occupied
                                    @elseif($student->nationality == "PA")
                                    Panama
                                    @elseif($student->nationality == "PG")
                                    Papua New Guinea
                                    @elseif($student->nationality == "PY")
                                    Paraguay
                                    @elseif($student->nationality == "PE")
                                    Peru
                                    @elseif($student->nationality == "PH")
                                    Philippines
                                    @elseif($student->nationality == "PN")
                                    Pitcairn
                                    @elseif($student->nationality == "PL")
                                    Poland
                                    @elseif($student->nationality == "PT")
                                    Portugal
                                    @elseif($student->nationality == "PR")
                                    Puerto Rico
                                    @elseif($student->nationality == "QA")
                                    Qatar
                                    @elseif($student->nationality == "RE")
                                    Reunion
                                    @elseif($student->nationality == "RO")
                                    Romania
                                    @elseif($student->nationality == "RU")
                                    Russian Federation
                                    @elseif($student->nationality == "RW")
                                    Rwanda
                                    @elseif($student->nationality == "BL")
                                    Saint Barthelemy
                                    @elseif($student->nationality == "SH")
                                    Saint Helena
                                    @elseif($student->nationality == "KN")
                                    Saint Kitts and Nevis
                                    @elseif($student->nationality == "SH")
                                    Saint Lucia
                                    @elseif($student->nationality == "MF")
                                    Saint Martin
                                    @elseif($student->nationality == "PM")
                                    Saint Pierre and Miquelon
                                    @elseif($student->nationality == "VC")
                                    Saint Vincent and the Grenadines
                                    @elseif($student->nationality == "WS")
                                    Samoa
                                    @elseif($student->nationality == "SM")
                                    San Marino

                                    @elseif($student->nationality == "ST")
                                    Sao Tome and Principe
                                    @elseif($student->nationality == "SA")
                                    Saudi Arabia
                                    @elseif($student->nationality == "SN")
                                    Senegal
                                    @elseif($student->nationality == "RS")
                                    Serbia
                                    @elseif($student->nationality == "CS")
                                    Serbia and Montenegro
                                    @elseif($student->nationality == "SC")
                                    Seychelles
                                    @elseif($student->nationality == "SL")
                                    Sierra Leone
                                    @elseif($student->nationality == "SX")
                                    Sint Maarten
                                    @elseif($student->nationality == "SK")
                                    Slovakia
                                    @elseif($student->nationality == "SI")
                                    Slovenia
                                    @elseif($student->nationality == "SB")
                                    Solomon Islands
                                    @elseif($student->nationality == "SO")
                                    Somalia
                                    @elseif($student->nationality == "ZA")
                                    South Africa
                                    @elseif($student->nationality == "GS")
                                    South Georgia and the South Sandwich Islands
                                    @elseif($student->nationality == "SS")
                                    South Sudan
                                    @elseif($student->nationality == "ES")
                                    Spain
                                    @elseif($student->nationality == "LK")
                                    Sri Lanka
                                    @elseif($student->nationality == "SD")
                                    Sudan

                                    @elseif($student->nationality == "SR")
                                    Suriname
                                    @elseif($student->nationality == "SJ")
                                    Svalbard and Jan Mayen
                                    @elseif($student->nationality == "SZ")
                                    Swaziland
                                    @elseif($student->nationality == "SE")
                                    Sweden
                                    @elseif($student->nationality == "CH")
                                    Switzerland
                                    @elseif($student->nationality == "SY")
                                    Syrian Arab Republic
                                    @elseif($student->nationality == "TW")
                                    Taiwan, Province of China
                                    @elseif($student->nationality == "TJ")
                                    Tajikistan
                                    @elseif($student->nationality == "TZ")
                                    Tanzania, United Republic of
                                    @elseif($student->nationality == "TH")
                                    Thailand
                                    @elseif($student->nationality == "TL")
                                    Timor-Leste
                                    @elseif($student->nationality == "TG")
                                    Togo
                                    @elseif($student->nationality == "TK")
                                    Tokelau
                                    @elseif($student->nationality == "TO")
                                    Tonga
                                    @elseif($student->nationality == "TN")
                                    Trinidad and Tobago
                                    @elseif($student->nationality == "TR")
                                    Turkey
                                    @elseif($student->nationality == "TM")
                                    Turkmenistan
                                    @elseif($student->nationality == "TC")
                                    Turks and Caicos Islands
                                    @elseif($student->nationality == "TV")
                                    Tuvalu
                                    @elseif($student->nationality == "UG")
                                    Uganda
                                    @elseif($student->nationality == "UA")
                                    Ukraine
                                    @elseif($student->nationality == "AE")
                                    United Arab Emirates
                                    @elseif($student->nationality == "GB")
                                    United Kingdom
                                    @elseif($student->nationality == "US")
                                    United States
                                    @elseif($student->nationality == "UM")

                                    United States Minor Outlying Islands
                                    @elseif($student->nationality == "UY")

                                    Uruguay
                                    @elseif($student->nationality == "UZ")

                                    Uzbekistan
                                    @elseif($student->nationality == "VU")
                                    Vanuatu
                                    @elseif($student->nationality == "VE")
                                    Venezuela
                                    @elseif($student->nationality == "VN")
                                    Viet Nam
                                    @elseif($student->nationality == "VG")
                                    Virgin Islands, British
                                    @elseif($student->nationality == "VI")
                                    Virgin Islands, U.s.
                                    @elseif($student->nationality == "WF")
                                    Wallis and Futuna
                                    @elseif($student->nationality == "EH")
                                    Western Sahara
                                    @elseif($student->nationality == "EH")
                                    Yemen
                                    @elseif($student->nationality == "ZM")
                                    Zambia
                                    @elseif($student->nationality == "ZW")
                                    Zimbabwe
                                    @else
                                    {{$student->nationality }}

                                    @endif">
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
                                    <label class="form-control-label" for="input-country">هاتف من ينوب عن الاهل</label>
                                    <input type="text" id="input-phone" name="other_phone" class="form-control"
                                        value="{{ $student_detail->other_phone }}">
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
                    <hr class="my-4">
                    <!-- Description -->
                     <h6 class="heading-small text-muted mb-4">الوثائق</h6>
                    <a class="btn btn-danger"  href="{{route('all_documents',$student->id)}}" style="color:white;">
                        تنزيل جميع وثائق الطالب   </a>
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
