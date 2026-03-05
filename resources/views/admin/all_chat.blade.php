@extends('admin.master')

@section('style')



<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Stylesheet -->
    <link rel="stylesheet" href="style.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <style>

.player2 {
    top: 40px;
    margin: 0 auto;
  position: relative;
  width: 10em;
  min-height: 20em;
  overflow: hidden;
  background-color: #eee;
  border-radius: 0.25em;
  box-shadow:
    0 1.5em 2em -1em rgba(0,0,0,0.8),
    inset 0 0.0625em 0 rgba(255,255,255,1),
    inset 0 -0.125em 0.0625em rgba(0,0,0,0.3);
}

.album2 {
  position: relative;
  left: 50%;
  width: 15em;
  height: 15em;
  margin-bottom: -13%;
  overflow: hidden;
  transform: translate(-50%,-25%);
  background-color: #111;
  border: 1px solid #111;
  border-radius: 50%;
  box-shadow:
    0 0.0625em 0.1875em rgba(0,0,0,0.5),
    0 0 0.125em 0.3125em #ddd,
    0 0.0625em 0 0.375em #bbb,
    0 0 0.375em 0.325em rgba(0,0,0,0.3),
    0 0 0.5em 0.375em rgba(0,0,0,0.3),
    0 0.25em 1em 0.5em rgba(0,0,0,0.15),
    inset 0 0 0 0.0625em rgba(0,0,0,0.5),
    inset 0 0 0 0.1875em rgba(255,255,255,1),
    inset 0 0 0 0.375em rgba(0,0,0,0.5),
    inset 0 0 0 0.4375em rgba(255,255,255,0.2),
    inset 0 0 0 0.5em rgba(0,0,0,0.5),
    inset 0 0 0 0.5625em rgba(255,255,255,0.3),
    inset 0 0 0 0.625em rgba(0,0,0,0.5),
    inset 0 0 0 0.6875em rgba(255,255,255,0.2),
    inset 0 0 0 0.75em rgba(0,0,0,0.5),
    inset 0 0 0 0.8125em rgba(255,255,255,0.3),
    inset 0 0 0 0.875em rgba(0,0,0,0.5),
    inset 0 0 0 0.9375em rgba(255,255,255,0.3),
    inset 0 0 0 1em rgba(0,0,0,0.5),
    inset 0 0 0 1.0625em rgba(255,255,255,0.2),
    inset 0 0 0 1.125em rgba(0,0,0,0.5),
    inset 0 0 0 1.1875em rgba(255,255,255,0.3),
    inset 0 0 0 1.25em rgba(0,0,0,0.5),
    inset 0 0 0 1.3125em rgba(255,255,255,0.2),
    inset 0 0 0 1.375em rgba(255,255,255,0.2),
    inset 0 0 0 1.4375em rgba(0,0,0,0.5),
    inset 0 0 0 1.5em rgba(255,255,255,0.3),
    inset 0 0 0 1.5625em rgba(0,0,0,0.5),
    inset 0 0 0 1.625em rgba(255,255,255,0.3),
    inset 0 0 0 1.6875em rgba(0,0,0,0.5),
    inset 0 0 0 1.75em rgba(255,255,255,0.2),
    inset 0 0 0 1.8125em rgba(0,0,0,0.5),
    inset 0 0 0 1.875em rgba(255,255,255,0.2),
    inset 0 0 0 1.9375em rgba(0,0,0,0.5),
    inset 0 0 0 2em rgba(255,255,255,0.3),
    inset 0 0 0 2.0625em rgba(0,0,0,0.5),
    inset 0 0 0 2.125em rgba(0,0,0,0.5),
    inset 0 0 0 2.1875em rgba(255,255,255,0.1),
    inset 0 0 0 2.25em rgba(0,0,0,0.5),
    inset 0 0 0 2.3125em rgba(255,255,255,0.2),
    inset 0 0 0 2.375em rgba(255,255,255,0.1),
    inset 0 0 0 2.4375em rgba(0,0,0,0.5),
    inset 0 0 0 2.5em rgba(255,255,255,0.3),
    inset 0 0 0 2.5625em rgba(0,0,0,0.5),
    inset 0 0 0 2.625em rgba(255,255,255,0.2),
    inset 0 0 0 2.6875em rgba(0,0,0,0.5),
    inset 0 0 0 2.75em rgba(255,255,255,0.2),
    inset 0 0 0 2.8125em rgba(0,0,0,0.5),
    inset 0 0 0 2.875em rgba(255,255,255,0.2),
    inset 0 0 0 2.9375em rgba(0,0,0,0.5),
    inset 0 0 0 3em rgba(255,255,255,0.3),
    inset 0 0 0 3.0625em rgba(0,0,0,0.5),
    inset 0 0 0 3.125em rgba(0,0,0,0.5),
    inset 0 0 0 3.1875em rgba(255,255,255,0.2),
    inset 0 0 0 3.25em rgba(0,0,0,0.5),
    inset 0 0 0 3.3125em rgba(255,255,255,0.2),
    inset 0 0 0 3.375em rgba(255,255,255,0.1),
    inset 0 0 0 3.4375em rgba(0,0,0,0.5),
    inset 0 0 0 3.5em rgba(255,255,255,0.3);
}

