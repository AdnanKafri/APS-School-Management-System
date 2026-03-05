<!doctype html>
<html >

<head>
    <!-- Required meta tags -->

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('edit-question/fonts/icomoon/style.css')}}">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('edit-question/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- Style -->
    <link rel="stylesheet" href=" {{ asset('edit-question/css/style.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
    <script src="  https://unpkg.com/html2canvas@1.0.0-rc.5/dist/html2canvas.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.3.min.js"
        integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>

    <script src="http://code.jquery.com/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <title>Question</title>
    <style>
           body{
    overflow: hidden;
}
        .btn,
        .form-control,
        .custom-select {
            height: 45px;
            border-radius: 0;
        }

        /*cards*/

        .data-card {
            display: flex;
            flex-direction: column;
            width: 15.95em;
            min-height: auto;
            overflow: hidden;
            border-radius: 0.5em;
            text-decoration: none;
            background: white;
            margin: 1em;
            padding: 2.75em 2.5em;
            box-shadow: 0 1.8em 2.7em -0.7em rgba(0, 0, 0, 0.3);
            transition: transform 0.45s ease, background 0.45s ease;
        }

        .data-card h3 {
            color: #2E3C40;
            font-size: 3.5em;
            font-weight: 600;
            line-height: 1;
            padding-bottom: 0.5em;
            margin: 0 0 0.142857143em;
            border-bottom: 2px solid #f38639;
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
            border-bottom-color: #f38639;
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

        /*checkbox*/



        ul.ks-cboxtags {
            list-style: none;
            padding: 20px;
        }

        ul.ks-cboxtags li {
            display: inline;
        }

        ul.ks-cboxtags li label {
            display: inline-block;
            background-color: rgba(255, 255, 255, .9);
            border: 2px solid rgba(139, 139, 139, .3);
            color: #adadad;
            border-radius: 25px;
            white-space: nowrap;
            margin: 3px 0px;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-tap-highlight-color: transparent;
            transition: all .2s;
        }

        ul.ks-cboxtags li label {
            padding: 8px 12px;
            cursor: pointer;
        }

        ul.ks-cboxtags li label::before {
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 15px;
            padding: 2px 6px 2px 2px;
            /*content: " \f13b ";
    transition: transform .3s ease-in-out;*/


        }

        ul.ks-cboxtags li input[type="checkbox"]:checked+label::before {
            /* content: "\f00c";*/
            transform: rotate(-360deg);
            transition: transform .3s ease-in-out;

        }

        ul.ks-cboxtags li input[type="checkbox"]:checked+label {
            border: 2px solid #f38639;
            background-color: #f38639;
            color: #fff;
            transition: all .2s;
        }

        ul.ks-cboxtags li input[type="checkbox"] {
            display: absolute;
        }

        ul.ks-cboxtags li input[type="checkbox"] {
            position: absolute;
            opacity: 0;
        }

        ul.ks-cboxtags li input[type="checkbox"]:focus+label {
            border: 2px solid #e9a1ff;
        }

        /**/
        .myDiv {
            display: none;
        }

        .tab1cards {
            display: flex;
            flex-direction: row;
        }

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
            opacity: 1;
            /* Firefox */
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
            --background-gradient: linear-gradient(to right top, #f38639 20%, rgb(132, 167, 196)) --gray: #f38639;
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
            color: #f38639;
        }

        /* Arrow */
        .select::after {
            content: '\25BC';
            position: absolute;
            top: 0;
            right: 0;
            padding: 1em;
            background-color: #2c71ad;
            transition: .25s all ease;
            pointer-events: none;

        }

        /* Transition */
        .select:hover::after {
            color: #f38639;
        }
    </style>

</head>

<body  style="background-image: url( {{  asset('teachers/images/new2.jpg') }});
             background-size: cover; border-radius: 15px; text-align: right ">

    <div class="content" style=" text-align: right; padding-bottom: 16px;">

        <div class="container" style="border-radius: 15px;background: white;">
            <div class="row align-items-stretch no-gutters contact-wrap" style="border-radius: 15px;">
                <div class="col-md-12 col-xs-12">

                    @php
                    $i2=0
                @endphp
@foreach ($prepares as $prepare )
<div class="divIdToPrint">
     @php
                    $i2=$i2+1;
                @endphp
<input hidden class="i2" data-id="{{  $i2 }}">
           <div>
            <div class="row" style="padding-right: 20px; padding-top:20px">
                <h5>  التحضير اليومي  لمادة   &#8758;</h5>&nbsp;
               <span>{{ $lesson_id->name }}</span>

            </div>
            <br>
            <div class="row" style="padding-right: 20px;">
            <div class="col-md-6">
                <h7>  الصف  </h7> :&nbsp;
                <span>{{ $class_id->name }}</span>
               
                    

            </div>
            <div class="col-md-6">
                <div  style="display: inline-flex;">
                    <h7>  الشعبة  </h7>: &nbsp;
                    @if(json_decode($prepare->room_id))
                    @foreach(json_decode($prepare->room_id) as $item1 )
                    @if($item1)
                    <span>{{ $item1 }}</span>
                    
                      &nbsp;&nbsp;&nbsp;
                    <h3 style="color: #f38639;">/

                    </h3>&nbsp;
                    @endif
                    @endforeach
                    @else

                        @endif
                </div>
            </div>
            <div class="col-md-12">

                            <div class="Period" style="display: inline-flex;">
                    <h7>  الحصة  </h7>&nbsp;:
                    @if(json_decode($prepare->period))
                    @foreach(json_decode($prepare->period) as $item1 )
                    @if($item1)
                    <span>{{ $item1 }}</span>
                    
                       &nbsp;&nbsp;&nbsp;
                    <h3 style="color: #f38639;">/</h3>&nbsp;


                    @endif
                    @endforeach
                    @else
                   <span></span>
                <h3 style="color: #f38639;">/</h3>&nbsp;
                    @endif
                </div><br>
            </div>
            <div class="col-md-6">
                   <h7>  زمن الحصة  </h7> &nbsp;:
                   <span>{{ $prepare->class_time }}</span>
                &nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-md-6">
                <h7>     عدد الحصص  </h7> &nbsp;:
                 <span>{{ $prepare->number_of_lecture }}</span>
               
            </div>
            </div>
            </div>
            <div class="row" style="padding-right: 20px;">

                <h7>التاريخ  </h7>&nbsp;:
                <input   disabled style="width: 40px;text-align: center;background: #00ffff00;border: none;" value="{{ $prepare->day }}"
                 > &nbsp;&nbsp;
                <h3 style="color: #f38639;">/</h3>
                <input  disabled style="width: 40px;text-align: center;background: #00ffff00;border: none; " value="{{ $prepare->month }}"
                  >&nbsp;&nbsp;
                <h3 style="color: #f38639">/</h3>
                <input disabled style="width: 40px; text-align: center;background: #00ffff00;border: none;" value="{{ $prepare->year }}"

                    >&nbsp;&nbsp;&nbsp;


                <h7>الوحدة </h7>:
                <input disabled style=" text-align: center;background: #00ffff00;border: none; " value="{{ $prepare->unit }}"
                    name="unit"  type="text">
                    &nbsp;&nbsp;


                <h7>الدرس </h7> &nbsp;:
                <input disabled style="text-align: center;background: #00ffff00;border: none;" value="{{ $prepare->lecture }}"
               >&nbsp;&nbsp;

            </div>


            <br>


            <!-- new div-->
            <div class="row" style="padding-right: 20px;">
                <h7>الهدف &nbsp;  العام &nbsp; للدرس  </h7>:
              <span
             style="width: 240px; text-align: center;background: #00ffff00;border: none; " class="common-input mb-20 form-control" type="text">
             {{ $prepare->The_general_goal_of_the_lesson }}</span>
         &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
         <h7>تهيئة  &nbsp; محفزة  </h7>:
         <span 
             style="width: 240px; text-align: center;background: #00ffff00;border: none; " class="common-input mb-20 form-control" type="text">
             {{ $prepare->stimulating_initialization }}</span>    <!-- end new div-->

            </div>
            <br>
            <br>
            <div class="row" style="justify-content: center;">

                <input id="conatin"  hidden type="text">
                <div  >
                    <div class="tab1cards">
                        <!-- one div-->

                        <div style="padding-right: 19px">
                           <h7>      مؤشرات الأداء</h7>
                                @php
                                    $i=0;
                                @endphp
                                 @if($prepare->procedures_and_activities != null)
                                @foreach (json_decode($prepare->procedures_and_activities) as $key=>$item3 )

                                @php
                                    $i=$i+1;
                                @endphp
                                <input hidden class="i" value="{{ $i }}" type="text">
                                 <div data-id="{{ $i }}"  value="{{ $item3[0] }}" style="border-bottom: 1px solid black;" >{{ $i }}  &#8758; {{ $item3[0] }}</div>
                                @endforeach
@endif


                        </div>

                        <!-- end one -->
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <!-- start tow div -->
                        <div>
                            </a>
                            <h7> الزمن </h7>
                            @php
                                    $i=0;
                                @endphp
                                 @if($prepare->procedures_and_activities != null)
                            @foreach (json_decode($prepare->procedures_and_activities) as $key=>$item3 )
                            @php
                                    $i=$i+1;
                                @endphp
                                 <input hidden class="i" value="{{ $i }}" type="text">
                                  <div data-id="{{ $i }}"  value="{{ $item3[1] }}" style="border-bottom: 1px solid black;" >
                        {{ $i }}  &#8758; {{ $item3[1] }}</div>
                                @endforeach
                                @endif
                            <div class="appendme"> </div>


                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <!-- end two div -->
                        <!-- start three div -->
                        <div style="width: 700px;">
                            <h7> الاجراءات و المناشط </h7>
                            @php
                                    $i=0;
                                @endphp
                                 @if($prepare->procedures_and_activities != null)
                            @foreach (json_decode($prepare->procedures_and_activities) as $key=>$item3 )
                            @php
                                    $i=$i+1; 
                                @endphp
                                 <input hidden class="i" value="{{ $i }}" type="text">
                                 <div data-id="{{ $i }}"  value="{{ $item3[2] }}" style="border-bottom: 1px solid black;" >
                           {{ $i }}  &#8758; {{ $item3[2] }} 
                            </div>
                            @endforeach
                            @endif
                            <div class="appendme"> </div>

                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <!-- end three div -->
                        <!-- four div-->
                        <div style="    padding-left: 19px;">
                            <h7> التقويم المرحلي </h7>
                            @php
                                    $i=0;
                                @endphp
                                 @if($prepare->procedures_and_activities != null)
                            @foreach (json_decode($prepare->procedures_and_activities) as $key=>$item3 )
                            @php
                                    $i=$i+1;
                                @endphp

                            <div data-id="{{ $i }}"  value="{{ $item3[3] }}" style="border-bottom: 1px solid black;" >{{ $i }}  &#8758; {{ $item3[3] }}</div>
                            @endforeach
                            @endif
                            <div class="appendme"> </div>

                        </div>
                        <!-- end four -->


                    </div>

                </div>


                <!-- end cards-->
            </div>
            <br>
            <br>

            <div class="row" style="justify-content: center;">
                <div class="col-md-11" >
                    <h7 style="text-align: center;">الوسائل  </h7>:

                    <ul class="ks-cboxtags">
                        <div class="row" style="justify-content: center;">
@if($prepare->means !="null"  && $prepare->created_at <= "2022-10-12 07:50:09" )
                            @foreach(json_decode($prepare->means) as $item2 )

                            @if($item2 =="Rainbow Dash")
                            <li> <input type="checkbox" id="checkboxOne" class="x" data-id="Rainbow Dash" name="means[]"
                                value="Rainbow Dash">
                            <label for="checkboxOne">الحاسوب </label></li>
                            @endif
                            @if($item2 =="Cotton Candy")
                            <li><input type="checkbox" id="checkboxTwo" class="x" data-id="Cotton Candy" name="means[]"
                            data-id="Cotton Candy" value="Cotton Candy"><label for="checkboxTwo">السبورة البيضاء
                        </label></li>

                            @endif
                            @if($item2 =="Rarity")
                            <li><input type="checkbox" id="checkboxThree" name="means[]" class="x" data-id="Rarity"
                                value="Rarity"><label for="checkboxThree">السبورة الذكية </label></li>

                            @endif
                            @if($item2 =="Moondancer")
                            <li><input type="checkbox" id="checkboxFour" name="means[]" class="x" data-id="Moondancer"
                                value="Moondancer"><label for="checkboxFour">اوراق عمل </label></li>

                            @endif
                            @if($item2 =="Surprise")
                            <li><input type="checkbox" id="checkboxFive" name="means[]" class="x" data-id="Surprise"
                                value="Surprise"><label for="checkboxFive">البطاقات </label></li>

                            @endif
                            @if($item2 =="Twilight Sparkle")
                            <li><input type="checkbox" id="checkboxSix" name="means[]" class="x"
                                data-id="Twilight Sparkle" value="Twilight Sparkle"><label for="checkboxSix">الخرائط
                            </label></li>
                            @endif
                            @if($item2 =="Fluttershy")
                            <li><input type="checkbox" id="checkboxSeven" name="means[]" class="x" data-id="Fluttershy"
                                value="Fluttershy"><label for="checkboxSeven">مشهد فيديو </label></li>
                            @endif
                            @if($item2 =="Derpy Hooves")
                            <li><input type="checkbox" id="checkboxEight" name="means[]" class="x"
                                data-id="Derpy Hooves" value="Derpy Hooves"><label for="checkboxEight">المجسمات
                            </label></li>
                            @endif
                            @if($item2 =="Princess Celestia")
                            <li><input type="checkbox" id="checkboxNine" name="means[]" class="x"
                                data-id="Princess Celestia" value="Princess Celestia"><label
                                for="checkboxNine">المعاجم
                            </label></li>
                            @endif
                            @if($item2 =="Gusty")
                            <li><input type="checkbox" id="checkboxTen" name="means[]" class="x" data-id="Gusty"
                            value="Gusty"><label for="checkboxTen">اللوحات </label></li>

                            @endif
                            @if($item2 =="Discord")
                            <li class="ks-selected"><input type="checkbox" name="means[]" class="x" data-id="Discord"
                                id="checkboxEleven" value="Discord"><label for="checkboxEleven">القصص</label></li>


                            @endif
                            @if($item2 =="Clover")
                            <li><input type="checkbox" id="checkboxTwelve" name="means[]" class="x" data-id="Clover"
                                value="Clover"><label for="checkboxTwelve">الصور </label></li>

                            @endif
                            @if($item2 =="Baby Moondancer")
                            <li><input type="checkbox" id="checkboxThirteen" name="means[]" class="x"
                                data-id="Baby Moondancer" value="Baby Moondancer"><label
                                for="checkboxThirteen">المطويات
                            </label></li>

                            @endif
                            @if($item2 =="Baby Moondancer")
                            {{-- <li><input type="checkbox" id="checkboxFourteen" name="means[]" class="x" data-id="Medley"
                                value="Medley"><label for="checkboxFourteen">اخرى </label></li> --}}

                            @endif
                            @if($item2 =="Medley")
                            <li><input type="checkbox" id="checkboxFourteen" name="means[]" class="x" data-id="Medley"
                                value="Medley"><label for="checkboxFourteen">اخرى </label></li>

                            @endif
                            @endforeach
                            @elseif($prepare->means !="null"  && $prepare->created_at > "2022-10-12 07:50:09" )
                             @foreach(json_decode($prepare->means) as $item2 )
                                @foreach($means as $item3 )
                               @if($item2==$item3->id)
                          <li><input type="checkbox" id="checkboxFourteen" name="means[]" class="x" data-id="Medley"
                                value="Medley"><label for="checkboxFourteen">{{$item3->name}} </label></li>
                          
                            @endif
                            @endforeach
                             @endforeach
                            @endif 


                                             </div>
                    </ul>
                </div>
                <!-- new checkbox -->
                <div class="col-md-11" style="">
                    <h7 style="text-align: center;">الاستراتيجيات و الطرق المتبعة  </h7>:

                    <ul class="ks-cboxtags">
                        <div class="row " style="justify-content: center;">
                             @if($prepare->roads!='null' && $prepare->created_at <= "2022-10-12 07:50:09" )
                           
                            @foreach(json_decode($prepare->roads) as $item2 )

                            @if($item2 =="Rainbow Dash")
                            <li><input type="checkbox" id="checkboxO" name="roads[]" class="x1" data-id="Rainbow Dash"
                                value="Rainbow Dash"><label for="checkboxO">التعليم الاصفي </label></li>

                            @endif
                            @if($item2 =="Cotton Candy")
                            <li><input type="checkbox" id="checkboxT" name="roads[]" class="x1" data-id="Cotton Candy"
                                value="Cotton Candy"><label for="checkboxT">البحث و الاستكشاف </label></li>
                                   @endif
                            @if($item2 =="Rarity")
                            <li><input type="checkbox" id="checkboxTh" name="roads[]" class="x1" data-id="Rarity"
                                value="Rarity"><label for="checkboxTh">العصف الذهني </label></li>
                            @endif
                            @if($item2 =="Moondancer")
                            <li><input type="checkbox" id="checkboxF" name="roads[]" class="x1" data-id="Moondancer"
                                value="Moondancer"><label for="checkboxF">المناظرة</label></li>

                            @endif
                            @if($item2 =="Surprise")
                            <li><input type="checkbox" id="checkboxFi" name="roads[]" class="x1" data-id="Surprise"
                                value="Surprise"><label for="checkboxFi">الاستماع </label></li>
                            @endif
                            @if($item2 =="Twilight Sparkle")
                            <li><input type="checkbox" id="checkboxS" name="roads[]" class="x1"
                                data-id="Twilight Sparkle" value="Twilight Sparkle">
                            <label for="checkboxS">التعليل
                            </label></li>
                            @endif
                            @if($item2 =="Fluttershy")
                            <li><input type="checkbox" id="checkboxSev" name="roads[]" class="x1" data-id="Fluttershy"
                                value="Fluttershy"><label for="checkboxSev">التجربة </label></li>
                            @endif
                            @if($item2 =="Derpy Hooves")
                            <li><input type="checkbox" id="checkboxEig" name="roads[]" class="x1" data-id="Derpy Hooves"
                                value="Derpy Hooves"><label for="checkboxEig">المخططات </label></li>
                                  @endif
                            @if($item2 =="Princess Celestia")
                            <li><input type="checkbox" id="checkboxNi" name="roads[]" class="x1"
                                data-id="Princess Celestia" value="Princess Celestia"><label for="checkboxNi">العمل
                                الفردي
                            </label></li>
                            @endif
                            @if($item2 =="Gusty")
                            <li><input type="checkbox" id="checkboxTen1" name="roads[]" class="x1" data-id="Gusty"
                                value="Gusty"><label for="checkboxTen1">التعلم الثنائي </label></li>

                            @endif
                            @if($item2 =="Discord")
                           <li class="ks-selected"><input type="checkbox" name="roads[]" class="x1" data-id="Discord"
                                    id="checkboxElev" value="Discord">
                                <label for="checkboxElev">التعلم التعاوني </label></li>
                            @endif
                            @if($item2 =="Clover")
                            <li><input type="checkbox" id="checkboxTw" name="roads[]" class="x1" data-id="Clover"
                                value="Clover"><label for="checkboxTw">التعلم الذاتي </label></li>
                            @endif
                            @if($item2 =="Baby Moondancer")
                            <li><input type="checkbox" id="checkboxThir" name="roads[]" class="x1"
                                data-id="Baby Moondancer" value="Baby Moondancer"><label for="checkboxThir">التعلم
                                بالأقران
                            </label></li>

                            @endif

                            @if($item2 =="Medley")
                            <li><input type="checkbox" id="checkboxFourt" name="roads[]" class="x1" data-id="Medley"
                                value="Medley"><label for="checkboxFourt">الحوار و المناقشة </label></li>

                            @endif
                            @if($item2 =="Medley1")

                            <li><input type="checkbox" id="checkbox2" name="roads[]" class="x1" data-id="Medley1"
                                value="Medley1"><label for="checkbox2">التعلم باللعب </label></li>

                            @endif
                            @if($item2 =="Medley2")
                            <li><input type="checkbox" id="checkbox3" name="roads[]" class="x1" data-id="Medley2"
                                value="Medley2"><label for="checkbox3">الاستنتاج </label></li>

                            @endif
                            @if($item2 =="Medley3")
                            <li><input type="checkbox" id="checkbox4" name="roads[]" class="x1" data-id="Medley3"
                                value="Medley3"><label for="checkbox4">التحليل </label></li>

                            @endif
                            @if($item2 =="Medley4")
                            <li><input type="checkbox" id="checkbox5" name="roads[]" class="x1" data-id="Medley4"
                                value="Medley4"><label for="checkbox5">التلخيص </label></li>
                            @endif
                            @if($item2 =="Medley5")
                            <li><input type="checkbox" id="checkbox6" name="roads[]" class="x1" data-id="Medley4"
                                value="Medley4"><label for="checkbox6">التمييز والتحديد </label></li>
                            @endif
                            @endforeach
                               @elseif($prepare->roads!='null' && $prepare->created_at > "2022-10-12 07:50:09" )
                                 @foreach(json_decode($prepare->roads) as $item2 )
                                @foreach($road as $item32 )
                               @if($item2==$item32->id)
                              <li><input type="checkbox" id="checkbox6" name="roads[]" class="x1" data-id="Medley4"
                                value="Medley4"><label for="checkbox6">{{$item32->name}} </label></
                          
                            @endif
                            @endforeach
                             @endforeach
 @endif
                        </div>
                    </ul>
                </div>
                <!-- end new -->

            </div>
            <div class="row" style="justify-content: center;">
                <div class="col-md-11" style="">
                    <h7 style="text-align: center;">الواجب المنزلي  </h7>:
                    <br>
                    <p name="homework" class="form-control" cols="5" rows="4">{{ $prepare->homework }}</p>

                </div>
                <div class="col-md-11" style="">
                    <h7 style="text-align: center;">ملاحظات  </h7>:
                    <br>
                    <p name="note" class="form-control" cols="5" rows="4">
        {{ $prepare->note }}
                    </p>
                </div>
                <div class="col-md-11" style="">
                    <h7 style="text-align: center;">المفاهيم و المصطلحات  </h7>:
                    <br>
                    <p name="concepts_and_terminology" class="form-control" cols="5" rows="4">
                        {{ $prepare->concepts_and_terminology }}
                    </p>
                </div>
                <div class="col-md-11" style="">
                    <h7 style="text-align: center;">التقويم النهائي  </h7>:
                    <br>
                    <p name="Final_calendar" class="form-control" cols="5" rows="4">
        {{ $prepare->Final_calendar }}
                    </p>
                </div>

            </div>
            <!-- style for number-->

            <!-- end style -->

        </div>
@endforeach



        <!-- end menue -->

</div>








                </div>
            </div>
        </div>
    </div>


    <script>


       // This code is collected but useful, click below to jsfiddle link.
    </script>
     <script>

var $i2 =$('.i2').last().data('id');

const pdf = new jsPDF("p","mm","a2");
        const input = document.getElementsByClassName('divIdToPrint');
        var x=0
        $.each($(input), function (key, value) {

            html2canvas(value)
        .then((canvas) => {
          const imgData = canvas.toDataURL('image/png');

        //   pdf.addImage(imgData,  'JPEG', 0, 0, width, height);
          var width = pdf.internal.pageSize.getWidth;
var height = pdf.internal.pageSize.getHeight;
// pdf.addPage([width, height], "p");
pdf.addFont('Helvetica', 'Helvetica', 'normal')
pdf.setFont('Helvetica')
pdf.setFontSize(80);
 x=x+1
pdf.addImage(imgData, 'png', 10, 1,);
pdf.addPage()


if($i2==x){
    pdf.save("download.pdf");
}




    });
        })


    </script>






    <script src=" {{ asset('edit-question/index.js')}} "></script>
    <script src=" {{ asset('edit-question/js/jquery-3.3.1.min.js')}}"></script>
    <script src=" {{ asset('edit-question/js/popper.min.js')}}"></script>
    <script src=" {{ asset('edit-question/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('edit-question/js/jquery.validate.min.js')}} "></script>
    <script src="{{ asset('edit-question/js/main.js')}} "></script>

</body>

</html>

