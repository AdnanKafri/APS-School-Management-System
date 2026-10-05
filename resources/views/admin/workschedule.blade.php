@extends('admin.layouts.v2')

@section('page_title', 'برنامج الدوام')
@section('page_subtitle', 'إدارة جدول الحصص الأسبوعي للشعبة وربط المواد والمدرسين')

@section('style')
    <link rel="stylesheet" href="{{ asset('admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/work-schedule-ui.css') }}">
     <style>

.workschedule-v2 .card {
    background-color: #fff;
    border-radius: 10px;
    border: none;
	top: 50px;
	margin: 0 auto;
	text-align: center;
	width: 300px;
	min-height: 120px;

    /*position: relative;*/

    margin-bottom: 30px;
    box-shadow: 0 0.46875rem 2.1875rem rgba(90,97,105,0.1), 0 0.9375rem 1.40625rem rgba(90,97,105,0.1), 0 0.25rem 0.53125rem rgba(90,97,105,0.12), 0 0.125rem 0.1875rem rgba(90,97,105,0.1);
}
.workschedule-v2 .l-bg-cherry {
    background: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196)) !important;
    color: #fff;

}

.workschedule-v2 .l-bg-blue-dark {
	background: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196)) !important;
    color: #fff;
	text-align: center;
}

