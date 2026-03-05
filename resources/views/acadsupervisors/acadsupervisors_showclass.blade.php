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
       .breadcrumbs {
 
  border-radius: 0.3rem;
  display: inline-flex;
  overflow: hidden;
  direction: rtl !important;
}

.breadcrumbs__item {
 
  color: #f38639;
  outline: none;
  padding: 0.75em 0.75em 0.75em 1.25em;
  position: relative;
  text-decoration: none;
  transition: background 0.2s linear;
}

.breadcrumbs__item:hover:after,
.breadcrumbs__item:hover {
  background: #edf1f5;
  color: black !important;
}

.breadcrumbs__item:focus:after,
.breadcrumbs__item:focus,
.breadcrumbs__item.is-active:focus {
  background: #e2e9e708;
  color: #fff;
}

.breadcrumbs__item:after,
.breadcrumbs__item:before {
  background: #fff;
  bottom: 0;
  clip-path: polygon(50% 50%, -50% -50%, 0 100%);
  content: "";
  left: 100%;
  position: absolute;
  top: 0;
  transition: background 0.2s linear;
  width: 1.5em;
  z-index: 1;
}

.breadcrumbs__item:before {
  background: #3971a0;
  margin-left: 1px;
}

.breadcrumbs__item:last-child {
  border-right: none;
}

.breadcrumbs__item.is-active {
    background: #e2e9e708;
    font-weight: bold;
    color: #3971a0;
}
  
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

<body style=" background-image: url( {{  asset('teachers/images/new2.jpg') }}) ;background-size: cover;
">

 <nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">  تقييم </a>
     <a  href="{{ route('dashboard.acadsupervisor_teacher',[$room->id,$teacher->id, $lesson->id ]) }}" class="breadcrumbs__item "> {{ $teacher->first_name }}  {{ $teacher->last_name }}   </a>
    <a  href="{{ route('dashboard.acadsupervisor_subject',$room->id ) }}" class="breadcrumbs__item ">{{ $classes->name }} / {{$room->name}}   </a>
     <a   href="{{ route('dashboard.acadsupervisor') }}" class="breadcrumbs__item ">الواجهة الرئيسية 
</a>
</nav>


        <div class="container-login100">

            <div class="wrap-login100">
                <div class="grid-container" style="margin-top: -30px;">
                    <div class="Row" style="margin-top:-30px">
                        <div class="Column">
                            <div class="select" style=" border-radius: 5px; float: left;width: 200px;">
                                <select class="download">
                                    <option value="1"> تنزيل صفحة التقييم </option>
                                    <option value="3">تنزيل صفحة </option>
                                    <option value="4">تنزيل كامل التقييم </option>
                                </select>
                            </div>
                        </div>
                        &nbsp;
                        <div class="Column">
                            <div class="search">
                                <input class="search__input" id="search" type="date" placeholder="البحث .." />
                                <button class="fa fa-search search__button" id="search1"></button>
                            </div>

                        </div>
                    </div>
                </div>

                <br>
                <br>


                <input  hidden  id="lesson_name"  value="{{ $lesson->name }}">
                <input   hidden id="class_id"   name="class_id" value="{{ $classes->id }}">
                <input   hidden  id="lesson_id"   name="lesson_id" value="{{ $lesson->id }}">
                <input   hidden id="teacher_id"  name="teacher_id" value="{{ $teacher->id }}">
                <input   hidden  id="teacher_name"   value="{{ $teacher->first_name }} {{ $teacher->last_name }}" >


                <h4 style="color: #094e89;"> العام الدراس الحالي {{ $year->name }} </h4>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <h4 style=" color:#f38639; float: right;"> تقييم حصة مشاهدة معلم </h4>
                <br>
                <br>
                <div class="table_data" id="divIdToPrint">
                    @include('acadsupervisors.evaluation')
                    </div>
            </div>

            <!--end warp-->
            <!-- end card 2-->

            <!-- end form -->

        </div><!-- end container-->
        </div>

        <div class="btn"  style="float: left; padding-right: 700px;">
            {{ $evaluation->links() }}
        {{-- <ul >
          <li style="display: inline-block;"> <a href="#" class="btn btn-primary" style="padding-top: 12px;">3</a></li>
          <li style="display: inline-block;"> <a href="#" class="btn btn-primary" style="padding-top: 12px;">2</a></li>
          <li style="display: inline-block;"> <a href="#" class="btn btn-primary" style="padding-top: 12px;">1 </a></li>
        </ul> --}}
      </div>
   <div id="test2">

    </div>

    <div class="Row " style="text-align: right; padding-right:100px">
        <button onclick="buttonPressed()" class="btn btn-primary " style="margin:0 auto; width: 200px; height:40px;margin-top: 60px;
    background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));;"> اضافة تقييم
        </button>
    </div>
    <br>
    <br>

    <!-- end form for question-->
    <script src="{{ asset('show-class/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
    <script>