.album2::after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 100%;
  height: 100%;
  transform: translate(-50%,-50%);
  background-image:
    linear-gradient(
      -45deg,
      rgba(255,255,255,0) 30%,
      rgba(255,255,255,0.125),
      rgba(255,255,255,0) 70%
    ),
    linear-gradient(
      -48deg,
      rgba(255,255,255,0) 45%,
      rgba(255,255,255,0.075),
      rgba(255,255,255,0) 55%
    ),
    linear-gradient(
      -42deg,
      rgba(255,255,255,0) 45%,
      rgba(255,255,255,0.075),
      rgba(255,255,255,0) 55%
    ),
    radial-gradient(
      circle at top left,
      rgba(0,0,0,1) 20%,
      rgba(0,0,0,0) 80%
    ),
    radial-gradient(
      circle at bottom right,
      rgba(0,0,0,1) 20%,
      rgba(0,0,0,0) 80%
    );
}

.cover2,
.cover2 div {
  position: absolute;
  z-index: 1;
  top: 50%;
  left: 50%;
  width: 6em;
  height: 6em;
  overflow: hidden;
  transform-origin: 0 0;
  transform: rotate(0) translate(-50%,-50%);
  border-radius: 50%;
  animation: spin 4s linear infinite paused;
}

.ffing2 .cover2 {
  animation-play-state: running;
}

.cover2 div {
  border-radius: 0;
  animation: spin 2s linear infinite reverse paused;
}

.rwing2 .cover2 div {
  animation: spin 2s linear infinite reverse running;
}

.cover2::before,
.cover2::after {
  content: '';
  position: absolute;
  z-index: 10;
  top: 50%;
  left: 50%;
  width: 100%;
  height: 100%;
  transform-origin: 0 0;
  transform: rotate(0) translate(-50%,-50%);
  border-radius: 50%;
  box-shadow: inset 0 0.0625em rgba(255,255,255,0.3);
  animation: spin 4s linear infinite reverse paused;
}

.cover2::after {
  width: 0.25em;
  height: 0.3125em;
  margin-top: -0.0625em;
  background-color: #eee;
  border-radius: 0.125em;
  box-shadow:
    inset 0 -0.0625em 0.0625em rgba(0,0,0,0.5),
    inset 0.0625em -0.0625em 0.125em rgba(255,255,255,0.15),
    inset -0.0625em -0.0625em 0.125em rgba(255,255,255,0.15),
    inset 0 -0.125em 0.125em rgba(0,0,0,0.8),
    0 0.0625em 0.0625em rgba(0,0,0,0.5),
    0 0.0625em 0.25em 0.0625em rgba(0,0,0,0.15),
    0 0 0.25em 0.125em rgba(0,0,0,0.15);
}

