@extends('teachers2.layouts.app')
@section('css')
<style>
    /*responsive table*/
/**/

table {
border: 1px solid #ccc ;
border-collapse: collapse !important;
margin: 0 !important;
padding: 0 !important;
width: 100% !important;
margin-top:10px !important;
}

table caption {
font-size: 1.5em !important;
margin: .25em 0 .75em !important;
}

table tr {
background: #f8f8f8 !important;
border: 1px solid #ddd ;
padding: .35em !important;
}

table th, table td {
padding: .625em !important;
text-align: center !important;
}

table th {
font-size: 20px !important;

}

table td img { text-align: center; }
@media screen and (max-width: 900px) {

table { border: none !important; }


table thead { display: none !important; }

table tr {
/*border-bottom: 3px solid #ddd!important ;*/
border-bottom: none !important;
border-top: none !important;
border-left: none !important;
border-right: none !important;
display: block!important;
margin-bottom: .625em !important;
}

table td {
padding: 10px !important;
border-top: 1px solid #ddd !important;
border-bottom: none !important;
display: block !important;
font-size: .8em !important;
text-align: right !important;
}

table td:before {
content: attr(data-label) !important;
float: left !important;
font-weight: bold !important;

}

table td:last-child {
border-bottom: 1px solid #ddd !important;
border-right: 1px solid #ddd;
}


}
/*css for show homework button*/
a:hover{
  color: #fff;
  text-decoration: none;
}
.home {
position: relative;
/* margin: 0;*/
width: 120px;
padding: 0.8em 1em;
outline: none;
text-decoration: none;
display: inline-flex;
justify-content: center;
align-items: center;
cursor: pointer;
border: none;
text-transform: uppercase;
background-color: #14315C   ;
border-radius: 10px;
color: #fff;
font-weight: 300;
font-size: 18px;
font-family: inherit;
z-index: 0;
overflow: hidden;
transition: all 0.3s cubic-bezier(0.02, 0.01, 0.47, 1);
}

.home:hover {
animation: sh0 0.5s ease-in-out both;
}

@keyframes sh0 {
0% {
transform: rotate(0deg) translate3d(0, 0, 0);
}

25% {
transform: rotate(7deg) translate3d(0, 0, 0);
}

50% {
transform: rotate(-7deg) translate3d(0, 0, 0);
}

75% {
transform: rotate(1deg) translate3d(0, 0, 0);
}

100% {
transform: rotate(0deg) translate3d(0, 0, 0);
}
}

.home:hover span {
animation: storm 0.7s ease-in-out both;
animation-delay: 0.06s;
}

.home::before,
.home::after {
content: '';
position: absolute;
right: 0;
bottom: 0;
width: 100px;
height: 100px;
border-radius: 50%;
background: #fff;
opacity: 0;
transition: transform 0.15s cubic-bezier(0.02, 0.01, 0.47, 1), opacity 0.15s cubic-bezier(0.02, 0.01, 0.47, 1);
z-index: -1;
transform: translate(100%, -25%) translate3d(0, 0, 0);
}

.home:hover::before,
.home:hover::after {
opacity: 0.15;
transition: transform 0.2s cubic-bezier(0.02, 0.01, 0.47, 1), opacity 0.2s cubic-bezier(0.02, 0.01, 0.47, 1);
}

.home:hover::before {
transform: translate3d(50%, 0, 0) scale(0.9);
}

.home:hover::after {
transform: translate(50%, 0) scale(1.1);
}


