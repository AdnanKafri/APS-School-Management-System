@extends('students.layouts.app4')
@section('title')
School
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('student/assets/css/demo_1/style.css') }}" />
     <style>
   ::-webkit-scrollbar {
  width: 4px;
}
::-webkit-scrollbar-thumb {
  background-color: #c4c4e9;
  border-radius: 2px;
}
.chatbox {
   /* width: 300px;*/
    height: 400px;
    max-height: 400px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    border-radius: 5px;
    box-shadow: 0 0 4px rgba(0,0,0,.14),0 4px 8px rgba(0,0,0,.28);
}
.chat-window {
    flex: auto;
    max-height: calc(100% - 60px);
    background: #0b79dba6;
    overflow: auto;
}
.chat-input {
    flex: 0 0 auto;
    height: 60px;
   /* background: #40434e;*/
    border-top: 1px solid #2671ff;
    box-shadow: 0 0 4px rgba(0,0,0,.14),0 4px 8px rgba(0,0,0,.28);
}
.chat-input input {
    height: 59px;
    line-height: 60px;
    outline: 0 none;
    border: none;
    width: calc(100% - 60px);
    color: rgb(143, 140, 140);
    text-indent: 10px;
    font-size: 12pt;
    padding: 0;
    /*background: #40434e;*/
}
.chat-input button {
    float: right;
    outline: 0 none;
    border: none;
    background: rgba(255,255,255,.25);
    height: 40px;
    width: 40px;
    border-radius: 50%;
    padding: 2px 0 0 0;
    margin: 10px;
    transition: all 0.15s ease-in-out;
}
.chat-input input[good] + button {
    box-shadow: 0 0 2px rgba(0,0,0,.12),0 2px 4px rgba(0,0,0,.24);
    background: #2671ff;
}
.chat-input input[good] + button:hover {
    box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
}
.chat-input input[good] + button path {
    fill: white;
}
.msg-container {
    position: relative;
    display: inline-block;
    width: 100%;
    margin: 0 0 10px 0;
    padding: 15px;
}
.msg-box {
    display: flex;
    background: #ffff;
    padding: 10px 10px 0 10px;
    border-radius: 6px 6px 6px 6px;
    max-width: 80%;
    width: auto;
    float: left;
    box-shadow: 0 0 2px rgba(0,0,0,.12),0 2px 4px rgba(0,0,0,.24);
}
.user-img {
    display: inline-block;
    border-radius: 50%;
    height: 40px;
    width: 40px;
    /* background: #4382E0 ; */
    margin: 0 10px 10px 0;
}
.flr {
    flex: 1 0 auto;
    display: flex;
    flex-direction: column;
    width: calc(100% - 50px);
}
.messages {
    flex: 1 0 auto;
}
.msg {
    display: inline-block;
    font-size: 11pt;
    line-height: 13pt;
    color: rgba(133, 129, 129, 0.7);
    margin: 0 0 4px 0;
}
.msg:first-of-type {
    margin-top: 8px;
}
.timestamp {
    color: rgba(0,0,0,.38);
    font-size: 8pt;
    margin-bottom: 10px;
}
.username {
    margin-right: 3px;
}
.posttime {
    margin-left: 3px;
}
.msg-self .msg-box {
    border-radius: 6px 6px 6px 6px;
   /* background: #00F2D0;*/
   background: #14315C ;

    float: right;
}
.msg-self .user-img {
    margin: 0 0 10px 10px;
}
.msg-self .msg {
    text-align: right;
}
.msg-self .timestamp {
    text-align: right;
}
</style>
@endsection

@section('content')



<div class="main-panel" >
  <ul class="breadcrumbs" style="padding-bottom: 7px;
  padding-top: 11px;">
   
    <li class="li"><a href="{{ route('dashboard.student.lessons',$student->id) }}">الصفحة الرئيسية</a></li>
    <li class="li"><a href="#">رسائل مع الأدمن </a></li>
    
 </ul>
  <div class="content-wrapper pb-0">
    <!--content  -->
    <section class="chatbox">
      <section class="chat-window" id="chat">
        <!--msg admin-->
        @foreach ( $messages as $item )
            @if ($item->type==0)
        <article class="msg-container msg-remote" id="msg-0">
          <div class="msg-box">
            <img class="user-img" id="user-0" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZEAvDrrXeFOolwuey8_vCnT8vTn83dDC1Tc83pCFVUQ&s" />
            <div class="flr">
              <div class="messages">
                <p class="msg" id="msg-0">
                  {{ $item->message }}
                </p>
              </div>
              <span class="timestamp"><span class="username">الادارة</span>&nbsp;<span class="posttime"> {{ $item->created_at }} </span></span>
            </div>
          </div>
        </article>
        @else
        <!--end msg admin-->
        <!--msg self-->
        <article class="msg-container msg-self" id="msg-0">
          <div class="msg-box">
            <div class="flr">
              <div class="messages">
                <p class="msg" id="msg-1" style="color: white;">
                  {{ $item->message }}
                </p>
              
              </div>
              <span class="timestamp"><span class="username" style="color: #fff;">{{ $student->first_name }} {{ $student->last_name }}</span>&nbsp;<span class="posttime" style="color: #fff;">{{ $item->created_at }}</span></span>
            </div>
            @if($student->image)
            <img class="user-img" id="user-0" src=" {{ asset('storage/'. $student->image) }}" />
            @else
            <img class="user-img" id="user-0" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZEAvDrrXeFOolwuey8_vCnT8vTn83dDC1Tc83pCFVUQ&s" />
            @endif
            
          </div>
        </article>
        @endif

        @endforeach
        <!--end msg self-->
        

      </section>
      <form class="chat-input" action="{{route('add_mes')}}" method="POST" >
        @csrf
     
        <input type="text" name="message" autocomplete="on" placeholder="Type a message" />
        <button type="submit" >
                      <svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="rgba(0,0,0,.38)" d="M17,12L12,17V14H8V10H12V7L17,12M21,16.5C21,16.88 20.79,17.21 20.47,17.38L12.57,21.82C12.41,21.94 12.21,22 12,22C11.79,22 11.59,21.94 11.43,21.82L3.53,17.38C3.21,17.21 3,16.88 3,16.5V7.5C3,7.12 3.21,6.79 3.53,6.62L11.43,2.18C11.59,2.06 11.79,2 12,2C12.21,2 12.41,2.06 12.57,2.18L20.47,6.62C20.79,6.79 21,7.12 21,7.5V16.5M12,4.15L5,8.09V15.91L12,19.85L19,15.91V8.09L12,4.15Z" /></svg>
                  </button>
      </form>
    </section>
    <!--end content-->

</div>
</div>


@endsection
@section('js')
<script>
window.onload = function() {
  // Get the height of the content inside the div
  var contentHeight = document.getElementById('chat').scrollHeight;

  // Get the height of the div
  var divHeight = document.getElementById('chat').clientHeight;

  // Scroll to the bottom of the content inside the div
  document.getElementById('chat').scrollTop = contentHeight - divHeight;
};
</script>

@endsection