.ffing2 .cover2::before,
.ffing2 .cover2::after {
  animation-play-state: running;
}

.cover2 img {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 100%;
  height: 100%;
  transform-origin: 0 0;
  transform: rotate(0) translate(-50%,-50%);
  animation: spin 4s linear infinite paused;
}

.paused2 .cover2 img {
  animation-play-state: paused;
}

.playing2 .cover2 img {
  animation-play-state: running;
}

.info2 {
  text-align: center;
  text-shadow: 0 0.0625em rgba(255,255,255,1);
}

.time2 {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0 0.5em;
  margin-bottom: 0.5em;
}

.time2 > * {
  margin: 0 0.5em;
}

.progress2 {
  flex-grow: 2;
  height: 0.125em;
  background-color: #999;
  border-radius: 0.0625em;
  box-shadow: 0 0.0625em rgba(255,255,255,1);
  cursor: pointer;
}

.progress2 span {
  display: block;
  width: 0;
  height: 100%;
  background-color: #666;
}

.actions2 {
  position: relative;
  width: 100%;
  padding: 1em 0 1.125em;
  display: flex;
  justify-content: center;
  align-items: center;
}

button {
  appearance: none;
  outline: none;
  position: relative;
  padding: 0;
  font-size: 100%;
  background-color: transparent;
  border: none;
  cursor: pointer;
}

