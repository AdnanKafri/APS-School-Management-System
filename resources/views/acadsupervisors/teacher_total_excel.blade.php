@extends('acadsupervisors.master')
@section('css')

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.min.js>"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <style>
 @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:600&display=swap');
  .cart-count
{
  display: flex;
  position: relative;
  align-items:center;
  justify-content:center;
  min-width:1.3rem;
  height:1.3rem;
  border-radius:50%;
  font-weight:700;
  font-size:0.7rem;
  line-height:1;
  
  margin-left:20px;
  margin-top:-40px;
  color:#f38639;
  background: linear-gradient(to right top, #2c71ad 20%, #84a7c4);
}
input[type="checkbox"] {
  
  text-align: right;
  position: relative;
  width: 1.1em;
  height: 1.1em;
  color: #094e89;
  border: 1px solid #094e89;
  border-radius: 4px;
  appearance: none;
  outline: 0;
  cursor: pointer;
  transition: background 175ms cubic-bezier(0.1, 0.1, 0.25, 1);
}
input[type="checkbox"]::before {
  position: absolute;
  content: '';
  display: block;
  top: 2px;
  right: 7px;
  width: 4px;
  height: 10px;
  border-style: solid;
  border-color: #fff;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
  opacity: 0;
}
input[type="checkbox"]:checked {
  color: #fff;
  border-color: #ffb832;
  background: #ffb832;
}
input[type="checkbox"]:checked::before {
  opacity: 1;
}
input[type="checkbox"]:checked ~ label::before {
  clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
}
label {
  color: #0b273f;
  position: relative;
  cursor: pointer;
  font-size: 1.1em;
  font-weight: 400;
  padding: 0 0.25em 0;
  user-select: none;
}
label::before {
  position: absolute;
  content: attr(data-content);
  color: #9c9e9f;
  clip-path: polygon(0 0, 0 0, 0% 100%, 0 100%);
  text-decoration: line-through;
  text-decoration-thickness: 3px;
  text-decoration-color: #363839;
  transition: clip-path 200ms cubic-bezier(0.25, 0.46, 0.45, 0.94);
}


   /*end checkbox*/
   /*cards*/

.data-card {
  display: flex;
  flex-direction: column;
  max-width: 55.75em;
  
  min-height: auto;
  overflow: hidden;
  border-radius: 0.5em;
  text-decoration: none;
  background: white;
  margin: 1em;
  padding: 2.75em 5.5em;
  text-align: right;
  box-shadow: 0 1.8em 2.7em -0.7em rgba(0, 0, 0, 0.3);
  transition: transform 0.45s ease, background 0.45s ease;
}
@media (max-width: 992px) {
  .data-card {
    padding: 177px 90px 33px 85px;
  }

 

  .data-card {
    width: 50%;
  }
}

@media (max-width: 768px)  {
  .data-card {
    padding: 100px 80px 33px 80px;
  }

  .data-card {
    width: 100%;
  }
}

@media only screen and (max-width: 868px)  {
  .data-card {
    padding: 100px 80px 33px 80px;
  }

  .data-card {
    width: 100%;
  }
}
@media only screen and (max-width: 968px)  {
  .data-card {
    padding: 100px 80px 33px 80px;
  }

  .data-card {
    width: 100%;
  }
}
@media only screen and (max-width: 985px)  {
  .data-card {
    padding: 100px 80px 33px 80px;
  }

  .data-card {
    width: 100%;
  }
}
@media only screen and (max-width: 988px)  {
  .data-card {
    padding: 100px 80px 33px 80px;
  }

  .data-card {
    width: 100%;
  }
}

@media (max-width: 772px) , (max-width:991px) , (max-width:992px){
  .data-card {
    padding: 100px 80px 33px 80px;
  }
  .data-card {
    width: 100%;
  }
}

@media (max-width: 576px) {
  .data-card {
    padding: 10px 15px 33px 15px;
  }
}

.data-card h3 {
  color: #2E3C40;
  font-size: 3.5em;
  font-weight: 600;
  line-height: 1;
  padding-bottom: 0.5em;
  margin: 0 0 0.142857143em;
  border-bottom: 2px solid #753BBD;
  transition: color 0.45s ease, border 0.45s ease;
}
.data-card h4 {
  color: #627084;
  text-transform: uppercase;
  font-size: 1.125em;
  font-weight: 700;
  line-height: 1;
  letter-spacing: 0.1em;
  margin: 0 0 1.777777778em;
  transition: color 0.45s ease;
}
.data-card p {
  opacity: 0;
  color: #FFFFFF;
  font-weight: 600;
  line-height: 1.8;
  margin: 0 0 1.25em;
  transform: translateY(-1em);
  transition: opacity 0.45s ease, transform 0.5s ease;
}
.data-card .link-text {
  display: block;
  color: #753BBD;
  font-size: 1.125em;
  font-weight: 600;
  line-height: 1.2;
  margin: auto 0 0;
  transition: color 0.45s ease;
}
.data-card .link-text svg {
  margin-left: 0.5em;
  transition: transform 0.6s ease;
}
.data-card .link-text svg path {
  transition: fill 0.45s ease;
}
.data-card:hover {
  background: #FFFFFF;
  transform: scale(1.02);
}
.data-card:hover h3 {
  color: #FFFFFF;
  border-bottom-color: #A754C4;
}
.data-card:hover h4 {
  color: #FFFFFF;
}
.data-card:hover p {
  opacity: 1;
  transform: none;
}
.data-card:hover .link-text {
  color: #FFFFFF;
}
.data-card:hover .link-text svg {
  animation: point 1.25s infinite alternate;
}
.data-card:hover .link-text svg path {
  fill: #FFFFFF;
}
@keyframes point {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(0.125em);
  }
}


