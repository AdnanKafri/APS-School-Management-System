@extends('students.layouts.app4')
@section('title')
School
@endsection
@section('css')
  <!--link cards-->
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;700&display=swap" rel="stylesheet">
  <style>
    button:not(:disabled), [type="button"]:not(:disabled), [type="reset"]:not(:disabled), [type="submit"]:not(:disabled) {
    cursor: initial;
}
   .labeltitle{
    font-size: 17px;
    color: #152C4F ;
   }

.form {
background-color: white;
padding: 3.125em;
border-radius: 10px;
display: flex;
flex-direction: column;
align-items: center;
box-shadow: 5px 5px 15px -1px rgba(0,0,0,0.75);
}

.signup {
color: rgb(77, 75, 75);
text-transform: uppercase;
letter-spacing: 2px;
display: block;
font-weight: bold;
font-size: x-large;
margin-bottom: 0.5em;
}

.form--input {
/*width: 100%;*/
margin-bottom: 1.25em;
height: 40px;
border-radius: 5px;
border: 1px solid gray;
padding: 0.8em;
font-family: 'Inter', sans-serif;
outline: none;
}

.form--input:focus {
border: 1px solid #a5c9ff ;
outline: none;
}

.form--marketing {
display: flex;
margin-bottom: 1.25em;
align-items: center;
}

.form--marketing > input {
margin-right: 0.625em;
}

.form--marketing > label {
color: grey;
}

.checkbox, input[type="checkbox"] {
accent-color: #14315C ;
}

.form--submit {
width: 100%;
padding: 0.625em;
border-radius: 5px;
color: white;
background-color: #14315C ;
border: 1px dashed #14315C ;
cursor: pointer;
}

.form--submit:hover {
color: #14315C ;
background-color: white;
border: 1px dashed #14315C ;
cursor: pointer;
transition: 0.5s;
}
label {
  display: block;
  margin-bottom: 0.5rem;
}

/*style for upload file*/
/*.form22 {
background-color: none !important;
box-shadow: 0 10px 60px rgb(218, 229, 255) !important;
border: 1px solid rgb(159, 159, 160);
border-radius: 20px;
padding: 2rem .7rem .7rem .7rem;
text-align: center;
font-size: 1.125rem;
max-width: 320px;
}*/

.form-title {
color: #000000;
font-size: 1.8rem;
font-weight: 500;
}

.form-paragraph {
margin-top: 10px;
font-size: 0.9375rem;
color: rgb(105, 105, 105);
}
@media(min-width:200px) and (max-width:500px){
.drop-container{
  width: 77% !important;
  margin-top: 0px !important;
  margin:  auto !important;
}
}

.drop-container {
background-color: #fff;
position: relative;
display: flex;
gap: 10px;
flex-direction: column;
justify-content: center;
align-items: center;
padding: 10px;
margin-top: 2.1875rem;
border-radius: 10px;
border: 2px dashed #a5c9ff  ;
color: #444;
cursor: pointer;
transition: background .2s ease-in-out, border .2s ease-in-out;
}

.drop-container:hover {
background: #a5c9ff;
border-color: #14315C ;
}

.drop-container:hover .drop-title {
color: #222;
}

.drop-title {
color: #444;
font-size: 20px;
font-weight: bold;
text-align: center;
transition: color .2s ease-in-out;
background: none !important;
}

#file-input {
width: 350px;
max-width: 100%;
color: #444;
padding: 4px;
background: #fff;
border-radius: 10px;
border: 1px solid rgba(8, 8, 8, 0.288);
}

#file-input::file-selector-button {
margin-right: 0px;
border: none;
background: #152C4F ;
padding: 10px 20px;
border-radius: 10px;
color: #fff;
cursor: pointer;
transition: background .2s ease-in-out;
}

#file-input::file-selector-button:hover {
background: #a5c9ff  ;
}
/*end style*/