//         const input = document.getElementById('divIdToPrint');
//   html2canvas(input)
//         .then((canvas) => {
//           const imgData = canvas.toDataURL('image/png');
//           const pdf = new jsPDF("p","mm","a3");
//         //   pdf.addImage(imgData,  'JPEG', 0, 0, width, height);
//           var width = pdf.internal.pageSize.getWidth;
// var height = pdf.internal.pageSize.getHeight;
// // pdf.addPage([width, height], "p");
// pdf.addFont('Helvetica', 'Helvetica', 'normal')
// pdf.setFont('Helvetica')
// pdf.setFontSize(80);

// pdf.addImage(imgData, 'png', 0, 1,);

//           pdf.save("download.pdf");
//     })
    </script>
    <script>


          $(document).on('change', '.download', function () {
        if($(this).val()==3){
            $('#buttondown').show();
            $('#buttondown1').hide();

        }
    else{
        $('#buttondown1').show();
        $('#buttondown').hide();

    }

    })
$(document).on('click', '#search1', function () {

var lect=$('#search').val();
        var class_id=$('#class_id').val();
        var lesson_id=$('#lesson_id').val();
        var teacher_id=$('#teacher_id').val();


                var data={
                        "search":lect,
                        "class_id":class_id,
                        "lesson_id":lesson_id,
                        "teacher_id":teacher_id,

                    }
                    $('.table1 tbody').empty();
                var url = "{{ URL::to('SMARMANger/dashboard/coordinator/searchdate') }}";
            $.ajax({
                url: url,
                data : data,
                type: "get",
                contentType: 'application/json',
                success: function (data) {
                    console.log(data);

                    $('.table_data').empty().html(data);




                }
            })


})


        var lesson_name=$('#lesson_name').val();
        var lesson_id=$('#lesson_id').val();
        var class_id=$('#class_id').val();
        var teacher_id=$('#teacher_id').val();
        var teacher_name=$('#teacher_name').val();

        i = 1;

        const buttonPressed = () => {
            $('#test2').empty();
            document.getElementById("test2").innerHTML +=
                `
                <form  action="{{ route('acadsupervisor.addevaluion') }}"   method="post" >

        @csrf
        <input   hidden id="class_id"   name="class_id" value="${class_id}">
                <input   hidden  id="lesson_id"   name="lesson_id" value="${lesson_id}">
                <input   hidden id="teacher_id"  name="teacher_id" value="${teacher_id}">
		<div class="container-login100" >

			<div class="wrap-login100"  >

               <div class="data-card" style="margin: 0 auto;" id="test">
                <div class="text pl-3">
                <small style="color: red;"
                data-aos="zoom-in-down" data-aos-duration="1000" data-aos-delay="600"> يضع المقيمون اشارة تحت البنود التالية(غيرمقبول , مقبول , جيد , ممتاز ) ووضع مجموع درجات المعيار  والملاحظات في الحقل الأخير </small>
                <br>
                <br>

                <div class="Row " >

                      <div class="Column">
                        <div class="page" style="margin-top: -60px;">
                          <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input id="first-name" class="field__input" placeholder=""  type="number"  name="final_grade" style="width: 100px; text-align: center;">
                            <span class="field__label-wrap" aria-hidden="true">
                              <span class="field__label"></span>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="Column">
                        <h5 style="color: gray;">الدرجة النهائية </h5>

                      </div>
                      <div class="Column"></div>
                      <div class="Column"></div>
                      <div class="Column"></div>
                      <div class="Column"></div>
                      <div class="Column"></div>


                     </div><!-- end row -->

                   <div class="grid-container" >
                     <div class="Row" style="margin-left: 70px;"><!--row-->


                <div class="Column">


                </div>
                 <div class="Column" >
                 <div class="page" style="margin-top: -60px;">
                  <div class="field field_v1">
                    <label for="first-name" class="ha-screen-reader"></label>
                    <input id="first-name" class="field__input" placeholder="" readonly  value="${lesson_name}" style="width: 150px;" >
                    <span class="field__label-wrap" aria-hidden="true">
                      <span class="field__label"></span>
                    </span>
                  </div>
                </div>
                     </div>
                   <div class="Column">
                      <h5 style="width: 100px;color: gray;"> : المادة </h5>
                 </div>

                 <div class="Column" >
                  <div class="page"  style="margin-top: -60px; ">
                  <div class="field field_v1">
                    <label for="first-name" class="ha-screen-reader"></label>
                    <input id="first-name" class="field__input" placeholder="" readonly value="${teacher_name}" style="width: 150px;"  >
                    <span class="field__label-wrap" aria-hidden="true">
                      <span class="field__label"></span>
                    </span>
                  </div>
                </div>
              </div>
                 <div class="Column">
                 <h5 style="width: 100px;color: gray;">:الاسم </h5>
               </div>





                 </div> <!--end row -->
                   </div><!-- end grid-->

                   <div class="grid-container"  >
                    <div class="Row" style="margin-left: 90px;"><!--row-->




                <div class="Column">
                <div class="page" style="margin-top: -30px;">
                 <div class="field field_v1">
                   <label  class="ha-screen-reader"></label>
                   <input  class="field__input"  style="width: 160px;" required name="date"  type="date" >
                   <span class="field__label-wrap" aria-hidden="true">
                     <span class="field__label"></span>
                   </span>
                 </div>
               </div>

                    </div>


                  <div class="Column">
                     <h5 style="width: 100px;color: gray;"> : تاريخ التقييم </h5>
                </div>


                <div class="Column" >
                 <div class="page"  style="margin-top: -30px;">
                 <div class="field field_v1">
                   <label class="ha-screen-reader"></label>
                   <input  class="field__input" placeholder="" name="title" style="width: 180px;"  >
                   <span class="field__label-wrap" aria-hidden="true">
                     <span class="field__label"></span>
                   </span>
                 </div>
               </div>
             </div>

                <div class="Column">
                <h5 style="width: 100px;color: gray;">: الموضوع</h5>
              </div>
                </div> <!--end row -->
                  </div><!-- end grid-->

            <!-- end new-->
             </div>
           </div>
             <!-- end 1 card -->
             <!-- start card 2-->
                  <br>
                  <br>
                <div class="data-card" style="margin: 0 auto ; margin-top: 30px;">
                  <div class="text pl-3">
                    <table>
                      <thead>
                      <tr>
                        <th rowspan="1"  colspan="1"  style="text-align: center;">المجالات </th>
                        <th rowspan="1" colspan="4" style="text-align: center;">مستوى الأداء </th>
                        <th rowspan="1" colspan="1">ملاحظات </th>
                      </tr>
                      <tr>
                        <th rowspan="1" colspan="1" style="text-align: center;">المعيار 1 : اللغة</th>
                        <th rowspan="1" colspan="1">غير مقبول </th>
                        <th rowspan="1" colspan="1">مقبول  </th>
                        <th rowspan="1" colspan="1">جيد </th>
                        <th rowspan="1" colspan="1">متميز </th>
                        <th rowspan="1" colspan="1" style="text-align: center;"> / 8</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr>
                        <td>سلامة اللغة والتعبير الصوتي تبعا للموقف التعليمي</td>
                        <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard1[]"" value="1"> </td>
                        <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard1[]" value="2"> </td>
                        <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard1[]" value="3"> </td>
                        <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard1[]" value="4"> </td>                        <td> <div class="page"  style="margin-top: -30px;">
                          <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input id="first-name" class="field__input" placeholder=""  type="number" name="Standard1_mark" style="width: 100px; text-align: center;"  >
                            <span class="field__label-wrap" aria-hidden="true">
                              <span class="field__label"></span>
                            </span>
                          </div>
                        </div> </td>
                      </tr>
                      <tr>
                        <th rowspan="1" colspan="1" style="text-align: center;">المعيار 2 : التمهيد </th>
                        <th rowspan="1" colspan="1">غير مقبول </th>
                        <th rowspan="1" colspan="1">مقبول  </th>
                        <th rowspan="1" colspan="1">جيد </th>
                        <th rowspan="1" colspan="1">متميز </th>
                        <th rowspan="1" colspan="1" style="text-align: center;"> / 8</th>
                      </tr>
                       <tr>
                        <td>التهيئة الحافزة والدخول الى الدرس </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard2[]" value="1"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard2[]" value="2"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard2[]" value="3"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard2[]" value="4"> </td>
                         <td style="text-align: center;"> <div class="page"  style="margin-top: -30px;">
                          <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input id="first-name" class="field__input" placeholder=""  name="Standard2_mark" type="number" style="width: 100px; text-align: center;"  >
                            <span class="field__label-wrap" aria-hidden="true">
                              <span class="field__label"></span>
                            </span>
                          </div>
                        </div></td>
                       </tr>
                       <tr>
                        <th rowspan="1" colspan="1" style="text-align: center;">المعيار 3 : الادارة الصفية </th>
                        <th rowspan="1" colspan="1">غير مقبول </th>
                        <th rowspan="1" colspan="1">مقبول  </th>
                        <th rowspan="1" colspan="1">جيد </th>
                        <th rowspan="1" colspan="1">متميز </th>
                        <th rowspan="1" colspan="1" style="text-align: center;"> / 24 </th>
                      </tr>
                      <tr>
                        <td>حيوية المعلم ولغة الجسد </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard31[]" value="1"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard31[]" value="2"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard31[]" value="3"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard31[]" value="4"> </td>
                         <td style="text-align: center;"> <div class="page"  style="margin-top: -30px;">
                          <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input id="first-name" class="field__input" placeholder="" name="Standard31_mark" type="number" style="width: 100px; text-align: center;"  >
                            <span class="field__label-wrap" aria-hidden="true">
                              <span class="field__label"></span>
                            </span>
                          </div>
                        </div></td>
                       </tr>
                       <tr>
                        <td>استراتيجيات التعلم النشط </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard32[]" value="1"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard32[]" value="2"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard32[]" value="3"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard32[]" value="4"> </td>
                         <td style="text-align: center;"> <div class="page"  style="margin-top: -30px;">
                          <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input id="first-name" class="field__input" placeholder="" name="Standard32_mark" type="number" style="width: 100px; text-align: center;"  >
                            <span class="field__label-wrap" aria-hidden="true">
                              <span class="field__label"></span>
                            </span>
                          </div>
                        </div></td>
                       </tr>
                       <tr>
                        <td>مشاركة الطلبة وتعزيز تفاعلهم </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard33[]" value="1"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard33[]" value="2"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard33[]" value="3"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard33[]" value="4"> </td>
                         <td style="text-align: center;"> <div class="page"  style="margin-top: -30px;">
                          <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input id="first-name" class="field__input" placeholder="" name="Standard33_mark" type="number" style="width: 100px; text-align: center;"  >
                            <span class="field__label-wrap" aria-hidden="true">
                              <span class="field__label"></span>
                            </span>
                          </div>
                        </div></td>
                       </tr>
                       <tr>
                        <th rowspan="1" colspan="1" style="text-align: center;">المعيار 4 : كفايات التخصص</th>
                        <th rowspan="1" colspan="1">غير مقبول </th>
                        <th rowspan="1" colspan="1">مقبول  </th>
                        <th rowspan="1" colspan="1">جيد </th>
                        <th rowspan="1" colspan="1">متميز </th>
                        <th rowspan="1" colspan="1" style="text-align: center;"> / 48</th>
                      </tr>
                      <tr>
                        <td>احكام المادة العلمية </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard41[]" value="1"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard41[]" value="2"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard41[]" value="3"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard41[]" value="4"> </td>
                         <td style="text-align: center;"> <div class="page"  style="margin-top: -30px;">
                          <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input id="first-name" class="field__input" placeholder="" name="Standard41_mark" type="number"  style="width: 100px; text-align: center;"  >
                            <span class="field__label-wrap" aria-hidden="true">
                              <span class="field__label"></span>
                            </span>
                          </div>
                        </div></td>
                       </tr>
                       <tr>
                        <td>توضيح اهداف الدرس للطلبة </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard42[]" value="1"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard42[]" value="2"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard42[]" value="3"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard42[]" value="4"> </td>
                         <td style="text-align: center;"> <div class="page"  style="margin-top: -30px;">
                          <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input id="first-name" class="field__input" placeholder=""  name="Standard42_mark" type="number"  style="width: 100px; text-align: center;"  >
                            <span class="field__label-wrap" aria-hidden="true">
                              <span class="field__label"></span>
                            </span>
                          </div>
                        </div></td>
                       </tr>
                       <tr>
                        <td>توضيح المفاهيم والمصطلحات الجديدة </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard43[]" value="1"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard43[]" value="2"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard43[]" value="3"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard43[]" value="4"> </td>
                         <td style="text-align: center;"> <div class="page"  style="margin-top: -30px;">
                          <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input id="first-name" class="field__input" placeholder="" name="Standard43_mark" type="number" style="width: 100px; text-align: center;"  >
                            <span class="field__label-wrap" aria-hidden="true">
                              <span class="field__label"></span>
                            </span>
                          </div>
                        </div></td>
                       </tr>
                       <tr>
                        <td>تفعيل التكنلوجيا والوسائل التعليمية الحديثة  التي تحقق الشروط التربوية </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard44[]" value="1"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard44[]" value="2"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard44[]" value="3"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard44[]" value="4"> </td>
                         <td style="text-align: center;"> <div class="page"  style="margin-top: -30px;">
                          <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input id="first-name" class="field__input" placeholder=""  name="Standard44_mark" type="number" style="width: 100px; text-align: center;"  >
                            <span class="field__label-wrap" aria-hidden="true">
                              <span class="field__label"></span>
                            </span>
                          </div>
                        </div></td>
                       </tr>
                       <tr>
                        <td>مراعاة الفروق الفردية للطلبة </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard45[]" value="1"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard45[]" value="2"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard45[]" value="3"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard45[]" value="4"> </td>
                         <td style="text-align: center;"> <div class="page"  style="margin-top: -30px;">
                          <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input id="first-name" class="field__input" placeholder=""  name="Standard45_mark" type="number" style="width: 100px; text-align: center;"  >
                            <span class="field__label-wrap" aria-hidden="true">
                              <span class="field__label"></span>
                            </span>
                          </div>
                        </div></td>
                       </tr>
                       <tr>
                        <td>التقويم المرحلي </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard46[]" value="1"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard46[]" value="2"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard46[]" value="3"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard46[]" value="4"> </td>
                         <td style="text-align: center;"> <div class="page"  style="margin-top: -30px;">
                          <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input id="first-name" class="field__input" placeholder="" name="Standard46_mark"  type="number" style="width: 100px; text-align: center;"  >
                            <span class="field__label-wrap" aria-hidden="true">
                              <span class="field__label"></span>
                            </span>
                          </div>
                        </div></td>
                       </tr>
                       <tr>
                        <td>طرح اسئلة تأملية لتنمية مهارات التفكير العليا </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard47[]" value="1"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard47[]" value="2"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard47[]" value="3"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard47[]" value="4"> </td>
                         <td style="text-align: center;"> <div class="page"  style="margin-top: -30px;">
                          <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input id="first-name" class="field__input" placeholder=""  name="Standard47_mark"  type="number"  style="width: 100px; text-align: center;"  >
                            <span class="field__label-wrap" aria-hidden="true">
                              <span class="field__label"></span>
                            </span>
                          </div>
                        </div></td>
                       </tr>
                       <tr>
                        <td>التقويم النهائي </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard48[]"" value="1"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard48[]"" value="2"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard48[]"" value="3"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard48[]"" value="4"> </td>
                         <td style="text-align: center;"> <div class="page"  style="margin-top: -30px;">
                          <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input id="first-name" class="field__input" placeholder="" name="Standard48_mark" type="number"  style="width: 100px; text-align: center;"  >
                            <span class="field__label-wrap" aria-hidden="true">
                              <span class="field__label"></span>
                            </span>
                          </div>
                        </div></td>
                       </tr>

                       <tr>
                        <th rowspan="1" colspan="1" style="text-align: center;">المعيار 5: تعزيز السلوكيات </th>
                        <th rowspan="1" colspan="1">غير مقبول </th>
                        <th rowspan="1" colspan="1">مقبول  </th>
                        <th rowspan="1" colspan="1">جيد </th>
                        <th rowspan="1" colspan="1">متميز </th>
                        <th rowspan="1" colspan="1" style="text-align: center;"> / 12</th>
                      </tr>
                      <tr>
                        <td>الربط بالحياة العملية </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard51[]" value="1"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard51[]" value="2"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard51[]" value="3"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard51[]" value="4"> </td>
                         <td style="text-align: center;"> <div class="page"  style="margin-top: -30px;">
                          <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input id="first-name" class="field__input" placeholder="" name="Standard51_mark"  type="number" style="width: 100px; text-align: center;"  >
                            <span class="field__label-wrap" aria-hidden="true">
                              <span class="field__label"></span>
                            </span>
                          </div>
                        </div></td>
                       </tr>
                       <tr>
                        <td>تعزيز القيم والسلوكيات الايجابية </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard52[]" value="1"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard52[]" value="2"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard52[]" value="3"> </td>
                         <td style="text-align: center;">  <input type="radio" id="tod22" name="Standard52[]" value="4"> </td>
                         <td style="text-align: center;"> <div class="page"  style="margin-top: -30px;">
                          <div class="field field_v1">
                            <label for="first-name" class="ha-screen-reader"></label>
                            <input id="first-name" class="field__input" placeholder="" name="Standard52_mark"  type="number" style="width: 100px; text-align: center;"  >
                            <span class="field__label-wrap" aria-hidden="true">
                              <span class="field__label"></span>
                            </span>
                          </div>
                        </div></td>
                       </tr>
                      </tbody>
                    </table>
                  </div>

                    </div>

                    <div class="Row " style="margin: 0 auto ; text-align: center;">
                    <button  class="btn btn-primary "
                    style="margin:0 auto; width: 200px; height:40px;margin-top: 100px;
                    background-color: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196));;"> حفظ
                    </button>
                  </div>

                </div><!--end warp-->
             <!-- end card 2-->

     <!-- end form -->

			</div><!-- end container-->

</form>

            `
            +
                i + "";
            i++;
        }
    </script>



    <script src="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <!--===============================================================================================-->
    <script src="{{ asset('show-class/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('show-class/vendor/bootstrap/js/popper.js')}}"></script>
    <script src="{{ asset('show-class/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('show-class/vendor/select2/select2.min.js')}}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('show-class/vendor/tilt/tilt.jquery.min.js')}}"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>

    <!--===============================================================================================-->
    <script src="{{ asset('show-class/js/main.js')}}"></script>

</body>

</html>