/*end cards*/

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

<section class="hero-wrap hero-wrap-2" style="background-image: url( {{  asset('teachers/ppp.jpg') }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2">
                        <!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
                        <h1 class="mb-0 bread">دفتر العلامات 
            </div>
        </div>
    </div>
</section>

<!-- start new-->


<br>
<br>


<br>
<br>
<!--- tablist for total marks -->
<!-- marks of subjects -->

 <input class="btn btn-primary " type="button" onclick="tablesToExcel(array1, 'myfile.xls')" value="تنزيل ملف اكسل" style="margin:0 auto; width: 200px; height:40px;margin-top: 100px;
    background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));">
  @php
                     function arabic_w2e($str)
{
    $arabic_eastern = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $arabic_western = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    return str_replace($arabic_western, $arabic_eastern, $str);
}

                     @endphp
  

  
  <table id="1">
   <tr>
    <td>  <table >
        <thead>
            <tr>
                <th rowspan="2"    style="text-align: center;" >الطلاب </th>
                <th rowspan="2"   style="text-align: center;" >الدرجة العظمى </th>
                <th rowspan="1" colspan="4" style="text-align: center;">درجات اعمال الفصل الأول </th>
                <th rowspan="1"  colspan="1"  style="text-align: center;">درجة اختبار الفصل الأول </th>
                <th rowspan="1"  colspan="1"  style="text-align: center;">مجموع درجات الفصل الأول </th>
                <th rowspan="2"  colspan="1"  style="text-align: center;" > تقدير الفصل الأول </th>
              
               
            </tr>
            <tr>
             
                <th rowspan="1" colspan="1"  style="text-align: center;">شفوية <br> <span style="color: #f38639;">%١٠</span>  </th>
              <th rowspan="1" colspan="1" style="text-align: center;"> وظائف و اوراق عمل  <br> <span style="color: #f38639;">%١٠</span> </th>
              <th rowspan="1" colspan="1" style="text-align: center;"> نشاطات  و مبادرات <br> <span style="color: #f38639;">%٢٠</span></th>
              <th rowspan="1" colspan="1" style="text-align: center;"> المذاكرات  <br> <span style="color: #f38639;">%٢٠</span></th>
              <th rowspan="1" colspan="1" style="text-align: center;"><span style="color: #f38639;">%٤٠</span></th>
              <th rowspan="1" colspan="1" style="text-align:center;"><span style="color: #f38639;">%١٠٠</span> </th>
            </tr>


        </thead>
        <tbody>
            @foreach (  $students as $item  )
        
            <tr>
          
                <td> {{ $item->first_name }} {{ $item->last_name }} </td>
             <td>{{arabic_w2e($lesson->max_mark)}} </td>
                  @foreach ($item->student_mark as $item2)

               <td>{{arabic_w2e( json_decode($item2->mark,true)[$lesson_id]['oral'])}}</td>

                      <td>{{arabic_w2e( json_decode($item2->mark,true)[$lesson_id]['homework'])}}</td>
                         <td>{{ arabic_w2e(json_decode($item2->mark,true)[$lesson_id]['activities'])}}</td>
                        <td>{{arabic_w2e( json_decode($item2->mark,true)[$lesson_id]['quize'])}}</td>
                           <td>{{arabic_w2e( json_decode($item2->mark,true)[$lesson_id]['exam'])}}</td>

                       @if(json_decode($item2->result1,true)[$lesson_id]['term1_result'] >$lesson->min_mark)
                <td> {{arabic_w2e( json_decode($item2->result1,true)[$lesson_id]['term1_result']) }} </td>
                @else
                 <td style="color: red;
               text-decoration: underline;"> {{ arabic_w2e(json_decode($item2->result1,true)[$lesson_id]['term1_result']) }} </td>
                @endif
                <td>
                  @if($item2->estimation1)
                  @foreach( json_decode($item2->estimation1,true) as $key=>$item)
                  @if($key == $lesson_id )
                    {{$item}}
                        @break
               
                @endif
              
                 @endforeach
                 
                    @endif
                    </td>
              
              
                </td>
                 @endforeach
            </tr>
      
          @endforeach


        </tbody>
      </table>
      </td>

   <td>  <table style="text-align: center;" >
          <thead style="text-align: center;" >
              <tr style="text-align: center;"  >
                <th rowspan="2" colspan="1" style="text-align: center;">الطلاب </th>
                <th rowspan="2" colspan="1" style="text-align: center;"> الدرجة العظمى </th>
                  <th rowspan="1" colspan="4" style="text-align: center;"> درجة اعمال الفصل الثاني </th>
                  <th rowspan="1" colspan="1" style="text-align: center;" >درجة اختبار الفصل الثاني </th>
                  <th rowspan="1" colspan="1" style="text-align: center;" >مجموع درجات الفصل الثاني </th>
                  <th rowspan="2" colspan="1" style="text-align: center;" >تقدير الفصل الثاني  </th>
                  <th rowspan="2" colspan="1" style="text-align: center;" >مجموع درجات الفصلين</th>
                  <th rowspan="2" colspan="1" style="text-align: center;"  > متوسط درجات الفصلين </th>
                  <th rowspan="2" colspan="1" style="text-align: center;"  >  التقدير النهائي </th>
         
              </tr>
              <tr>
           <th rowspan="1" colspan="1"  style="text-align: center;">شفوية <br> <span style="color: #f38639;">%١٠</span>  </th>
              <th rowspan="1" colspan="1" style="text-align: center;"> وظائف و اوراق عمل  <br> <span style="color: #f38639;">%١٠</span> </th>
              <th rowspan="1" colspan="1" style="text-align: center;"> نشاطات  و مبادرات <br> <span style="color: #f38639;">%٢٠</span></th>
              <th rowspan="1" colspan="1" style="text-align: center;"> المذاكرات  <br> <span style="color: #f38639;">%٢٠</span></th>
              <th rowspan="1" colspan="1" style="text-align: center;"><span style="color: #f38639;">%٤٠</span></th>
              <th rowspan="1" colspan="1" style="text-align:center;"><span style="color: #f38639;">%١٠٠</span> </th>

              </tr>
          </thead>
          <tbody style="text-align: center;"  >
             @foreach (  $students as $item  )

   <tr>
            
                <td> {{ $item->first_name }} {{ $item->last_name }} </td>
                <td>{{arabic_w2e($lesson->max_mark)	}} </td>
                 @foreach ($item->student_mark as $item2)
                 <td>
              
                   {{ arabic_w2e( json_decode($item2->mark2,true)[$lesson_id]['oral'])}}
                    </td>
                    <td>
              
                   {{arabic_w2e( json_decode($item2->mark2,true)[$lesson_id]['homework'])}}
                    </td>
                    <td>
              
                   {{arabic_w2e( json_decode($item2->mark2,true)[$lesson_id]['activities'])}}
                    </td>
                     <td>
              
                   {{arabic_w2e( json_decode($item2->mark2,true)[$lesson_id]['quize'])}}
                    </td>
                    <td>
              
                   {{arabic_w2e( json_decode($item2->mark2,true)[$lesson_id]['exam'])}}
                    </td>
               
               
                  @if(json_decode($item2->result2,true)[$lesson_id]['term2_result'] >$lesson->min_mark)
                <td> {{ arabic_w2e(json_decode($item2->result2,true)[$lesson_id]['term2_result'] )}}</td>
                @else
                 <td style="color: red;
               text-decoration: underline;"> {{ arabic_w2e( json_decode($item2->result2,true)[$lesson_id]['term2_result']) }} </td>
                @endif
              
                 <td>
                  @if($item2->estimation2)
                  @foreach( json_decode($item2->estimation2,true) as $key=>$item)
                  @if($key == $lesson_id )
                    {{$item}}
                        @break
               
                @endif
              
                 @endforeach
                 
                    @endif
                    </td>
                <td>{{arabic_w2e( json_decode($item2->result,true)[$lesson_id]['year_result']) }}</td>
                @if(ceil(json_decode($item2->result,true)[$lesson_id]['year_result'] /2)>$lesson->min_mark)
                  <td>{{arabic_w2e( ceil(json_decode($item2->result,true)[$lesson_id]['year_result'] /2) )}}</td>
                    @else
                 <td style="color: red;
               text-decoration: underline;"> {{arabic_w2e( ceil(json_decode($item2->result,true)[$lesson_id]['year_result'] /2) )}} </td>
                @endif
                  <td>
                  @if($item2->estimation)
                  @foreach( json_decode($item2->estimation,true) as $key=>$item)
                  @if($key == $lesson_id )
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
        </table></td>
   </tr>
