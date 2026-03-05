@extends('school_controller.layouts.app')
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
.btn_file {
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

.btn_filebtn_file, .button__icon, .button__text {
  transition: all 0.3s;
}

.btn_file .button__text {
  transform: translateX(22px);
  color: var(--font-color);
  font-weight: 600;
}

.btn_file .button__icon {
  position: absolute;
  transform: translateX(105px);
  height: 100%;
  width: 50px;
  background-color: var(--bg-color-sub);
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn_file .svg {
  width: 20px;
  fill: var(--main-color);
}

.btn_file:hover {
  background: var(--bg-color);
}

.btn_file:hover .button__text {
  color: transparent;
}

.btn_file:hover .button__icon {
  width: 148px;
  transform: translateX(0);
}

.btn_file:active {
  transform: translate(3px, 3px);
  box-shadow: 0px 0px var(--main-color);
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
    left: 30%;
    top: 15%;
    transform: translate(-96%, -0%);
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
    width: 900px;
    padding-right: 115px;
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

</style>
@endsection




@section('content')
    <div class="main-panel" style="background: #f8f9fb;">
        <ul class="breadcrumbs" style="padding-bottom: 7px;
	padding-top: 11px;">

	  <li class="li"><a href="{{ route('dashboard.coordinator') }}">الصفحة الرئيسية</a></li>
	  <li class="li"><a href="{{route('coordinator_electronic_sections')}}">الاقسام الالكترونية</a></li>
      <li class="li"><a href="#">ملفات {{$electronic_sections->name_section}}</a></li>
        </ul>
      <div class="content-wrapper pb-0">
        <div class="container" style="padding-bottom: 100px;">

<div class="timeline">
    @if($electronic_files->isNotEmpty())
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
         <a href="{{ asset('website/assets/files/' . $item->file) }}" target="_blank"
            class="btn_file" type="button">
           <span class="button__text">تحميل الملف</span>
           <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35" id="bdd05811-e15d-428c-bb53-8661459f9307" data-name="Layer 2" class="svg"><path d="M17.5,22.131a1.249,1.249,0,0,1-1.25-1.25V2.187a1.25,1.25,0,0,1,2.5,0V20.881A1.25,1.25,0,0,1,17.5,22.131Z"></path><path d="M17.5,22.693a3.189,3.189,0,0,1-2.262-.936L8.487,15.006a1.249,1.249,0,0,1,1.767-1.767l6.751,6.751a.7.7,0,0,0,.99,0l6.751-6.751a1.25,1.25,0,0,1,1.768,1.767l-6.752,6.751A3.191,3.191,0,0,1,17.5,22.693Z"></path><path d="M31.436,34.063H3.564A3.318,3.318,0,0,1,.25,30.749V22.011a1.25,1.25,0,0,1,2.5,0v8.738a.815.815,0,0,0,.814.814H31.436a.815.815,0,0,0,.814-.814V22.011a1.25,1.25,0,1,1,2.5,0v8.738A3.318,3.318,0,0,1,31.436,34.063Z"></path></svg></span>
           </a>
      </div>
    </div>
  </div>
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
            <div class="box__description-text">لا يوجد ملفات لهذا القسم</div>
          </div>
        </div>

      </div>
    <!--end style-->
</div>
@endif



</div>

        </div>
      </div>
    </div>

@endsection