/*end css*/
</style>

    <style>
        .teacher-workflow-page {
            background: #f6f8fc !important;
        }

        .teacher-workflow-shell {
            padding-top: 0;
        }

        .teacher-workflow-container {
            position: relative;
            padding-bottom: 1.5rem;
        }

        .teacher-workflow-hero {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin: 0 0 12px;
            padding: 14px 18px;
            border: 1px solid #e6edf6;
            border-radius: 24px;
            background: linear-gradient(180deg, #ffffff 0%, #f7faff 100%);
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.06);
        }

        .teacher-workflow-hero h4 {
            margin: 0;
            color: #0f172a !important;
            font-size: 1.35rem !important;
            line-height: 1.3;
            font-weight: 800;
            padding-bottom: 0 !important;
        }

        .teacher-workflow-hero__meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .teacher-pill {
            display: inline-flex;
            align-items: center;
            min-height: 32px;
            padding: 0.35rem 0.8rem;
            border-radius: 999px;
            background: #eef3fb;
            color: #41506a;
            font-size: 0.92rem;
            font-weight: 700;
            border: 1px solid #dbe4f0;
        }

        .teacher-workflow-card {
            overflow: visible !important;
            border: 1px solid #e6edf6 !important;
            border-radius: 24px !important;
            background: #fff;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.06);
        }

        .teacher-workflow-card .card-header {
            background: transparent !important;
            border: 0 !important;
            padding: 12px 16px 12px !important;
        }

        .teacher-workflow-card .card-body {
            padding: 12px 16px 18px !important;
        }

        .teacher-workflow-card .nav-tabs {
            border: 0 !important;
            padding: 0 !important;
            gap: 8px;
            display: flex;
            flex-wrap: wrap;
        }

        .teacher-workflow-card .nav-tabs .nav-link {
            border: 1px solid #dbe4f0 !important;
            border-radius: 999px !important;
            padding: 0.6rem 1rem !important;
            background: #f5f8fd !important;
            color: #5b6b84 !important;
            font-weight: 700 !important;
            box-shadow: none !important;
        }

        .teacher-workflow-card .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, #14315c, #1f4b8c) !important;
            color: #fff !important;
            box-shadow: 0 10px 26px rgba(20, 49, 92, 0.18);
        }

        .teacher-workflow-surface {
            border-radius: 20px;
            overflow: hidden;
            background: #fff;
        }

        .teacher-workflow-page table {
            margin: 0 !important;
            border: 0 !important;
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0;
        }

        .teacher-workflow-page .table-responsive {
            margin: 0;
            overflow-x: auto;
        }

        .teacher-workflow-page table thead th {
            background: #f4f7fb !important;
            color: #41506a;
            border-bottom: 1px solid #e4ebf4 !important;
            font-size: 0.95rem !important;
            padding: 14px 12px !important;
            white-space: nowrap;
        }

        .teacher-workflow-page table tbody tr {
            background: #fff !important;
            border: 0 !important;
            transition: background-color 0.18s ease, transform 0.18s ease, box-shadow 0.18s ease;
        }

        .teacher-workflow-page table tbody tr:hover {
            background: #f9fbff !important;
        }

        .teacher-workflow-page table td {
            border-bottom: 1px solid #edf2f7 !important;
            padding: 12px 12px !important;
            vertical-align: middle;
        }

        .teacher-workflow-page table th,
        .teacher-workflow-page table td {
            text-align: center !important;
        }

        .teacher-workflow-page .home,
        .teacher-workflow-page .showstate,
        .teacher-workflow-page .bu,
        .teacher-workflow-page .Btn,
        .teacher-workflow-page .addquestion {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            border-radius: 999px;
            padding-inline: 1rem;
        }

        .teacher-workflow-page .home {
            width: auto;
            min-width: 108px;
            height: auto;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            background-color: #14315c;
            box-shadow: none;
        }

        .teacher-workflow-page .showstate {
            min-width: 108px;
            padding: 0.6rem 0.95rem;
            border: 1px solid #d6e0ed;
            color: #274059;
            background: #fff;
            box-shadow: none;
        }

        .teacher-workflow-page .bu,
        .teacher-workflow-page .Btn {
            width: 42px;
            height: 42px;
            background: #fff;
            border: 1px solid #d6e0ed;
            box-shadow: none;
        }

        .teacher-workflow-page .addquestion {
            height: 40px;
            padding: 0 0.95rem;
            border: 0;
            background: #14315c;
            color: #fff;
        }

        .teacher-workflow-page .modal-content {
            border: 0;
            border-radius: 22px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.15);
        }

        .teacher-workflow-page .modal-header,
        .teacher-workflow-page .modal-footer {
            border: 0;
        }

        .teacher-workflow-page .modal-footer {
            padding-top: 0;
        }

        .teacher-workflow-page .tab-content {
            text-align: right !important;
        }

        @media (max-width: 991px) {
            .teacher-workflow-hero {
                flex-direction: column;
            }

            .teacher-workflow-card .nav-tabs {
                justify-content: flex-start;
            }
        }

        @media (max-width: 767px) {
            .teacher-workflow-card .card-header,
            .teacher-workflow-card .card-body {
                padding-inline: 12px !important;
            }

            .teacher-workflow-page table th,
            .teacher-workflow-page table td {
                padding: 10px 8px !important;
            }
        }
    </style>