</table>
	
		<!-- loader -->
		<div id="ftco-loader" class="show fullscreen">
			<svg class="circular" width="48px" height="48px">
				<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/> 
				<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/>
			</svg>
		</div>
@endsection
@section('js')
 
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
   
<script>
  (function() {
var Util,
__bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

Util = (function() {
function Util() {}

Util.prototype.extend = function(custom, defaults) {
var key, value;
for (key in custom) {
  value = custom[key];
  if (value != null) {
    defaults[key] = value;
  }
}
return defaults;
};

Util.prototype.isMobile = function(agent) {
return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(agent);
};

return Util;

})();

this.WOW = (function() {
WOW.prototype.defaults = {
boxClass: 'wow',
animateClass: 'animated',
offset: 0,
mobile: true
};

function WOW(options) {
if (options == null) {
  options = {};
}
this.scrollCallback = __bind(this.scrollCallback, this);
this.scrollHandler = __bind(this.scrollHandler, this);
this.start = __bind(this.start, this);
this.scrolled = true;
this.config = this.util().extend(options, this.defaults);
}

WOW.prototype.init = function() {
var _ref;
this.element = window.document.documentElement;
if ((_ref = document.readyState) === "interactive" || _ref === "complete") {
  return this.start();
} else {
  return document.addEventListener('DOMContentLoaded', this.start);
}
};

WOW.prototype.start = function() {
var box, _i, _len, _ref;
this.boxes = this.element.getElementsByClassName(this.config.boxClass);
if (this.boxes.length) {
  if (this.disabled()) {
    return this.resetStyle();
  } else {
    _ref = this.boxes;
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      box = _ref[_i];
      this.applyStyle(box, true);
    }
    window.addEventListener('scroll', this.scrollHandler, false);
    window.addEventListener('resize', this.scrollHandler, false);
    return this.interval = setInterval(this.scrollCallback, 50);
  }
}
};

WOW.prototype.stop = function() {
window.removeEventListener('scroll', this.scrollHandler, false);
window.removeEventListener('resize', this.scrollHandler, false);
if (this.interval != null) {
  return clearInterval(this.interval);
}
};

WOW.prototype.show = function(box) {
this.applyStyle(box);
return box.className = "" + box.className + " " + this.config.animateClass;
};

WOW.prototype.applyStyle = function(box, hidden) {
var delay, duration, iteration;
duration = box.getAttribute('data-wow-duration');
delay = box.getAttribute('data-wow-delay');
iteration = box.getAttribute('data-wow-iteration');
return box.setAttribute('style', this.customStyle(hidden, duration, delay, iteration));
};

WOW.prototype.resetStyle = function() {
var box, _i, _len, _ref, _results;
_ref = this.boxes;
_results = [];
for (_i = 0, _len = _ref.length; _i < _len; _i++) {
  box = _ref[_i];
  _results.push(box.setAttribute('style', 'visibility: visible;'));
}
return _results;
};

WOW.prototype.customStyle = function(hidden, duration, delay, iteration) {
var style;
style = hidden ? "visibility: hidden; -webkit-animation-name: none; -moz-animation-name: none; animation-name: none;" : "visibility: visible;";
if (duration) {
  style += "-webkit-animation-duration: " + duration + "; -moz-animation-duration: " + duration + "; animation-duration: " + duration + ";";
}
if (delay) {
  style += "-webkit-animation-delay: " + delay + "; -moz-animation-delay: " + delay + "; animation-delay: " + delay + ";";
}
if (iteration) {
  style += "-webkit-animation-iteration-count: " + iteration + "; -moz-animation-iteration-count: " + iteration + "; animation-iteration-count: " + iteration + ";";
}
return style;
};

WOW.prototype.scrollHandler = function() {
return this.scrolled = true;
};

WOW.prototype.scrollCallback = function() {
var box;
if (this.scrolled) {
  this.scrolled = false;
  this.boxes = (function() {
    var _i, _len, _ref, _results;
    _ref = this.boxes;
    _results = [];
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      box = _ref[_i];
      if (!(box)) {
        continue;
      }
      if (this.isVisible(box)) {
        this.show(box);
        continue;
      }
      _results.push(box);
    }
    return _results;
  }).call(this);
  if (!this.boxes.length) {
    return this.stop();
  }
}
};

WOW.prototype.offsetTop = function(element) {
var top;
top = element.offsetTop;
while (element = element.offsetParent) {
  top += element.offsetTop;
}
return top;
};

WOW.prototype.isVisible = function(box) {
var bottom, offset, top, viewBottom, viewTop;
offset = box.getAttribute('data-wow-offset') || this.config.offset;
viewTop = window.pageYOffset;
viewBottom = viewTop + this.element.clientHeight - offset;
top = this.offsetTop(box);
bottom = top + box.clientHeight;
return top <= viewBottom && bottom >= viewTop;
};

WOW.prototype.util = function() {
return this._util || (this._util = new Util());
};

WOW.prototype.disabled = function() {
return !this.config.mobile && this.util().isMobile(navigator.userAgent);
};

return WOW;

})();

}).call(this);


wow = new WOW(
{
animateClass: 'animated',
offset: 100
}
);
wow.init();

</script>
@endsection
