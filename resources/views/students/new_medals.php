@extends('students.layouts.app4')
@section('title')
الأوسمة
@endsection
@section('css')
     <style>
	 /*
	/*table */
table {
  border-spacing: 1;
  border-collapse: collapse;
  background: linear-gradient(to right top, #2c71ad 50%, rgb(132, 167, 196));
  border-radius: 6px;
  overflow: hidden;
  max-width: 990px;
  width: 100%;
  margin: 0 auto;
  position: relative;
  margin-top: -170px;
  margin-bottom: 100px;
  direction: rtl;


}
table * {
  position: relative;
}
table td, table th {
  padding-left: 8px;

}
table thead tr {
  height: 60px;
  background: white;
  font-size: 22px;
  color: #f38639;
  border-style: solid ;
  border-color: #094e89;


}
table tbody tr {
  height: 48px;
  font-size: 18px;
  /*border-bottom: 1px solid #f38639;*/

  color: white;
}
table tbody tr:last-child {
  border: 0;
  border-radius: 15px;
}
table td, table th {
  text-align: center;
}
table td.l, table th.l {
  text-align: center;
}
table td.c, table th.c {
  text-align: center;
}
table td.r, table th.r {
  text-align: center;
}
@media screen and (max-width: 35.5em) {
  table {
    display: block;
  }
  table > *, table tr, table td, table th {
    display: block;
  }
  table thead {
    display: none;
  }
  table tbody tr {
    height: auto;
    padding: 8px 0;
  }
  table tbody tr td {
    padding-right: 45%;
    margin-bottom: 12px;
  }
  table tbody tr td:last-child {
    margin-bottom: 0;
  }
  table tbody tr td:before {
    position: absolute;
    font-weight: 700;
    width: 40%;
    right: 10px;
    top: 0;
  }
  table tbody tr td:nth-child(1):before {
    content: "اسم الاستاذ ";
  }
  table tbody tr td:nth-child(2):before {
    content: "المادة ";
  }
  table tbody tr td:nth-child(3):before {
    content: "تاريخ المنح ";
  }
  table tbody tr td:nth-child(4):before {
    content: "الأوسمة";
  }

}


/* end table */
/*select and option */
:root {
  --background-gradient: linear-gradient(30deg, #4986fc 30%, #4986fc);
  --gray: #2c71ad;
  --darkgray: #2c71ad;
}

select {
  /* Reset Select */
  appearance: none;
  outline: 0;
  border: 0;
  box-shadow: none;
  /* Personalize */
  flex: 1;
  padding: 0 1em;
  color: white;
  background-color: var(--darkgray);
  background-image: none;
  cursor: pointer;


}
/* Remove IE arrow */
select::-ms-expand {
  display: none;
}
/* Custom Select wrapper */
.select {
  position: relative;
  display: flex;
  width: 20em;
  height: 3em;
  border-radius: .25em;
  overflow: hidden;
  color: #f38639;
  float: right;
  text-align: center;


}
/* Arrow */
.select::after {
  content: '\25BC';
  position: absolute;
  top: 0;
  right: 0;
  padding: 1em;
  background-color: #f38639;
  transition: .25s all ease;
  pointer-events: none;
  float: right;
  text-align: center;

}
/* Transition */
.select:hover::after {
  color: #f38639;
  text-align: center;
  float: right;
}
.img1{
  height: 80px;
  width: 80px;
}

/*css for cards slide*/


/* Please ❤ this if you like it! */


/* ========================================= *
		        BEST VIEWED FULLSCREEN
   https://codepen.io/ig_design/full/NWxwBvw
 * ========================================= */
@import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900');



.section{
  position: relative;
  width: 100%;
  display: block;
}
.full-height{
  min-height: 100vh;
}
.over-hide{
  overflow: hidden;
}
.padding-tb{
  padding: 100px 0;
}
[type="radio"]:checked,
[type="radio"]:not(:checked){
  position: absolute;
  left: -9999px;

}
.checkbox:checked + label,
.checkbox:not(:checked) + label{

  position: relative;
  cursor: pointer;
  margin: 0 auto;
  text-align: center;
  margin-right: 6px;
  margin-left: 6px;
  display: inline-block;
  width: 50px;
  height: 50px;
  border: 3px solid #bdc3c7;
  background-size: cover;
  background-position: center;
  box-sizing: border-box;
  -webkit-transition: all 0.2s ease;
  transition: all 0.2s ease;
  background-image: url('{{ asset('student-UI/gold.png') }}');
  animation: border-transform 6s linear infinite alternate forwards;
    -webkit-animation-play-state: paused;
    -moz-animation-play-state: paused;
    animation-play-state: paused;
}
.checkbox.scnd + label{
  background-image: url('{{ asset('student-UI/silver.png') }}');
}
.checkbox.thrd + label{
  background-image: url('{{ asset('student-UI/pronze.png') }}');
}
/*.checkbox.foth + label{
  background-image: url('https://assets.codepen.io/1462889/sl4.jpg');
}*/

.checkbox:checked + label{
  border-color: #f38639;
  box-shadow: 0 8px 25px 0 rgba(16,39,112,.3);
  transform: scale(1.3);
    -webkit-animation-play-state: running;
    -moz-animation-play-state: running;
    animation-play-state: running;
}
@keyframes border-transform{
  0%,100% { border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%; }
  14% { border-radius: 40% 60% 54% 46% / 49% 60% 40% 51%; }
  28% { border-radius: 54% 46% 38% 62% / 49% 70% 30% 51%; }
  42% { border-radius: 61% 39% 55% 45% / 61% 38% 62% 39%; }
  56% { border-radius: 61% 39% 67% 33% / 70% 50% 50% 30%; }
  70% { border-radius: 50% 50% 34% 66% / 56% 68% 32% 44%; }
  84% { border-radius: 46% 54% 50% 50% / 35% 61% 39% 65%; }
}

.slider-height-padding {
  padding-top: 440px;
}

.ul {
  position: absolute;
  top: 0;
  left: 0;
  display: block;
  width: 100%;
  z-index: -100;
  padding: 0;
  margin: 0;
  list-style: none;
}
.ul .li {

  position: absolute;
  top: -80px;
  left: 0;
  width: 110%;
  display: block;
  z-index: 100;
  padding: 0;
  margin: 0;
  list-style: none;
  height: 500px;
  border: 5px solid #bdc3c7;
  /*background-size: cover;
  background-position: left;
  background-image: url('{{ asset('student-UI/gold.png') }}');*/
  border-radius: 50%;
  box-sizing: border-box;

  font-weight: 900;
  font-size: 16px;
  letter-spacing: 2px;
  line-height: 2.7;
  color: #343434;
  writing-mode:horizontal-tb;
 opacity: 0;
  pointer-events: none;
  box-shadow: 0 8px 25px 0 rgba(16,39,112,.1);
  -webkit-transition: all 0.5s ease;
  transition: all 0.5s ease;
}
.ul .li span {
  /*mix-blend-mode: difference;*/
  z-index: 999;
}
.ul .li:nth-child(2) {
  /*background-image: url('./news/جديد\ 2-01.png');*/

}
.ul .li:nth-child(3) {
  /*background-image: url('./news/جديد\ 3-01.png');*/
}
/*.ul .li:nth-child(4) {
  background-image: url('https://assets.codepen.io/1462889/sl4.jpg');
}*/


.checkbox.frst:checked ~ .ul .li:nth-child(1) {
  opacity: 1;
  pointer-events: auto;
  border-radius: 16px;
}
.checkbox.scnd:checked ~ .ul .li:nth-child(2) {
  opacity: 1;
  pointer-events: auto;
  border-radius: 16px;
}
.checkbox.thrd:checked ~ .ul .li:nth-child(3) {
  opacity: 1;
  pointer-events: auto;
  border-radius: 16px;
}
/*.checkbox.foth:checked ~ .ul .li:nth-child(4) {
  opacity: 1;
  pointer-events: auto;
  border-radius: 16px;
}*/




@media (max-width: 767px) {
  .slider-height-padding {
    padding-top: 340px;
  }
  .ul .li {
    height: 300px;
    font-size: 13px;
    letter-spacing: 1px;
  }
}

@media (max-width: 575px) {
  .slider-height-padding {
    padding-top: 240px;
  }
  .ul .li {
    height: 200px;
  }
}

/*end card slide */

/*style cards*/
@import url("https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&display=swap");


.container5 {
	display: flex;
	flex-direction: column;
	align-items: center;
}

.container5:hover {
	cursor: pointer;
}

.container5 img {
	/*filter: grayscale();*/
	width: 110px;
	height: 110px;
	border-radius: 50%;
	border: 6px solid whitesmoke;
	box-shadow: 2px 2px 10px 2px rgba(0, 0, 0, 0.5);
	margin-bottom: 1rem;
	transition: filter 0.4s ease-in-out;
}

.container5:hover img {
	filter: none;
}

.title {
	font-family: "Dancing Script", cursive;
	font-size: 1rem;
	color: #f38639;
	position: relative;
  margin-top: -10px;
}

.title::after {
	position: absolute;
	content: "";
	width: 0%;
	height: 4px;
	background-color: #f38639;
	left: 50%;
	bottom: -10px;
	transition: all 0.4s ease-in-out;
}

.container5:hover .title::after {
	width: 100%;
	left: 0;
}






    .tabs {
        left: 50%;
        transform: translateX(-50%);
        position: relative;
        background: linear-gradient(to right top, rgb(32, 5, 151) 20%, rgb(20, 33, 75));
        padding: 20px;
        padding-bottom: 80px;
        width: 80%;
        height: auto;
        box-shadow: 0 8px 10px rgba(0, 0, 0, 0.), 0 5px 7px rgba(0, 0, 0, 0.22);
        border-radius: 10px;
        min-width: 240px;
        direction: rtl;
        margin-bottom: 50px

    }

    .tabs input[name="tab-control"] {
        display: none;
    }

    .tabs .content section h2,
    .tabs ul li label {
        font-family: "Montserrat";
        font-weight: bold;
        font-size: 18px;
        color: #428bff;
    }

    .tabs ul {
        list-style-type: none;
        padding-left: 0;

        flex-direction: row;
        margin-bottom: 10px;
        display: flex;
        justify-content: center;
        /*justify-content: space-between;*/
        align-items: center;
        flex-wrap: wrap;

    }

    .tabs ul li {
        box-sizing: border-box;
        /*flex: 1;*/
        /*width: 25%;*/
        /*padding: 0 0px;*/
        text-align: center;
    }

    .tabs ul li label {
        transition: all 0.3s ease-in-out;
        color:  rgb(70, 67, 126);

        padding: 5px auto;


        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        white-space: nowrap;
        -webkit-touch-callout: none;
    }

    .tabs ul li label br {
        display: none;
    }

    .tabs ul li label svg {
        fill:  rgb(70, 67, 126);
        ;
        height: 1.2em;
        vertical-align: bottom;
        margin-right: 0.2em;
        transition: all 0.2s ease-in-out;
    }

    .tabs ul li label:hover,
    .tabs ul li label:focus,
    .tabs ul li label:active {
        outline: 0;
        color:  #264eb4c9;

    }

    .tabs ul li label:hover svg,
    .tabs ul li label:focus svg,
    .tabs ul li label:active svg {
        fill: #264eb4c9;

    }

    .tabs .slider {
        position: relative;
        width: 25%;
        transition: all 0.33s cubic-bezier(0.38, 0.8, 0.32, 1.07);
    }

    .tabs .slider .indicator {
        position: relative;
        width: 50px;
        max-width: 100%;
        margin: 0 auto;
        height: 4px;
        background: #cc151525;
        border-radius: 1px;
    }

    .tabs .content {
        margin-top: 30px;
    }

    .tabs .content section {
        display: none;
        animation-name: content;
        animation-direction: normal;
        animation-duration: 0.3s;
        animation-timing-function: ease-in-out;
        animation-iteration-count: 1;
        line-height: 1.4;
    }

    .tabs .content section h2 {
        color: white;
        display: none;
    }

    .tabs .content section h2::after {
        content: "";
        position: relative;
        display: block;
        width: 30px;
        height: 3px;
        background: rgb(16, 4, 51);
        margin-top: 5px;
        left: 1px;
    }

    .tabs input[name="tab-control"]:nth-of-type(1):checked~ul>li:nth-child(1)>label {
        cursor: default;
        color: rgb(250, 250, 250);
    }

    .tabs input[name="tab-control"]:nth-of-type(1):checked~ul>li:nth-child(1)>label svg {
        fill: rgb(255, 255, 255);
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(1):checked~ul>li:nth-child(1)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(1):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(1):checked~.content>section:nth-child(1) {
        display: block;
    }

    .tabs input[name="tab-control"]:nth-of-type(2):checked~ul>li:nth-child(2)>label {
        cursor: default;
        color:  rgb(247, 246, 253);
    }

    .tabs input[name="tab-control"]:nth-of-type(2):checked~ul>li:nth-child(2)>label svg {
        fill: rgb(246, 246, 248);
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(2):checked~ul>li:nth-child(2)>label {
            background: rgba(253, 252, 252, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(2):checked~.slider {
        transform: translateX(100%);
    }

    .tabs input[name="tab-control"]:nth-of-type(2):checked~.content>section:nth-child(2) {
        display: block;
    }

    .tabs input[name="tab-control"]:nth-of-type(3):checked~ul>li:nth-child(3)>label {
        cursor: default;
        color: rgb(247, 246, 250);
    }

    .tabs input[name="tab-control"]:nth-of-type(3):checked~ul>li:nth-child(3)>label svg {
        fill: rgb(240, 240, 245);
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(3):checked~ul>li:nth-child(3)>label {
            background: rgba(243, 241, 241, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(3):checked~.slider {
        transform: translateX(200%);
    }

    .tabs input[name="tab-control"]:nth-of-type(3):checked~.content>section:nth-child(3) {
        display: block;
    }

    /*tab 4*/
    .tabs input[name="tab-control"]:nth-of-type(4):checked~ul>li:nth-child(4)>label {
        cursor: default;
        color: rgb(247, 247, 248);
    }

    .tabs input[name="tab-control"]:nth-of-type(4):checked~ul>li:nth-child(4)>label svg {
        fill: rgb(253, 253, 255);
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(4):checked~ul>li:nth-child(4)>label {
            background: rgba(255, 253, 253, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(4):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(4):checked~.content>section:nth-child(4) {
        display: block;
    }

  /*tab 5*/
    .tabs input[name="tab-control"]:nth-of-type(5):checked~ul>li:nth-child(5)>label {
        cursor: default;
        color: rgb(238, 238, 241);
    }

    .tabs input[name="tab-control"]:nth-of-type(5):checked~ul>li:nth-child(5)>label svg {
        fill: rgb(237, 236, 245);
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(5):checked~ul>li:nth-child(5)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(5):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(5):checked~.content>section:nth-child(5) {
        display: block;
    }
     /*tab 6*/
    .tabs input[name="tab-control"]:nth-of-type(6):checked~ul>li:nth-child(6)>label {
        cursor: default;
        color: rgb(235, 234, 247);
    }

    .tabs input[name="tab-control"]:nth-of-type(6):checked~ul>li:nth-child(6)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(6):checked~ul>li:nth-child(6)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(6):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(6):checked~.content>section:nth-child(6) {
        display: block;
    }
     /*tab 7*/
    .tabs input[name="tab-control"]:nth-of-type(7):checked~ul>li:nth-child(7)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(7):checked~ul>li:nth-child(7)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(7):checked~ul>li:nth-child(7)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(7):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(7):checked~.content>section:nth-child(7) {
        display: block;
    }

     /*tab 8*/
    .tabs input[name="tab-control"]:nth-of-type(8):checked~ul>li:nth-child(8)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(8):checked~ul>li:nth-child(8)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(8):checked~ul>li:nth-child(8)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(8):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(8):checked~.content>section:nth-child(8) {
        display: block;
    }

     /*tab 9*/
    .tabs input[name="tab-control"]:nth-of-type(9):checked~ul>li:nth-child(9)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(9):checked~ul>li:nth-child(9)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(9):checked~ul>li:nth-child(9)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(9):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(9):checked~.content>section:nth-child(9) {
        display: block;
    }
     /*tab 10*/
    .tabs input[name="tab-control"]:nth-of-type(10):checked~ul>li:nth-child(10)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(10):checked~ul>li:nth-child(10)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(10):checked~ul>li:nth-child(10)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(10):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(10):checked~.content>section:nth-child(10) {
        display: block;
    }

 /*tab 11*/
    .tabs input[name="tab-control"]:nth-of-type(11):checked~ul>li:nth-child(11)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(11):checked~ul>li:nth-child(11)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(11):checked~ul>li:nth-child(11)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(11):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(11):checked~.content>section:nth-child(11) {
        display: block;
    }

     /*tab 12*/
    .tabs input[name="tab-control"]:nth-of-type(12):checked~ul>li:nth-child(12)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(12):checked~ul>li:nth-child(12)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(12):checked~ul>li:nth-child(12)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(12):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(12):checked~.content>section:nth-child(12) {
        display: block;
    }
       /*tab 13*/
    .tabs input[name="tab-control"]:nth-of-type(13):checked~ul>li:nth-child(13)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(13):checked~ul>li:nth-child(13)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(13):checked~ul>li:nth-child(13)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(13):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(13):checked~.content>section:nth-child(13) {
        display: block;
    }
       /*tab 14*/
    .tabs input[name="tab-control"]:nth-of-type(14):checked~ul>li:nth-child(14)>label {
        cursor: default;
        color: white;
    }

    .tabs input[name="tab-control"]:nth-of-type(14):checked~ul>li:nth-child(14)>label svg {
        fill: white;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(14):checked~ul>li:nth-child(14)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(14):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(14):checked~.content>section:nth-child(14) {
        display: block;
    }

    @keyframes content {
        from {
            opacity: 0;
            transform: translateY(5%);
        }

        to {
            opacity: 1;
            transform: translateY(0%);
        }
    }

    @media (max-width: auto) {
        .tabs ul li label {
            white-space: initial;
        }

        .tabs ul li label br {
            display: initial;
        }

        .tabs ul li label svg {
            height: 1.5em;
        }
    }

    @media (max-width: 600px) {
        .tabs ul li label {
            padding: 5px;
            border-radius: 5px;
        }

        .tabs ul li label span {
            display: none;
        }

        .tabs .slider {
            display: none;
        }

        .tabs .content {
            margin-top: 20px;
        }

        .tabs .content section h2 {
            display: block;
        }
    }

    /*end style tablist*/
    /* cards of marks */
    .cards-list {
        z-index: 0;
        width: 100%;
        display: flex;
        /*justify-content: space-around;*/
        flex-wrap: wrap;
    }

    .card2 {
        margin: 30px auto;
        width: 180px;
        height: 180px;
        border-radius: 15px;
        /*box-shadow: 1px 1px 10px 2px rgba(0,0,0,0.22), -1px -1px 10px 2px rgba(0,0,0,0.20);*/
        cursor: pointer;
        transition: 0.4s;
        border-color: 10px solid white;
    }

    .card2 .card_image {
        width: inherit;
        height: inherit;
        border-radius: 15px;
        border-color: 10px solid white;
    }

    .card2 .card_image img {
        width: inherit;
        height: inherit;
        border-radius: 15px;
        object-fit: cover;
        /* opacity: #f38639 10%;
  border-color: 10px solid white;*/
    }

    .card2 .card_title {
        text-align: center;
        border-radius: 0px 0px 40px 40px;
        font-family: sans-serif;
        font-weight: bold;
        font-size: 30px;
        margin-top: 15px;
        height: 40px;
    }

    .card2:hover {
        border-color: 10px solid white;
        transform: scale(0.9, 0.9);
        box-shadow: 1px 1px 10px 2px rgba(0, 0, 0, 0.22), -1px -1px 10px 2px rgba(0, 0, 0, 0.20);
    }

    .title-white {
        color: white;
    }

    .title-black {
        color: black;
    }

    @media all and (max-width: 500px) {
        .card-list {
            /* On small screens, we are no longer using row direction but column */
            flex-direction: column;
        }
    }



/*end style cards*/


	 </style>


	<section class="hero-wrap hero-wrap-2" style="background-image: url('{{  asset('teachers/ppp1.jpg') }}'); border-bottom-right-radius: 70px 50px;">
		<div class="overlay"></div>
		<div class="container">
			<div class="row no-gutters slider-text align-items-end justify-content-center">
				<div class="col-md-9 ftco-animate pb-5 text-center">
					<p class="breadcrumbs"><span class="mr-2"><!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
					<h1 class="mb-0 bread">   {{$class->name}} / {{ $room->name  }}</h1>
				</div>
			</div>
		</div>
	</section>
  <!-- start new-->





{{-- **************************************************************************************** --}}

<div style="margin-top: 60px; border-top-right-radius: 100px 50px; " id="class">
    <div class="col-md-12 heading-section text-center ftco-animate">
        <span class="subheading"></span>
        <h2 class="mb-4" style="color: #f38639; ">الأوسمة</h2>
        <br> <br> <br>
    </div>
    <!-- start tablist -->
    <br> <br> <br>
    <div class="tabs" style="margin-top: 60px;>
<br>

        <input type="radio" value="1" id="tab1" name="tab-control" checked>


        <input type="radio" value="2" id="tab2" name="tab-control" >



        <input type="radio" value="3" id="tab3" name="tab-control" >

        <ul>

            <li title="class_medal"><label for="tab1" role="button">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,
                        10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,
                        4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,
                        3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                    </svg>
                    <span> النشاط الصفي </span>
                </label>
            </li> &nbsp;&nbsp;&nbsp;&nbsp;

            <li title="main_exam_medal"><label for="tab2" role="button">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,
                        10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,
                        4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,
                        3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                    </svg>
                    <span> الامتحانات  </span>
                </label>
            </li> &nbsp;&nbsp;&nbsp;&nbsp;

            <li title="test_exam"><label for="tab3" role="button">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,
                        10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,
                        4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,
                        3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                    </svg>
                    <span> الاختبارات  </span>
                </label>
            </li> &nbsp;&nbsp;&nbsp;&nbsp;


        </ul>


        <div class="">
            <div class="indicator"></div>
        </div>
<br>
        <div class="content">
            <!-- start  mark subject -->
            {{-- @foreach ($classes as $item ) --}}
            <section style="direction: rtl; text-align:right">

            <table style="margin-top: 15px ">
                <thead>

                        <tr>
                            {{-- <th>اسم الاستاذ </th> --}}
                            <th>اسم المادة </th>
                            <th>تاريخ المنح  </th>
                            <th>الأوسمة </th>

                        </tr>

            </thead>
            <tbody>
                @php

                @endphp
                @foreach($medals as $medal)
                <tr>
                    {{-- <td>اسم الاستاذ الأول </td> --}}
                    <td>{{ $medal->lesson->name }} </td>
                    <td> {{ $medal->lesson->created_at }}  </td>
                    @if($medal->type == '1')
                    <td><img src="{{ asset('student-UI/gold.png') }}" class="img1" alt="gold"> </td>
                    @elseif($medal->type == '2')
                        <td><img src="{{ asset('student-UI/silver.png') }}" class="img1" alt="silver"> </td>
                    @else
                        <td><img src="{{ asset('student-UI/pronze.png') }}" class="img1" alt="pronze"> </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>


            </section>
            <section style="direction: rtl; text-align:right">

            <table style="margin-top: 15px ">
                <thead>
                <tr>
                    {{-- <th>اسم الاستاذ </th> --}}
                    <th>اسم المادة </th>
                    <th>تاريخ المنح  </th>
                    <th>الأوسمة </th>

                </tr>
            </thead>
            <tbody>
                @php

                @endphp
                @foreach($exam_medals as $medal)
                <tr>
                    {{-- <td>اسم الاستاذ الأول </td> --}}
                    <td>{{ $medal->lesson->name }} </td>
                    <td> {{ $medal->lesson->created_at }}  </td>
                    @if($medal->type == '1')
                    <td><img src="{{ asset('student-UI/gold.png') }}" class="img1" alt="gold"> </td>
                    @elseif($medal->type == '2')
                        <td><img src="{{ asset('student-UI/silver.png') }}" class="img1" alt="silver"> </td>
                    @else
                        <td><img src="{{ asset('student-UI/pronze.png') }}" class="img1" alt="pronze"> </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>


            </section>
            <section style="direction: rtl; text-align:right">

            <table style="margin-top: 15px ">
                <thead>
                <tr>
                    {{-- <th>اسم الاستاذ </th> --}}
                    <th>اسم المادة </th>
                    <th>تاريخ المنح  </th>
                    <th>الأوسمة </th>

                </tr>
            </thead>
            <tbody>
                @php

                @endphp
               @foreach($test_medals as $medal)
               <tr>
                   {{-- <td>اسم الاستاذ الأول </td> --}}
                   <td>{{ $medal->lesson->name }} </td>
                   <td> {{ $medal->lesson->created_at }}  </td>
                   @if($medal->type == '1')
                   <td><img src="{{ asset('student-UI/gold.png') }}" class="img1" alt="gold"> </td>
                   @elseif($medal->type == '2')
                       <td><img src="{{ asset('student-UI/silver.png') }}" class="img1" alt="silver"> </td>
                   @else
                       <td><img src="{{ asset('student-UI/pronze.png') }}" class="img1" alt="pronze"> </td>
                   @endif
               </tr>
               @endforeach

            </tbody>
        </table>


            </section>
{{-- @endforeach --}}


        </div>
    </div>
    <!-- end add content -->
    <!-- end tablist -->


</div>
{{-- **************************************************************************************** --}}


      <!-- start slider-->


<br><br><br>
	<div class="section full-height over-hide px-4 px-sm-0" style="margin-top: -50px;">
		<div class="container">
			<div class="row full-height justify-content-center">
				<div class="col-lg-10 col-xl-8 align-self-center padding-tb">
					<div class="section mx-auto text-center slider-height-padding">
			          	<input class="checkbox frst" type="radio" id="slide-1" name="slider" checked/>
			          	<label for="slide-1"></label>
			          	<input class="checkbox scnd" type="radio" name="slider" id="slider-2"/>
			          	<label for="slider-2"></label>
			          	<input class="checkbox thrd" type="radio" name="slider" id="slider-3"/>
			          	<label for="slider-3"></label>
                  <br>
                  <br>

						<ul class="ul">

							<li class="li">



              <br>
              <div class="row" style="margin: 0 auto;justify-content: center;">

                @foreach ($lessons as $lesson)

                    <div class="container5">
                        <img src="{{ asset('student-UI/gold.png') }}" />
                        <div class="title"> {{ $lesson->name }}
                            <br>
                            <h6>{{ $lesson->golden_medals_count }}</h6>
                        </div>
                    </div>
                    &nbsp;&nbsp;&nbsp;

                @endforeach
              </div>
			</li>
                <!-- end gold prize-->

                <!-- start silver prize -->
				<li class="li">
                    <br>
                <div class="row" style="margin: 0 auto;justify-content: center;padding-top: 20px;">

                    @foreach ($lessons as $lesson)

                        <div class="container5">
                            <img src="{{ asset('student-UI/silver.png') }}" />
                            <div class="title"> {{ $lesson->name }}
                                <br>
                                <h6>{{ $lesson->silver_medals_count }}</h6>
                            </div>
                        </div>
                        &nbsp;&nbsp;&nbsp;

                    @endforeach

                </div>
				</li>
                <!-- end silver prize-->


            <!-- start pronze prize -->
				<li class="li">

                <div class="row" style="margin: 0 auto;justify-content: center;padding-top: 20px;">

                </div>
                <br>
                <div class="row" style="margin: 0 auto;justify-content: center;">

                    @foreach ($lessons as $lesson)

                        <div class="container5">
                            <img src="{{ asset('student-UI/pronze.png') }}" />
                            <div class="title"> {{ $lesson->name }}
                                <br>
                                <h6>{{ $lesson->pronze_medals_count }}</h6>
                            </div>
                        </div>
                        &nbsp;&nbsp;&nbsp;

                    @endforeach
				</li>
                <!-- end pronze prize -->

					    </ul>
				    </div>
			    </div>
	      	</div>
	    </div>
	</div>
      <!-- end slider-->
         <br>
         <br>



         

	@endsection
