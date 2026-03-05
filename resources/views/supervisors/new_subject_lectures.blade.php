@extends('supervisors.layouts.new_app')
@section('css')
<style>
	 @media(min-width:1200px) and (max-width:2000px){
          .lessondate{
            text-align: right;
            left: 18px;
            top: -15px;
          }
        }
        @media(min-width:200px) and (max-width:1200px){
          .lessondate{
            text-align: right;
            left: 18px;
            top: -15px;
          }
          form div button {
         margin-left: 0px !important;
}
        }
        
        .col-md-4 {
          margin-bottom: 20px;
        }
        .form{
          --width-of-input: 100%;
        }
        @media(min-width:1200px) and (max-width:1900px){
          .textcol{
            left: 15px;
          }
        }
        @media (min-width: 1011px) and (max-width: 1300px){
          .newselect {
    position: relative;
    left: 0;
}
        }
        .form {
       --width-of-input: 100%;
      }
      .input {
    font-size: 0.9rem;
    background-color: transparent;
    width: 100%;
    height: 100%;
    padding-inline: 0.5em;
    padding-block: 0.7em;
    border: none;
}
      .form {
    --timing: 0.3s !important;
    --width-of-input: 100% !important;
    --height-of-input: 40px !important;
    --border-height: 2px !important;
    --input-bg: #a5c9ff !important;
    --border-color: #4382E0 !important;
    --border-radius: 30px !important;
    --after-border-radius: 1px !important;
    position: relative !important;
    width: var(--width-of-input) !important;
    height: var(--height-of-input) !important;
    display: flex !important;
    align-items: center !important;
    padding-inline: 0.8em !important;
    border-radius: var(--border-radius) !important;
    transition: border-radius 0.5s ease !important;
    background: var(--input-bg,#fff) !important;
    flex-direction: initial !important;
    padding: 0 !important;
    box-shadow: none !important;
}
.form button {
    border: none;
    background: none;
    color: #4382E0;
}

.box {
 /* width:100%;*/
  height: 100%;
  max-height: 600px;
  min-height: 450px;
  background: transparent !important;
  border-radius: 20px;
  position: absolute;
  left: 59%;
  top: 28%;
  /*transform: translate(-50%, -50%);
  padding: 30px 50px;*/
}
@media(min-width:100px) and (max-width:594px){
    .box {
        left: 0% !important;
        top: 45% !important;
    }
}

@media(min-width:595px) and (max-width:695px){
    .box {
        left: 0% !important;
        top: 28% !important;
    }
}

@media(min-width:696px) and (max-width:700px){
    .box {
        left: 50% !important;
        top: 28% !important;
    }
}

.box .box__ghost {
  padding: 15px 25px 25px;
  position: absolute;
  left: 50%;
  top: 30%;
  transform: translate(-50%, -0%);
}
.box .box__ghost .symbol:nth-child(1) {
  opacity: 0.2;
  animation: shine 4s ease-in-out 3s infinite;
}
.box .box__ghost .symbol:nth-child(1):before, .box .box__ghost .symbol:nth-child(1):after {
  content: '';
  width: 12px;
  height: 4px;
  background: #332F63;
  position: absolute;
  border-radius: 5px;
  bottom: 65px;
  left: 0;
}
.box .box__ghost .symbol:nth-child(1):before {
  transform: rotate(45deg);
}
.box .box__ghost .symbol:nth-child(1):after {
  transform: rotate(-45deg);
}
.box .box__ghost .symbol:nth-child(2) {
  position: absolute;
  left: -5px;
  top: 30px;
  height: 18px;
  width: 18px;
  border: 4px solid;
  border-radius: 50%;
  border-color: #332F63;
  opacity: 0.2;
  animation: shine 4s ease-in-out 1.3s infinite;
}
.box .box__ghost .symbol:nth-child(3) {
  opacity: 0.2;
  animation: shine 3s ease-in-out 0.5s infinite;
}
.box .box__ghost .symbol:nth-child(3):before, .box .box__ghost .symbol:nth-child(3):after {
  content: '';
  width: 12px;
  height: 4px;
  background: #332F63;
  position: absolute;
  border-radius: 5px;
  top: 5px;
  left: 40px;
}
.box .box__ghost .symbol:nth-child(3):before {
  transform: rotate(90deg);
}
.box .box__ghost .symbol:nth-child(3):after {
  transform: rotate(180deg);
}
.box .box__ghost .symbol:nth-child(4) {
  opacity: 0.2;
  animation: shine 6s ease-in-out 1.6s infinite;
}
.box .box__ghost .symbol:nth-child(4):before, .box .box__ghost .symbol:nth-child(4):after {
  content: '';
  width: 15px;
  height: 4px;
  background: #332F63;
  position: absolute;
  border-radius: 5px;
  top: 10px;
  right: 30px;
}
.box .box__ghost .symbol:nth-child(4):before {
  transform: rotate(45deg);
}
.box .box__ghost .symbol:nth-child(4):after {
  transform: rotate(-45deg);
}
.box .box__ghost .symbol:nth-child(5) {
  position: absolute;
  right: 5px;
  top: 40px;
  height: 12px;
  width: 12px;
  border: 3px solid;
  border-radius: 50%;
  border-color: #332F63;
  opacity: 0.2;
  animation: shine 1.7s ease-in-out 7s infinite;
}
.box .box__ghost .symbol:nth-child(6) {
  opacity: 0.2;
  animation: shine 2s ease-in-out 6s infinite;
}
.box .box__ghost .symbol:nth-child(6):before, .box .box__ghost .symbol:nth-child(6):after {
  content: '';
  width: 15px;
  height: 4px;
  background: #332F63;
  position: absolute;
  border-radius: 5px;
  bottom: 65px;
  right: -5px;
}
.box .box__ghost .symbol:nth-child(6):before {
  transform: rotate(90deg);
}
.box .box__ghost .symbol:nth-child(6):after {
  transform: rotate(180deg);
}
.box .box__ghost .box__ghost-container {
  background: #332F63;
  width: 150px;
  height: 150px;
  border-radius: 100px 100px 0 0;
  position: relative;
  margin: 0 auto;
  animation: upndown 3s ease-in-out infinite;
}
.box .box__ghost .box__ghost-container .box__ghost-eyes {
  position: absolute;
  left: 50%;
  top: 45%;
  height: 12px;
  width: 70px;
}
.box .box__ghost .box__ghost-container .box__ghost-eyes .box__eye-left {
  width: 12px;
  height: 12px;
  background: #ffff;
  border-radius: 50%;
  margin: 0 10px;
  position: absolute;
  left: 0;
}
.box .box__ghost .box__ghost-container .box__ghost-eyes .box__eye-right {
  width: 12px;
  height: 12px;
  background: #ffff;
  border-radius: 50%;
  margin: 0 10px;
  position: absolute;
  right: 0;
}
.box .box__ghost .box__ghost-container .box__ghost-bottom {
  display: flex;
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
}
.box .box__ghost .box__ghost-container .box__ghost-bottom div {
  flex-grow: 1;
  position: relative;
  top: -10px;
  height: 20px;
  border-radius: 100%;
  background-color: #332F63;
}
.box .box__ghost .box__ghost-container .box__ghost-bottom div:nth-child(2n) {
  top: -12px;
  margin: 0 0px;
  border-top: 15px solid #332F63;
  background: transparent;
}
.box .box__ghost .box__ghost-shadow {
  height: 20px;
  box-shadow: 0 50px 15px 5px #3B3769;
  border-radius: 50%;
  margin: 0 auto;
  animation: smallnbig 3s ease-in-out infinite;
}
.box .box__description {
  position: absolute;
  bottom: 150px;
  left: 50%;
  transform: translateX(-50%);
}
.box .box__description .box__description-container {
  color: #fff;
  text-align: center;
  width: 500px;
  font-size: 16px;
  margin: 0 auto;
}
.box .box__description .box__description-container .box__description-title {
  font-size: 24px;
  letter-spacing: 0.5px;
}
.box .box__description .box__description-container .box__description-text {
  color: #8C8AA7;
  line-height: 20px;
  margin-top: 20px;
  font-size: 40px
}
.box .box__description .box__button {
  display: block;
  position: relative;
  background: #FF5E65;
  border: 1px solid transparent;
  border-radius: 50px;
  height: 50px;
  text-align: center;
  text-decoration: none;
  color: #fff;
  line-height: 50px;
  font-size: 18px;
  padding: 0 70px;
  white-space: nowrap;
  margin-top: 25px;
  transition: background 0.5s ease;
  overflow: hidden;
  -webkit-mask-image: -webkit-radial-gradient(white, black);
}
.box .box__description .box__button:before {
  content: '';
  position: absolute;
  width: 20px;
  height: 100px;
  background: #fff;
  bottom: -25px;
  left: 0;
  border: 2px solid #fff;
  transform: translateX(-50px) rotate(45deg);
  transition: transform 0.5s ease;
}
.box .box__description .box__button:hover {
  background: transparent;
  border-color: #fff;
}
.box .box__description .box__button:hover:before {
  transform: translateX(250px) rotate(45deg);
}
@keyframes upndown {
  0% {
    transform: translateY(5px);
  }
  50% {
    transform: translateY(15px);
  }
  100% {
    transform: translateY(5px);
  }
}
@keyframes smallnbig {
  0% {
    width: 90px;
  }
  50% {
    width: 100px;
  }
  100% {
    width: 90px;
  }
}
@keyframes shine {
  0% {
    opacity: 0.2;
  }
  25% {
    opacity: 0.1;
  }
  50% {
    opacity: 0.2;
  }
  100% {
    opacity: 0.2;
  }
}
.sidebar {
    min-height: calc(100vh - -190px) !important;}

    ::-webkit-input-placeholder { /* WebKit, Blink, Edge */
    color: #fff;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
    color: #fff;
    opacity: 1;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
    color: #fff;
    opacity: 1;
}

:-ms-input-placeholder { /* Internet Explorer 10-11 */
    color: #fff;
}

::placeholder { /* Most modern browsers support this now. */
    color: #fff;
}
input[type="date"], input[type="time"], input[type="datetime-local"], input[type="month"]{
    -webkit-appearance: listbox;
    color: #fff;
}
input[type="date"]::-webkit-calendar-picker-indicator {
  filter: invert(1);
}
.col-md-12 input[type="date"], input[type="time"], input[type="datetime-local"], input[type="month"]{
    -webkit-appearance: listbox;
    color: #161515 !important;
}
.col-md-12 input[type="date"]::-webkit-calendar-picker-indicator {
  filter: invert(0);
}

</style>
@endsection

@section('content')


<div class="main-panel" style="background: #f8f9fb;">
    <ul class="breadcrumbs" style="padding-bottom: 7px;
    padding-top: 11px;">
      <li class="li"><a href="{{ route('dashboard.supervisor') }}">الصفحة الرئيسية</a></li>
      <li class="li"><a href="{{ route('dashboard.edu_supervisor.subjects',['room_id' => $room->id])}}">{{ $room->name }}</a></li>
      <li class="li"><a href="#">{{ $lesson->name }}</a></li>
   </ul>


    <div class="content-wrapper pb-0">
     
     
      <!--lessons-->
       <div class="container" style="padding-bottom: 100px;">

        <input hidden value="{{ $lesson->id }}" id="lesson_id">
        <input hidden id="room_id" value="{{ $room->id }}">
         <div class="row   newarticls">
    @if($lectures->isNotEmpty())
       @foreach ($lectures as $item )
       @if($item->lecture_time < $now )
           <div class="col-md-4 div_lesson {{ "ll_".$item->id }}">
            <section class="articles">
              <!--start card-->
              <article>
                  <div class="article-wrapper">
                    <figure>
                      <img src="{{asset('teachers_2/icons/sub1.jpg')}}" alt="" />
                    </figure>
                    <div class="article-body">
                       <div class="container">
                        <div class="row">
                           <div class="col-md-12 lessondate">
                            <span style="font-size: 15px;;">
                              <i class="mdi mdi-calendar" style="font-size: 14px;"></i>&nbsp;{{$item->lecture_time}}</span>
                           </div>
                        </div>
                         <div class="row" style="justify-content: space-between;">
                           <h2>{{ $item->name }}</h2>
                          
                         </div>
                       </div>
                       <div class="row" style="justify-content: space-around;">
                        <button class="button">
                          <a href="{{ route('dashboard.edu_supervisor.lecture_content',[$lesson->id,$room->id,$item->id]) }}" style="color: #fff;" > مشاهدة المحتوى</a>
                        </button>
                      
                       </div>
                    </div>
                  </div>
                </article>
              <!--end card-->
            </section>
           </div>
           @endif
           @endforeach
           @else
           <div>
       
            <!--style for no lectures found-->
            <div class="box">
                <div class="box__ghost">
                  <div class="symbol"></div>
                  <div class="symbol"></div>
                  <div class="symbol"></div>
                  <div class="symbol"></div>
                  <div class="symbol"></div>
                  <div class="symbol"></div>
    
                  <div class="box__ghost-container">
                    <div class="box__ghost-eyes">
                      <div class="box__eye-left"></div>
                      <div class="box__eye-right"></div>
                    </div>
                    <div class="box__ghost-bottom">
                      <div></div>
                      <div></div>
                      <div></div>
                      <div></div>
                      <div></div>
                    </div>
                  </div>
                  <div class="box__ghost-shadow"></div>
                </div>
    
                <div class="box__description">
                  <div class="box__description-container">
                    <div class="box__description-text">لايوجد دروس لهذه المادة</div>
                  </div>
                </div>
    
              </div>
            <!--end style-->
        </div>
@endif

<!--edit name lesson-->

   <!-- end model-->
<!--end edit modal-->




         </div>

       </div>
      <!--end lessons-->

  <!-- main-panel ends -->
</div><!--end container of cards-->
<!-- page-body-wrapper ends -->
</div>
@endsection

@section('js')
@endsection