</style>


@endsection

@section('content')

<div class="main-panel teacher-workflow-page" style="background: #f6f8fc;">
    <ul class="breadcrumbs" style="padding-bottom: 7px;
    padding-top: 11px;">
      <li class="li"><a href="{{ route('dashboard.teacher') }}">الصفحة الرئيسية</a></li>
      <li class="li"><a href="{{ route('dashboard.teacher_lessons2',['room_id' =>$room_id ,'teacher_id'=>$teacher->id])}}">{{ $room->name }}  </a></li>
      {{--<li class="li"><a href="{{ route('dashboard.teacher_lessons2',['room_id' =>$room_id ,'teacher_id'=>$teacher->id])}}">{{ $lesson->name }}  </a></li>--}}
      <li class="li"><a href="#">الاختبارات</a></li>
   </ul>
    <div class="content-wrapper pb-0 teacher-workflow-shell">
       <!--start content-->
        <div class="container teacher-workflow-container" style="direction: rtl;">
           <div class="teacher-workflow-hero">
                <div>
                    <h4>{{ __('teacher_portal.exams_quizzes.tests_title') }}</h4>
                    <div class="teacher-workflow-hero__meta">
                        <span class="teacher-pill">{{ $room->name }}</span>
                        <span class="teacher-pill">{{ $lesson->name }}</span>
                    </div>
                </div>
            </div>

           <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card teacher-workflow-card">
                <div class="card-body">
                  <h4 style="text-align: center;padding-bottom: 20px;color: #152C4F;font-size: 28px;">الاختبارات</h4>
                  <div class="table-responsive teacher-workflow-surface">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                            <th> اسم الاختبار </th>
                            <th>وقت البداية </th>
                            <th>وقت النهاية </th>
                            <th>عرض العلامات </th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach ( $quize as $item)
                        <tr>
                          <td data-label="اسم الاختبار" class="py-1">
                            {{ $item->name_quize1 }}
                          </td>
                          <td data-label="وقت البداية">{{ $item->start_time }}</td>
                          <td data-label="وقت النهاية">
                            {{ $item->end_time }}
                          </td>
                          <td data-label="عرض العلامات">
                            <a href="{{ route('dashboard.StudentsRoomLesson_exammark1',[$room_id ,$teacher->id,$lesson_id,$item->id]) }}" class="home">
                            <span>الاختبار</span>
                            </a>
                      </td>

                        </tr>
                        @endforeach

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

           </div>

        </div>
       <!--end content-->
    </div><!--end content-wrapper pb-0-->
  </div><!--end main panels-->
{{--

<section class="hero-wrap hero-wrap-2" style="background-image:url( {{  asset('teachers/ppp.jpg') }})">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2"><!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
                <h1 class="mb-0 bread">علامات الاختبارات  </h1>
            </div>
        </div>
    </div>
</section>
<!-- start new-->
 <nav class="breadcrumbs" style="float: left;">

     <a  class="breadcrumbs__item is-active"> الاختبارات   </a>

    <a   href="{{ route('dashboard.teacher_lessons2',['room_id' =>$room_id ,'teacher_id'=>$teacher->id])}}" class="breadcrumbs__item ">{{$lesson->name}}/{{ $room->name }}   </a>

     <a   href="{{ route('dashboard.teacher') }}" class="breadcrumbs__item ">الواجهة الرئيسية
</a>
</nav>

<br>
<br>

<br>
<br>


<!-- marks of homework -->
<table class="">
<thead>
  <tr>
      <th> اسم الاختبار </th>
      <th>وقت البداية </th>
      <th>وقت النهاية </th>
      <th>عرض العلامات </th>

  </tr>
</thead>
<tbody>
    @foreach ( $quize as $item)
  <tr>
      <td> {{ $item->name_quize1 }} </td>
      <td>{{ $item->start_time }}</td>
      <td>{{ $item->end_time }}</td>

      <td><a href="{{ route('dashboard.StudentsRoomLesson_exammark1',[$room_id ,$teacher->id,$lesson_id,$item->id]) }}" class="btn" style="background-color: white; color: rgb(117, 115, 115);">الاختبار  </a>

         </td>
  </tr>
@endforeach
</tbody>
</table>

<!-- end marks of homework-->


     <br>
     <br>
     <br>
     <br>
     <br>
     <br>


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

</script> --}}
@endsection