.workschedule-v2 .l-bg-green-dark {
    background: linear-gradient(to right top, #094e89 20%, rgb(132, 167, 196)) !important;
    color: #fff;
	text-align: center;
}

.workschedule-v2 .l-bg-orange-dark {
    background: linear-gradient(to right, #a86008, #ffba56) !important;
    color: #fff;
}

.workschedule-v2 .card .card-statistic-3 .card-icon-large .fas, .workschedule-v2 .card .card-statistic-3 .card-icon-large .far, .workschedule-v2 .card .card-statistic-3 .card-icon-large .fab, .workschedule-v2 .card .card-statistic-3 .card-icon-large .fal {
    font-size: 80px;

}

.workschedule-v2 .card .card-statistic-3 .card-icon {

    line-height: 50px;
    margin-right: 195px;
    color: #000;
    position: absolute;
    right: -5px;
    top: 20px;
    opacity: 0.1;
	color: white;

}

.workschedule-v2 .l-bg-cyan {
    background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
    color: #fff;
	text-align: center;
}

.workschedule-v2 .l-bg-green {
    background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important;
    color: #fff;
	text-align: center;
}

.workschedule-v2 .l-bg-orange {
    background: linear-gradient(to right, #f9900e, #ffba56) !important;
    color: #fff;
	text-align: center;
}

.workschedule-v2 .l-bg-cyan {
    background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
    color: #fff;
	text-align: center;
}
/*style tablist*/
/* section add content */
@import "bourbon";
 @import 'https://fonts.googleapis.com/css?family=Montserrat:400,700|Raleway:300,400';

 .workschedule-v2 .tabs {
	 left: 50%;
	 transform: translateX(-50%);
	 position: relative;
	 background: white;
	 padding: 20px;
	 padding-bottom: 80px;
	 width: 90%;
	 height: auto;
	 box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
	 border-radius: 5px;
	 min-width: 240px;
}
 .workschedule-v2 .tabs input[name="tab-control"] {
	 display: none;
}
 .workschedule-v2 .tabs .content section h2, .workschedule-v2 .workschedule-v2 .tabs ul li label {
	 font-family: "Montserrat";
	 font-weight: bold;
	 font-size: 18px;
	 color: #094e89;
}
 .workschedule-v2 .tabs ul {
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
 .workschedule-v2 .tabs ul li {
	 box-sizing: border-box;
	 /*flex: 1;
	 width: 25%;
	 padding: 0 10px;*/
	 text-align: center;
}
 .workschedule-v2 .tabs ul li label {
	 transition: all 0.3s ease-in-out;
	 color: #929daf;
	 padding: 5px auto;
	 overflow: hidden;
	 text-overflow: ellipsis;
	 display: block;
	 cursor: pointer;
	 transition: all 0.2s ease-in-out;
	 white-space: nowrap;
	 -webkit-touch-callout: none;
}
 .workschedule-v2 .tabs ul li label br {
	 display: none;
}
 .workschedule-v2 .tabs ul li label svg {
	 fill: #929daf;
	 height: 1.2em;
	 vertical-align: bottom;
	 margin-right: 0.2em;
	 transition: all 0.2s ease-in-out;
}
 .tabs ul li label:hover, .tabs ul li label:focus, .tabs ul li label:active {
	 outline: 0;
	 color: #bec5cf;
}
 .tabs ul li label:hover svg, .tabs ul li label:focus svg, .tabs ul li label:active svg {
	 fill: #bec5cf;
}
 .workschedule-v2 .tabs .slider {
	 position: relative;
	 width: 25%;
	 transition: all 0.33s cubic-bezier(0.38, 0.8, 0.32, 1.07);
}
 .workschedule-v2 .tabs .slider .indicator {
	 position: relative;
	 width: 50px;
	 max-width: 100%;
	 margin: 0 auto;
	 height: 4px;
	 background: #cc151525;
	 border-radius: 1px;
}
 .workschedule-v2 .tabs .content {
	 margin-top: 30px;
}
 .workschedule-v2 .tabs .content section {
	 display: none;
	 animation-name: content;
	 animation-direction: normal;
	 animation-duration: 0.3s;
	 animation-timing-function: ease-in-out;
	 animation-iteration-count: 1;
	 line-height: 1.4;
}
 .workschedule-v2 .tabs .content section h2 {
	 color: #1068b4;
	 display: none;
}
 .workschedule-v2 .tabs .content section h2::after {
	 content: "";
	 position: relative;
	 display: block;
	 width: 30px;
	 height: 3px;
	 background: #1068b4;
	 margin-top: 5px;
	 left: 1px;
}
 .tabs input[name="tab-control"]:nth-of-type(1):checked ~ ul > li:nth-child(1) > label {
	 cursor: default;
	 color: #f38639;
}
 .tabs input[name="tab-control"]:nth-of-type(1):checked ~ ul > li:nth-child(1) > label svg {
	 fill: #f38639;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(1):checked ~ ul > li:nth-child(1) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(1):checked ~ .slider {
	 transform: translateX(0%);
}
 .tabs input[name="tab-control"]:nth-of-type(1):checked ~ .content > section:nth-child(1) {
	 display: block;
}
 .tabs input[name="tab-control"]:nth-of-type(2):checked ~ ul > li:nth-child(2) > label {
	 cursor: default;
	 color: #f38639;
}
 .tabs input[name="tab-control"]:nth-of-type(2):checked ~ ul > li:nth-child(2) > label svg {
	 fill: #f38639;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(2):checked ~ ul > li:nth-child(2) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(2):checked ~ .slider {
	 transform: translateX(100%);
}
 .tabs input[name="tab-control"]:nth-of-type(2):checked ~ .content > section:nth-child(2) {
	 display: block;
}
 .tabs input[name="tab-control"]:nth-of-type(3):checked ~ ul > li:nth-child(3) > label {
	 cursor: default;
	 color: #f38639;
}
 .tabs input[name="tab-control"]:nth-of-type(3):checked ~ ul > li:nth-child(3) > label svg {
	 fill: #f38639;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(3):checked ~ ul > li:nth-child(3) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(3):checked ~ .slider {
	 transform: translateX(200%);
}
 .tabs input[name="tab-control"]:nth-of-type(3):checked ~ .content > section:nth-child(3) {
	 display: block;
}
/*tab 4*/
.tabs input[name="tab-control"]:nth-of-type(4):checked ~ ul > li:nth-child(4) > label {
	 cursor: default;
	 color: #1068b4;
}
 .tabs input[name="tab-control"]:nth-of-type(4):checked ~ ul > li:nth-child(4) > label svg {
	 fill: #1068b4;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(4):checked ~ ul > li:nth-child(4) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(4):checked ~ .slider {
	 transform: translateX(0%);
}
 .tabs input[name="tab-control"]:nth-of-type(4):checked ~ .content > section:nth-child(4) {
	 display: block;
}
 .tabs input[name="tab-control"]:nth-of-type(5):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(5):checked ~ .content > section:nth-child(5) {
	 display: block;
}
/*tab 5*/
.tabs input[name="tab-control"]:nth-of-type(5):checked ~ ul > li:nth-child(5) > label {
	 cursor: default;
	 color: #1068b4;
}
 .tabs input[name="tab-control"]:nth-of-type(5):checked ~ ul > li:nth-child(5) > label svg {
	 fill: #1068b4;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(5):checked ~ ul > li:nth-child(5) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(5):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(5):checked ~ .content > section:nth-child(5) {
	 display: block;
}
/*tab 6*/
.tabs input[name="tab-control"]:nth-of-type(6):checked ~ ul > li:nth-child(6) > label {
	 cursor: default;
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(6):checked ~ ul > li:nth-child(6) > label svg {
	 fill: #428bff;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(6):checked ~ ul > li:nth-child(6) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(6):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(6):checked ~ .content > section:nth-child(6) {
	 display: block;
}
/*tab 7*/
.tabs input[name="tab-control"]:nth-of-type(7):checked ~ ul > li:nth-child(7) > label {
	 cursor: default;
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(7):checked ~ ul > li:nth-child(7) > label svg {
	 fill: #428bff;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(7):checked ~ ul > li:nth-child(7) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(7):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(7):checked ~ .content > section:nth-child(7) {
	 display: block;
}
/*tab 8*/
.tabs input[name="tab-control"]:nth-of-type(8):checked ~ ul > li:nth-child(8) > label {
	 cursor: default;
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(8):checked ~ ul > li:nth-child(8) > label svg {
	 fill: #428bff;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(8):checked ~ ul > li:nth-child(8) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(8):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(8):checked ~ .content > section:nth-child(8) {
	 display: block;
}
/*tab 9*/
.tabs input[name="tab-control"]:nth-of-type(9):checked ~ ul > li:nth-child(9) > label {
	 cursor: default;
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(9):checked ~ ul > li:nth-child(9) > label svg {
	 fill: #428bff;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(9):checked ~ ul > li:nth-child(9) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(9):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(9):checked ~ .content > section:nth-child(9) {
	 display: block;
}
/*tab 10*/
.tabs input[name="tab-control"]:nth-of-type(10):checked ~ ul > li:nth-child(10) > label {
	 cursor: default;
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(10):checked ~ ul > li:nth-child(10) > label svg {
	 fill: #428bff;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(10):checked ~ ul > li:nth-child(10) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(10):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(10):checked ~ .content > section:nth-child(10) {
	 display: block;
}
/*tab 11*/
.tabs input[name="tab-control"]:nth-of-type(11):checked ~ ul > li:nth-child(11) > label {
	 cursor: default;
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(11):checked ~ ul > li:nth-child(11) > label svg {
	 fill: #428bff;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(11):checked ~ ul > li:nth-child(11) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(11):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(11):checked ~ .content > section:nth-child(11) {
	 display: block;
}
/*tab 12*/
.tabs input[name="tab-control"]:nth-of-type(12):checked ~ ul > li:nth-child(12) > label {
	 cursor: default;
	 color: #428bff;
}
 .tabs input[name="tab-control"]:nth-of-type(12):checked ~ ul > li:nth-child(12) > label svg {
	 fill: #428bff;
}
 @media (max-width: 600px) {
	 .tabs input[name="tab-control"]:nth-of-type(12):checked ~ ul > li:nth-child(12) > label {
		 background: rgba(0, 0, 0, 0.08);
	}
}
 .tabs input[name="tab-control"]:nth-of-type(12):checked ~ .slider {
	 transform: translateX(300%);
}
 .tabs input[name="tab-control"]:nth-of-type(12):checked ~ .content > section:nth-child(12) {
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
 @media (max-width: 1000px) {
	 .workschedule-v2 .tabs ul li label {
		 white-space: initial;
	}
	 .workschedule-v2 .tabs ul li label br {
		 display: initial;
	}
	 .workschedule-v2 .tabs ul li label svg {
		 height: 1.5em;
	}
}
 @media (max-width: 600px) {
	 .workschedule-v2 .tabs ul li label {
		 padding: 5px;
		 border-radius: 5px;
	}
	 .tabs ul li label span {
		 display: none;
	}
	 .workschedule-v2 .tabs .slider {
		 display: none;
	}
	 .workschedule-v2 .tabs .content {
		 margin-top: 20px;
	}
	 .workschedule-v2 .tabs .content section h2 {
		 display: block;
	}
}


/*end style tablist*/
/* cards of marks */
.workschedule-v2 .cards-list {
  z-index: 0;
  width: 100%;
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
}

.workschedule-v2 .card2 {
  margin: 30px auto;
  width: 170px;
  height: 170px;
  border-radius: 40px;
  border-color: 5px solid #094e89;
  /*box-shadow: 1px 1px 9px 2px rgba(0,0,0,0.22), -1px -1px 9px 2px rgba(0,0,0,0.20);*/
  cursor: pointer;
  transition: 0.4s;
}

.workschedule-v2 .card2 .card_image {
 border-color: 5px solid #094e89;
  width: inherit;
  height: inherit;
  border-radius: 40px;
}

.workschedule-v2 .card2 .card_image img {
  width: inherit;
  height: inherit;
  border-radius: 40px;
  object-fit: cover;
}

.workschedule-v2 .card2 .card_title {
  text-align: center;
  border-radius: 0px 0px 40px 40px;
  font-family: sans-serif;
  font-weight: bold;
  font-size: 30px;
  margin-top: -20px;
  height: 40px;
}

.workschedule-v2 .card2:hover {
  transform: scale(0.9, 0.9);
  box-shadow: 1px 1px 10px 2px rgba(0,0,0,0.22), -1px -1px 10px 2px rgba(0,0,0,0.20);
}

.workschedule-v2 .title-white {
  color: white;
}

.workschedule-v2 .title-black {
  color: black;
}

@media all and (max-width: 500px) {
  .card-list {
    /* On small screens, we are no longer using row direction but column */
    flex-direction: column;
  }
}
.workschedule-v2 a{
    color:#fff !important;
    font-size: 16px !important;
}
.workschedule-v2 table{
    background: white !important;
    color: black;
    font-size: 20px;
    font-weight:400;
}
.workschedule-v2 .table-bordered,.workschedule-v2 th,.workschedule-v2 td{
    border: 1px solid #dee2e6 !important;
    padding: 10px;
}

.workschedule-v2 div::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.workschedule-v2 div {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
.workschedule-v2 th,.workschedule-v2 td{
    border: 1px solid #c1e3e5 !important;
}
/*new style for table*/

.workschedule-v2 .table-scroll {
	position:relative;
	max-width:600px;
	margin:auto;
	/*overflow:hidden;*/
	border:1px solid #000;
}
.workschedule-v2 .table-wrap {
	width:100%;
	overflow:auto;
}
.workschedule-v2 .table-scroll table {
	width:100%;
	margin:auto;
	border-collapse:separate;
	border-spacing:0;
}
.workschedule-v2 .table-scroll th, .workschedule-v2 .table-scroll td {
	padding:5px 10px;
	border:1px solid #000;
	background:#fff;
	white-space:nowrap;
	vertical-align:top;
}
.workschedule-v2 .table-scroll thead, .workschedule-v2 .table-scroll tfoot {
	background:#f9f9f9;
}
.workschedule-v2 .clone {
	position:absolute;
	top:0;
	left:0;
	pointer-events:none;
}
.workschedule-v2 .clone th, .workschedule-v2 .clone td {
	visibility:hidden
}
.workschedule-v2 .clone td, .workschedule-v2 .clone th {
	border-color:transparent
}
.workschedule-v2 .clone tbody th {
	visibility:visible;
	color:red;
}
.workschedule-v2 .clone .fixed-side {
	border:1px solid #000;
	background:#eee;
	visibility:visible;
}
.workschedule-v2 .clone thead, .workschedule-v2 .clone tfoot{background:transparent;}

.workschedule-v2 .btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: revert !important;
    vertical-align: middle;
    user-select: none;
    
    border: 1px solid transparent;
    /*padding: 0.375rem 0.75rem;*/
    font-size: 0.875rem;
    line-height: 1.5;
    margin: 5px !important;
    border-radius: 0.25rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.workschedule-v2 .modal-header .close {
    padding: 1rem;
    margin: -1rem 20rem -1rem auto;
}
.v2-bc {
    display: flex;
    align-items: center;
    gap: .4rem;
    font-size: .9rem;
    flex-wrap: wrap;
    direction: rtl;
}
.v2-bc a {
    color: #8a869a;
    font-weight: 700;
    text-decoration: none;
}
.v2-bc a:hover { color: #5B4B8A; }
.v2-bc .sep { color: #b2aec0; font-weight: 700; }
.v2-bc .active { color: #2f2b3a; font-weight: 800; }
.workschedule-v2 {
    direction: rtl;
    text-align: right;
    padding: 0 1.25rem 1.5rem;
}
.workschedule-shell {
    background: #fff;
    border-radius: 22px;
    border: 1px solid rgba(91,75,138,0.12);
    box-shadow: 0 14px 36px rgba(36,30,62,0.08);
    padding: 1.5rem;
}
.workschedule-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1.25rem;
}
.workschedule-page-header__title h1 {
    margin: 0;
    font-size: 1.5rem;
    color: #2f2b3a;
    font-weight: 800;
}
.workschedule-page-header__title p {
    margin: .35rem 0 0;
    color: #7a748f;
    font-size: .92rem;
    font-weight: 700;
}
.workschedule-page-actions {
    display: flex;
    align-items: center;
    gap: .75rem;
    flex-wrap: wrap;
}
.workschedule-page-actions .btn {
    min-height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: .65rem 1rem;
    border-radius: 12px;
    margin: 0 !important;
    font-weight: 700;
}
.workschedule-v2 .table-responsive {
    width: 100%;
    overflow-x: auto;
    border-radius: 18px;
    border: 1px solid rgba(91,75,138,0.1);
}
.workschedule-v2 .workschedule-table {
    width: 100%;
    margin: 0;
    background: #fff !important;
    border-collapse: separate;
    border-spacing: 0;
    table-layout: fixed;
}
.workschedule-v2 .workschedule-table thead th {
    background: #f5f3fb;
    color: #2f2b3a;
    font-size: .88rem;
    font-weight: 800;
    text-align: center !important;
    padding: 1rem .45rem;
}
.workschedule-v2 .workschedule-table tbody th {
    background: #fbfaff;
    color: #2f2b3a;
    font-weight: 800;
    text-align: center !important;
    vertical-align: middle;
}
.workschedule-v2 .workschedule-table td {
    padding: .9rem .5rem;
    text-align: center !important;
    vertical-align: middle;
    background: #fff;
}
.workschedule-v2 .workschedule-table .btn.add_time {
    min-height: 86px;
    width: min(140px, 100%);
    margin: 0 auto !important;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    white-space: normal !important;
    font-weight: 700;
    gap: .2rem;
    padding: .65rem .55rem;
    box-shadow: none;
}
.workschedule-v2 .workschedule-table .btn.add_time p {
    margin: 0 !important;
}
.workschedule-modal .modal-dialog {
    max-width: 760px;
    width: calc(100% - 2rem);
    margin: 1.75rem auto;
    min-height: calc(100vh - 3.5rem);
    display: flex;
    align-items: center;
}
.workschedule-modal .modal-content {
    width: 100%;
    border-radius: 22px;
    border: 1px solid rgba(91,75,138,0.14);
    box-shadow: 0 28px 80px rgba(36,30,62,0.2);
}
.workschedule-modal .modal-header {
    padding: 1.2rem 1.5rem;
    border-bottom: 1px solid rgba(91,75,138,0.1);
    background: linear-gradient(180deg, rgba(91,75,138,0.05), rgba(91,75,138,0.01));
}
.workschedule-modal .modal-title {
    font-size: 1.08rem;
    font-weight: 800;
    color: #2f2b3a;
}
.workschedule-modal .modal-body {
    padding: 1.5rem;
}
.workschedule-modal .form-group {
    margin-bottom: 1rem;
}
.workschedule-modal .form-control {
    min-height: 46px;
    border-radius: 12px;
    padding: .7rem .9rem;
    border-color: rgba(123,103,178,0.22);
    background: #fcfbff;
}
.workschedule-modal .modal-footer {
    padding: 1rem 1.5rem 1.35rem;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: .75rem;
}
.workschedule-modal .modal-footer .btn {
    min-width: 120px;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin: 0 !important;
}
@media (max-width: 991px) {
    .workschedule-v2 {
        padding: 0 .75rem 1rem;
    }
    .workschedule-shell {
        padding: 1rem;
    }
}
@media (max-width: 767px) {
    .workschedule-page-header {
        align-items: flex-start;
    }
    .workschedule-page-actions {
        width: 100%;
    }
    .workschedule-page-actions .btn {
        flex: 1 1 100%;
    }
    .workschedule-modal .modal-dialog {
        width: calc(100% - 1rem);
        margin: .75rem auto;
        min-height: calc(100vh - 1.5rem);
    }
    .workschedule-v2 .workschedule-table .btn.add_time {
        width: 100%;
        min-height: 74px;
    }
}

	 </style>
     @endsection


    @section('breadcrumbs')

<nav class="v2-bc" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}">لوحة التحكم</a>
    <span class="sep">/</span>
    <a href="{{ route('classes') }}">قسم الصفوف</a>
    <span class="sep">/</span>
    <a href="{{ route('classroom',$room->class_id) }}">الشعب</a>
    <span class="sep">/</span>
    <span class="active">برنامج الدوام</span>
</nav>

@endsection


     @section('content')

	{{-- <section class="hero-wrap hero-wrap-2" style="background-image: url('{{ asset('student-UI/img/school_bulding.jpg') }}'); border-bottom-right-radius: 70px 50px;">
		<div class="overlay"></div>
		<div class="container">
			<div class="row no-gutters slider-text align-items-end justify-content-center">
				<div class="col-md-12 ftco-animate pb-5 text-right">
					<h1 class="mb-0 bread">  <span> {{ $room_name  }} </span> / {{ $class_name }} </h1>
				</div>
			</div>
		</div>
	</section> --}}
  <!-- start new-->
     <div class="workschedule-v2">
     <div class="modal fade workschedule-modal" id="store_session">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form_update" method="POST" action="{{ route('session_store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="class_id" id="class_id">
                            <div class="modal-header">
                                <h4 class="modal-title">اضافة حصة</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:right">
                                    <label>اسم الحصة</label>
                                    <input type="text" name="session_name" class="form-control" value="" style="direction: rtl"  maxlength="20" required>
                                </div>

                                <div class="form-group" style="text-align:right">
                                    <label>بداية الحصة</label>
                                    <input type="time" name="start_time"  class="form-control" value="" style="direction: rtl" required>
                                </div>

                                <div class="form-group" style="text-align:right">
                                    <label>نهاية الحصة</label>
                                    <input type="time" name="end_time"  class="form-control" value="" style="direction: rtl" required>
                                </div>


                                <div class="form-group" style="text-align:right" hidden>
                                    <label>الصفوف</label>
                                    <select name="class[]" class="w-100 js-example-basic-multiple"  multiple="multiple">
                                            <option value="{{ $room->class_id }}" selected ></option>
                                    </select>
                                </div>


                                <div class="form-group" style="text-align:right">
                                    <label>النوع</label>
                                    <select name="type" style="direction: rtl" class="form-control" required>
                                        <option value="1">حصة درسية</option>
                                        <option value="2">استراحة</option>
                                    </select>
                                </div>
                                <div class="form-group" style="text-align:right">
                                    <label>  الشعب</label>
                                    <select name="room[]" style="direction: rtl" class="form-control" >
                                   
                                            <option value="{{ $room->id }}" selected>{{ $room->name }}</option>
                                  
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer" style="justify-content: right;">
                                <a class="btn btn-default" data-dismiss="modal" style="color: black !important;">الغاء</a>
                                <button class="btn btn-primary">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
<div class="workschedule-shell">
    <div class="workschedule-page-header">
        <div class="workschedule-page-header__title">
            <h1>برنامج الدوام للصف {{ $class_name }} / {{ $room_name }}</h1>
            <p>إدارة الجدول الأسبوعي للشعبة وتوزيع الحصص مع الربط بين المواد والمدرسين وروابط الاجتماعات.</p>
        </div>
        <div class="workschedule-page-actions">
            @can('Deletion of a class in the work schedule section')
            <a class="btn btn-danger delete_lecture_time" data-toggle="modal" data-target="#delete_lesson_time">حذف الحصة</a>
            @endcan
            @can('create_workschedule')
            <a class="btn btn-success" data-toggle="modal" data-target="#store_session" data-id="">إنشاء حصة جديدة</a>
            @endcan
        </div>
    </div>
        <div class="row" style="width: 100%; margin: 0;">
            <div class="col-lg-12">
        <div class="table-responsive">
        <table class="table table-striped workschedule-table" id=""
            style="direction: rtl !important;text-align: center !important;display: table; font-size:15px;">
                <thead>
                <tr>
                    <th scope="col">اليوم </th>
                    @foreach ($lecture_times as $key => $value)
                    {{-- @dd($value['name']) --}}
                        <th scope="col"> {{ $value['name'] }} <br>
                        <span style="font-size: 13px"> {{ $value['start_time'] }} <br> {{ $value['end_time'] }} </span>
                        </th>
                    @endforeach


                    {{-- <th scope="col"> محتوى الدرس</th>  --}}
                </tr>
                </thead>
                <tbody>
                    <?php $i = 1 ?>
                    @foreach ($days as $key => $day)
                        <tr>
                            <th scope="row">{{ $day->name }}</th>
                            @foreach ($lecture_times as $key2 => $lecture_time)
                                @php
                                    $lesson_name2 =  '' ;
                                    $teacher_name2 =    '';
                                    $counter = 0 ;
                                    $target = 'add_schedule';
                                @endphp
                                <td >                                    @php
                                        $slotAssignments = $schedule->where('day_id', $day->id)
                                            ->where('lecture_time_id', $lecture_time->id)
                                            ->values();
                                        $slotPayload = $slotAssignments->map(function ($assignment) {
                                            return ['schedule_id' => (int) $assignment->id, 'lesson_id' => (int) $assignment->lesson_id, 'teacher_id' => (int) $assignment->teacher_id];
                                        })->values();
                                        $slotKey = $day->id . '-' . $lecture_time->id;
                                    @endphp
                                    <div class="schedule-slot-content" id="schedule-slot-{{ $slotKey }}">
                                        <a class="btn @if($lecture_time->type == 1) btn-info @else btn-success @endif btn-sm add_time js-schedule-slot"
                                           data-toggle="modal" data-target="#add_schedule"
                                           data-day_id="{{ $day->id }}" data-day="{{ $day->name }}"
                                           data-time_id="{{ $lecture_time->id }}" data-time="{{ $lecture_time->name }}"
                                           data-schedule_context="normal" data-assignments='@json($slotPayload)'
                                           title="{{ __('timetable.schedule.choose_lesson') }}">
                                            <div class="schedule-assignment-labels">
                                                @forelse($slotAssignments as $slotAssignment)
                                                    <div class="schedule-assignment-label">
                                                        <p class="lesson_name-schedule{{ $day->id . $lecture_time->id }}" style="margin:0;font-weight:bold">{{ $slotAssignment->lesson->name ?? '' }}</p>
                                                        <p class="teacher_name-schedule{{ $day->id . $lecture_time->id }}" style="margin:0;font-size:10px">{{ trim(optional($slotAssignment->teacher)->first_name . ' ' . optional($slotAssignment->teacher)->last_name) }}</p>
                                                    </div>
                                                @empty
                                                    <p class="schedule-empty-label" style="margin:0;font-weight:bold">{{ __('timetable.schedule.choose_lesson') }}</p>
                                                @endforelse
                                            </div>
                                        </a>
                                        <div class="schedule-meeting-actions" data-link-class="btn btn-warning btn-sm" data-meeting-title="{{ __('timetable.schedule.add_meeting_link') }}">
                                            @foreach($slotAssignments as $meetingSchedule)
                                                <a class="btn btn-warning btn-sm js-meeting-link" data-toggle="modal" data-target="#add_schedule1"
                                                   data-day_id="{{ $day->id }}" data-day="{{ $day->name }}"
                                                   data-time_id="{{ $lecture_time->id }}" data-time_name="{{ $lecture_time->name }}"
                                                   data-lesson_name="{{ optional($meetingSchedule->lesson)->name }}"
                                                   data-lesson_id="{{ $meetingSchedule->lesson_id }}"
                                                   data-lesson_time_id="{{ $meetingSchedule->id }}"
                                                   data-meeting_link="{{ $meetingSchedule->meeting_link }}"
                                                   title="{{ __('timetable.schedule.add_meeting_link') }}">
                                                    <i class="fas fa-link" aria-hidden="true"></i>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div></td>

                            @endforeach

                        </tr>


                    @endforeach

            </tbody>
        </table>
        </div>
    
 </div>
    <br>
    <br>

    </div>
      </div>
</div>
<!-- end new-->

  <br>
  <br>
  <br>
  <br>

{{-- add lesson time --}}

<div class="modal fade workschedule-modal" id="add_schedule">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="direction: rtl; text-align:right">
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLongTitle"> تحديد الحصة   </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="display: inline-block;margin: 0px;padding: 0px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="{{ route('save.schedule') }}" method="post" class="w-100 this-form" id="workScheduleAssignmentForm">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room_id }}" class="room_id">
                <input type="hidden" name="schedule_context" value="normal">


                <div class="form-group row">
                    <label for="courseCost" class="col-sm-2 col-form-label"> اليوم : </label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control day">
                        <input type="hidden" name="day_id"  class="form-control day_id">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="courseCost" class="col-sm-2 col-form-label"> الحصة : </label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control time">
                        <input type="hidden" name="lecture_time_id"  class="form-control time_id">

                    </div>
                </div>
                                <div class="lessons-container"></div>
                <template id="scheduleAssignmentRowTemplate">
                    <div class="schedule-assignment-row border rounded p-3 mb-3">
                        <input type="hidden" class="schedule_id">
                        <div class="form-group mb-2">
                            <label>{{ __('timetable.schedule.choose_lesson') }}</label>
                            <select class="form-control lesson_id" style="width:100%">
                                <option value="">{{ __('timetable.schedule.choose_lesson') }}</option>
                                @foreach ($lessons as $lesson)
                                    <option value="{{ $lesson->id }}">{{ $lesson->name }}@if(optional($lesson->base_subject)->name) ({{ $lesson->base_subject->name }})@endif</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>{{ __('timetable.schedule.choose_teacher') }}</label>
                            <select class="form-control teacher_id" style="width:100%">
                                <option value="">{{ __('timetable.schedule.choose_teacher') }}</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-outline-danger btn-sm remove-schedule-assignment">{{ __('timetable.schedule.remove_lesson') }}</button>
                    </div>
                </template><span> <a href="#" class="btn btn-info btn-sm add_another_lesson">إضافة مادة أخرى لهذ التوقيت</a></span>
                <div class="form-group modal-footer row justify-content-around px-3">
                      <button class="btn btn-success save_lecture_time" type="submit" style="width: 35%">تأكيد </button>
                    <button type="button" class="btn btn-light btn-light text-dark" data-dismiss="modal" style="width: 35%">خروج</button>
                </div>

                <!-- end submit-->


            </form>
            </div>
        </div>
    </div>
</div>
        {{-- end add lesson time --}}



{{-- delete lesson time --}}

<div class="modal fade workschedule-modal" id="delete_lesson_time">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="direction: rtl; text-align:right">
            <div class="modal-header ">
                <h5 class="modal-title" id="exampleModalLongTitle"> حذف الحصة   </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form  action="{{ route('dashboard.room.delete.lecture_time') }}" method="post" class="w-100">
                @csrf
                <input type="hidden" name="room_id" id="room_id" value=" {{ $room_id }}" class="room_id">


                <div class="form-group row">
                    <label for="courseCost" class="col-sm-2 col-form-label"> اليوم : </label>
                    <div class="col-sm-10">
                        <select class="form-control wide2 " style="width: 100%;" name="day_id" id="">
                            <option value="">حدد اليوم</option>
                            @foreach ($days as $day)
                            <option value="{{ $day->id }}"><span>{{ $day->name }} </span></option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="courseCost" class="col-sm-2 col-form-label"> الحصة : </label>
                    <div class="col-sm-10">
                        <select class="form-control wide2 " style="width: 100%;" name="lecture_time_id" id="">
                            <option value="">حدد الحصة</option>
                            @foreach ($lecture_times as $lecture_time)

                                <option value="{{ $lecture_time->id }}"><span>{{ $lecture_time->name }} </span></option>

                            @endforeach
                        </select>
                    </div>
                </div>



                <div class="form-group modal-footer row justify-content-around px-3">
                      <button class="btn btn-warning delete_lecture_time" type="submit" style="width: 35%">تأكيد </button>
                    <button  class="btn btn-light btn-info" data-dismiss="modal" style="width: 35%">خروج</button>
                </div>

                <!-- end submit-->


            </form>
            </div>
        </div>
    </div>
</div>
</div>
        {{-- end delete lesson time --}}
    @include('admin.partials.work_schedule_feedback')

	@endsection
    @section('js')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/work-schedule-ui.js') }}"></script>
    <script>
    $(function () {
        var $modal = $('#add_schedule');
        var $form = $('#workScheduleAssignmentForm');
        var $container = $form.find('.lessons-container');
        var activeTrigger = null;
        var feedback = {
            success: @json(__('timetable.schedule.saved')),
            error: @json(__('timetable.schedule.save_failed')),
            errorTitle: @json(__('timetable.schedule.error_title')),
            chooseLesson: @json(__('timetable.schedule.choose_lesson')),
            chooseTeacher: @json(__('timetable.schedule.choose_teacher')),
            searchEmpty: @json(__('timetable.schedule.teacher_search_empty')),
            searchPrompt: @json(__('timetable.schedule.teacher_search_prompt')),
            unavailable: @json(__('timetable.schedule.unavailable'))
        };
        var scheduleUi = window.WorkScheduleUI.create($modal, $form, feedback);

        function destroySelect2() {
            if (!$.fn.select2) return;
            $container.find('select.select2-hidden-accessible').each(function () {
                $(this).select2('destroy');
            });
        }

        function reindexRows() {
            $container.find('.schedule-assignment-row').each(function (index) {
                $(this).find('.schedule_id').attr('name', 'lesson[' + index + '][schedule_id]');
                $(this).find('.lesson_id').attr('name', 'lesson[' + index + '][lesson_id]');
                $(this).find('.teacher_id').attr('name', 'lesson[' + index + '][teacher_id]');
            });
        }

        function addRow(assignment) {
            var template = document.getElementById('scheduleAssignmentRowTemplate');
            var row = template.content.firstElementChild.cloneNode(true);
            var $row = $(row);
            $container.append($row);
            if (assignment) {
                $row.find('.schedule_id').val(assignment.schedule_id || '');
                $row.find('.lesson_id').val(assignment.lesson_id);
                $row.find('.teacher_id').val(assignment.teacher_id);
            }
            scheduleUi.initSelects($row);
            reindexRows();
        }

        function resetRows(assignments) {
            destroySelect2();
            $container.empty();
            if (assignments && assignments.length) {
                assignments.forEach(addRow);
            } else {
                addRow(null);
            }
        }

        $modal.on('show.bs.modal', function (event) {
            var trigger = event.relatedTarget;
            if (!trigger) return;
            scheduleUi.clearError();
            activeTrigger = trigger;
            var $trigger = $(trigger);
            $form.find('.day').val($trigger.attr('data-day') || '');
            $form.find('.time').val($trigger.attr('data-time') || '');
            $form.find('.day_id').val($trigger.attr('data-day_id') || '');
            $form.find('.time_id').val($trigger.attr('data-time_id') || '');
            $form.find('[name="schedule_context"]').val($trigger.attr('data-schedule_context') || 'normal');
            var assignments = [];
            try {
                assignments = JSON.parse($trigger.attr('data-assignments') || '[]');
            } catch (error) {
                assignments = [];
            }
            resetRows(assignments);
        });

        $modal.on('hidden.bs.modal', function () {
            if (scheduleUi.isSuspended()) return;
            scheduleUi.clearError();
            destroySelect2();
            $container.empty();
            $form.find('.day, .time, .day_id, .time_id').val('');
            activeTrigger = null;
        });

        $form.on('click', '.add_another_lesson', function (event) {
            event.preventDefault();
            addRow(null);
        });

        $form.on('click', '.remove-schedule-assignment', function () {
            if ($container.find('.schedule-assignment-row').length === 1) {
                $(this).closest('.schedule-assignment-row').find('select').val('').trigger('change');
                return;
            }
            var $row = $(this).closest('.schedule-assignment-row');
            if ($.fn.select2) $row.find('select.select2-hidden-accessible').select2('destroy');
            $row.remove();
            reindexRows();
        });

        function refreshSlot(assignments) {
            var $trigger = $(activeTrigger);
            var $labels = $trigger.find('.schedule-assignment-labels').empty();
            assignments.forEach(function (assignment) {
                var $item = $('<div class="schedule-assignment-label"></div>');
                $('<p class="lesson_name-schedule"></p>').css({margin: 0, fontWeight: 'bold'}).text(assignment.lesson_name).appendTo($item);
                $('<p class="teacher_name-schedule"></p>').css({margin: 0, fontSize: '10px'}).text(assignment.teacher_name).appendTo($item);
                $labels.append($item);
            });
            $trigger.attr('data-assignments', JSON.stringify(assignments.map(function (item) {
                return {schedule_id: item.schedule_id, lesson_id: item.lesson_id, teacher_id: item.teacher_id};
            })));

            var $actions = $trigger.closest('.schedule-slot-content').find('.schedule-meeting-actions');
            var linkClass = $actions.attr('data-link-class') || 'btn btn-warning btn-sm';
            var meetingTitle = $actions.attr('data-meeting-title') || '';
            $actions.empty();
            assignments.forEach(function (assignment) {
                var $link = $('<a></a>').attr({
                    'class': linkClass + ' js-meeting-link',
                    'data-toggle': 'modal',
                    'data-target': '#add_schedule1',
                    'data-day_id': $trigger.attr('data-day_id'),
                    'data-day': $trigger.attr('data-day'),
                    'data-time_id': $trigger.attr('data-time_id'),
                    'data-time_name': $trigger.attr('data-time'),
                    'data-lesson_name': assignment.lesson_name,
                    'data-lesson_id': assignment.lesson_id,
                    'data-lesson_time_id': assignment.schedule_id,
                    'data-meeting_link': assignment.meeting_link || '',
                    'title': meetingTitle
                }).append('<i class="fas fa-link" aria-hidden="true"></i>');
                $actions.append($link);
            });
        }

        $form.on('submit', function (event) {
            event.preventDefault();
            var $button = $form.find('.save_lecture_time');
            if (!activeTrigger || $button.prop('disabled') || scheduleUi.isSuspended()) return;
            scheduleUi.clearError();
            reindexRows();
            $button.prop('disabled', true);
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                dataType: 'json',
                headers: {'Accept': 'application/json'}
            }).done(function (response) {
                if (!response || response.status !== true || !Array.isArray(response.assignments)) {
                    scheduleUi.error(response, (response && (response.msg || response.message)) || feedback.error);
                    return;
                }
                refreshSlot(response.assignments);
                $modal.modal('hide');
                scheduleUi.success(response.msg || feedback.success);
            }).fail(function (xhr) {
                var body = xhr.responseJSON || {};
                var errors = body.errors || {};
                var message = body.message || feedback.error;
                Object.keys(errors).some(function (key) {
                    var value = errors[key];
                    message = Array.isArray(value) ? value[0] : value;
                    return true;
                });
                scheduleUi.error(body, message);
            }).always(function () {
                $button.prop('disabled', false);
            });
        });

        $('#add_schedule1').on('show.bs.modal', function (event) {
            var $button = $(event.relatedTarget);
            var $meetingModal = $(this);
            $meetingModal.find('.day').val($button.attr('data-day') || '');
            $meetingModal.find('.day_id').val($button.attr('data-day_id') || '');
            $meetingModal.find('.time_name').val($button.attr('data-time_name') || '');
            $meetingModal.find('.time_id').val($button.attr('data-time_id') || '');
            $meetingModal.find('.lesson').val($button.attr('data-lesson_name') || '');
            $meetingModal.find('.lesson_id').val($button.attr('data-lesson_id') || '');
            $meetingModal.find('.lesson_time_id').val($button.attr('data-lesson_time_id') || '');
            $meetingModal.find('.meeting_link').val($button.attr('data-meeting_link') || '');
        });
    });
    </script>

    @endsection