@media(min-width:200px) and (max-width:800px){
.form{
  text-align: center !important;
}
}
@media(min-width:772px) and (max-width:1089px){
.col-md-4{
  max-width: 47.33333%;
}
}
a .form--submit:hover{
    color: #14315C;
}
a .form--submit:hover{
    color: #14315C;
}
</style>
@endsection

@section('content')
@if (session()->has('success'))
<script>
  window.onload = function() {
      notif({
          msg: "    تم تعديل المعلومات بنجاح    ",
          type: "success"
      })
  }

</script>
@endif

@if (session()->has('success1'))
<script>
  window.onload = function() {
      notif({
          msg: " تم ارسال طلب تعديل معلومات بنجاح     ",
          type: "success"
      })
  }

</script>
@endif
<div class="main-panel" >
  <ul class="breadcrumbs" style="padding-bottom: 7px;
  padding-top: 11px;">

    <li class="li"><a href="{{ route('dashboard.student.lessons',$student->id) }}">الصفحة الرئيسية</a></li>
    <li class="li"><a href="#"> حسابي </a></li>

 </ul>
 @error('certification_nine')
 <div class="alert alert-danger">{{ $message }}</div>
@enderror
@error('certification')
<div class="alert alert-danger">{{ $message }}</div>
@enderror
@error('study_sequence')
<div class="alert alert-danger">{{ $message }}</div>
@enderror
@error('father_page')
<div class="alert alert-danger">{{ $message }}</div>
@enderror
@error('mother_page')
<div class="alert alert-danger">{{ $message }}</div>
@enderror
@error('passport')
<div class="alert alert-danger">{{ $message }}</div>
@enderror
@error('fourth_image')
<div class="alert alert-danger">{{ $message }}</div>
@enderror
@error('father_image')
<div class="alert alert-danger">{{ $message }}</div>
@enderror
@error('mother_image')
<div class="alert alert-danger">{{ $message }}</div>
@enderror
@error('family_book')
<div class="alert alert-danger">{{ $message }}</div>
@enderror
@error('personal_image')
<div class="alert alert-danger">{{ $message }}</div>
@enderror


 <div class="content-wrapper pb-0">
    <!--content -->

      <div class="container" style="padding-bottom: 100px;">
         <div class="row">
           <div class="col-md-12">
            <form class="form"  action="{{ route('edit_student_info',$student_id) }}" method="post" enctype="multipart/form-data"   style="direction: rtl;text-align: right;">
              @csrf
              <input type="text"  hidden  name="room_id" value="{{$room_id}}">
              <div class="row">
                <div class="col-md-4" style="margin-top: 24px;">
                  <label class="labeltitle">الاسم الأول </label>
                  <input type="text" placeholder="الاسم الأول"  name="first_name" value="{{$student->first_name}}"
                   @if ($student->first_name)
                    readonly
                  @endif class="form--input">
                </div>
                <div class="col-md-4">
                  <label for="" class="labeltitle">الاسم الأول باالانكليزي</label>
                  <input type="text" placeholder="الاسم الأول"
                  @if ($student->first_name_en)
                  readonly
                @endif name="first_name_en" value="{{$student->first_name_en}}"  class="form--input">
                </div>
                <div class="col-md-4">
                  <label for="" class="labeltitle">الكنية</label>
                  <input type="text" placeholder="الكنية"   @if ($student->last_name)
                  readonly
                @endif name="last_name" value="{{$student->last_name}}" class="form--input">
                </div>
                <div class="col-md-4">
                  <label for="" class="labeltitle">الكنية بالانكليزي</label>
                  <input
                   @if ($student->last_name_en)
                  readonly
                   @endif type="text" placeholder="الكنية باالانكليزي" name="last_name_en" value="{{$student->last_name_en}}" class="form--input">
                </div>

                <div class="col-md-4">
                  <label for="" class="labeltitle">اسم الأب</label>
                  <input type="text" placeholder="اسم الأب"  name="father_name"
                  @if ($student_detail->father_name)
                  readonly
                @endif
                  value="{{$student_detail->father_name}}" class="form--input">
                </div>
                <div class="col-md-4">
                  <label for="" class="labeltitle">اسم الأم</label>
                  <input  @if ($student_detail->mother_name)
                  readonly
                   @endif type="text" placeholder="اسم الأم" name="mother_name" value="{{$student_detail->mother_name}}" class="form--input">
                </div>

                <div class="col-md-4">
                   <label for="" class="labeltitle">كنية الأم</label>
                   <input  @if ($student_detail->last_mother_name)
                   readonly
                   @endif type="text" placeholder="كنية الأم" name="last_mother_name"  value="{{$student_detail->last_mother_name}}"    class="form--input">
                </div>


                <div class="col-md-4">
                    <label for="" class="labeltitle">رقم الأم</label>
                    <input  @if ($student_detail->mother_phone)
                    readonly
                    @endif type="number" placeholder="رقم الأم" name="mother_phone"  value="{{$student_detail->mother_phone}}"    class="form--input">
                 </div>

                 <div class="col-md-4">
                    <label for="" class="labeltitle">رقم الأب</label>
                    <input  @if ($student_detail->father_phone)
                    readonly
                    @endif type="number" placeholder="رقم الأب" name="father_phone"  value="{{$student_detail->father_phone}}"    class="form--input">
                 </div>

                 <div class="col-md-4">
                    <label for="" class="labeltitle">عمل الأب</label>
                    <input  @if ($student_detail->father_job)
                    readonly
                    @endif type="text" placeholder="عمل الأب" name="father_job"  value="{{$student_detail->father_job}}"    class="form--input">
                 </div>
                 <div class="col-md-4">
                    <label for="" class="labeltitle">عمل الأم</label>
                    <input  @if ($student_detail->mother_job)
                    readonly
                    @endif type="text" placeholder="عمل الأم" name="mother_job"  value="{{$student_detail->mother_job}}"    class="form--input">
                 </div>


                <div class="col-md-4">
                  <label for="" class="labeltitle">رقم التواصل 1</label>
                  <input  @if ($student_detail->phone)
                  readonly
                @endif type="number" placeholder="" name="phone" value="{{$student_detail->phone}}" class="form--input">
                </div>

                <div class="col-md-4">
                    <label for="" class="labeltitle">هاتف من ينوب عن الأهل</label>
                    <input  @if ($student_detail->other_phone)
                    readonly
                  @endif type="number" placeholder="" name="other_phone" value="{{$student_detail->other_phone}}" class="form--input">
                  </div>

                <div class="col-md-4">
                  <label for="" class="labeltitle">مكان الولادة</label>
                  <input  @if ($student->place_birth)
                  readonly
                @endif type="text" placeholder="مكان الولادة" name="place_birth" value="{{$student->place_birth}}" class="form--input">
                </div>

                <div class="col-md-4">
                    <label for="" class="labeltitle">تاريخ الميلاد</label>
                    <input  @if ($student->date_birth)
                    readonly
                  @endif type="text" placeholder="تاريخ الميلاد" name="date_birth" value="{{$student->date_birth}}" class="form--input">
                  </div>


                <div class="col-md-4">
                  <label for="" class="labeltitle">الجنس</label>

                  <select name="gender"   id="" class="form--input"
                  style="
                  @if ($student_detail->gender)
                  pointer-events: none;
                    @endif
                  min-height: 36px;direction: rtl; height: fit-content;width: 78%;">

                  <option value=""> حدد جنس  </option>
                  <option value="1" {{ $student_detail->gender == '1' ? 'selected' :''}}>
                      ذكر
                  </option>
                  <option value="2" {{ $student_detail->gender == '2'  ? 'selected' :''}}>
                      انثى
                  </option>
              </select>


                </div>
                <div class="col-md-4">
                  <label for="" class="labeltitle">الديانة</label>
                  <select name="religion" id="" class="form--input"
                  style="

                  @if ($student->religion)
                  pointer-events: none;
                      @endif
                  min-height: 36px;direction: rtl;height: fit-content;width: 78%;" >

                  <option value=""> حدد ديانة  </option>
                  <option value="0" {{ $student->religion == '0' ? 'selected' :''}}>
                      اسلامية
                  </option>
                  <option value="1" {{ $student->religion == '1'  ? 'selected' :''}}>
                      مسيحية
                  </option>
              </select>
                </div>
                <div class="col-md-4">
                  <label for="" class="labeltitle">الجنسية</label>
                  <input type="text" @if ($student->nationality)
                  readonly
                @endif name="nationality" class="form--input"
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
                <div class="col-md-4">
                  <label for="" class="labeltitle">رقم جواز السفر</label>
                  <input type="text" @if ($student_detail->passport_number)
                  readonly
                @endif  name="passport_number"  value="{{$student_detail->passport_number}}" placeholder="رقم جواز السفر" class="form--input">
                </div>
                <div class="col-md-4">
                  <label for="" class="labeltitle">الرقم الوطني</label>
                  <input
                  @if ($student_detail->the_ID_number)
                  readonly
                  @endif  type="text" placeholder="الرقم الوطني" name="the_ID_number" value="{{$student_detail->the_ID_number}}" class="form--input">
                </div>

                <div class="col-md-4">
                  <label for="" class="labeltitle">مكان الإقامة (حاليا)</label>
                  <input  @if ($student->address)
                  readonly
                @endif class="form--input" name="address"
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
                <div class="col-md-4">
                  <label for="" class="labeltitle">المدينة</label>
                  <input type="text" placeholder="المدينة" name="city"  @if ($student_detail->city)
                  readonly
                @endif  value="{{ $student_detail->city }}" class="form--input">
                </div>
                {{-- <div class="col-md-4">
                  <label for="" class="labeltitle">مكان الولادة</label>
                  <input type="text" placeholder="مكان الولادة" class="form--input">
                </div> --}}

                {{-- <div class="col-md-4">
                  <label for="" class="labeltitle">الصف الدراسي</label>
                  <input type="text" placeholder="الصف الدراسي" class="form--input">
                </div> --}}
                {{-- <div class="col-md-4" class="labeltitle">
                  <label for="">البريد الالكتروني </label>
                  <input type="text" placeholder="البريد الالكتروني" class="form--input">
                </div> --}}

                <div class="col-md-4">
                  <label for="" class="labeltitle">رقم التواصل 2</label>
                  <input type="text"
                    @if ($student_detail->other_phone)
                  readonly
                  @endif  placeholder="رقم التواصل 2" name="other_phone"  value="{{ $student_detail->other_phone }}" class="form--input">
                </div>
                <div class="col-md-4">
                  <label for="" class="labeltitle"> شعبة التجنيد</label>
                  <input type="text" placeholder="شعبة التجنيد"
                  @if ($student->army_room)
                  readonly
                  @endif
                   name="army_room"  value="{{ $student->army_room }}" class="form--input">
                </div>
                <div class="col-md-4">
                  <label for="" class="labeltitle">الخانة</label>
                  <input type="text" placeholder="الخانة" name="box_birth"
                  @if ($student->box_birth)
                  readonly
                  @endif
                   value="{{ $student->box_birth }}" class="form--input">
                </div>


                <div class="col-md-4">
                 <label for="" class="labeltitle"> أخر شهادة علمية</label>
                 @if ($student_detail->certification!=null)
                 <img src="{{ asset('storage/'.$student_detail->certification) }}" class="del_edit_img"
                     id="image1" alt="Not found" width="100"  height="100px" alt="">
                     @else
                     <img src="{{asset('student/notfound.jpg') }}"
                     class="del_edit_img" id="image6" alt="Not found" width="100" height="100px" alt="">
                 @endif
                   @if ($student_detail->certification)
                   <label for="file-input" class="drop-container" style="display:none">
                  <span class="drop-title"></span>
                  <input type="file" accept="image/*"  name="certification" id="file-input">
                </label>
                 @else
                  <label for="file-input" class="drop-container" >
                  <span class="drop-title"></span>
                  <input type="file" accept="image/*"  name="certification" id="file-input">
                </label>
                 @endif
                </div>

                <div class="col-md-4">
                  <label for="" class="labeltitle"> صورة الطالب</label>
                  @if ($student_detail->personal_image!=null)

                  <img src="{{ asset('storage/'.$student_detail->personal_image) }}"
                      class="del_edit_img rounded-circle" id="image6" alt="Not found" width="100" height="100px" alt="">
                      @else
                      <img src="{{asset('student/notfound.jpg') }}"
                      class="del_edit_img" id="image6" alt="Not found" width="100" height="100px" alt="">
                  @endif
                   @if ($student_detail->personal_image)
                  <label for="file-input" class="drop-container" style="display:none">
                   <span class="drop-title"></span>
                   <input type="file" accept="image/*"  name="personal_image" id="file-input">
                 </label>
                  @else
                   <label for="file-input" class="drop-container">
                   <span class="drop-title"></span>
                   <input type="file" accept="image/*"  name="personal_image" id="file-input">
                 </label>
                  @endif

                 </div>

                 <div class="col-md-4">
                  <label for="" class="labeltitle">  جواز السفر</label>

                  @if ($student_detail->passport!=null)

                  <img src="{{ asset('storage/'.$student_detail->passport) }}" class="del_edit_img"
                      id="image1" alt="Not found" width="100" height="100px"  alt="">
                      @else
                      <img src="{{asset('student/notfound.jpg') }}"
                      class="del_edit_img" id="image6" alt="Not found" width="100" height="100px" alt="">
                  @endif
                   @if ($student_detail->passport)
                    <label for="file-input" class="drop-container" style="display:none">
                   <span class="drop-title"></span>
                   <input type="file" accept="image/*" name="passport" id="file-input">
                 </label>
                  @else
                    <label for="file-input" class="drop-container">
                   <span class="drop-title"></span>
                   <input type="file" accept="image/*" name="passport" id="file-input">
                 </label>
                  @endif

                 </div>
                 <div class="col-md-4">
                  <label for="" class="labeltitle">تحميل إخراج القيد /شهادة الميلاد /</label>
                  @if ($student_detail->fourth_image!=null)

                  <img src="{{ asset('storage/'.$student_detail->fourth_image) }}" class="del_edit_img"
                      id="image1" alt="Not found" width="100" height="100px"  alt="">
                      @else
                      <img src="{{asset('student/notfound.jpg') }}"
                      class="del_edit_img" id="image6" alt="Not found" width="100" height="100px" alt="">

                  @endif
                  @if ($student_detail->fourth_image)
                    <label for="file-input" class="drop-container"  style="display:none">
                   <span class="drop-title"></span>
                   <input  type="file" accept="image/*" name="fourth_image" id="file-input">
                 </label>
                   @else
                   <label for="file-input" class="drop-container">
                   <span class="drop-title"></span>
                   <input  type="file" accept="image/*" name="fourth_image" id="file-input">
                 </label>
                   @endif

                 </div>
                 <div class="col-md-4">
                  <label for="" class="labeltitle">  جواز سفر الأم</label>
                  @if ($student_detail->mother_page!=null)

                            <img src="{{ asset('storage/'.$student_detail->mother_page) }}" class="del_edit_img"
                                id="image1" alt="Not found" width="100" height="100px" alt="">
                                @else
                                <img src="{{asset('student/notfound.jpg') }}"
                                class="del_edit_img" id="image6" alt="Not found" width="100" height="100px" alt="">

                            @endif
                            @if ($student_detail->mother_page)
                    <label for="file-input" class="drop-container" style="display:none">
                   <span class="drop-title"></span>
                   <input  type="file" accept="image/*" name="mother_page" id="file-input">
                 </label>
                  @else
                   <label for="file-input" class="drop-container">
                   <span class="drop-title"></span>
                   <input  type="file" accept="image/*" name="mother_page" id="file-input">
                 </label>
               @endif
                 </div>

                 <div class="col-md-4">
                  <label for="" class="labeltitle">  جواز سفر الأب</label>
                  @if ($student_detail->father_page!=null)

                  <img src="{{ asset('storage/'.$student_detail->father_page) }}" class="del_edit_img"
                      id="image1" alt="Not found" width="100" height="100px" alt="">
                      @else
                      <img src="{{asset('student/notfound.jpg') }}"
                      class="del_edit_img" id="image6" alt="Not found" width="100" height="100px" alt="">

                  @endif
                  @if ($student_detail->father_page)
                  <label for="file-input" class="drop-container" style="display:none">
                   <span class="drop-title"></span>
                   <input  type="file" accept="image/*" name="father_page" id="file-input">
                 </label>
                   @else
                     <label for="file-input" class="drop-container">
                   <span class="drop-title"></span>
                   <input  type="file" accept="image/*" name="father_page" id="file-input">
                 </label>
 @endif
                 </div>
                 <div class="col-md-4">
                  <label for="" class="labeltitle">    هوية الأب</label>
                  @if ($student_detail->father_image!=null)

                  <img src="{{ asset('storage/'.$student_detail->father_image) }}" class="del_edit_img"
                      id="image1" alt="Not found" width="100" height="100px" alt="">
                      @else
                      <img src="{{asset('student/notfound.jpg') }}"
                      class="del_edit_img" id="image6" alt="Not found" width="100" height="100px" alt="">

                  @endif
