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
        <link rel="stylesheet" href="{{ asset('css/stream/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/stream/media-queries-stream.css') }}">
        <!-- Modernizer Script for old Browsers -->
	      <script src="{{ asset('js/stream/modernizr-2.6.2.min.js') }}"></script>
        <!-- Main jQuery -->
         <script src="{{ asset('js/stream/jquery-1.11.1.min.js') }}"></script>
         @csrf
    </head>
    <body>
    <!--Side Navbar-->
    {{-- <audio controls id="record" style="display:none">

    </audio>
    <audio controls id="play" style="margin-left: 100px;">

    </audio>
    <a href="" id="sendaudio" class="btn btn-primary">send</a> --}}
    <nav id="primary_nav">
        <a id="mobile_nav" class="fifth_item" data-mic="no"><i class="glyphicon glyphicon-hand-up" data-toggle="tooltip" data-placement="top" title="speaking"></i></a><br>
        <a id="mobile_nav" class="zero_item" data-on="0"><i class="glyphicon glyphicon-camera" data-toggle="tooltip" data-placement="top" title="Camera"> </i></a><br>
      <a data-id="popup5" class="change_div" id="mobile_nav" ><i class="glyphicon glyphicon-user"></i></a><br>
      <a data-id="popup1" class="change_div" id="mobile_nav" ><i class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top" title="White Board"> </i></a><br>
      <a data-id="popup6" class="change_div" id="mobile_nav" > <i class="glyphicon glyphicon-facetime-video" data-toggle="tooltip" data-placement="top" title="Teacher Screen"> </i></a><br>
      <a data-id="popup2" class="change_div" id="mobile_nav" > <i class="glyphicon glyphicon-user" data-toggle="tooltip" data-placement="top" title="Your Video"></i></a><br>
      {{-- <a href="" id="mobile_nav" ><i class="glyphicon glyphicon-record" id="record"></i></a><br>
      <a href="" id="mobile_nav" ><i class="glyphicon glyphicon-stop" id="stop_record"></i></a><br> --}}
      {{-- <a href="{{ url('SMARMANger/dashboard/student/lessons/details') }}/{{ $course->lesson_id}}/{{ $course->teacher_id }}/{{ $course->room_id }}/{{ $course->id }}" id="mobile_nav" ><i class="glyphicon glyphicon-off" ></i></a><br> --}}
    </nav>
    <!--//Side Navbar-->

    <div class="main">
      <div class="container-fluid " style="width: 100%; padding-right:0px" >
        <!--Top Navigation-->
        <div class="row">

        <div class="col-lg-3 col-md-5 col-xs-12 lesson-name">
              <p>{{ $course->name }}</p>
              <a id="change_stream" class="btn btn-primary">change stream</a>
          </div>

          <!--//Lesson Name-->


          <!--Enter Chat Room ID-->
          <!--<div class="col-lg-4 col-md-12  col-xs-12 " >-->
          <!--  <div id="wrap">-->
          <!--    <input id="room" name="room" type="text" placeholder="Enter ">-->
          <!--    <i class="glyphicon glyphicon-log-in submit"> </i>-->
          <!--    <input id="send_messages" value="Rechercher" type="submit">-->
          <!--  </div>-->
          <!--</div>-->
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
            <div class="col-lg-9 col-sm-12 col-xs-12 draw" >
              {{-- <div class="draw-icon">
                <!--<a class="close" href="#">-->
                <!--  <i class="glyphicon glyphicon-trash"> </i>-->
                <!--</a><br><br><br>-->
                <!--  <a class="close" href="#">-->
                <!--    <i class="glyphicon glyphicon-print"> </i>-->
                <!--  </a><br><br><br>-->
                <!--    <a class="close" href="#">-->
                <!--      <i class="glyphicon glyphicon-download-alt"> </i>-->
                <!--    </a><br><br><br>-->
                    <!--<a href="#" id="refresh_socket">-->
                    <!--  <i class="glyphicon glyphicon-camera"> </i>-->
                    <!--</a><br><br><br>-->
                <!--    <a class="close" href="#">-->
                <!--      <i class="glyphicon glyphicon-random"> </i>-->
                <!--    </a>-->
              </div> --}}

              <!--canvas-->
              <div id="popup1" class="row hide_div" style="width: inherit;height: inherit;position: absolute;display: none">
                <div class="popup">

                  <div id="buttons" class="color-canvas">
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
                  <canvas id="art" width="815px" height="400px"></canvas>

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
                      <!--<div class='chatbox__user--active'>-->
                      <!--  <p>Jack Thomson</p>-->
                      <!--</div>-->
                      <!--<div class='chatbox__user--busy'>-->
                      <!--  <p>Angelina Jolie</p>-->
                      <!--</div>-->
                      <!--<div class='chatbox__user--active'>-->
                      <!--  <p>George Clooney</p>-->
                      <!--</div>-->
                      <!--<div class='chatbox__user--active'>-->
                      <!--  <p>Seth Rogen</p>-->
                      <!--</div>-->
                      <!--<div class='chatbox__user--away'>-->
                      <!--  <p>John Lydon</p>-->
                      <!--</div>-->
                      <!--<div class='chatbox__user--away'>-->
                      <!--  <p>John Lydon</p>-->
                      <!--</div>-->
                    </div>
                  </div>

              </div>
              <!--//Side Online Users -->

              <!--chat -->
              <div class="col-lg-12 col-xs-6 chat_row">
                  <div class="--dark-theme" id="chat">
                      <div class="chat__conversation-board" id="main_chat">

                        <!-- massage-->
                      <!--  <div class="chat__conversation-board__message-container" >-->
                      <!--     massage content-->
                      <!--    <div class="chat__conversation-board__message__context" >-->
                      <!--      <div class="chat__conversation-board__message__bubble" >-->
                      <!--          <span>-->
                      <!--            <p><b>Maya</b></p>-->
                      <!--            reversed massage content-->
                      <!--          </span>-->
                      <!--        </div>-->
                      <!--    </div>-->
                      <!--     //massage content-->
                      <!--    <div class="chat__conversation-board__message__options">-->
                      <!--      <button class="btn-icon chat__conversation-board__message__option-button option-item emoji-button">-->
                      <!--        <svg class="feather feather-smile sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">-->
                      <!--          <circle cx="12" cy="12" r="10"></circle>-->
                      <!--          <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>-->
                      <!--          <line x1="9" y1="9" x2="9.01" y2="9"></line>-->
                      <!--          <line x1="15" y1="9" x2="15.01" y2="9"></line>-->
                      <!--        </svg>-->
                      <!--      </button>-->
                      <!--      <button class="btn-icon chat__conversation-board__message__option-button option-item more-button">-->
                      <!--        <svg class="feather feather-more-horizontal sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">-->
                      <!--          <circle cx="12" cy="12" r="1"></circle>-->
                      <!--          <circle cx="19" cy="12" r="1"></circle>-->
                      <!--          <circle cx="5" cy="12" r="1"></circle>-->
                      <!--        </svg>-->
                      <!--      </button>-->
                      <!--    </div>-->
                      <!--  </div>-->
                        <!-- //massage-->

                        <!-- reversed massage-->
                      <!--  <div class="chat__conversation-board__message-container reversed">-->
                      <!--     massage content-->
                      <!--    <div class="chat__conversation-board__message__context">-->
                      <!--      <div class="chat__conversation-board__message__bubble">-->
                      <!--          <span> -->
                      <!--          <p><b>Yara</b></p>-->
                      <!--            the massage u sent content-->
                      <!--          </span>-->
                      <!--        </div>-->
                      <!--    </div>-->
                      <!--     //massage content-->
                      <!--    <div class="chat__conversation-board__message__options">-->
                      <!--      <button class="btn-icon chat__conversation-board__message__option-button option-item emoji-button">-->
                      <!--        <svg class="feather feather-smile sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">-->
                      <!--          <circle cx="12" cy="12" r="10"></circle>-->
                      <!--          <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>-->
                      <!--          <line x1="9" y1="9" x2="9.01" y2="9"></line>-->
                      <!--          <line x1="15" y1="9" x2="15.01" y2="9"></line>-->
                      <!--        </svg>-->
                      <!--      </button>-->
                      <!--      <button class="btn-icon chat__conversation-board__message__option-button option-item more-button">-->
                      <!--        <svg class="feather feather-more-horizontal sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">-->
                      <!--          <circle cx="12" cy="12" r="1"></circle>-->
                      <!--          <circle cx="19" cy="12" r="1"></circle>-->
                      <!--          <circle cx="5" cy="12" r="1"></circle>-->
                      <!--        </svg>-->
                      <!--      </button>-->
                      <!--    </div>-->
                      <!--  </div>-->
                        <!-- //reversed massage-->

                      </div>
                      <!--Input massage-->
                      <div class="chat__conversation-panel">
                        <div class="chat__conversation-panel__container">
                          <!--add file button-->
                          <!--<button class="chat__conversation-panel__button panel-item btn-icon add-file-button">-->
                          <!--  <svg class="feather feather-plus sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">-->
                          <!--    <line x1="12" y1="5" x2="12" y2="19"></line>-->
                          <!--    <line x1="5" y1="12" x2="19" y2="12"></line>-->
                          <!--  </svg>-->
                          <!--</button>-->
                          <!--//add file button-->

                          <!--emoji button-->
                          <!--<button class="chat__conversation-panel__button panel-item btn-icon emoji-button">-->
                          <!--  <svg class="feather feather-smile sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">-->
                          <!--    <circle cx="12" cy="12" r="10"></circle>-->
                          <!--    <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>-->
                          <!--    <line x1="9" y1="9" x2="9.01" y2="9"></line>-->
                          <!--    <line x1="15" y1="9" x2="15.01" y2="9"></line>-->
                          <!--  </svg>-->
                          <!--</button>-->
                          <!--//emoji button-->
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


              <!--Lecture Info Mobile View-->
              {{-- <div class="col-xs-12 lec-info-mob ">
                <div class="container theme-cactus" style="margin-left:0px; margin-right:30px" >
                    <div class="ui-tabgroup left-side">
                      <input class="ui-tab1" type="radio" id="tgroup_c2_tab1" name="tgroup_c2" checked />
                      <input class="ui-tab2" type="radio" id="tgroup_c2_tab2" name="tgroup_c2" />
                      <input class="ui-tab3" type="radio" id="tgroup_c2_tab3" name="tgroup_c2" />
                      <input class="ui-tab4" type="radio" id="tgroup_c2_tab4" name="tgroup_c2" />
                      <div class="ui-tabs"  >
                          <label class="ui-tab1" for="tgroup_c2_tab1"><i class="fa fa-info-circle"></i>Lecture Info</label>
                          <label class="ui-tab2" for="tgroup_c2_tab2"><i class="fa fa-list"></i>Intro</label>
                          <label class="ui-tab3" for="tgroup_c2_tab3"><i class="fa fa-rocket"></i>Progress Bar</label>
                          <label class="ui-tab4" for="tgroup_c2_tab4"><i class="fa fa-mortar-board"></i>Benefits</label>
                      </div>
                      <div class="ui-panels"   >
                          <div class="ui-tab1" style="width:620px;">
                              <h3>Lecture Info</h3>
                              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                          </div>
                          <div class="ui-tab2" style="width:620px;">
                              <h3>Intro</h3>
                              <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur,</p>
                          </div>
                          <div class="ui-tab3" style="width:620px;">
                              <h3>Progress Bar</h3>
                              <p>...</p>
                          </div>
                          <div class="ui-tab4" style="width:620px;">
                              <h3>Expected benefits</h3>
                              <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                          </div>
                      </div>
                    </div>
                </div>
              </div> --}}
              <!--//Lecture Info Mobile View-->

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
        var room = "{{ $course->id }}";
    </script>

    <script src="{{ asset('js/stream/student_stream.js') }}"></script>
    <script src="{{ asset('js/stream/canvas.js') }}"></script>
    <script>
        const interaction = document.querySelector('.c-interaction');
        const toggleButton = document.querySelector('.c-interaction__toggle')

        $('.change_div').click(function (e) {
            $('.hide_div').hide();
            $(`#${$(this).data('id')}`).show();
        });

        if(toggleButton){
        toggleButton.addEventListener('click',() => {
        interaction.classList.toggle('c-interaction__options')
        })
      }
     </script>
    </body>
</html>
