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
        <link rel="stylesheet" href="{{ asset('css/stream/stream2.css') }}">
        <link rel="stylesheet" href="{{ asset('css/stream/chat.css') }}">
        <link rel="stylesheet" href="{{ asset('css/stream/model.css') }}">
        <link rel="stylesheet" href="{{ asset('css/stream/tabs.css') }}">
        <link rel="stylesheet" href="{{ asset('css/stream/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/stream/media-queries-stream.css') }}">
        <!-- Modernizer Script for old Browsers -->
	      <script src="{{ asset('js/stream/modernizr-2.6.2.min.js') }}"></script>
        <!-- Main jQuery -->
         <script src="{{ asset('js/stream/jquery-1.11.1.min.js') }}"></script>
    </head>
    <body>
      <!--Side Navbar-->
        <nav id="primary_nav">

            <a class="change_div" data-id="popup2" id="mobile_nav" ><i class="glyphicon glyphicon-facetime-video"></i></a><br>
            <a class="change_div" data-id="popup5" id="mobile_nav" ><i class="glyphicon glyphicon-user"></i></a><br>
            <a class="change_div" data-id="popup1" id="mobile_nav" ><i class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top" title="White Board"></i></a><br>
            {{-- <a id="mobile_nav"><i class="glyphicon glyphicon-random" id="screen_share_stop" data-toggle="tooltip" data-placement="top" title="Clear Screen"></i></a><br> --}}
            <a id="mobile_nav"><i class="glyphicon glyphicon-camera" data-toggle="tooltip" data-placement="top" title="Teacher Screen"></i></a><br>
            <!--<a href="#" id="mobile_nav"  ><i class="glyphicon glyphicon-cog"> </i></a><br>-->
            {{-- <a href="{{ url('SMARMANger/dashboard/teacher/lessons/book_details') }}/{{ $course->lesson_id}}/{{ $course->teacher_id }}/{{ $course->room_id }}/{{ $course->id }}" id="mobile_nav" ><i class="glyphicon glyphicon-off" ></i></a><br> --}}

        </nav>
        <!--//Side Navbar-->

        <div class="main">
            <div class="container-fluid " style="width: 100%; padding-right:0px;" >
                <!--Top Navigation-->
                {{-- <div class="row"> --}}

                  <!--Lesson Name-->

                  <!--//Lesson Name-->

                  <!--Tool Bar-->
                  {{-- <div class="col-lg-5 col-md-4 col-xs-12 ">
                      <div class="FABMenu" >
                        <input type="checkbox" checked/>
                        <div class="hamburger">
                          <div class="dots" >
                            <span class="first"></span>
                            <span class="second"></span>
                            <span class="third"></span>
                          </div>
                        </div>
                        <div class="action_items_bar" style=" margin-bottom: 0px;">
                          <div class="action_items">
                            <span class="first_item box">
                              <a href="#popup1" >
                              <i class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="top" title="White Board"></i></a>
                            </span>
                            <span class="second_item">
                              <a href="">
                                <i class="glyphicon glyphicon-camera" data-toggle="tooltip" data-placement="top" title="Teacher Screen"></i></a>
                            </span>
                            <span class="third_item">
                              <a>
                                <i class="glyphicon glyphicon-random" id="screen_share_stop" data-toggle="tooltip" data-placement="top" title="Clear Screen"></i></a>
                            </span>
                            <span class="fourth_item">
                              <a href="">
                                <i class="glyphicon glyphicon-trash"  data-toggle="tooltip" data-placement="top" title="Your Video"></i>
                              </a>
                            </span>
                          </div>

                        </div>
                        <div class="video-options" hidden>
                            <select name="" id="" class="custom-select">
                                <option value="">Select camera</option>
                            </select>
                        </div>
                      </div>
                  </div> --}}
                  <!--//Tool Bar-->

                  <!--Enter Chat Room ID-->
                  <!--<div class="col-lg-4 col-md-12  col-xs-12 " >-->
                  <!--  <div id="wrap">-->
                  <!--    <input id="room" name="room" type="text" placeholder="Enter ">-->
                  <!--    <i class="glyphicon glyphicon-log-in submit"> </i>-->
                  <!--    <input id="send_messages" value="Rechercher" type="submit">-->
                  <!--  </div>-->
                  <!--</div> -->
                  <!--//Enter Chat Room IDr-->
                 {{-- </div> --}}
                <!--//Top Navigation-->


                <!--body-->
                <div class="container-fluid main-body" style=" margin-top: 0px;" >
                    <div class="col-lg-9 col-sm-12 col-xs-12 " >

                      <div class="row">

                        <div class="col-lg-6 col-md-6 col-xs-12 lesson-name">
                            <p>{{ $course->name }}</p>
                            <a id="change_share" class="btn btn-primary" style="display: none">change share</a>
                            <a id="change_stream" class="btn btn-primary">change stream</a>
                        </div>

                        <div class="col-lg-6 col-md-6 col-xs-12 lesson-name">
                            <p id="timer"></p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-xs-12 lesson-name">
                            @if (Auth::user())
                            <p>Teacher {{ auth()->user()->name }}</p>
                            <p id="reconnecting_txt"></p>
                            @else
                                <p>Teacher Test</p>
                            @endif
                        </div>
                  </div>

                      <div class="draw">

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
                            <!--<a class="close" href="#">-->
                            <!--  <i class="glyphicon glyphicon-camera" id='sharedcam'></i>-->
                            <!--</a><br><br><br>-->
                            <!--<a class="close" href="#">-->
                            <!--  <i class="glyphicon glyphicon-random" id="screen_share_stop"> </i>-->
                            <!--</a>-->
                      </div> --}}

                      <!--canvas-->
                      <div id="popup1" class=" hide_div" style="width: inherit;height: inherit;position: absolute;">
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

                        <!--Student video div-->
                        <div id="popup2" class=" hide_div" style="width: inherit;height: inherit;position: absolute;display: none">
                          <div class="popup">
                            <div class="row main-video" >
                                {{-- <a id="choose_random_student" href="" class="btn btn-primary">choose student</a> --}}
                                <a id="turn_mic" data-on="1" class="btn btn-primary">turn off All Microphone</a>
                                <a id="turn_video" data-on="1" class="btn btn-primary">turn off All Video</a>
                              <div class="students-video" id="students-video" style="overflow: scroll">

                              </div>
                            </div>

                          </div>
                        </div>
                        <!--//Student video div-->

                        <!--Open File-->
                        <div id="popup3" class=" hide_div" style="width: inherit;height: inherit;position: absolute;display: none">
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
                                    <div class="col-md-12">
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

                        <!--Lecture Info-->
                        {{-- <div id="popup4" class=" hide_div" style="width: inherit;height: inherit;position: absolute;display: none">
                          <div class="popup">

                            <div class="container theme-cactus" style="width: 800px;">
                              <div class="ui-tabgroup">
                                <input class="ui-tab1" type="radio" id="tgroup_c1_tab1" name="tgroup_c1" checked />
                                <input class="ui-tab2" type="radio" id="tgroup_c1_tab2" name="tgroup_c1" />
                                <input class="ui-tab3" type="radio" id="tgroup_c1_tab3" name="tgroup_c1" />
                                <input class="ui-tab4" type="radio" id="tgroup_c1_tab4" name="tgroup_c1" />
                                <div class="ui-tabs">
                                    <label class="ui-tab1" for="tgroup_c1_tab1"><i class="fa fa-info-circle"></i>Lecture Info</label>
                                    <label class="ui-tab2" for="tgroup_c1_tab2"><i class="fa fa-list"></i>Intro</label>
                                    <label class="ui-tab3" for="tgroup_c1_tab3"><i class="fa fa-rocket"></i>Progress Bar</label>
                                    <label class="ui-tab4" for="tgroup_c1_tab4"><i class="fa fa-mortar-board"></i>Expected benefits</label>
                                </div>
                                <div class="ui-panels">
                                    <div class="ui-tab1">
                                        <h3>Lecture Info</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt </p>
                                    </div>
                                    <div class="ui-tab2">
                                        <h3>Intro</h3>
                                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</p>
                                    </div>
                                    <div class="ui-tab3">
                                        <h3>Progress Bar</h3>
                                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequa.</p>
                                    </div>
                                    <div class="ui-tab4">
                                        <h3>Expected benefits</h3>
                                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequa.</p>
                                    </div>
                                </div>
                              </div>
                          </div>

                          </div>
                        </div> --}}
                        <!--//Lecture Info-->

                        <!--Iframe-->
                        <div id="popup5" class=" hide_div" style="width: inherit;height: inherit;position: absolute;display: none">
                          <div class="popup">
                            <video id="remoteVideo" controls autoplay muted playsinline>

                            </video>

                          </div>
                        </div>
                        <!--//Iframe-->

                        <!--popup user videos -->
                        <div id="popup6" class=" hide_div" style="width: inherit;height: inherit;position: absolute;display: none">
                             <div class="popup">
                              <div class="row user-video" >
                                <video autoplay muted playsinline>

                                </video>
                              </div>

                           </div>
                        </div>
                        <!--// popup user video-->
                      </div>
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
                            <div class='chatbox__user-list' id="user_list2" style="height:140px;overflow:auto;display: none;" >

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
                                  <!-- massage content-->
                              <!--    <div class="chat__conversation-board__message__context" >-->
                              <!--      <div class="chat__conversation-board__message__bubble" >-->
                              <!--          <span>-->
                              <!--            <p><b>Maya</b></p>-->
                              <!--            reversed massage content-->
                              <!--          </span>-->
                              <!--        </div>-->
                              <!--    </div>-->
                                  <!-- //massage content-->
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
                                  <!-- massage content-->
                              <!--    <div class="chat__conversation-board__message__context">-->
                              <!--      <div class="chat__conversation-board__message__bubble">-->
                              <!--          <span> -->
                              <!--          <p><b>Yara</b></p>-->
                              <!--            the massage u sent content-->
                              <!--          </span>-->
                              <!--        </div>-->
                              <!--    </div>-->
                                  <!-- //massage content-->
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


                    <div class="col-lg-12  col-xs-6 permission" style="margin-top: 20px !important" >

                        <div class="chatbox-title">
                          <h1>permission</h1>
                        </div>
                          <div class="chatbox">
                          <div class='chatbox__permission-list' id="permission_list" style="height:140px;overflow:auto">
                            <table class="table" id="table_per" style="color: white !important">

                            </table>
                          </div>
                        </div>

                    </div>

                      <!--//chat -->

                      {{-- <div class="col-lg-12 col-xs-6 " style="border: 2px solid black;margin: 10px">

                      </div> --}}

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
                                  <label class="ui-tab4" for="tgroup_c2_tab4"><i class="fa fa-mortar-board"></i> Benefits</label>
                              </div>
                              <div class="ui-panels"   >
                                  <div class="ui-tab1" style="width:620px;">
                                      <h3>Lecture {{ $course->name }}</h3>
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
        <div class="modal fade" id="largeShoes" tabindex="-1" role="dialog" aria-labelledby="modalLabelLarge" aria-hidden="true">
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
                         <p>your room is: <span id="room_id" style="font-weight:bold"></span>{{ $course->id }}</span></p>
                         <p>Please ... Give your room number to your students due to starting your session and prease ok</p>
                    </div>
                    <div class="modal-footer">
                        <a id='sharedcam' class="btn btn-primary">Ok</a>
                    </div>
                </div>
            </div>
        </div>


        <!--//Javasccript -->
       <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>

       <script>

        console.log("-------------------------------------");
        // console.log(navigator.mediaDevices.getUserMedia);
        console.log("-------------------------------------");
            dt = new Date();
            var start_course = dt.getHours() + ":" + dt.getMinutes();
            var room = "{{ $course->id }}";
            var end = "{{ $end }}";
            var name = "Teacher {{ auth()->user()->name }}";
            var url = "{{ url('SMARMANger/dashboard/teacher/lessons/book_details') }}/{{ $course->lesson_id}}/{{ $course->teacher_id }}/{{ $course->room_id }}/{{ $course->id }}";
       </script>
       <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
       <script src="{{ asset('js/stream/recorder.js') }}"></script>
       <script src="{{ asset('js/stream/ebml.js') }}"></script>
        <script src="{{ asset('js/stream/teacher_stream.js') }}"></script>
        <script src="{{ asset('js/stream/FileBufferReader.js') }}"></script>
        <script src="{{ asset('js/stream/canvas.js') }}"></script>
        <script>
          if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
              if(Notification.permission != "granted"){
                  Notification.requestPermission();
              }
              var options = {
                  body: "Welcome to new class", // body part of the notification
              }

              var n = new Notification("Welcome "+name, options);
          }
        </script>
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