@if ($student_detail->father_image)
                  <label for="file-input" class="drop-container" style="display:none">
                   <span class="drop-title"></span>
                   <input  type="file" accept="image/*" name="father_image" id="file-input">
                 </label>
                 @else
                  <label for="file-input" class="drop-container">
                   <span class="drop-title"></span>
                   <input  type="file" accept="image/*" name="father_image" id="file-input">
                 </label>
                  @endif
                 </div>

                 <div class="col-md-4">
                  <label for="" class="labeltitle">    هوية الام</label>

                  @if ($student_detail->mother_image!=null)

                  <img src="{{ asset('storage/'.$student_detail->mother_image) }}" class="del_edit_img"
                      id="image1" alt="Not found" width="100" height="100px" alt="">
                      @else
                      <img src="{{asset('student/notfound.jpg') }}"
                      class="del_edit_img" id="image6" alt="Not found" width="100" height="100px" alt="">

                  @endif
                  @if ($student_detail->mother_image)
                  <label for="file-input" class="drop-container" style="display:none">
                   <span class="drop-title"></span>
                   <input type="file" accept="image/*" name="mother_image" id="file-input">
                 </label>
                 @else
                  <label for="file-input" class="drop-container">
                   <span class="drop-title"></span>
                   <input type="file" accept="image/*" name="mother_image" id="file-input">
                 </label>
                 @endif
                 </div>


                 <div class="col-md-4">
                    <label for="" class="labeltitle">دفتر العائلة</label>

                    @if ($student_detail->family_book!=null)

                    <img src="{{ asset('storage/'.$student_detail->family_book) }}" class="del_edit_img"
                        id="image1" alt="Not found" width="100" height="100px" alt="">
                        @else
                        <img src="{{asset('student/notfound.jpg') }}"
                        class="del_edit_img" id="image6" alt="Not found" width="100" height="100px" alt="">

                    @endif
                     @if ($student_detail->family_book)
                    <label for="file-input" class="drop-container" style="display:none">
                     <span class="drop-title"></span>
                     <input  type="file" accept="image/*" name="family_book" id="file-input">
                   </label>
                    @else
                    <label for="file-input" class="drop-container">
                     <span class="drop-title"></span>
                     <input  type="file" accept="image/*" name="family_book" id="file-input">
                   </label>
                   @endif
                   </div>


                   <div class="col-md-4">
                    <label for="" class="labeltitle">التسلسل الدراسي</label>

                    @if ($student_detail->study_sequence!=null)

                    <img src="{{ asset('storage/'.$student_detail->study_sequence) }}" class="del_edit_img"
                        id="image1" alt="Not found" width="100" height="100px" alt="">
                        @else
                        <img src="{{asset('student/notfound.jpg') }}"
                        class="del_edit_img" id="image6" alt="Not found" width="100" height="100px" alt="">

                    @endif
                    @if ($student_detail->study_sequence)
                    <label for="file-input" class="drop-container" style="display:none">
                     <span class="drop-title"></span>
                     <input  type="file" accept="image/*" name="study_sequence" id="file-input">
                   </label>
                   @else
                     <label for="file-input" class="drop-container">
                     <span class="drop-title"></span>
                     <input  type="file" accept="image/*" name="study_sequence" id="file-input">
                   </label>
                    @endif
                   </div>

                   <div class="col-md-4">
                    <label for="" class="labeltitle">شهادة التاسع</label>

                    @if ($student_detail->certification_nine!=null)

                    <img src="{{ asset('storage/'.$student_detail->certification_nine) }}" class="del_edit_img"
                        id="image1" alt="Not found" width="100" height="100px" alt="">
                        @else
                        <img src="{{asset('student/notfound.jpg') }}"
                        class="del_edit_img" id="image6" alt="Not found" width="100" height="100px" alt="">

                    @endif
                    @if ($student_detail->certification_nine)
                    <label for="file-input" class="drop-container" style="display:none">
                     <span class="drop-title"></span>
                     <input  type="file" accept="image/*" name="certification_nine" id="file-input">
                   </label>
                    @else
                     <label for="file-input" class="drop-container">
                     <span class="drop-title"></span>
                     <input  type="file" accept="image/*" name="certification_nine" id="file-input">
                   </label>
                    @endif
                   </div>

              </div>
              <div class="row">
                 <div class="col-md-6">
                  <button type="button" data-toggle="modal" data-target="#demoModal" class="form--submit">
                    طلب تعديل
                  </button>
                 </div>
                 <div class="col-md-6">
                  <button class="form--submit" type="submit">
                    تعديل
                </button>
                 </div>

              </div>

        </form>
      </div>
  </div>

      </div>

    <!--end content-->

