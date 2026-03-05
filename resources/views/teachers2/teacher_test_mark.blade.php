@extends('teachers2.layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('teachers_2/assets/css/newteacher.css')}}">
<style>

   /*ens css select*/
   .select2-container .select2-selection--single .select2-selection__rendered{
    display: block;
    padding-left: 0px;
    /* padding-right: 20px; */
    
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    position: relative;
    bottom: 15px;
    text-align: center;
   }
   .select2-results{
    text-align: center;
   }
   .form-control, .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--single .select2-search__field, .typeahead, .tt-query, .tt-hint{
    font-size: 17px;
    font-weight: 600;
   }
   
   .table th, .table td {
    vertical-align: middle;
    font-size: 0.875rem;
    line-height: 1;
    white-space: nowrap;
    /* padding-bottom: 35px; */
    padding-top: 5px;
    padding-bottom: 40px;
}

.showstate {
  background: transparent;
  position: relative;
  padding: 5px 15px;
  display: inline-flex;
  align-items: center;
  font-size: 17px;
  font-weight: 600;
  text-decoration: none;
  cursor: pointer;
  border: 1px solid #152C4F;
  border-radius: 25px;
  outline: none;
  overflow: hidden;
  color: #152C4F ;
  transition: color 0.3s 0.1s ease-out;
  text-align: center;
}

.showstate span {
  margin: 10px;
}

.showstate::before {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
  content: '';
  border-radius: 50%;
  display: block;
  width: 20em;
  height: 20em;
  left: -5em;
  text-align: center;
  transition: box-shadow 0.5s ease-out;
  z-index: -1;
}

.showstate:hover {
  color: #152C4F ;
  border: 1px solid #152C4F;
}

.showstate:hover::before {
  box-shadow: inset 0 0 0 10em #152C4F;
}
.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #e4e9f0;
    font-size: 18px;
    font-weight: 800;
    /* padding-top: 6px; */
    text-align: center;
    padding-bottom: 20px;
    padding-top: 15px;
}
</style>
@endsection
@section('content')

<div class="main-panel" style="background: #f8f9fb;">
  <ul class="breadcrumbs" style="padding-bottom: 7px;
  padding-top: 11px;">

  <li class="li"><a href="{{ route('dashboard.teacher') }}">المواد</a></li>

  <li class="li"><a
          href="{{ route('dashboard.teacher_lessons2', ['room_id' => $room_id, 'teacher_id' => $teacher->id]) }}">{{ $room->name }}</a>
  </li>
  <li class="li"><a
          href="{{ route('dashboard.lessons.lectures', ['lesson_id' => $lesson->id, 'teacher_id' => $teacher->id, 'room_id' => $room->id]) }}">{{ $lesson->name }}
      </a></li>
      <li class="li"><a
          href="{{ route('dashboard.student.lessons.book_details',[$lesson->id,$teacher->id,$room->id ,$exam1->lecture->id]) }}">{{ $exam1->lecture->name }}
      </a></li>

  <li class="li"><a href="#">

          {{ $exam1->name_quize1 }}
  </a></li>

