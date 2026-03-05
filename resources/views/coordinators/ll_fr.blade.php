coordinators<!doctype html>
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




<div id="divIdToPrint">

           <div>
            <div class="row" style="padding-right: 20px; padding-top:20px">
                <h5>التحضير اليومي  لمادة </h5>&nbsp;
                <input style="width: 100px;
                text-align: center; margin-top: -20px;"
                    class="common-input mb-20 form-control" disabled value="{{ $lesson_id->name }}">

            </div>
            <br>
            <div class="row" style="padding-right: 20px;">
            <div class="col-md-6">
                <h7>  الصف  </h7> :&nbsp;
                <input style=" width: 100px;
                 text-align: center;margin-top: -20px;" value="{{ $class_id->name }}"
                    disabled class="common-input mb-20 " >

            </div>
            <div class="col-md-6">
                <div  style="display: inline-flex;">
                    <h7>  الشعبة  </h7>: &nbsp;
                    @if(json_decode($prepare->room_id))
                    @foreach(json_decode($prepare->room_id) as $item1 )
                    @if($item1)
                    <input style=" text-align: center;background: #00ffff00;border: none;"
                         value="{{ $item1 }}"
                      disabled >&nbsp;&nbsp;&nbsp;
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
                    <input disabled style="  text-align: center;background: #00ffff00;border: none;"
                        value="{{ $item1 }}"
                       >&nbsp;&nbsp;&nbsp;
                    <h3 style="color: #f38639;">/</h3>&nbsp;


                    @endif
                    @endforeach
                    @else
                    <input style="text-align: center;background: #00ffff00;border: none;"
                    value=""
                   >&nbsp;&nbsp;&nbsp;
                <h3 style="color: #f38639;">/</h3>&nbsp;
                    @endif
                </div><br>
            </div>
            <div class="col-md-6">
                   <h7>  زمن الحصة  </h7> &nbsp;:
                <input disabled style=" text-align: center;background: #00ffff00;border: none;"
                    value="{{ $prepare->class_time }}"
                   > &nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-md-6">
                <h7>     عدد الحصص  </h7> &nbsp;:
                <input disabled
                    style=" text-align: center;background: #00ffff00;border: none;"
                    value="{{ $prepare->number_of_lecture }}" >
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
                <div class="col-md-12" style="text-align: left;
                direction: ltr;
                padding-left: 23px;">
                <h7>
                    Acte de language </h7>:
                <input disabled value="{{ $prepare->The_general_goal_of_the_lesson }}"
                    style="width: 240px; text-align: center;background: #00ffff00;border: none; " class="common-input mb-20 form-control" type="text">
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                </div>
                <div class="col-md-12" style="text-align: left;
                direction: ltr;
                padding-left: 23px;">
                <h7> Situation de communication </h7>:
                <input name="stimulating_initialization" value="{{ $prepare->stimulating_initialization }}"
                    style="width: 240px; text-align: center;background: #00ffff00;border: none; " class="common-input mb-20 form-control" type="text">
                <!-- end new div-->
                </div>

            </div>
            <br>
            <br>

            <h5 style="text-align: center;">Linguistique</h5>
            <div class="row" style="justify-content: center;direction: ltr;">
              <!-- start cards-->

              <div class="col-md-11" style="direction: ltr;text-align: left;" >
                <h7 style="text-align: center;">
                   Lexique: </h7>
             <p  name="Lexique" value="{{ $prepare->Lexique }}" class="form-control" cols="5" rows="4" >
               {{ $prepare->Lexique }}</p>
              </div>
              <div class="col-md-11 " style="direction: ltr;text-align: left;">
                <h7 style="text-align: center;"> Points grammaticaux: </h7>
                 <br>
             <p name="Points_grammaticaux"  value="{{ $prepare->Points_grammaticaux }}" class="form-control" cols="5" rows="4" >
               {{ $prepare->Points_grammaticaux }}
             </p>
              </div>

              <div class="col-md-11 "style="direction: ltr;text-align: left;">
                <h7 style="text-align: center;"> Phonetique : </h7>
                 <br>
             <p name="Phonetique" value="{{ $prepare->Phonetique }}" class="form-control" cols="5" rows="4" >
               {{ $prepare->Phonetique }}</p>
              </div>

              <!-- end cards-->

            </div>

            <div class="row" style="justify-content: center;direction: ltr;">
                <div class="col-md-11 " style="direction: ltr;text-align: left;">
                <h7 style="text-align: center;"> Materiel : </h7>
                 <br>
             <p name="Materiel" class="form-control" cols="5" rows="4" >{{ $prepare->Materiel }}</p>

              </div>
              <div class="col-md-11 " style="direction: ltr;text-align: left;">
                <h7 style="text-align: center;">Taches
                   (Competences)
                    : </h7>
                 <br>
             <p name="Taches" class="form-control" cols="5" rows="4" >
               {{ $prepare->Taches }}
             </p>
              </div>
              <div class="col-md-11 "style="direction: ltr;text-align: left;">
                <h7 style="text-align: center;">Evaluation  : </h7>
                 <br>
             <p name="Evaluation" class="form-control" cols="5" rows="4" >
               {{ $prepare->Evaluation }}
             </p>
              </div>


            </div>
           <!-- style for number-->

           <!-- end style -->

          </div>
          <div class="row" style="justify-content: center;padding-top: -200px;">
           <p>{{ $prepare->number }}</p>
           </div>
            <!-- style for number-->

            <!-- end style -->

</div>

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
        const input = document.getElementById('divIdToPrint');
  html2canvas(input)
        .then((canvas) => {
          const imgData = canvas.toDataURL('image/png');
          const pdf = new jsPDF("p","mm","a2");
        //   pdf.addImage(imgData,  'JPEG', 0, 0, width, height);
          var width = pdf.internal.pageSize.getWidth;
var height = pdf.internal.pageSize.getHeight;
// pdf.addPage([width, height], "p");
pdf.addFont('Helvetica', 'Helvetica', 'normal')
pdf.setFont('Helvetica')
pdf.setFontSize(80);

pdf.addImage(imgData, 'png', -2, 1,);

          pdf.save("download.pdf");
    });
    </script>





    <script src=" {{ asset('edit-question/index.js')}} "></script>
    <script src=" {{ asset('edit-question/js/jquery-3.3.1.min.js')}}"></script>
    <script src=" {{ asset('edit-question/js/popper.min.js')}}"></script>
    <script src=" {{ asset('edit-question/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('edit-question/js/jquery.validate.min.js')}} "></script>
    <script src="{{ asset('edit-question/js/main.js')}} "></script>

</body>

</html>

