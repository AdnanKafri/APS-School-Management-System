@extends('teachers2.layouts.app')
@section('css')
<style>
 @media (min-width: 992px){
        .container, .container-sm, .container-md, .container-lg {
        max-width: 1050px;
        }
    }

/*input*/
/*
=====
HELPERS
=====
*/
.ha-screen-reader{
  width: var(--ha-screen-reader-width, 1px);
  height: var(--ha-screen-reader-height, 1px);
  padding: var(--ha-screen-reader-padding, 0);
  border: var(--ha-screen-reader-border, none);

  position: var(--ha-screen-reader-position, absolute);
  clip: var(--ha-screen-reader-clip, rect(1px, 1px, 1px, 1px));
  overflow: var(--ha-screen-reader-overflow, hidden);
}

/*
=====
RESET STYLES
=====
*/

.field__input{
  --uiFieldPlaceholderColor: var(--fieldPlaceholderColor, #767676);

  background-color: transparent;
  border-radius: 0;
  border: none;

  -webkit-appearance: none;
  -moz-appearance: none;

  font-family: inherit;
  font-size: inherit;
  text-align: right;
}

.field__input:focus::-webkit-input-placeholder{
  color: var(--uiFieldPlaceholderColor);
}

.field__input:focus::-moz-placeholder{
  color: var(--uiFieldPlaceholderColor);
}

/*
=====
CORE STYLES
=====
*/

.field{
  --uiFieldBorderWidth: var(--fieldBorderWidth, 2px);
  --uiFieldPaddingRight: var(--fieldPaddingRight, 1rem);
  --uiFieldPaddingLeft: var(--fieldPaddingLeft, 1rem);
  --uiFieldBorderColorActive: var(--fieldBorderColorActive, rgba(22, 22, 22, 1));

  display: var(--fieldDisplay, inline-flex);
  position: relative;
  font-size: var(--fieldFontSize, 1rem);
  text-align: right;
}

.field__input{
  box-sizing: border-box;
  width: var(--fieldWidth, 100%);
  height: var(--fieldHeight, 3rem);
  padding: var(--fieldPaddingTop, 1.25rem) var(--uiFieldPaddingRight) var(--fieldPaddingBottom, .5rem) var(--uiFieldPaddingLeft);
  border-bottom: var(--uiFieldBorderWidth) solid var(--fieldBorderColor, rgba(0, 0, 0, .25));
}

.field__input:focus{
  outline: none;
}

.field__input::-webkit-input-placeholder{
  opacity: 0;
  transition: opacity .2s ease-out;
}

.field__input::-moz-placeholder{
  opacity: 0;
  transition: opacity .2s ease-out;
}

.field__input:focus::-webkit-input-placeholder{
  opacity: 1;
  transition-delay: .2s;
}

.field__input:focus::-moz-placeholder{
  opacity: 1;
  transition-delay: .2s;
}

.field__label-wrap{
  box-sizing: border-box;
  pointer-events: none;
  cursor: text;

  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
}

.field__label-wrap::after{
  content: "";
  box-sizing: border-box;
  width: 100%;
  height: 0;
  opacity: 0;

  position: absolute;
  bottom: 0;
  left: 0;
}

.field__input:focus ~ .field__label-wrap::after{
  opacity: 1;
}

.field__label{
  position: absolute;
  left: var(--uiFieldPaddingLeft);
  top: calc(50% - .5em);

  line-height: 1;
  font-size: var(--fieldHintFontSize, inherit);

  transition: top .2s cubic-bezier(0.9, -0.15, 0.1, 1.15), opacity .2s ease-out, font-size .2s ease-out;
  will-change: bottom, opacity, font-size;
}

.field__input:focus ~ .field__label-wrap .field__label,
.field__input:not(:placeholder-shown) ~ .field__label-wrap .field__label{
  --fieldHintFontSize: var(--fieldHintFontSizeFocused, .75rem);

  top: var(--fieldHintTopHover, .25rem);
}

/*
effect 1
*/

.field_v1 .field__label-wrap::after{
  border-bottom: var(--uiFieldBorderWidth) solid var(--uiFieldBorderColorActive);
  transition: opacity .2s ease-out;
  will-change: opacity;
}

/*

/*
=====
LEVEL 4. SETTINGS
=====
*/

.field{
  --fieldBorderColor: #9fb0cf;
  --fieldBorderColorActive: #ffb832;
}

/*
=====
DEMO
=====
*/

.tab1cards {
  display: flex;
  flex-direction: row;
  justify-content: center;

}

.grid-container {
  display: grid;
  grid-template-columns: auto auto auto auto;
  grid-gap: 10px;
  background-color: transparent;
  padding: 10px;
  /*margin-left: -50px;*/
  justify-content:center ;
  text-align: center;

}
@media (max-width: 576px) {
  .grid-container {
    padding: 10px 15px 33px 15px;
  }
}
.myDiv{
	display:none;
}
@media only screen and (max-width: 876px), (max-width:991px) {
  .grid-container {
    padding: 10px 15px 33px 15px;
    width: 100%;
  }
}

@media only screen and (max-width: 579px) , (max-width:991px) {
  .grid-container {
    padding: 10px 15px 33px 15px;
    width: 100%;
  }
}


@media only screen and (max-width: 500px) {
      .tab1cards {
        width: calc( 100% - 10px);
      }
    }

    @media only screen and (max-width: 300px) {
      .tab1cards {
        width: 50%;
      }
    }

    .Row {
    display: table;
    width: 100%; /*Optional*/
    table-layout: fixed; /*Optional*/
    border-spacing: 0px; /*Optional*/
}
.Column {

    display: table-cell;
    background-color: transparent;
     /*Optional*/
}
@media only screen and (max-width:480px){
  .Row{
     width: 120%;

  }
  .Column {
    display: inline-block;

  }
}
@media only screen and (max-width:780px){
  .Row{
     width: 100%;

  }
  .Column {
    display: inline-block;

  }
}
@media only screen and (max-width:360px){
  .Row{
     width: 120%;

  }
  .Column {
    display: inline-block;

  }
}
@media only screen and (max-width:579px){
  .Row{
     width: 120%;

  }
  .Column {
    display: inline-block;

  }
}
@media only screen and (max-width:679px){
  .Row{
     width: 120%;

  }
  .Column {
    display: inline-block;

  }
}
@media only screen and (max-width:500px) , (max-width:575px) {
  .Row{
     width: 100%;

  }
  .Column {
    display: inline-block;

  }
}
@media only screen and (max-width:522px){
  .Row{
     width: 100%;

  }
  .Column {
    display: inline-block;

  }
}
@media only screen and (max-width:529px){
  .Row{
     width: 100%;

  }
  .Column {
    display: inline-block;

  }
}
@media only screen and (max-width:547px){
  .Row{
     width: 100%;

  }
  .Column {
    display: inline-block;

  }
}
@media only screen and (max-width:529px) , (max-width:557px  ) , (max-width:596px  ) , (max-width:624px  )
, (max-width:557px  ) , (max-width:579px  ) and (max-width:696px  )
{
  .Row{
     width: 100%;

  }
  .Column {
    display: inline-block;

  }
}
@media only screen and (max-width:635px)
{
  .Row{
     width: 100%;

  }
  .Column {
    display: inline-block;

  }
}
@media only screen and (max-width:682px)
{
  .Row{
     width: 120%;

  }
  .Column {
    display: inline-block;

  }
}
@media only screen and (max-width: 783px ) , (max-width:783px )  , ( max-width: 809px ) , ( max-width: 811px ),
( max-width: 823px ) , ( max-width: 854px ) , ( max-width: 856px )
{

 .Row{
     width: 100%;

  }
  .Column {
    display: inline-block;

  }
}
@media screen  and (max-width:861px) ,  (max-width:882px){

  .Row{
     width: 90%;

  }
  .Column {
    display: inline-block;

  }
}
@media screen  and (max-width:904px){

.Row{
   width: 80%;

}
.Column {
  display: inline-block;

}
}

@media screen  and (max-width:911px){

.Row{
   width: 110%;

}
.Column {
  display: inline-block;

}
}
@media screen  and (max-width:837px) , (max-width:841px) , (max-width:845px) , (max-width:850px), (max-width:869px), (max-width:872px), (max-width:875px),
(max-width:886px), (max-width:909px){

.Row{
   width: 80%;

}
.Column {
  display: inline-block;

}
}
@media screen and (max-width:918px), (max-width:921px), (max-width:929px), (max-width:949px), (max-width:960px),
(max-width:974px) , (max-width:982px), (max-width:986px), (max-width:991px){
  .Row{
   width: 110%;

}
.Column {
  display: inline-block;

}
}
@media screen and (max-width:994px) , (max-width:1000px),(max-width:1008px), (max-width:1016px), (max-width:1022px),
(max-width:1032px) , (max-width:1044px), (max-width:1054px){
  .Row{
   width: 105%;

}
.Column {
  display: inline-block;

}
}

@media screen and  (max-width:846px) , (max-width:580px),   (max-width:853px),  (max-width:861px),  (max-width:871px) , (max-width:873px) ,
(max-width:875px) , (max-width:878px) ,(max-width:881px),
(max-width:885px) , (max-width:881px), (max-width:888px),(max-width:900px),(max-width:999px){
  .Row{
   width: 80%;

}
.Column {
  display: inline-block;

}
}

@media screen and (max-width:960px) ,(max-width:964px) , (max-width:966px) , (max-width:971px), (max-width:983px), (max-width:984px),
(max-width:990px){
  .Row{
   width: 110%;

}
.Column {
  display: inline-block;

}

}
/*style table*/
table {
  direction: rtl;
    border: 2px solid black;
}
th {
    border: 2px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
td {
    border: 1px solid black;
    padding: 5px;
}
/*end table */


.search {
  box-shadow: 0 20px 10px -10px rgba(200, 200, 200, 0.5);
  display: inline-block;
}
.search__input {
  background-color: #84a7c4;
  border: 0;

  outline: 0;
  line-height: 50px;
  font-size: 14px;
  padding: 0 18px;
  float: right;
  color: white;
}
::placeholder {
  color: white;
  opacity: 1; /* Firefox */
}
.search__button {
  box-shadow: -10px 0 10px -5px rgba(90, 117, 238, 0.5);
  color: white;
  background-color: #094e89;
  width: 50px;
  line-height: 50px;
  text-align: center;
  border: 0;

  padding: 0;
  cursor: pointer;
  outline: 0;
  transition: box-shadow 0.3s ease-out;
}
.search__button:active {
  box-shadow: -10px 0 10px -10px rgba(90, 238, 209, 0.5);
}
/*select and option */
:root {
  --background-gradient: linear-gradient(to right top, #f38639  20%, rgb(132, 167, 196))
  --gray: #f38639 ;
  --darkgray: #2c71ad;
}

select {
  /* Reset Select */
  appearance: none;
  outline: 0;
  border: 0;
  box-shadow: #f38639;
  /* Personalize */
  flex: 1;
  padding: 0 1em;
  color: white;
  background-color: var(--darkgray);
  background-image: none;
  cursor: pointer;
  text-align: center;



}
/* Remove IE arrow */
select::-ms-expand {
  display: none;

}
/* Custom Select wrapper */
.select {
  position: relative;
  display: flex;
  width: 12em;
  height: 3em;
  border-radius: .25em;
  overflow: hidden;
  color: #f38639 ;
}
/* Arrow */
.select::after {
  content: '\25BC';
  position: absolute;
  top: 0;
  right: 0;
  padding: 1em;
  background-color: #2c71ad ;
  transition: .25s all ease;
  pointer-events: none;

}
/* Transition */
.select:hover::after {
  color: #f38639;
}
.vertical {
            border-left: 1px solid rgb(110, 110, 110);
            height: 99px;
            position:absolute;

        }


	 </style>

@endsection
@section('content')


<div class="main-panel" style="background: #f8f9fb;">
     <ul class="breadcrumbs" style="padding-bottom: 7px;
        padding-top: 11px;">
            <li class="li"><a href="{{ route('dashboard.teacher') }}">الصفحة الرئيسية</a></li>
            <li class="li"><a href="{{ route('teacher.mark_class') }}">دفتر العلامات </a></li>
            <li class="li"><a
                    href="{{ route('teacher.mark_room', ['room_id' => $room_id, 'teacher_id' => $teacher->id]) }}">علامات
                    المواد</a></li>
            <li class="li"><a href="#">دفتر العلامات</a></li>
        </ul>

	 @php
function arabic_w2e($str)
{
    $arabic_eastern = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $arabic_western = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    return str_replace($arabic_western, $arabic_eastern, $str);
}

@endphp

<div class="content-wrapper pb-0">
    <div class="container mt-5" style="direction: rtl;">

<div class="row" style="justify-content: right">
    <div class="col-md-2">
        <input class="button" type="button" onclick="tablesToExcel(array1, 'myfile.xls')" value="تنزيل ملف اكسل">
    </div>
</div>


<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">

<table id="1" class="table table-striped">
    <tr>
    <td>
        <table class="table table-striped">
        <thead style="text-align: center;" >
            <tr>
                  <th rowspan="2"   style="text-align: center;" >الرقم </th>
                <th rowspan="2"    style="text-align: center;" >الاسم والشهرة </th>
                <th rowspan="1" colspan="4" style="text-align: center;">اعمال الطالب </th>
                <th rowspan="1"  colspan="1"  style="text-align: center;">درجة الأعمال </th>
                <th rowspan="1"  colspan="1"  style="text-align: center;">درجة الامتحان </th>
                <th rowspan="1"  colspan="1"  style="text-align: center;" > المجموع </th>
                <th rowspan="2"  colspan="1"  style="text-align: center;" > المحصلة الأولى </th>


            </tr>
            <tr>


             <th rowspan="1" colspan="1"  style="text-align: center;">شفهي <br> <span style="color: #f38639;">%١٠</span>  </th>
              <th rowspan="1" colspan="1" style="text-align: center;"> وظائف   <br> <span style="color: #f38639;">%١٠</span> </th>
              <th rowspan="1" colspan="1" style="text-align: center;">نشاطات   <br> <span style="color: #f38639;">%٢٠</span></th>
              <th rowspan="1" colspan="1" style="text-align: center;"> المذاكرات  <br> <span style="color: #f38639;">%٢٠</span></th>
               <th rowspan="1" colspan="1" style="text-align: center;"><span style="color: #f38639;">%٦٠</span></th>
              <th rowspan="1" colspan="1" style="text-align: center;"><span style="color: #f38639;">%٤٠</span></th>
              <th rowspan="1" colspan="1" style="text-align:center;"><span style="color: #f38639;">%١٠٠</span> </th>
            </tr>


        </thead>
        <tbody style="text-align: center;     " >
            @foreach (  $students->student as $item  )

            <tr>
           <td> {{arabic_w2e( $item->id) }}  </td>
                <td> {{ $item->first_name }} {{ $item->last_name }} </td>

                  @foreach ($item->student_mark as $item2)

                  <td>  @foreach( json_decode($item2->mark,true) as $key=>$item)
                    @if($key == $lesson_id && $item['oral'] !="null" )
                    @if(json_decode($item2->mark,true)[$lesson_id]['oral'] !=null)
                    {{arabic_w2e( json_decode($item2->mark,true)[$lesson_id]['oral'])}}

                    @endif
                    @break

                    @endif

                    @endforeach
                    </td>

                          <td>

                            @foreach( json_decode($item2->mark,true) as $key=>$item)
                            @if($key == $lesson_id && $item['homework'] !="null" )
                            @if(json_decode($item2->mark,true)[$lesson_id]['homework'] !=null)
                            {{arabic_w2e( json_decode($item2->mark,true)[$lesson_id]['homework'])}}

                            @endif
                            @break

                            @endif

                            @endforeach




                             <td>
                              @foreach( json_decode($item2->mark,true) as $key=>$item)
                              @if($key == $lesson_id && $item['activities'] !="null" )
                              @if(json_decode($item2->mark,true)[$lesson_id]['activities'] !=null)
                              {{arabic_w2e( json_decode($item2->mark,true)[$lesson_id]['activities'])}}

                              @endif
                              @break

                              @endif

                              @endforeach

                             </td>
                            <td>
                              @foreach( json_decode($item2->mark,true) as $key=>$item)
                              @if($key == $lesson_id && $item['quize'] !="null" )
                              @if(json_decode($item2->mark,true)[$lesson_id]['quize'] !=null)
                              {{arabic_w2e( json_decode($item2->mark,true)[$lesson_id]['quize'])}}

                              @endif
                              @break

                              @endif

                              @endforeach
                             </td>
                  <td>
                      @if($item2->worke_degree)
                  @foreach( json_decode($item2->worke_degree,true) as $key=>$item)
                  @if($key == $lesson_id  && $item['term1_result'] !="null")
                    {{arabic_w2e($item['term1_result'])}}
                        @break

                @endif

                 @endforeach
                    @endif
                    </td>
                    <td>
                      @foreach( json_decode($item2->mark,true) as $key=>$item)
                      @if($key == $lesson_id && $item['exam'] !="null" )
                      @if(json_decode($item2->mark,true)[$lesson_id]['exam'] !=null)
                      {{arabic_w2e( json_decode($item2->mark,true)[$lesson_id]['exam'])}}

                      @endif
                      @break

                      @endif

                      @endforeach
                     </td>
                     <td>
                      @if($item2->result1)
                      @foreach( json_decode($item2->result1,true) as $key=>$item)
                      @if($key == $lesson_id && $item['term1_result'] !="null" )
                      @if(json_decode($item2->result1,true)[$lesson_id]['term1_result'] >=$lesson->min_mark)
                      <span>
                          {{ arabic_w2e(json_decode($item2->result1,true)[$lesson_id]['term1_result'] )}}</span>
                      @else
                      <span style="color: red;
               text-decoration: underline;">
                          {{ arabic_w2e(json_decode($item2->result1,true)[$lesson_id]['term1_result'] )}}</span>
                      @endif
                      @break

                      @endif

                      @endforeach
                      @endif
                  </td>
                  <td>
                    @if($item2->result1)
                    @foreach( json_decode($item2->result1,true) as $key=>$item)
                    @if($key == $lesson_id && $item['term1_result'] !="null" )
                    @if(json_decode($item2->result1,true)[$lesson_id]['term1_result'] >=$lesson->min_mark)
                    <span>
                        {{ arabic_w2e(json_decode($item2->result1,true)[$lesson_id]['term1_result'] )}}</span>
                    @else
                    <span style="color: red;
             text-decoration: underline;">
                        {{ arabic_w2e(json_decode($item2->result1,true)[$lesson_id]['term1_result'] )}}</span>
                    @endif
                    @break

                    @endif

                    @endforeach
                    @endif
                </td>


                 @endforeach
            </tr>

          @endforeach



        </tbody>

      </table>
      </td>

   <td>
 <table  >
          <thead style="text-align: center;" >
              <tr style="text-align: center;"  >
              <th rowspan="2"   style="text-align: center;" >الرقم </th>
                <th rowspan="2"    style="text-align: center;" >الاسم والشهرة </th>
                <th rowspan="1" colspan="4" style="text-align: center;">اعمال الطالب </th>
                <th rowspan="1"  colspan="1"  style="text-align: center;">درجة الأعمال </th>
                <th rowspan="1"  colspan="1"  style="text-align: center;">درجة الامتحان </th>
                <th rowspan="1"  colspan="1"  style="text-align: center;" > المجموع </th>
                <th rowspan="2"  colspan="1"  style="text-align: center;" > المحصلة الثانية </th>
                <th rowspan="2" colspan="1" style="text-align: center;"> مجموع المحصلتين <span style="color:white;"> &#247</span> ٢ </th>
                 <th rowspan="2" colspan="1" style="text-align: center;"> ملاحظات </th>

              </tr>
              <tr>

             <th rowspan="1" colspan="1"  style="text-align: center;">شفهي <br> <span style="color: #f38639;">%١٠</span>  </th>
              <th rowspan="1" colspan="1" style="text-align: center;"> وظائف   <br> <span style="color: #f38639;">%١٠</span> </th>
              <th rowspan="1" colspan="1" style="text-align: center;">نشاطات   <br> <span style="color: #f38639;">%٢٠</span></th>
              <th rowspan="1" colspan="1" style="text-align: center;"> المذاكرات  <br> <span style="color: #f38639;">%٢٠</span></th>
               <th rowspan="1" colspan="1" style="text-align: center;"><span style="color: #f38639;">%٦٠</span></th>
              <th rowspan="1" colspan="1" style="text-align: center;"><span style="color: #f38639;">%٤٠</span></th>
              <th rowspan="1" colspan="1" style="text-align:center;"><span style="color: #f38639;">%١٠٠</span> </th>

              </tr>
          </thead>
          <tbody style="text-align: center;"  >
             @foreach (  $students->student as $item  )

            <tr>
             <td> {{arabic_w2e( $item->id) }}  </td>
                <td> {{ $item->first_name }} {{ $item->last_name }} </td>

                 @foreach ($item->student_mark as $item2)
                 <td>  @foreach( json_decode($item2->mark2,true) as $key=>$item)
                  @if($key == $lesson_id && $item['oral'] !="null" )
                  @if(json_decode($item2->mark2,true)[$lesson_id]['oral'] !=null)
                  {{arabic_w2e( json_decode($item2->mark2,true)[$lesson_id]['oral'])}}

                  @endif
                  @break

                  @endif

                  @endforeach
                  </td>

                        <td>

                          @foreach( json_decode($item2->mark2,true) as $key=>$item)
                          @if($key == $lesson_id && $item['homework'] !="null" )
                          @if(json_decode($item2->mark2,true)[$lesson_id]['homework'] !=null)
                          {{arabic_w2e( json_decode($item2->mark2,true)[$lesson_id]['homework'])}}

                          @endif
                          @break

                          @endif

                          @endforeach
                        </td>




                           <td>
                            @foreach( json_decode($item2->mark2,true) as $key=>$item)
                            @if($key == $lesson_id && $item['activities'] !="null" )
                            @if(json_decode($item2->mark2,true)[$lesson_id]['activities'] !=null)
                            {{arabic_w2e( json_decode($item2->mark2,true)[$lesson_id]['activities'])}}

                            @endif
                            @break

                            @endif

                            @endforeach

                           </td>
                          <td>
                            @foreach( json_decode($item2->mark2,true) as $key=>$item)
                            @if($key == $lesson_id && $item['quize'] !="null" )
                            @if(json_decode($item2->mark2,true)[$lesson_id]['quize'] !=null)
                            {{arabic_w2e( json_decode($item2->mark2,true)[$lesson_id]['quize'])}}

                            @endif
                            @break

                            @endif

                            @endforeach
                           </td>
                    <td>
                      @if($item2->worke_degree)
                  @foreach( json_decode($item2->worke_degree,true) as $key=>$item)
                  @if($key == $lesson_id && $item['term2_result'] !="null" )
                    {{arabic_w2e($item['term2_result'])}}
                        @break

                @endif

                 @endforeach
                    @endif
                    </td>
                    <td>
                      @foreach( json_decode($item2->mark2,true) as $key=>$item)
                      @if($key == $lesson_id && $item['exam'] !="null" )
                      @if(json_decode($item2->mark2,true)[$lesson_id]['exam'] !=null)
                      {{arabic_w2e( json_decode($item2->mark2,true)[$lesson_id]['exam'])}}

                      @endif
                      @break

                      @endif

                      @endforeach
                     </td>



      <td>
        @foreach( json_decode($item2->result2,true) as $key=>$item)
        @if($key == $lesson_id && $item['term2_result'] !="null" )
        @if(json_decode($item2->result2,true)[$lesson_id]['term2_result'] >=$lesson->min_mark)
        <span>
            {{ arabic_w2e(json_decode($item2->result2,true)[$lesson_id]['term2_result'] )}}</span>
        @else
        <span style="color: red;
 text-decoration: underline;">
            {{ arabic_w2e(json_decode($item2->result2,true)[$lesson_id]['term2_result'] )}}</span>
        @endif
        @break

        @endif

        @endforeach
        </td>
        <td>
          @foreach( json_decode($item2->result2,true) as $key=>$item)
          @if($key == $lesson_id && $item['term2_result'] !="null" )
          @if(json_decode($item2->result2,true)[$lesson_id]['term2_result'] >=$lesson->min_mark)
          <span>
              {{ arabic_w2e(json_decode($item2->result2,true)[$lesson_id]['term2_result'] )}}</span>
          @else
          <span style="color: red;
   text-decoration: underline;">
              {{ arabic_w2e(json_decode($item2->result2,true)[$lesson_id]['term2_result'] )}}</span>
          @endif
          @break

          @endif

          @endforeach
          </td>




      <td>
          @if($item2->result)
          @foreach( json_decode($item2->result,true) as $key=>$item)
          @if($key == $lesson_id && $item['year_result'] !="null" )
          @if(ceil(json_decode($item2->result,true)[$lesson_id]['year_result']
          /2)>=$lesson->min_mark)
          {{     arabic_w2e(ceil(json_decode($item2->result,true)[$lesson_id]['year_result'] /2)) }}
          @else
          <span style="color: red;
              text-decoration: underline;">
              {{     arabic_w2e(ceil(json_decode($item2->result,true)[$lesson_id]['year_result'] /2)) }}
          </span>
          @endif
          @break

          @endif

          @endforeach
          @endif
      </td>
      <td>

                      @if($item2->notes)
                  @foreach( json_decode($item2->notes,true) as $key=>$item)
                  @if($key == $lesson_id   )
                    {{$item}}
                        @break

                @endif

                 @endforeach
                    @endif

                    </td>


             @endforeach
              </tr>


   @endforeach





          </tbody>
        </table>
        </td>
   </tr>
</table>
</div>
</div>
</div>
</div>
</div>



</div>
</div>
</div>


		<!-- loader -->

@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.min.js>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
$(document).on('keyup', '.number', function () {

    if($(this).val()>$(this).data('max')){
        alert('لايمكن وضع القيمة');
        $(this).val("");
    }


})
</script>

<script type="text/javascript">


    var array1 = new Array();

   var n = 1; //Total table
   for ( var x=1; x<=n; x++ ) {
       array1[x-1] = x;

   }

   var tablesToExcel = (function () {
       var uri = 'data:application/vnd.ms-excel;base64,'
       , template = '<html xmlns.o="urn.schemas-microsoft-com.office.office" xmlns.x="urn.schemas-microsoft-com.office.excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x.ExcelWorkbook><x.ExcelWorksheets>'
       , templateend = '</x.ExcelWorksheets></x.ExcelWorkbook></xml><![endif]--></head>'
       , body = '<body>'
       , tablevar = '<table>{table'
       , tablevarend = '}</table>'
       , bodyend = '</body></html>'
       , worksheet = '<x.ExcelWorksheet><x.Name>'
       , worksheetend = '</x.Name><x.WorksheetOptions><x.DisplayGridlines/></x.WorksheetOptions></x.ExcelWorksheet>'
       , worksheetvar = '{worksheet'
       , worksheetvarend = '}'
       , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
       , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
       , wstemplate = ''
       , tabletemplate = '';

       return function (table, name, filename) {
           var tables = table;

           for (var i = 0; i < tables.length; ++i) {
               wstemplate += worksheet + worksheetvar + i + worksheetvarend + worksheetend;
               tabletemplate += tablevar + i + tablevarend;
           }

           var allTemplate = template + wstemplate + templateend;
           var allWorksheet = body + tabletemplate + bodyend;
           var allOfIt = allTemplate + allWorksheet;

           var ctx = {};
           for (var j = 0; j < tables.length; ++j) {
               ctx['worksheet' + j] = name[j];
           }

           for (var k = 0; k < tables.length; ++k) {
               var exceltable;
               if (!tables[k].nodeType) exceltable = document.getElementById(tables[k]);
               ctx['table' + k] = exceltable.innerHTML;
           }

           //document.getElementById("dlink").href = uri + base64(format(template, ctx));
           //document.getElementById("dlink").download = filename;
           //document.getElementById("dlink").click();

           window.location.href = uri + base64(format(allOfIt, ctx));

       }
   })();


</script>


@endsection