</div>

<div class="modal fade auto-off"id="demoModal" tabindex="-1" role="dialog" aria-labelledby="demoModal" aria-hidden="true">
<div class="modal-dialog animated zoomInLeft modal-dialog-centered" role="document">
    <div class="modal-content" style="padding-top: 50px !important;">
        <div class="container-fluid">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: white !important;">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4  style="color: #152C4F;text-align: center;font-size: 25px; ">طلب تعديل</h4>
            <form action="{{route('modification_request')}}" style="text-align: right;direction: rtl;"  method="post" enctype="multipart/form-data"  >
              @csrf
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <div class="py-8">
                    <label for="" class="labeltitle">    رقم الهاتف (whatsApp)</label>
                    <input type="text" hidden name="student_id" value="{{$student->id}}">
                    <input type="number" placeholder="" name="phone" class="form--input"  style="width: 100%;">


                  </div>
                </div><!--end col-->
                <div class="col-md-12">
                  <label for="" class="labeltitle"></label>
                  <textarea name="message" id="" cols="30" rows="10" class="form-control"></textarea>

                </div>
              </div><!--end row-->
              <div class="row" style="justify-content: center;">
                <div class="col-md-5">
                 <!--submit button-->
                 <button type="submit" class="custom-btn btn-10"  style="text-align: center;cursor: pointer;">اضافة</button>
                 <!--end submit button-->
                </div>
              </div>

            </div>

        </form>
      </div>
    </div>
</div>
</div>
</div>


@endsection
@section('js')


@endsection



