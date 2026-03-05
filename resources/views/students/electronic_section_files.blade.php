@extends('students.layouts.app4')
@section('title')
    School
@endsection
@section('css')
<style>

.timeline {
  display: flex;
  flex-direction: column;
  margin: 20px auto;
  position: relative;
}
.timeline__event {
    text-align: center;
  margin-bottom: 20px;
  position: relative;
  display: flex;
  margin: 20px 0;
  border-radius: 6px;
  align-self: center;
  width: 50vw;
}
.timeline__event:nth-child(2n + 1) {
  flex-direction: row-reverse;
}
.timeline__event:nth-child(2n + 1) .timeline__event__date {
  border-radius: 0 6px 6px 0;
}
.timeline__event:nth-child(2n + 1) .timeline__event__content {
  border-radius: 6px 0 0 6px;
}
.timeline__event:nth-child(2n + 1) .timeline__event__icon:before {
  content: "";
  width: 2px;
  height: 100%;
  background: #f6a4ec;
  position: absolute;
  top: 0%;
  left: 50%;
  right: auto;
  z-index: -1;
  transform: translateX(-50%);
  animation: fillTop 2s forwards 4s ease-in-out;
}
.timeline__event:nth-child(2n + 1) .timeline__event__icon:after {
  content: "";
  width: 100%;
  height: 2px;
  background: #f6a4ec;
  position: absolute;
  right: 0;
  z-index: -1;
  top: 50%;
  left: auto;
  transform: translateY(-50%);
  animation: fillLeft 2s forwards 4s ease-in-out;
}
.timeline__event__title {
  font-size: 1.2rem;
  line-height: 3.4;
  text-transform: uppercase;
  font-weight: 600;
  color: #9251ac;
  /* letter-spacing: 1.5px; */
}
.timeline__event__content {
  padding: 20px;
  box-shadow: 0 30px 60px -12px rgba(50, 50, 93, 0.25), 0 18px 36px -18px rgba(0, 0, 0, 0.3), 0 -12px 36px -8px rgba(0, 0, 0, 0.025);
  background: #fff;
  width: calc(40vw - 28px);
  border-radius: 0 6px 6px 0;
}
.timeline__event__date {
  color: #f6a4ec;
  font-size: 1.5rem;
  font-weight: 600;
  background: #9251ac;
  display: flex;
  align-items: center;
  justify-content: center;
  white-space: nowrap;
  padding: 0 20px;
  border-radius: 6px 0 0 6px;
}
.timeline__event__icon {
  display: flex;
  align-items: center;
  justify-content: center;
  color: #9251ac;
  padding: 20px;
  align-self: center;
  margin: 0 20px;
  background: #f6a4ec;
  border-radius: 100%;
  width: 40px;
  box-shadow: 0 30px 60px -12px rgba(50, 50, 93, 0.25), 0 18px 36px -18px rgba(0, 0, 0, 0.3), 0 -12px 36px -8px rgba(0, 0, 0, 0.025);
  padding: 40px;
  height: 40px;
  position: relative;
}
.timeline__event__icon i {
  font-size: 32px;
}
.timeline__event__icon:before {
  content: "";
  width: 2px;
  height: 100%;
  background: #f6a4ec;
  position: absolute;
  top: 0%;
  z-index: -1;
  left: 50%;
  transform: translateX(-50%);
  animation: fillTop 2s forwards 4s ease-in-out;
}
.timeline__event__icon:after {
  content: "";
  width: 100%;
  height: 2px;
  background: #f6a4ec;
  position: absolute;
  left: 0%;
  z-index: -1;
  top: 50%;
  transform: translateY(-50%);
  animation: fillLeftOdd 2s forwards 4s ease-in-out;
}
.timeline__event__description {
  flex-basis: 60%;
}
.timeline__event--type2:after {
  background: #555ac0;
}
.timeline__event--type2 .timeline__event__date {
  color: #87bbfe;
  background: #555ac0;
}
.timeline__event--type2:nth-child(2n + 1) .timeline__event__icon:before, .timeline__event--type2:nth-child(2n + 1) .timeline__event__icon:after {
  background: #87bbfe;
}
.timeline__event--type2 .timeline__event__icon {
  background: #87bbfe;
  color: #555ac0;
}
.timeline__event--type2 .timeline__event__icon:before, .timeline__event--type2 .timeline__event__icon:after {
  background: #87bbfe;
}
.timeline__event--type2 .timeline__event__title {
  color: #555ac0;
}
.timeline__event--type3:after {
  background: #24b47e;
}
.timeline__event--type3 .timeline__event__date {
  color: #aff1b6;
  background-color: #24b47e;
}
.timeline__event--type3:nth-child(2n + 1) .timeline__event__icon:before, .timeline__event--type3:nth-child(2n + 1) .timeline__event__icon:after {
  background: #82b1f4;
}
.timeline__event--type3 .timeline__event__icon {
    background: #95befa;
    color: #3c64a1;
}
.timeline__event--type3 .timeline__event__icon:before, .timeline__event--type3 .timeline__event__icon:after {
  background: #82b1f4;
}
.timeline__event--type3 .timeline__event__title {
  color: #152c4f;
}
.timeline__event:last-child .timeline__event__icon:before {
  content: none;
}
@media (max-width: 786px) {
  .timeline__event {
    flex-direction: column;
    align-self: center;
  }
  .timeline__event__content {
    width: 100%;
  }
  .timeline__event__icon {
    border-radius: 6px 6px 0 0;
    width: 100%;
    margin: 0;
    box-shadow: none;
  }
  .timeline__event__icon:before, .timeline__event__icon:after {
    display: none;
  }
  .timeline__event__date {
    border-radius: 0;
    padding: 20px;
  }
  .timeline__event:nth-child(2n + 1) {
    flex-direction: column;
    align-self: center;
  }
  .timeline__event:nth-child(2n + 1) .timeline__event__date {
    border-radius: 0;
    padding: 20px;
  }
  .timeline__event:nth-child(2n + 1) .timeline__event__icon {
    border-radius: 6px 6px 0 0;
    margin: 0;
  }
}
@keyframes fillLeft {
  100% {
    right: 100%;
  }
}
@keyframes fillTop {
  100% {
    top: 100%;
  }
}
@keyframes fillLeftOdd {
  100% {
    left: 100%;
  }
}
/* css for download button */
.button {
  --main-focus: #2d8cf0;
  --font-color: #323232;
  --bg-color-sub: #dedede;
  --bg-color: #eee;
  --main-color: #2b4770;
  position: relative;
  width: 150px;
  height: 40px;
  cursor: pointer;
  display: flex;
  align-items: center;
  border: 2px solid var(--main-color);
  box-shadow: 4px 4px var(--main-color);
  background-color: var(--bg-color);
  border-radius: 10px;
  overflow: hidden;
  margin: auto
}

