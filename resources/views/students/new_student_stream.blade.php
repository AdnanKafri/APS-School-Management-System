<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <!-- Page Title -->
        <title>Sunrise CC</title>
        <!-- Meta Description -->
        <meta name="description" content=" Sunrise Center website for online courses ">
        <meta name="keywords" content="Sunrise Center, SunriseIT, English, Computer, Desgin, Photoshop, Illustartor, InDesign">
        <meta name="author" content="Maya Hamdan">
        <!-- Mobile Specific Meta -->
        {{-- <link rel="icon" href="{{ asset('img/favicon.ico') }}"> --}}
        <link rel="stylesheet" href="{{ asset('css/stream/bootstrap.min.css') }}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('css/stream/stream.css') }}">
        <link rel="stylesheet" href="{{ asset('css/stream/chat.css') }}">
        <link rel="stylesheet" href="{{ asset('css/stream/model.css') }}">
        <link rel="stylesheet" href="{{ asset('css/stream/tabs.css') }}">
        {{-- <link rel="stylesheet" href="{{ asset('css/stream/font-awesome.min.css') }}"> --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/stream/media-queries-stream.css') }}">
        <!-- Modernizer Script for old Browsers -->
	      <script src="{{ asset('js/stream/modernizr-2.6.2.min.js') }}"></script>
        <!-- Main jQuery -->
         <script src="{{ asset('js/stream/jquery-1.11.1.min.js') }}"></script>

         {{-- <link href="https://v4-alpha.getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
<link rel="stylesheet" href="{{ asset('css/stream/texteditor.css') }}">
<link rel="stylesheet" href="{{ asset('css/stream/textedit.css') }}">

<!-- Font Awesome -->
<script src="https://use.fontawesome.com/46af14eb3c.js"></script>
<style>
    #mobile_nav {
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .dropdown-menu a{
        display: block;
        width: 100%;
        padding: 0.25rem 1.5rem;
        clear: both;
        font-size: 20px;
        font-weight: 400;
        color: #212529;
        text-align: inherit;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
    }

</style>
    </head>
    <body >
    <!--Side Navbar-->
    {{-- <audio controls id="record" style="display:none">

    </audio>
    <audio controls id="play" style="margin-left: 100px;">

    </audio>
    <a href="" id="sendaudio" class="btn btn-primary">send</a> --}}
    <nav id="primary_nav">
        <a id="mobile_nav" class="sevinth_item" data-mic="off"><i class="fa fa-microphone-slash" data-toggle="tooltip" data-placement="top" title="microphone is off" style="width: 30px;height: 30px;text-align: center"></i></a><br>
        <a id="mobile_nav" class="fifth_item" data-mic="no"><i class="glyphicon glyphicon-hand-up" data-toggle="tooltip" data-placement="top" title="speaking"></i></a><br>
        {{-- <a id="mobile_nav" class="zero_item" data-on="0"><i class="fa fa-video-slash" data-toggle="tooltip" data-placement="top" title="My Camera"> </i></a><br> --}}
        <div class="dropdown show">
            {{-- <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Dropdown link
            </a> --}}
            <a id="mobile_nav" class="dropdown-toggle"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-on="0"><i class="fa fa-video-slash" data-toggle="tooltip" data-placement="top" title="My Camera"> </i></a><br>

            <div class="dropdown-menu" aria-labelledby="mobile_nav" style="margin-left: 180px !important">
              <a class="dropdown-item turn_off" style="cursor: pointer">turn off</a>
              <a class="dropdown-item turn_on_at_teacher" style="cursor: pointer">turn on at teacher</a>
              <a class="dropdown-item turn_on_at_All" style="cursor: pointer">turn on at All</a>
            </div>
          </div>
      <a data-id="popup5" class="change_div" id="mobile_nav" ><i class="fa fa-users" title="All video"></i></a><br>
      <a data-id="popup1" class="change_div" id="mobile_nav" ><i class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top" title="White Board"> </i></a><br>
      <a data-id="popup6" class="change_div" id="mobile_nav" > <i class="fa fa-person-chalkboard" data-toggle="tooltip" data-placement="top" title="Teacher Screen"> </i></a><br>
      <a data-id="popup2" class="change_div" id="mobile_nav" > <i class="glyphicon glyphicon-user" data-toggle="tooltip" data-placement="top" title="My Video"></i></a><br>

      {{-- <a href="" id="mobile_nav" ><i class="glyphicon glyphicon-record" id="record"></i></a><br>
      <a href="" id="mobile_nav" ><i class="glyphicon glyphicon-stop" id="stop_record"></i></a><br> --}}
      {{-- <a href="{{ url('SMARMANger/dashboard/student/lessons/details') }}/{{ $room->lesson_id}}/{{ $room->teacher_id }}/{{ $room->room_id }}/{{ $room->id }}" id="mobile_nav" ><i class="glyphicon glyphicon-off" ></i></a><br> --}}
    </nav>
    <!--//Side Navbar-->

    <div class="main">
      <div class="container-fluid " style="width: 100%; padding-right:0px" >
        <!--Top Navigation-->
        <div class="row">

        <div class="col-lg-3 col-md-5 col-xs-12 lesson-name">
              <p>{{ $room->name }}</p>
              <a id="change_stream" class="btn btn-primary">change stream</a>
          </div>

          <!--//Lesson Name-->


          <div class="col-lg-1 col-md-1 col-xs-6">

          </div>
          <div class="col-lg-2 col-md-4 col-xs-12 lesson-name">
              @if (Auth::user())
                 <p>Student {{ auth()->user()->name }}</p>
              @else
                 <p>Student Test</p>
              @endif
          </div>
          <!--//Enter Chat Room IDr-->

        </div>
        <!--//Top Navigation-->

        <!--body-->
        <div class="container-fluid main-body"  >

            <div class="col-lg-9 col-sm-12 col-xs-12 draw" style="height: 100%" >
                <section id="section1">


              <div id="popup1" class="row hide_div" style="width: inherit;height: inherit;position: relative;display: none">
                <div class="popup">
                    <div class="all_tabs">
                        <a class="btn btn-danger tab00 tab1" data-id="1" style="background: #ce7775">tab 1  </a>
                        <a class="btn btn-danger tab00 tabmytab" data-id="mytab" style="background: #d9534f;float: right;margin-right: 6%">My tab </a>
                    </div>
                    <div class="row">
                    <div class="col-sm-10" id="add_canvas">
                        <canvas data-id="1" class="canvas00 canvas_number1 canvas_active" id="art" width="815px" height="400px"></canvas>
                        <canvas data-id="0" class="canvas00 canvas_numbermytab" id="mycanvas" width="815px" height="400px" style="display: none"></canvas>
                    </div>
                    <div id="buttons" class="color-canvas col-sm-1">
                        <input type="button" id="reset"  value="Reset"/>
                        <div id='red' class="color"></div>
                        <div id='blue' class="color"></div>
                        <div id='green' class="color"></div>
                        <div id='purple' class="color"></div>
                        <div id='yellow' class="color"></div>
                        <div id='orange' class="color"></div>
                        <div id='pink' class="color"></div>
                        <div id='black' class="color"></div>
                        <div id='white' class="color"></div>
                        <div id='ebebeb' class="color"></div>
                    </div>
                  </div>
                </div>
              </div>
                <!--//canvas-->

                <!--Main Video-->
                <div id="popup2" class="row hide_div" style="width: inherit;height: inherit;display: none">
                  <div class="popup">
                    <div class="row main-video" >
                      <video autoplay muted playsinline>

                      </video>
                    </div>

                  </div>
                </div>

                <!--//Main Video-->

                <!--Open File-->
                <div id="popup3" class="row hide_div" style="width: inherit;height: inherit;display: none">
                  <div class="popup">

                    <section>
                      <form action="" method="POST" enctype="multipart/form-data">
                        <div class="file-container">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label class="control-label">Upload File</label>
                                <div class="preview-zone hidden">
                                  <div class="file-box box-solid">
                                    <div class="box-header with-border">
                                      <div><b>Preview</b></div>
                                      <div class="box-tools">
                                        <button type="button" class="btn btn-danger btn-xs remove-preview">
                                          <i class="fa fa-times"></i> Reset This Form
                                        </button>
                                      </div>
                                    </div>
                                    <div class="box-body"></div>
                                  </div>
                                </div>
                                <div class="dropzone-wrapper">
                                  <div class="dropzone-desc">
                                    <i class="glyphicon glyphicon-download-alt"></i>
                                    <p>Choose an image file or drag it here.</p>
                                  </div>
                                  <input type="file" name="img_logo" class="dropzone">
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12" >
                              <button type="submit" class="btn btn-primary pull-right"
                              style="background-color: #8147fc; border: 0px;">Upload</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </section>

                  </div>
                </div>
                <!--//Open File-->


                <!--Iframe-->
                <!--<div id="popup5" class="row ">-->
                <!--  <div class="popup">-->
                <!--    <iframe src=""  height= "440px" width= "800px" >-->

                <!--    </iframe>-->

                <!--  </div>-->
                <!--</div>-->
                <!--//Iframe-->

                <!--popup user videos -->
                <div id="popup6" class="row hide_div" style="width: inherit;height: inherit;display: none">
                      <div class="popup">
                      <div class="row user-video" >
                        <video id="remote" controls autoplay playsinline>

                        </video>
                      </div>

                    </div>
                </div>
                <div id="popup5" class="row hide_div" style="width: inherit;height: inherit;display: none">
                      <div class="popup">
                      <div class="row user-video m-3" style="width: auto" >
                        <div class="row" id="client_vedio" style="overflow: scroll;height: 450px;width: 900px;">

                        </div>
                      </div>

                    </div>
                </div>
                <!--// popup user video-->

            </section>


            </div>






            <!--Side box-->
            <div class="col-lg-2  col-xs-12 side-box" >
              <div class="row">
                <!--Side Online Users -->
                <div class="col-lg-12  col-xs-6 side-online-users" >

                  <div class="chatbox-title">
                    <h1>User list</h1>
                  </div>
                    <div class="chatbox">
                    <div class='chatbox__user-list' id="user_list" style="height:140px;overflow:auto">

                    </div>
                  </div>

              </div>
              <!--//Side Online Users -->

              <!--chat -->
              <div class="col-lg-12 col-xs-6 chat_row">
                  <div class="--dark-theme" id="chat">
                      <div class="chat__conversation-board" id="main_chat">


                      </div>
                      <!--Input massage-->
                      <div class="chat__conversation-panel">
                        <div class="chat__conversation-panel__container">

                          <input class="chat__conversation-panel__input panel-item" id="message" placeholder="Type a message..."/>
                          <button class="chat__conversation-panel__button panel-item btn-icon send-message-button" id="send_message">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" data-reactid="1036">
                              <line x1="22" y1="2" x2="11" y2="13"></line>
                              <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                          </button>
                        </div>
                      </div>
                      <!--//Input massage-->
                  </div>
              </div>
              <!--//chat -->

              </div>
            </div>
            <!--//Side box-->

        </div>
        <!--//body-->

      </div>
    </div>
    <div class="modal fade" id="largeShoes" tabindex="-1" role="dialog" aria-labelledby="modalLabelLarge" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalLabelLarge" style="color: #57a5dc;">Welcome to SunriseIT LMS</h4>
                </div>

                <div class="modal-body">
                    <p>Welcome to our stream</p>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary" id="session">Ok</a>
                </div>
            </div>
        </div>

    </div>

    <!--//Javasccript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
    <script>

        if(Notification.permission != "granted"){
            Notification.requestPermission();
        }else{
            if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                var options = {
                body: "Welcome to new class", // body part of the notification
                }

                var n = new Notification("Welcome "+name, options);
            }
        }


    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        var name = "Student {{ auth()->user()->name }}";
        var name_for = "Student {{ auth()->user()->name }}";
        var room = "{{ $room->id }}";
        var userid = "{{ auth()->user()->id }}";
    </script>

    <script src="{{ asset('js/stream/student_stream.js?1') }}"></script>
    <script src="{{ asset('js/stream/canvas.js') }}"></script>
    <script>
        const interaction = document.querySelector('.c-interaction');
        const toggleButton = document.querySelector('.c-interaction__toggle')

        $('.show_texteditor').click(function (e) {
            $('#section1').hide();
            $('#section3').hide();
            $('#section2').show();
            $('.draw').css('background',"#fff");
        });

        $('.change_div').click(function (e) {
            $('.hide_div').hide();
            $(`#${$(this).data('id')}`).show();
            $('#section2').hide();
            $('#section3').hide();
            $('#section1').show();
            $('.draw').css('background',"#000");
        });

        $('.show_textedit').click(function (e) {
            $('#section2').hide();
            $('#section1').hide();
            $('#section3').show();
            $('.draw').css('background',"#fff");
        });

        if(toggleButton){
        toggleButton.addEventListener('click',() => {
        interaction.classList.toggle('c-interaction__options')
        })
      }
     </script>

    <script>
    $(document).on(start_touch,".canvas00",function(evt){
        if ($(`.canvas_active`).prop("id") == "mycanvas" ) {

            check_r = 1;
            canvas = $(`.canvas_active`)[0];
            ctx = canvas.getContext('2d');
            var mousePos = getMousePos(canvas, evt);
            check = true
            check_status(check);
            ctx.beginPath();
            ctx.moveTo(mousePos.x, mousePos.y);
            POS.x = mousePos.x;
            POS.y = mousePos.y;

            $(document).on(move,".canvas00",function(e){
                if (check_r == 1 ) {
                    mouseMove(e,$(this).data('id'));
                }
            });

        }
    });


    $(document).on(end_touch,".canvas00",function(e){
        $(document).off(move,".canvas00");
        check_r = 0;
        var canvas = $(`.canvas_active`)[0];
        var ctx = canvas.getContext('2d');
        check = false;
        check_status(check);
    });
    </script>

     {{-- <script src="http://cdn.sketchpad.pro/dist/current/sketchpad.min.js"></script> --}}
     <script src="{{ asset('js/stream/texteditorplugin.js') }}"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
    </body>
</html>
