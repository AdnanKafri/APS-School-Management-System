<!DOCTYPE html>
<html lang="en">

<head>
    <title>تقييم حصة مشاهدة معلم   </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('show-class/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('show-class/vendor/bootstrap/css/bootstrap.min-2.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('show-class/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('show-class/vendor/animate/animate.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('show-class/vendor/css-hamburgers/hamburgers.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('show-class/vendor/select2/select2.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('show-class/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('show-class/css/main.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
    <script src="  https://unpkg.com/html2canvas@1.0.0-rc.5/dist/html2canvas.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
        integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <!--===============================================================================================-->
    <link href="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css" rel="stylesheet">

    <style>
        /*radio */
        @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:600&display=swap');

        input[type="radio"] {

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

        input[type="radio"]::before {
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

        input[type="radio"]:checked {
            color: #fff;
            border-color: #ffb832;
            background: #ffb832;
        }

        input[type="radio"]:checked::before {
            opacity: 1;
        }

        input[type="radio"]:checked~label::before {
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


        /*end radio*/
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

        @media (max-width: 768px) {
            .data-card {
                padding: 100px 80px 33px 80px;
            }

            .data-card {
                width: 100%;
            }
        }

        @media only screen and (max-width: 868px) {
            .data-card {
                padding: 100px 80px 33px 80px;
            }

            .data-card {
                width: 100%;
            }
        }

        @media only screen and (max-width: 968px) {
            .data-card {
                padding: 100px 80px 33px 80px;
            }

            .data-card {
                width: 100%;
            }
        }

        @media only screen and (max-width: 985px) {
            .data-card {
                padding: 100px 80px 33px 80px;
            }

            .data-card {
                width: 100%;
            }
        }

        @media only screen and (max-width: 988px) {
            .data-card {
                padding: 100px 80px 33px 80px;
            }

            .data-card {
                width: 100%;
            }
        }

        @media (max-width: 772px),
        (max-width:991px),
        (max-width:992px) {
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

        .ha-screen-reader {
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

        .field__input {
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

        .field__input:focus::-webkit-input-placeholder {
            color: var(--uiFieldPlaceholderColor);
        }

        .field__input:focus::-moz-placeholder {
            color: var(--uiFieldPlaceholderColor);
        }

        /*
=====
CORE STYLES
=====
*/

        .field {
            --uiFieldBorderWidth: var(--fieldBorderWidth, 2px);
            --uiFieldPaddingRight: var(--fieldPaddingRight, 1rem);
            --uiFieldPaddingLeft: var(--fieldPaddingLeft, 1rem);
            --uiFieldBorderColorActive: var(--fieldBorderColorActive, rgba(22, 22, 22, 1));

            display: var(--fieldDisplay, inline-flex);
            position: relative;
            font-size: var(--fieldFontSize, 1rem);
            text-align: right;
        }

        .field__input {
            box-sizing: border-box;
            width: var(--fieldWidth, 100%);
            height: var(--fieldHeight, 3rem);
            padding: var(--fieldPaddingTop, 1.25rem) var(--uiFieldPaddingRight) var(--fieldPaddingBottom, .5rem) var(--uiFieldPaddingLeft);
            border-bottom: var(--uiFieldBorderWidth) solid var(--fieldBorderColor, rgba(0, 0, 0, .25));
        }

        .field__input:focus {
            outline: none;
        }

        .field__input::-webkit-input-placeholder {
            opacity: 0;
            transition: opacity .2s ease-out;
        }

        .field__input::-moz-placeholder {
            opacity: 0;
            transition: opacity .2s ease-out;
        }

        .field__input:focus::-webkit-input-placeholder {
            opacity: 1;
            transition-delay: .2s;
        }

        .field__input:focus::-moz-placeholder {
            opacity: 1;
            transition-delay: .2s;
        }

        .field__label-wrap {
            box-sizing: border-box;
            pointer-events: none;
            cursor: text;

            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .field__label-wrap::after {
            content: "";
            box-sizing: border-box;
            width: 100%;
            height: 0;
            opacity: 0;

            position: absolute;
            bottom: 0;
            left: 0;
        }

        .field__input:focus~.field__label-wrap::after {
            opacity: 1;
        }

        .field__label {
            position: absolute;
            left: var(--uiFieldPaddingLeft);
            top: calc(50% - .5em);

            line-height: 1;
            font-size: var(--fieldHintFontSize, inherit);

            transition: top .2s cubic-bezier(0.9, -0.15, 0.1, 1.15), opacity .2s ease-out, font-size .2s ease-out;
            will-change: bottom, opacity, font-size;
        }

        .field__input:focus~.field__label-wrap .field__label,
        .field__input:not(:placeholder-shown)~.field__label-wrap .field__label {
            --fieldHintFontSize: var(--fieldHintFontSizeFocused, .75rem);

            top: var(--fieldHintTopHover, .25rem);
        }

        /*
effect 1
*/

        .field_v1 .field__label-wrap::after {
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

        .field {
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
            background-color: #767676;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto auto;
            grid-gap: 10px;
            background-color: transparent;
            padding: 10px;
            /*margin-left: -50px;*/
            justify-content: center;
            text-align: center;

        }

        @media (max-width: 576px) {
            .grid-container {
                padding: 10px 15px 33px 15px;
            }
        }

        .myDiv {
            display: none;
        }

        @media only screen and (max-width: 876px),
        (max-width:991px) {
            .grid-container {
                padding: 10px 15px 33px 15px;
                width: 100%;
            }
        }

        @media only screen and (max-width: 579px),
        (max-width:991px) {
            .grid-container {
                padding: 10px 15px 33px 15px;
                width: 100%;
            }
        }


        @media only screen and (max-width: 500px) {
            .tab1cards {
                width: calc(100% - 10px);
            }
        }

        @media only screen and (max-width: 300px) {
            .tab1cards {
                width: 50%;
            }
        }

        .Row {
            display: table;
            width: 100%;
            /*Optional*/
            table-layout: fixed;
            /*Optional*/
            border-spacing: 0px;
            /*Optional*/
        }

        .Column {

            display: table-cell;
            background-color: transparent;
            /*Optional*/
        }

        @media only screen and (max-width:480px) {
            .Row {
                width: 120%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media only screen and (max-width:780px) {
            .Row {
                width: 100%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media only screen and (max-width:360px) {
            .Row {
                width: 120%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media only screen and (max-width:579px) {
            .Row {
                width: 120%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media only screen and (max-width:679px) {
            .Row {
                width: 120%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media only screen and (max-width:500px),
        (max-width:575px) {
            .Row {
                width: 100%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media only screen and (max-width:522px) {
            .Row {
                width: 100%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media only screen and (max-width:529px) {
            .Row {
                width: 100%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media only screen and (max-width:547px) {
            .Row {
                width: 100%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media only screen and (max-width:529px),
        (max-width:557px),
        (max-width:596px),
        (max-width:624px),
        (max-width:557px),
        (max-width:579px) and (max-width:696px) {
            .Row {
                width: 100%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media only screen and (max-width:635px) {
            .Row {
                width: 100%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media only screen and (max-width:682px) {
            .Row {
                width: 120%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media only screen and (max-width: 783px),
        (max-width:783px),
        (max-width: 809px),
        (max-width: 811px),
        (max-width: 823px),
        (max-width: 854px),
        (max-width: 856px) {

            .Row {
                width: 100%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media screen and (max-width:861px),
        (max-width:882px) {

            .Row {
                width: 90%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media screen and (max-width:904px) {

            .Row {
                width: 80%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media screen and (max-width:911px) {

            .Row {
                width: 110%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media screen and (max-width:837px),
        (max-width:841px),
        (max-width:845px),
        (max-width:850px),
        (max-width:869px),
        (max-width:872px),
        (max-width:875px),
        (max-width:886px),
        (max-width:909px) {

            .Row {
                width: 80%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media screen and (max-width:918px),
        (max-width:921px),
        (max-width:929px),
        (max-width:949px),
        (max-width:960px),
        (max-width:974px),
        (max-width:982px),
        (max-width:986px),
        (max-width:991px) {
            .Row {
                width: 110%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media screen and (max-width:994px),
        (max-width:1000px),
        (max-width:1008px),
        (max-width:1016px),
        (max-width:1022px),
        (max-width:1032px),
        (max-width:1044px),
        (max-width:1054px) {
            .Row {
                width: 105%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media screen and (max-width:846px),
        (max-width:580px),
        (max-width:853px),
        (max-width:861px),
        (max-width:871px),
        (max-width:873px),
        (max-width:875px),
        (max-width:878px),
        (max-width:881px),
        (max-width:885px),
        (max-width:881px),
        (max-width:888px),
        (max-width:900px),
        (max-width:999px) {
            .Row {
                width: 80%;

            }

            .Column {
                display: inline-block;

            }
        }

        @media screen and (max-width:960px),
        (max-width:964px),
        (max-width:966px),
        (max-width:971px),
        (max-width:983px),
        (max-width:984px),
        (max-width:990px) {
            .Row {
                width: 110%;

            }

            .Column {
                display: inline-block;

            }

        }

        /*style table*/
        table {
            width: 100%;
            border-collapse: collapse;
            direction: rtl;
            text-align: right;
        }

        /* Zebra striping */
        tr:nth-of-type(odd) {
            background: #eee;
        }

        th {
            background: #094e89;
            color: white;
            font-weight: bold;
        }

        td,
        th {
            padding: 6px;
            border: 1px solid #ccc;
            text-align: right;
        }

        @media only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px) {

            /* Force table to not be like tables anymore */
            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            /* Hide table headers (but not display: none;, for accessibility) */
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                border: 1px solid #ccc;
            }

            td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }

            td:before {
                /* Now like a table header */
                position: absolute;
                /* Top/left values mimic padding */
                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
            }

            /*
	Label the data
	*/
            td:nth-of-type(1):before {
                content: "المجالات ";
            }

            td:nth-of-type(2):before {
                content: "غير مقبول ";
            }

            td:nth-of-type(3):before {
                content: "مقبول ";
            }

            td:nth-of-type(4):before {
                content: "جيد ";
            }

            td:nth-of-type(5):before {
                content: "متميز";
            }

            td:nth-of-type(6):before {
                content: "ملاحظات ";
            }

            td:nth-of-type(7):before {
                content: "Date of Birth";
            }

            td:nth-of-type(8):before {
                content: "Dream Vacation City";
            }

            td:nth-of-type(9):before {
                content: "GPA";
            }

            td:nth-of-type(10):before {
                content: "Arbitrary Data";
            }
        }

        /*end style table */
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

<body style=" background-image: background-size: cover;
">




        <div class="container-login100">

            <div class="">


                <br>
                <br>




                <h4 style="color: #094e89;"> العام الدراس الحالي {{ $year->name }} </h4>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <h4 style=" color:#f38639; float: right;"> تقييم حصة مشاهدة معلم </h4>
                <br>
                <br>
                <div class="table_data" id="divIdToPrint">
                    <div id="load" >

                            <input   hidden name="id" value="{{ $item->id }}">

                        <div class="" style="margin: 0 auto;">
                            <div class="text pl-3">

                                <br>
                                <br>

                                <div class="row">

                                    <div class="col-md-4">




                                    </div>
                                    <div class="col-md-4">
                                        <h4 style="color: #094e89;">الدرجة النهائية  <span> : {{ $item->final_grade }}</span></h4>




                                    </div>
                                    <div class="col-md-4">




                                    </div>




                                </div><!-- end row -->

<br>
                                    <div class="row">
                                        <!--row-->

                                        <div class="col-md-6">
                                            <h5 style="color: #094e89;">  المادة   <span> : {{ $lesson->name }}</span></h5>
                                        </div>

                                        <div class="col-md-6">
                                            <h5 style="color: #094e89;" >الاسم    <span> : {{ $teacher->first_name }} {{ $teacher->last_name }} :</span></h5>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <!--row-->

                                        <div class="col-md-6">
                                            <h5 style="color: #094e89;">    تاريخ التقييم   <span> : {{ $item->date }}</span> </h5>

                                        </div>

                                        <div class="col-md-6">
                                            <h5 style="color: #094e89;">  الموضوع  <span> : {{ $item->title }}</span></h5>

                                        </div>

                                    </div>
                                    <!--end row -->
                               <!-- end grid-->





                                <!-- end new-->
                            </div>
                        </div>
                        <!-- end 1 card -->
                        <!-- start card 2-->
                        <br>
                        <br>
                        <div class="" style="margin: 0 auto ; margin-top: 30px;">
                            <div class="text pl-3">
                                <table>
                                    <thead>
                                        <tr>
                                            <th rowspan="1" colspan="1" style="text-align: center;">المجالات </th>
                                            <th rowspan="1" colspan="4" style="text-align: center;">مستوى الأداء </th>
                                            <th rowspan="1" colspan="1">ملاحظات </th>
                                        </tr>
                                        <tr>
                                            <th rowspan="1" colspan="1" style="text-align: center;">المعيار 1  &#8758; اللغة</th>
                                            <th rowspan="1" colspan="1">غير مقبول </th>
                                            <th rowspan="1" colspan="1">مقبول </th>
                                            <th rowspan="1" colspan="1">جيد </th>
                                            <th rowspan="1" colspan="1">متميز </th>
                                            <th rowspan="1" colspan="1" style="text-align: center;"> / 8</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>سلامة اللغة والتعبير الصوتي تبعا للموقف التعليمي</td>
                                            @if($item->Standard1==1)
                                            <td style="text-align: center;"> <input type="radio" id="tod22"
                                                    value="1" checked name="Standard1[]"> </td>
                                                    @else
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                                        value="1" > </td>
                                                    @endif

                                                    @if($item->Standard1==2)
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                                        value="2" checked> </td>
                                                            @else
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                                                value="2"> </td>
                                                            @endif

                                                            @if($item->Standard1==3)
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                                                value="3" checked> </td>
                                                                    @else
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                                                        value="3" > </td>
                                                                    @endif
                                                                    @if($item->Standard1==4)
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                                                        value="4"checked> </td>
                                                                            @else
                                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard1[]"
                                                                                value="4"> </td>
                                                                            @endif


                                            <td  style="text-align: center;">
                                                {{ $item->Standard1_mark }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th rowspan="1" colspan="1" style="text-align: center;">المعيار 2 &#8758; التمهيد </th>
                                            <th rowspan="1" colspan="1">غير مقبول </th>
                                            <th rowspan="1" colspan="1">مقبول </th>
                                            <th rowspan="1" colspan="1">جيد </th>
                                            <th rowspan="1" colspan="1">متميز </th>
                                            <th rowspan="1" colspan="1" style="text-align: center;"> / 8</th>
                                        </tr>
                                        <tr>
                                            <td>التهيئة الحافزة والدخول الى الدرس </td>

                                            @if($item->Standard2==1)
                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                                    value="1" checked> </td>
                                                    @else
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                                        value="1" > </td>
                                                    @endif

                                                    @if($item->Standard2==2)
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                                        value="2" checked> </td>
                                                            @else
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                                                value="2"> </td>
                                                            @endif

                                                            @if($item->Standard2==3)
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                                                value="3" checked> </td>
                                                                    @else
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                                                        value="3"> </td>
                                                                    @endif
                                                                    @if($item->Standard2==4)
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                                                        value="4" checked> </td>
                                                                            @else
                                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard2[]"
                                                                                value="4"> </td>
                                                                            @endif



                                            <td style="text-align: center;">
                                                {{ $item->Standard2_mark }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th rowspan="1" colspan="1" style="text-align: center;">المعيار 3 &#8758; الادارة الصفية
                                            </th>
                                            <th rowspan="1" colspan="1">غير مقبول </th>
                                            <th rowspan="1" colspan="1">مقبول </th>
                                            <th rowspan="1" colspan="1">جيد </th>
                                            <th rowspan="1" colspan="1">متميز </th>
                                            <th rowspan="1" colspan="1" style="text-align: center;"> / 24 </th>
                                        </tr>
                                        <tr>
                                            <td>حيوية المعلم ولغة الجسد </td>
                                            @if($item->Standard31==1)
                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                                    value="1" checked> </td>
                                                    @else
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                                        value="1" > </td>
                                                    @endif

                                                    @if($item->Standard31==2)
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                                        value="2" checked> </td>
                                                            @else
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                                                value="2"> </td>
                                                            @endif

                                                            @if($item->Standard31==3)
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                                                value="3" checked> </td>
                                                                    @else
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                                                        value="3"> </td>
                                                                    @endif
                                                                    @if($item->Standard31==4)
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                                                        value="4" checked> </td>
                                                                            @else
                                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard31[]"
                                                                                value="4"> </td>
                                                                            @endif
                                            <td style="text-align: center;">
                                                {{ $item->Standard31_mark }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>استراتيجيات التعلم النشط </td>
                                            @if($item->Standard32==1)
                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                                    value="1" checked> </td>
                                                    @else
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                                        value="1" > </td>
                                                    @endif

                                                    @if($item->Standard32==2)
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                                        value="2" checked> </td>
                                                            @else
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                                                value="2"> </td>
                                                            @endif

                                                            @if($item->Standard32==3)
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                                                value="3" checked> </td>
                                                                    @else
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                                                        value="3"> </td>
                                                                    @endif
                                                                    @if($item->Standard32==4)
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                                                        value="4" checked> </td>
                                                                            @else
                                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard32[]"
                                                                                value="4"> </td>
                                                                            @endif
                                            <td style="text-align: center;">
                                                {{ $item->Standard32_mark }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>مشاركة الطلبة وتعزيز تفاعلهم </td>
                                            @if($item->Standard33==1)
                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                                    value="1" checked> </td>
                                                    @else
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                                        value="1" > </td>
                                                    @endif

                                                    @if($item->Standard33==2)
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                                        value="2" checked> </td>
                                                            @else
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                                                value="2"> </td>
                                                            @endif

                                                            @if($item->Standard33==3)
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                                                value="3" checked> </td>
                                                                    @else
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                                                        value="3"> </td>
                                                                    @endif
                                                                    @if($item->Standard33==4)
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                                                        value="4" checked> </td>
                                                                            @else
                                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard33[]"
                                                                                value="4"> </td>
                                                                            @endif
                                            <td style="text-align: center;">
                                                {{ $item->Standard33_mark }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th rowspan="1" colspan="1" style="text-align: center;">المعيار 4 &#8758; كفايات التخصص
                                            </th>
                                            <th rowspan="1" colspan="1">غير مقبول </th>
                                            <th rowspan="1" colspan="1">مقبول </th>
                                            <th rowspan="1" colspan="1">جيد </th>
                                            <th rowspan="1" colspan="1">متميز </th>
                                            <th rowspan="1" colspan="1" style="text-align: center;"> / 48</th>
                                        </tr>
                                        <tr>
                                            <td>احكام المادة العلمية </td>
                                            @if($item->Standard41==1)
                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                                    value="1" checked> </td>
                                                    @else
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                                        value="1" > </td>
                                                    @endif

                                                    @if($item->Standard41==2)
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                                        value="2" checked> </td>
                                                            @else
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                                                value="2"> </td>
                                                            @endif

                                                            @if($item->Standard41==3)
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                                                value="3" checked> </td>
                                                                    @else
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                                                        value="3"> </td>
                                                                    @endif
                                                                    @if($item->Standard41==4)
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                                                        value="4" checked> </td>
                                                                            @else
                                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard41[]"
                                                                                value="4"> </td>
                                                                            @endif
                                            <td style="text-align: center;">
                                                {{ $item->Standard41_mark }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>توضيح اهداف الدرس للطلبة </td>
                                            @if($item->Standard42==1)
                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                                    value="1" checked> </td>
                                                    @else
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                                        value="1" > </td>
                                                    @endif

                                                    @if($item->Standard42==2)
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                                        value="2" checked> </td>
                                                            @else
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                                                value="2"> </td>
                                                            @endif

                                                            @if($item->Standard42==3)
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                                                value="3" checked> </td>
                                                                    @else
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                                                        value="3"> </td>
                                                                    @endif
                                                                    @if($item->Standard42==4)
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                                                        value="4" checked> </td>
                                                                            @else
                                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard42[]"
                                                                                value="4"> </td>
                                                                            @endif
                                            <td style="text-align: center;">
                                                {{ $item->Standard42_mark }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>توضيح المفاهيم والمصطلحات الجديدة </td>
                                            @if($item->Standard43==1)
                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                                    value="1" checked> </td>
                                                    @else
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                                        value="1" > </td>
                                                    @endif

                                                    @if($item->Standard43==2)
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                                        value="2" checked> </td>
                                                            @else
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                                                value="2"> </td>
                                                            @endif

                                                            @if($item->Standard43==3)
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                                                value="3" checked> </td>
                                                                    @else
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                                                        value="3"> </td>
                                                                    @endif
                                                                    @if($item->Standard43==4)
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                                                        value="4" checked> </td>
                                                                            @else
                                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard43[]"
                                                                                value="4"> </td>
                                                                            @endif
                                            <td style="text-align: center;">
                                                {{ $item->Standard43_mark }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>تفعيل التكنلوجيا والوسائل التعليمية الحديثة التي تحقق الشروط التربوية </td>
                                            @if($item->Standard44==1)
                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                                    value="1" checked> </td>
                                                    @else
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                                        value="1" > </td>
                                                    @endif

                                                    @if($item->Standard44==2)
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                                        value="2" checked> </td>
                                                            @else
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                                                value="2"> </td>
                                                            @endif

                                                            @if($item->Standard44==3)
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                                                value="3" checked> </td>
                                                                    @else
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                                                        value="3"> </td>
                                                                    @endif
                                                                    @if($item->Standard44==4)
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                                                        value="4" checked> </td>
                                                                            @else
                                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard44[]"
                                                                                value="4"> </td>
                                                                            @endif
                                            <td style="text-align: center;">
                                                {{ $item->Standard44_mark }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>مراعاة الفروق الفردية للطلبة </td>
                                            @if($item->Standard45==1)
                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                                    value="1" checked> </td>
                                                    @else
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                                        value="1" > </td>
                                                    @endif

                                                    @if($item->Standard45==2)
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                                        value="2" checked> </td>
                                                            @else
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                                                value="2"> </td>
                                                            @endif

                                                            @if($item->Standard45==3)
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                                                value="3" checked> </td>
                                                                    @else
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                                                        value="3"> </td>
                                                                    @endif
                                                                    @if($item->Standard45==4)
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                                                        value="4" checked> </td>
                                                                            @else
                                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard45[]"
                                                                                value="4"> </td>
                                                                            @endif
                                            <td style="text-align: center;">
                                                {{ $item->Standard45_mark }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>التقويم المرحلي </td>
                                            @if($item->Standard46==1)
                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                                    value="1" checked> </td>
                                                    @else
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                                        value="1" > </td>
                                                    @endif

                                                    @if($item->Standard46==2)
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                                        value="2" checked> </td>
                                                            @else
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                                                value="2"> </td>
                                                            @endif

                                                            @if($item->Standard46==3)
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                                                value="3" checked> </td>
                                                                    @else
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                                                        value="3"> </td>
                                                                    @endif
                                                                    @if($item->Standard46==4)
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                                                        value="4" checked> </td>
                                                                            @else
                                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard46[]"
                                                                                value="4"> </td>
                                                                            @endif
                                            <td style="text-align: center;">
                                                {{ $item->Standard46_mark }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>طرح اسئلة تأملية لتنمية مهارات التفكير العليا </td>
                                            @if($item->Standard47==1)
                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                                    value="1" checked> </td>
                                                    @else
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                                        value="1" > </td>
                                                    @endif

                                                    @if($item->Standard47==2)
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                                        value="2" checked> </td>
                                                            @else
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                                                value="2"> </td>
                                                            @endif

                                                            @if($item->Standard47==3)
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                                                value="3" checked> </td>
                                                                    @else
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                                                        value="3"> </td>
                                                                    @endif
                                                                    @if($item->Standard47==4)
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                                                        value="4" checked> </td>
                                                                            @else
                                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard47[]"
                                                                                value="4"> </td>
                                                                            @endif
                                            <td style="text-align: center;">
                                                {{ $item->Standard47_mark }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>التقويم النهائي </td>
                                            @if($item->Standard48==1)
                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                                    value="1" checked> </td>
                                                    @else
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                                        value="1" > </td>
                                                    @endif

                                                    @if($item->Standard48==2)
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                                        value="2" checked> </td>
                                                            @else
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                                                value="2"> </td>
                                                            @endif

                                                            @if($item->Standard48==3)
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                                                value="3" checked> </td>
                                                                    @else
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                                                        value="3"> </td>
                                                                    @endif
                                                                    @if($item->Standard48==4)
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                                                        value="4" checked> </td>
                                                                            @else
                                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard48[]"
                                                                                value="4"> </td>
                                                                            @endif
                                            <td style="text-align: center;">

                                                        {{ $item->Standard48_mark }}

                                            </td>
                                        </tr>

                                        <tr>
                                            <th rowspan="1" colspan="1" style="text-align: center;">المعيار 5 &#8758;   تعزيز السلوكيات
                                            </th>
                                            <th rowspan="1" colspan="1">غير مقبول </th>
                                            <th rowspan="1" colspan="1">مقبول </th>
                                            <th rowspan="1" colspan="1">جيد </th>
                                            <th rowspan="1" colspan="1">متميز </th>
                                            <th rowspan="1" colspan="1" style="text-align: center;"> / 12</th>
                                        </tr>
                                        <tr>
                                            <td>الربط بالحياة العملية </td>
                                            @if($item->Standard51==1)
                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                                    value="1" checked> </td>
                                                    @else
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                                        value="1" > </td>
                                                    @endif

                                                    @if($item->Standard51==2)
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                                        value="2" checked> </td>
                                                            @else
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                                                value="2"> </td>
                                                            @endif

                                                            @if($item->Standard51==3)
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                                                value="3" checked> </td>
                                                                    @else
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                                                        value="3"> </td>
                                                                    @endif
                                                                    @if($item->Standard51==4)
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                                                        value="4" checked> </td>
                                                                            @else
                                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard51[]"
                                                                                value="4"> </td>
                                                                            @endif
                                            <td style="text-align: center;">

                                                      {{ $item->Standard51_mark }}

                                        </tr>
                                        <tr>
                                            <td>تعزيز القيم والسلوكيات الايجابية </td>
                                            @if($item->Standard52==1)
                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                                    value="1" checked> </td>
                                                    @else
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                                        value="1" > </td>
                                                    @endif

                                                    @if($item->Standard52==2)
                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                                        value="2" checked> </td>
                                                            @else
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                                                value="2"> </td>
                                                            @endif

                                                            @if($item->Standard52==3)
                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                                                value="3" checked> </td>
                                                                    @else
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                                                        value="3"> </td>
                                                                    @endif
                                                                    @if($item->Standard52==4)
                                                                    <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                                                        value="4" checked> </td>
                                                                            @else
                                                                            <td style="text-align: center;"> <input type="radio" id="tod22" name="Standard52[]"
                                                                                value="4"> </td>
                                                                            @endif
                                            <td style="text-align: center;">

                                                    {{ $item->Standard52_mark }}

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>




                    </div>
                    </div>
            </div>

            <!--end warp-->
            <!-- end card 2-->

            <!-- end form -->

        </div><!-- end container-->
        </div>


        <script>

                    const input = document.getElementById('divIdToPrint');
              html2canvas(input)
                    .then((canvas) => {
                      const imgData = canvas.toDataURL('image/png');
                      const pdf = new jsPDF("p","mm","a4");
                    //   pdf.addImage(imgData,  'JPEG', 0, 0, width, height);
                      var width = pdf.internal.pageSize.getWidth;
            var height = pdf.internal.pageSize.getHeight;
            // pdf.addPage([width, height], "p");



            pdf.addImage(imgData, 'png', 20, 1,);

                      pdf.save("download.pdf");
                })
                </script>


    <!-- end form for question-->
    <script src="{{ asset('show-class/vendor/jquery/jquery-3.2.1.min.js')}}"></script>



    <!--===============================================================================================-->
    <script src="{{ asset('show-class/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('show-class/vendor/bootstrap/js/popper.js')}}"></script>
    <script src="{{ asset('show-class/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('show-class/vendor/select2/select2.min.js')}}"></script>
    <!--===============================================================================================-->


    <!--===============================================================================================-->
    <script src="{{ asset('show-class/js/main.js')}}"></script>

</body>

</html>