.button2 {
  width: 3em;
  height: 3em;
  background-color: transparent;
  background-image: linear-gradient(#ddd, #f6f6f6);
  border: none;
  border-radius: 50%;
}

.button2::before {
  content: '';
  position: absolute;
  z-index: 1;
  top: 50%;
  left: 50%;
  width: 80%;
  height: 80%;
  transform: translate(-50%,-50%);
  background-color: #f4f4f4;
  border: 0.125em solid #d5d5d5;
  border-radius: 50%;
  box-shadow: inset 0 0.25em 1em -0.25em rgba(255,255,255,0.75);
}

.button2:hover::before {
  background-color: #fcfcfc;
}

.play-pause2 {
  width: 4em;
  height: 4em;
}

.rw2 {
  right: -0.25em;
  margin-left: 0.375em;
  transform: scaleX(-1);
}

.ff2 {
  left: -0.25em;
  margin-right: 0.375em;
}

.button2 .arrow2 {
  position: absolute;
  z-index: 10;
  top: 50%;
  left: 50%;
  width: 30%;
  height: 30%;
  overflow: hidden;
  transform: translate(-50%,-50%);
}

.button2 .arrow2::before,
.button2 .arrow2::after {
  content: '';
  position: absolute;
  left: -50%;
  width: 100%;
  height: 100%;
  transform: scale(1.2,0.7) rotate(45deg);
  background-color: #ddd;
  box-shadow:
    inset 0 0.125em 0.125em -0.0625em rgba(0,0,0,0.15),
    0.0625em 0.0625em 0.125em rgba(255,255,255,1);
}

.button2 .arrow2::after {
  left: 0;
  transform: none;
  background-color: transparent;
  box-shadow: inset 0.0625em 0 0.125em -0.0625em rgba(0,0,0,0.1);
}

.paused2 .play-pause2 .arrow2 {
  margin-left: 0.1875em;
}

.playing2 .play-pause2 .arrow2::before,
.playing2 .play-pause2 .arrow2::after {
  left: 0;
  width: 0.4375em;
  transform: none;
  background-color: #ddd;
  box-shadow:
    inset 0.0625em 0.125em 0.125em -0.0625em rgba(0,0,0,0.15),
    0.0625em 0.0625em 0.125em rgba(255,255,255,1);
}

.playing2 .play-pause2 .arrow2::after {
  left: auto;
  right: 0;
}

.rw2 .arrow2,
.ff2 .arrow2 {
  width: 20%;
  height: 20%;
  margin-left: 12%;
}

.rw2 .arrow2:first-child,
.ff2 .arrow2:first-child {
  margin-left: -4%;
}

.button2:active .arrow2::before,
.playing2 .play-pause2 .arrow2::before,
.playing2 .play-pause2 .arrow2::after {
  background-color: #cef;
}

.shuffle2 {
  width: 1.375em;
  height: 1.375em;
  color: #d5d5d5;
}

.shuffle2 .arrow2 {
  position: absolute;
  top: 0.1875em;
  left: 0;
  width: 0.375em;
  height: 0.125em;
  color: inherit;
  background-color: currentColor;
}

.shuffle2 .arrow2::before {
  content: '';
  position: absolute;
  top: 0;
  left: calc(100% + 0.125em);
  width: 0.5em;
  height: 1em;
  transform: skewX(30deg);
  border-bottom: 0.125em solid;
  border-left: 0.125em solid;
  box-shadow:
    -0.3125em 0em 0 -0.1875em #eee,
    inset 0.375em 0.25em 0 -0.25em #eee;
}

.shuffle2 .arrow2::after {
  content: '';
  position: absolute;
  top: 0.6875em;
  left: calc(100% + 0.625em);
  border: 0.25em solid transparent;
  border-left-width: 0.375em;
  border-left-color: currentColor;
}

.shuffle2 .arrow2:first-child {
  transform-origin: 0 0.5em;
  transform: scaleY(-1);
}

.repeat2 {
  width: 1.375em;
  height: 1.375em;
  color: #d5d5d5;
  border: 0.125em solid;
  border-right-color: transparent;
  border-radius: 50%;
}

.repeat2::before {
  content: '';
  position: absolute;
  top: -0.125em;
  left: -0.125em;
  width: calc(100% + 0.25em);
  height: calc(100% + 0.25em);
  transform: rotate(-45deg);
  border: 0.125em solid transparent;
  border-right-color: currentColor;
  border-radius: 50%;
}

.repeat2::after {
  content: '';
  position: absolute;
  top: 50%;
  right: -0.3125em;
  border: 0.25em solid transparent;
  border-top-width: 0.375em;
  border-top-color: currentColor;
}

.shuffle2.active2,
.repeat2.active2 {
  color: #bde;
}

@keyframes spin {
  100% { transform: rotate(360deg) translate(-50%,-50%); }
}


.card {
    background: #fff;
    transition: .5s;
    border: 0;
    margin-bottom: 30px;
    border-radius: .55rem;
    position: relative;
    width: 100%;
    box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
}
.chat-app .people-list {
    width: 280px;
    position: absolute;
    left: 0;
    top: 0;
    padding: 20px;
    z-index: 7
}

.chat-app .chat {
    margin-left: 280px;
    border-left: 1px solid #eaeaea
}

.people-list {
    -moz-transition: .5s;
    -o-transition: .5s;
    -webkit-transition: .5s;
    transition: .5s
}

.people-list .chat-list li {
    padding: 10px 15px;
    list-style: none;
    border-radius: 3px
}

.people-list .chat-list li:hover {
    background: #efefef;
    cursor: pointer
}

.people-list .chat-list li.active {
    background: #efefef
}

.people-list .chat-list li .name {
    font-size: 15px
}

.people-list .chat-list img {
    width: 45px;
    border-radius: 50%
}

.people-list img {
    float: left;
    border-radius: 50%
}

.people-list .about {
    float: left;
    padding-left: 8px
}

.people-list .status {
    color: #999;
    font-size: 13px
}

.chat .chat-header {
    padding: 15px 20px;
    border-bottom: 2px solid #f4f7f6
}

.chat .chat-header img {
    float: left;
    border-radius: 40px;
    width: 40px
}

.chat .chat-header .chat-about {
    float: left;
    padding-left: 10px
}

.chat .chat-history {
    padding: 20px;
    border-bottom: 2px solid #fff
}

.chat .chat-history ul {
    padding: 0
}

.chat .chat-history ul li {
    list-style: none;
    margin-bottom: 30px
}

.chat .chat-history ul li:last-child {
    margin-bottom: 0px
}

.chat .chat-history .message-data {
    margin-bottom: 15px
}

.chat .chat-history .message-data img {
    border-radius: 40px;
    width: 40px
}

.chat .chat-history .message-data-time {
    color: #434651;
    padding-left: 6px
}

.chat .chat-history .message {
    color: #444;
    padding: 18px 20px;
    line-height: 26px;
    font-size: 16px;
    border-radius: 7px;
    display: inline-block;
    position: relative
}

.chat .chat-history .message:after {
    bottom: 100%;
    left: 7%;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
    border-bottom-color: #fff;
    border-width: 10px;
    margin-left: -10px
}

.chat .chat-history .my-message {
    background: #efefef
}

.chat .chat-history .my-message:after {
    bottom: 100%;
    left: 30px;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
    border-bottom-color: #efefef;
    border-width: 10px;
    margin-left: -10px
}

.chat .chat-history .other-message {
    background: #e8f1f3;
    text-align: right
}

.chat .chat-history .other-message:after {
    border-bottom-color: #e8f1f3;
    left: 93%
}

.chat .chat-message {
    padding: 20px
}

.online,
.offline,
.me {
    margin-right: 2px;
    font-size: 8px;
    vertical-align: middle
}

.online {
    color: #86c541
}

.offline {
    color: #e47297
}

.me {
    color: #1d8ecd
}

.float-right {
    float: right
}

.clearfix:after {
    visibility: hidden;
    display: block;
    font-size: 0;
    content: " ";
    clear: both;
    height: 0
}

@media only screen and (max-width: 767px) {
    .chat-app .people-list {
        height: 465px;
        width: 100%;
        overflow-x: auto;
        background: #fff;
        left: -400px;
        display: none
    }
    .chat-app .people-list.open {
        left: 0
    }
    .chat-app .chat {
        margin: 0
    }
    .chat-app .chat .chat-header {
        border-radius: 0.55rem 0.55rem 0 0
    }
    .chat-app .chat-history {
        height: 300px;
        overflow-x: auto
    }
}

@media only screen and (min-width: 768px) and (max-width: 992px) {
    .chat-app .chat-list {
        height: 650px;
        overflow-x: auto
    }
    .chat-app .chat-history {
        height: 600px;
        overflow-x: auto
    }
}

@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
    .chat-app .chat-list {
        height: 480px;
        overflow-x: auto
    }
    .chat-app .chat-history {
        height: calc(100vh - 350px);
        overflow-x: auto
    }
  }

  .chattt::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.chattt {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
.count_message{
    color: white;
    background: green;
    border-radius: 50%;
    padding: 3px;
    float: right;
    min-width: 20px;
    text-align: center;
}
.select2-container{
    width: 100% !important;
}
    </style>

@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم التواصل</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection


@section('content')



<div class="row ml-5 mt-5" style="color: white ;display: flex;j">
    <div class="col-12 col-lg-2" >
        <a class="btn btn-success" style="font-size:20px" href="{{ route("chat_admin") }}" > <i class="fa fa-arrow-circle-left">  </i> التواصل </a>
    </div>
  </div>
<div class="container mt-5" style="direction: ltr;">


  <div class="row mb-3" style="color: white ;display: flex;justify-content: center;">
    <div class="col-4" >
        <select  id="second_user">
            @foreach ($users as $item)
            @if ($item->type == 1)
                <option value="{{ $item->id }}"> المدرس : {{ $item->teacher->first_name." ".$item->teacher->last_name }} </option>
            @elseif ($item->type == 2)
                <option value="{{ $item->id }}"> المسؤول : {{ $item->name }} </option>
            @elseif ($item->type == 3)
                <option value="{{ $item->id }}"> الموجه التربوي  : {{ $item->supervisor->first_name." ".$item->supervisor->last_name }} </option>
            {{-- @elseif ($item->type == 4)
                <option value="{{ $item->id }}"> المنسق : {{ $item->coordinator->first_name." ".$item->coordinator->last_name }} </option>
            @elseif ($item->type == 5)
                <option value="{{ $item->id }}"> المشرف الأكاديمي : {{ $item->acadsupervisor->first_name." ".$item->acadsupervisor->last_name }} </option> --}}
            @endif
            @endforeach
        </select>
    </div>
    <div class="col-4" >
    </div>
    <div class="col-4" >
        <select  id="first_user">
            @foreach ($users as $item)
            @if ($item->type == 1)
                <option value="{{ $item->id }}"> المدرس : {{ $item->teacher->first_name." ".$item->teacher->last_name }} </option>
            @elseif ($item->type == 2)
                <option value="{{ $item->id }}"> المسؤول : {{ $item->name }} </option>
            @elseif ($item->type == 3)
                <option value="{{ $item->id }}"> الموجه التربوي  : {{ $item->supervisor->first_name." ".$item->supervisor->last_name }} </option>
            {{-- @elseif ($item->type == 4)
                <option value="{{ $item->id }}"> المنسق : {{ $item->coordinator->first_name." ".$item->coordinator->last_name }} </option>
            @elseif ($item->type == 5)
                <option value="{{ $item->id }}"> المشرف الأكاديمي : {{ $item->acadsupervisor->first_name." ".$item->acadsupervisor->last_name }} </option> --}}
            @endif
            @endforeach
        </select>
    </div>
  </div>

  <div class="row clearfix">
      <div class="col-lg-12">
          <div class="card chat-app" style="height: calc(100vh - 100px);">

              <div class="chat" style="height: inherit !important;margin-left: 0px !important">
                  <div class="chat-header clearfix" style="height: 65px;">
                      <div class="row">
                          <div class="col-lg-6">

                              <div class="chat-about">
                                  <h6 class="m-b-0"></h6>
                                  {{-- <small>Last seen: 2 hours ago</small> --}}
                              </div>
                          </div>
                          <div class="col-lg-6 hidden-sm text-right">

                          </div>
                      </div>
                  </div>
                  <div class="chat-history" style="min-height: 60%;height: calc(100% - 135px) !important;">
                      <ul class="m-b-0 chattt" style="height: 100%;overflow-y: scroll;" >

                      </ul>
                  </div>
                  <div class="chat-message clearfix" style="height: 65px;background: #efefef;">
                      <div class="input-group mb-0">
                        <form  hidden id="form_new_item" method="POST">
                            @csrf
                            <input type="file" hidden name="message" id="file_upload">
                            <input type="text" hidden name="type" id="nametype">
                            <input type="text" hidden name="userid" id="nameuserid">
                        </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  </div>


  @endsection

  @section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    const socket = io.connect("https://albayan-virtualschool.com:3443/",{
        'reconnectionDelay': 500,
        'reconnectionAttempts': 10
    });
    user_active = 0;
    $('#first_user').select2();
    $('#second_user').select2();



    $(document).on('change','#second_user,#first_user', function () {

        userid1 = $('#first_user').val();
        userid2 = $('#second_user').val();
        if(userid1 != "" && userid2 != ""){
            myuserid = userid1;
            $.ajax({
            type: "get",
            url: "{{ route('getchat2') }}",
            data: {
                "userid1" : userid1,
                "userid2" : userid2
            },
            contentType: 'application/json',
            success: function (data) {
                console.log(data);
                $('.chattt').empty();
                $.each(data, function (index, value) {
                    message = '';

                    if (value.from == myuserid) {
                        if (value.isfile == 0) {
                            message = `<li class="clearfix">
                              <div class="message-data">
                                  <span class="message-data-time">${value.created_at}</span>
                              </div>
                              <div class="message my-message">${value.message}</div>
                          </li>`;
                        }else{
                            message = `<li class="clearfix">
                              <div class="message-data">
                                  <span class="message-data-time">${value.created_at}</span>
                              </div>
                              <div class="message my-message">
                                <i class="fa fa-download"> </i>
                                     <a href="{{asset('')}}${ value.message }" target="_blank"> تحميل الملف </a>
                                </div>
                          </li>`;
                        }
                    }else{
                        if (value.isfile == 0) {
                            message = `<li class="clearfix">
                              <div class="message-data text-right">
                                  <span class="message-data-time">${value.created_at}</span>
                                  <img src="{{ asset('website/person.png') }}" alt="avatar">
                              </div>
                              <div class="message other-message float-right"> ${value.message} </div>
                          </li>`;
                        }else{
                            message = `<li class="clearfix">
                              <div class="message-data text-right">
                                  <span class="message-data-time">${value.created_at}</span>
                                  <img src="{{ asset('website/person.png') }}" alt="avatar">
                              </div>
                              <div class="message other-message float-right">
                                <i class="fa fa-download"> </i>
                                     <a href="{{asset('')}}${ value.message }" target="_blank"> تحميل الملف </a>
                                </div>
                          </li>`;
                        }

                    }
                    $('.chattt').append(message);
                    $(".chattt").scrollTop($(".chattt")[0].scrollHeight);
                });

            }
          });
        }
    });


  </script>
       <script>
      var player = $('.player2'),
    audio = player.find('audio2'),
    duration = $('.duration2'),
    currentTime = $('.current-time2'),
    progressBar = $('.progress span2'),
    mouseDown = false,
    rewind, showCurrentTime;

function secsToMins(time) {
  var int = Math.floor(time),
      mins = Math.floor(int / 60),
      secs = int % 60,
      newTime = mins + ':' + ('0' + secs).slice(-2);

  return newTime;
}

function getCurrentTime() {
  var currentTimeFormatted = secsToMins(audio[0].currentTime),
      currentTimePercentage = audio[0].currentTime / audio[0].duration * 100;

  currentTime.text(currentTimeFormatted);
  progressBar.css('width', currentTimePercentage + '%');

  if (player.hasClass('playing2')) {
    showCurrentTime = requestAnimationFrame(getCurrentTime);
  } else {
    cancelAnimationFrame(showCurrentTime);
  }
}

audio.on('loadedmetadata', function() {
  var durationFormatted = secsToMins(audio[0].duration);
  duration.text(durationFormatted);
}).on('ended', function() {
  if ($('.repeat2').hasClass('active2')) {
    audio[0].currentTime = 0;
    audio[0].play();
  } else {
    player.removeClass('playing2').addClass('paused');
    audio[0].currentTime = 0;
  }
});

$('button2').on('click', function() {
  var self = $(this);

  if (self.hasClass('play-pause2') && player.hasClass('paused2')) {
    player.removeClass('paused2').addClass('playing2');
    audio[0].play();
    getCurrentTime();
  } else if (self.hasClass('play-pause2') && player.hasClass('playing2')) {
    player.removeClass('playing2').addClass('paused2');
    audio[0].pause();
  }

  if (self.hasClass('shuffle2') || self.hasClass('repeat2')) {
    self.toggleClass('active2');
  }
}).on('mousedown', function() {
  var self = $(this);

  if (self.hasClass('ff2')) {
    player.addClass('ffing2');
    audio[0].playbackRate = 2;
  }

  if (self.hasClass('rw2')) {
    player.addClass('rwing2');
    rewind = setInterval(function() { audio[0].currentTime -= .3; }, 100);
  }
}).on('mouseup', function() {
  var self = $(this);

  if (self.hasClass('ff2')) {
    player.removeClass('ffing2');
    audio[0].playbackRate = 1;
  }

  if (self.hasClass('rw2')) {
    player.removeClass('rwing2');
    clearInterval(rewind);
  }
});

player.on('mousedown mouseup', function() {
  mouseDown = !mouseDown;
});

progressBar.parent().on('click mousemove', function(e) {
  var self = $(this),
      totalWidth = self.width(),
      offsetX = e.offsetX,
      offsetPercentage = offsetX / totalWidth;

  if (mouseDown || e.type === 'click') {
    audio[0].currentTime = audio[0].duration * offsetPercentage;
    if (player.hasClass('paused2')) {
      progressBar.css('width', offsetPercentage * 100 + '%');
    }
  }
});
 </script>





    @endsection