.button, .button__icon, .button__text {
  transition: all 0.3s;
}

.button .button__text {
  transform: translateX(22px);
  color: var(--font-color);
  font-weight: 600;
}

.button .button__icon {
  position: absolute;
  transform: translateX(105px);
  height: 100%;
  width: 24px;
  background-color: var(--bg-color-sub);
  display: flex;
  align-items: center;
  justify-content: center;
}

.button .svg {
  width: 20px;
  fill: var(--main-color);
}

.button:hover {
  background: var(--bg-color);
}

.button:hover .button__text {
  color: transparent;
}

.button:hover .button__icon {
  width: 148px;
  transform: translateX(0);
}

.button:active {
  transform: translate(3px, 3px);
  box-shadow: 0px 0px var(--main-color);
}

</style>
@endsection




@section('content')
    <div class="main-panel" style="background: #f8f9fb;">
        <ul class="breadcrumbs" style="padding-bottom: 7px;
	padding-top: 11px;">

	  <li class="li"><a href="{{ route('dashboard.student.lessons',$student->id) }}">الصفحة الرئيسية</a></li>
	  <li class="li"><a href="{{route('student_electronic_sections')}}">الاقسام الالكترونية</a></li>
      <li class="li"><a href="#">ملفات {{$electronic_sections->name_section}}</a></li>
        </ul>
      <div class="content-wrapper pb-0">
        <div class="container" style="padding-bottom: 100px;">

<div class="timeline">
    @foreach ($electronic_files  as $item)
  <div class="timeline__event  animated fadeInUp delay-1s timeline__event--type3">
    <div class="timeline__event__icon ">
        <i class="mdi mdi-book-multiple menu-icon"></i>
    </div>
    <div class="timeline__event__content ">
      <div class="timeline__event__title">
        {{$item->file_name}}
      </div>
      <div class="timeline__event__description">
           @if (!empty($item->link))
                    
         <a href=" {{ $item->link }}" target="_blank"
            class="button" type="button">
           <span class="button__text">تحميل الملف</span>
           <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35" id="bdd05811-e15d-428c-bb53-8661459f9307" data-name="Layer 2" class="svg"><path d="M17.5,22.131a1.249,1.249,0,0,1-1.25-1.25V2.187a1.25,1.25,0,0,1,2.5,0V20.881A1.25,1.25,0,0,1,17.5,22.131Z"></path><path d="M17.5,22.693a3.189,3.189,0,0,1-2.262-.936L8.487,15.006a1.249,1.249,0,0,1,1.767-1.767l6.751,6.751a.7.7,0,0,0,.99,0l6.751-6.751a1.25,1.25,0,0,1,1.768,1.767l-6.752,6.751A3.191,3.191,0,0,1,17.5,22.693Z"></path><path d="M31.436,34.063H3.564A3.318,3.318,0,0,1,.25,30.749V22.011a1.25,1.25,0,0,1,2.5,0v8.738a.815.815,0,0,0,.814.814H31.436a.815.815,0,0,0,.814-.814V22.011a1.25,1.25,0,1,1,2.5,0v8.738A3.318,3.318,0,0,1,31.436,34.063Z"></path></svg></span>
           </a>
                @else
        <a href="{{ asset('website/assets/files/' . $item->file) }}" target="_blank"
            class="button" type="button">
           <span class="button__text">تحميل الملف</span>
           <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35" id="bdd05811-e15d-428c-bb53-8661459f9307" data-name="Layer 2" class="svg"><path d="M17.5,22.131a1.249,1.249,0,0,1-1.25-1.25V2.187a1.25,1.25,0,0,1,2.5,0V20.881A1.25,1.25,0,0,1,17.5,22.131Z"></path><path d="M17.5,22.693a3.189,3.189,0,0,1-2.262-.936L8.487,15.006a1.249,1.249,0,0,1,1.767-1.767l6.751,6.751a.7.7,0,0,0,.99,0l6.751-6.751a1.25,1.25,0,0,1,1.768,1.767l-6.752,6.751A3.191,3.191,0,0,1,17.5,22.693Z"></path><path d="M31.436,34.063H3.564A3.318,3.318,0,0,1,.25,30.749V22.011a1.25,1.25,0,0,1,2.5,0v8.738a.815.815,0,0,0,.814.814H31.436a.815.815,0,0,0,.814-.814V22.011a1.25,1.25,0,1,1,2.5,0v8.738A3.318,3.318,0,0,1,31.436,34.063Z"></path></svg></span>
           </a>
                @endif
        
      </div>
    </div>
  </div>
  @endforeach



</div>

        </div>
      </div>
    </div>

@endsection