</ul>
    <div class="content-wrapper pb-0">
       <!--start content-->
        <div class="container" style="direction: rtl;">
           <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                        <p style="color: #9ea7af;
                        text-align: right;">وقت البداية : {{ $exam1->start_time }}</p>
                        <p style="color: #9ea7af;
                        text-align: right;">وقت النهاية : {{ $exam1->end_time }}</p>
                 
                </div>
                    <div class="col-md-4">
                <h4 style="text-align: center;padding-bottom: 20px;color: #152C4F;font-size: 28px;">علامات
                    الاختبارات</h4>
                </div>
                    <div class="col-md-4">
                     
                 
                </div>
                </div>
                  <div class="row" style="position: relative;top: -80px;right: 85px;">
                    <div class="col-md-6" style="height: 80px;">
                      <div class="form-group newselect" style="width: 300px;">
                        <input  class="homeid"  hidden value="{{ $exam1->id}}">
                        <select class="js-example-basic-single  choice" style="width: 100%;direction: rtl;">
                          <option value="0">اختر الطلاب</option>
                          <option value="1">المتقدمين</option>
                          <option value="2">غير المتقدمين</option>
                        </select>
                      </div>
                    </div>
                  </div>
                
                  <!--end select students-->
                  <div class="table-responsive">
                    <table class="table table-striped table1">
                      <thead>
                        <tr>
                          <th>الرقم التسلسلي</th>
                          <th>اسم الطالب </th>
                          <th>العلامة</th>
                          <th>تصحيح الملف</th>
                        
                         
                        </tr>
                      </thead>
                      <tbody>
                        <input  style="width:80px; height: 45px;display: inline-block;" class="room_id"  hidden name="room_id"  value="{{ $room_id }}"  type="text">
                   
                        @foreach ($quize_result as $item)

            @foreach ($item->student as $item2)
            <tr>
                <form action="{{ route('dashboard.teacher.student_save_mark') }}" method="post" enctype="multipart/form-data">
                    @csrf

                <td class="py-1">{{ $item2->id }}</td>
                <td class="py-1">{{ $item2->first_name }} {{ $item2->last_name }} </td>


                <td class="py-1">
                    @if($item2->exam_result->count()>0)
                    @foreach ($item2->exam_result as $item3)
                    @php
                        $i2=0
                    @endphp
                    @if ($item3->exam_id == $exam_id  )


                    <input  style="width:80px; height: 45px;display: inline-block;"  hidden name="exam_result_id"  value="{{ $item3->id }}" type="text">

                       <input  hidden  style="width:80px; height: 45px;display: inline-block;" name="mark" value="{{ $item3->result!=null ?$item3->result : '' }}" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control input1"  type="text">

                       @endif


                    @endforeach
                    <input  style="width:80px; height: 45px;display: inline-block;" name="mark" value="" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control input2"  type="text">
                    @else
                    <input  style="width:80px; height: 45px;display: inline-block;" name="mark" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" class="common-input mb-20 form-control" required="" type="text">
                    @endif

                     <input  style="width:80px; height: 45px;display: inline-block;"  hidden name="class_id"  value="{{ $room_id }}" type="text">
                     <input  style="width:80px; height: 45px;display: inline-block;" class="room_id"  hidden name="room_id"  value="{{ $room_id }}"  type="text">
                     <input  style="width:80px; height: 45px;display: inline-block;"  hidden name="exam_id"  value="{{ $exam_id }}" type="text">
                     <input  style="width:80px; height: 45px;display: inline-block;"  hidden name="lesson_id"  value="{{ $lesson_id }}" type="text">
                     <input  style="width:80px; height: 45px;display: inline-block;"  hidden name="user_id"  value="{{ $item2->id }}" type="text">

                </td>
                <td class="py-1">
                @if($item2->exam_result->count()>0)
                @foreach ($item2->exam_result as $item322)

                @if ($item322->exam_id == $exam_id  )

                @if ($item322->type==5 ||$item322->type==8)

                <a href="#" class="showstate"  >    <span> تصحيح الاختبار</span> </a>


                @else

                @endif

                @endif
                @endforeach
                  @else
                @endif
                <!--<button type="submit" class="btn"  style="background-color: white; color: rgb(117, 115, 115);" >تعديل  </button>-->
            </td>

        {{-- <td class="py-1">
               

                  @if($item2->exam_result->count()>0)
                @foreach ($item2->exam_result as $item3)

                @if ($item3->exam_id == $exam_id  )
                        @if ($item3->medal ==  "1" )



                        <img src="{{  asset('teachers/medal1.png') }}" style="height: 86px;width:86px">
                @elseif($item3->medal ==  "2" )
                 <img src="{{  asset('teachers/medal2.png') }}" style="height: 86px;width:86px">
                @elseif($item3->medal ==  "3" )
                 <img src="{{  asset('teachers/medal3.png') }}" style="height: 86px;width:86px">
                @endif


                @endif
                @endforeach


                @endif





            </td> --}}

            </tr>
           @endforeach
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
    

    <!-- container-scroller -->
    @endsection
    @section('js')
    <script>
      $(document).ready(function () {
          $.each($('.input1'),function (key,value) {
              var z=value.value;
              $(this).parent().find('.input2').val(z);
          })
  
  
  
  
  })
  $(document).on('change', '.choice', function () {
  
  var lect=$(this).val();
  var home =$('.homeid').val();
  var room_id=$('.room_id').val();
   var data={
  
                          "room_id":room_id,
  
                      }
  var url = "{{ URL::to('SMARMANger/dashboard/teacher/examstudent') }}/" + lect+"/"+home ;
  $.ajax({
  url: url,
  data : data,
  type: "get",
  contentType: 'application/json',
  success: function (data) {
  
  console.log(data);
  
  if(lect==1){
      $('.table1 tbody').empty();
      $.each(data, function (key, value) {
           medal=` <td style="height: 86px">
  
              </td>`
          if(value.exam_result.length>0){
      $.each(value.exam_result, function (key1, value1) {
          if(value1.exam_id==home){
              d=`<input  style="width:80px; height: 45px;display: inline-block;"  hidden name="exam_result_id"  value="${value1.id}" type="text">
      <input   style="height: 50px; width:60px;    margin: auto;" name="mark" value="${value1.result}"  class="common-input mb-20 form-control input1"  type="text">`
    if(value1.medal=="1"){
           medal=` <td style="height: 86px">
  
                  <img src="{{  asset('teachers/medal1.png') }}" style="height: 86px;width:86px">
              </td>`
    }
    else if(value1.medal=="2"){
          medal=` <td style="height: 86px">
  
                  <img src="{{  asset('teachers/medal2.png') }}" style="height: 86px;width:86px">
              </td>`
  
    }
    else if(value1.medal=="3"){
          medal=` <td style="height: 86px">
  
                  <img src="{{  asset('teachers/medal3.png') }}" style="height: 86px;width:86px">
              </td>`
    }
  
  
  }
  
  
  })
  }
  
  
          $('.table1 tbody').append(`
  
  
          <tr  id="st">
  
              <td>${ value.id }</td>
  <td>${ value.first_name } ${ value.last_name}</td>
  
  
  <td>${d}</td>
  
  <td> <a href="{{url('SMARMANger/dashboard/exam/correct_exam') }}/${home}/${value.id}" class="showstate"  >    <span>  تصحيح الامتحان  </span> </a>
     </td>
  

  
  
  </tr> `)
  
  });
  
  }
  else if(lect==2){
      $('.table1 tbody').empty();
      $.each(data, function (key, value) {
           medal=`<td style="height: 86px"> </td>`
            d=`<input  style="width:80px; height: 45px;display: inline-block;"  hidden name="exam_result_id"  value="" type="text">
      <input    style="width:80px; height: 45px;display: inline-block;" name="mark" value=""  class="common-input mb-20 form-control input1"  type="text">`
          if(value.exam_result){
  
          if(value.exam_result.length>0){
  
      $.each(value.exam_result, function (key1, value1) {
          if(value1.exam_id==home){
              if(value1.result != null){
              d=`<input  style="width:80px; height: 45px;display: inline-block;"  hidden name="exam_result_id"  value="${value1.id}" type="text">
      <input   style="height: 50px; width:60px;    margin: auto;" name="mark" value="${value1.result}"  class="common-input mb-20 form-control input1"  type="text">`
              }
                if(value1.medal=="1"){
           medal=` <td style="height: 86px">
  
                  <img src="{{  asset('teachers/medal1.png') }}" style="height: 86px;width:86px">
              </td>`
    }
    else if(value1.medal=="2"){
          medal=` <td style="height: 86px">
  
                  <img src="{{  asset('teachers/medal2.png') }}" style="height: 86px;width:86px">
              </td>`
  
    }
    else if(value1.medal=="3"){
          medal=` <td style="height: 86px">
  
                  <img src="{{  asset('teachers/medal3.png') }}" style="height: 86px;width:86px">
              </td>`
    }
  }
  else{
      d=`<input  style="width:80px; height: 45px;display: inline-block;"  hidden name="exam_result_id"  value="" type="text">
      <input   style="height: 50px; width:60px;    margin: auto;" name="mark" value=""  class="common-input mb-20 form-control input1"  type="text"> `
  
  }
  })
  }
    $('.table1 tbody').append(`<tr  id="st">
  
              <td>${ value.id }</td>
  <td>${ value.first_name } ${ value.last_name}</td>
  
  
  <td>${d}</td>
  
  <td> <a href="{{url('SMARMANger/dashboard/exam/correct_exam') }}/${home}/${value.id}" class="showstate"  >    <span>  تصحيح الامتحان  </span> </a>
  
      </td>
  
 
  
  
      </tr> `)
  }
  
  else{
       d=`<input  style="width:80px; height: 45px;display: inline-block;"  hidden name="exam_result_id"  value="" type="text">
      <input    style="width:80px; height: 45px;display: inline-block;" name="mark" value=""  class="common-input mb-20 form-control input1"  type="text"> `
      if(value.id==room_id){
            $.each(value.student, function (key, value2) {
  
             $('.table1 tbody').append(`<tr  id="st">
  
              <td>${ value2.id }</td>
  <td>${ value2.first_name } ${ value2.last_name}</td>
  
  <td>${d}</td>
  
  <td> <a href="{{url('SMARMANger/dashboard/exam/correct_exam') }}/${home}/${value2.id}" class="showstate"  >    <span>  تصحيح الامتحان  </span> </a>
  
      </td>
   
  
      </tr> `)
       })
      }
  
  }
  
  
  
  });
  
  }
  
  
  
  },
  error: function (xhr) {
  
  }
  
  });})
  
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
