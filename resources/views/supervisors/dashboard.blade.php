@extends('supervisors.layouts.app')

@section('email')
{{ $supervisor->email }}
@endsection

@section('image')
{{ asset('storage/'.$supervisor->image) }}
@endsection

@section('name')
{{ $supervisor->first_name }} {{ $supervisor->last_name }}

@endsection
@section('my_info')
{{ $supervisor->first_name }} {{ $supervisor->last_name }}
@endsection


@section('classes')
{{ route('dashboard.supervisor.classes',$supervisor->id) }}
@endsection


@section('classes2')
{{ route('dashboard.supervisor.classes2',$supervisor->id) }}
@endsection


@section('messages')
{{ route('dashboard.supervisor.teachers',$supervisor->id) }}
@endsection

@section('content')






<div class="row clearfix">


        <div class="col-xs-12 col-sm-9">
            <!--@if(session()->has('success'))-->


            <!--        <div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
            <!--        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
            <!--        <strong></strong>  {{ session()->get('success') }}-->
            <!--        </div>-->
            <!--        @endif-->

            <div class="card">
                <div class="body">
                    <div>
                        <ul class="nav nav-tabs" role="tablist">
                            {{-- <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li> --}}
                            <li role="presentation" class="active"><a href="#profile_settings" aria-controls="settings" role="tab" data-toggle="tab">اعدادات الملف الشخصي</a></li>
                            <li role="presentation"><a href="#change_password_settings" aria-controls="settings" role="tab" data-toggle="tab">تغيير كلمة المرور</a></li>
                        </ul>

                        <div class="tab-content">
                            {{-- <div role="tabpanel" class="tab-pane fade in active" id="home">
                                <div class="panel panel-default panel-post">
                                    <div class="panel-heading">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img src="{{ asset('storage/'.$teacher->image) }}">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">
                                                    <a href="#">{{ $teacher->first_name }} {{ $teacher->last_name }}</a>
                                                </h4>
                                                Shared publicly - 26 Oct 2018
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="post">
                                            <div class="post-heading">
                                                <p>I am a very simple wall post. I am good at containing <a href="#">#small</a> bits of <a href="#">#information</a>. I require little more information to use effectively.</p>
                                            </div>
                                            <div class="post-content">
                                                <img src="../../images/profile-post-image.jpg" class="img-responsive">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <i class="material-icons">thumb_up</i>
                                                    <span>12 Likes</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="material-icons">comment</i>
                                                    <span>5 Comments</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="material-icons">share</i>
                                                    <span>Share</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" placeholder="Type a comment">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default panel-post">
                                    <div class="panel-heading">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img src="../../images/user-lg.jpg">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">
                                                    <a href="#">Marc K. Hammond</a>
                                                </h4>
                                                Shared publicly - 01 Oct 2018
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="post">
                                            <div class="post-heading">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                            </div>
                                            <div class="post-content">
                                                <iframe width="100%" height="360" src="https://www.youtube.com/embed/10r9ozshGVE" frameborder="0" allowfullscreen=""></iframe>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <i class="material-icons">thumb_up</i>
                                                    <span>125 Likes</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="material-icons">comment</i>
                                                    <span>8 Comments</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="material-icons">share</i>
                                                    <span>Share</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" placeholder="Type a comment">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div role="tabpanel" class="tab-pane fade in active" id="profile_settings">
                                <form class="form-horizontal" method="POST" action="{{ route('dashboard.supervisor.update_profile',$supervisor->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')





                                    <div class="form-group">
                                        <label for="image" class="col-sm-2 control-label">الصورة</label>
                                        <div class="col-sm-10">
                                            <div class="form-line focused">
                                                <img src="{{ asset('storage/'.$supervisor->image) }}" id="old_image" width="100px" height="100px">
                                                <img id="output" class="hidden" src=""  width="100px" height="100px" alt="">

                                                <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="loadFile(event)">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger" style="background-color:#019983 !important">حفظ</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="change_password_settings">
                                <form class="form-horizontal" method="POST" action="{{ route('dashboard.supervisor.update_password',Auth::user()->id) }}">
                                   @csrf
                                   @method('put')
                                    <div class="form-group">
                                        <label for="OldPassword" class="col-sm-3 control-label">كلمة المرور القديمة</label>
                                        <div class="col-sm-9">
                                            <div class="form-line">
                                                <input type="password" class="form-control" id="OldPassword" name="old_password" placeholder="اكتب كلمة المرور القديمة" required="">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="NewPassword" class="col-sm-3 control-label">كلمة المرور الجديدة</label>
                                        <div class="col-sm-9">
                                            <div class="form-line">
                                                <input type="password" class="form-control" id="NewPassword" name="password" placeholder="اكتب كلمة المرور " required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="NewPasswordConfirm" class="col-sm-3 control-label">تأكيد كلمة المرور الجديدة</label>
                                        <div class="col-sm-9">
                                            <div class="form-line">
                                                <input type="password" class="form-control" id="NewPasswordConfirm" name="password_confirmation" placeholder="اكتب كلمة المرور مرة اخرى للتاكيد" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <button type="submit" class="btn btn-danger" style="background-color:#019983 !important">حفظ</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </div>




    <script>
        var loadFile = function(event) {
          var output = document.getElementById('output');
          output.src = URL.createObjectURL(event.target.files[0]);
          output.onload = function() {
    document.getElementById('output').classList.remove('hidden');
    document.getElementById('old_image').setAttribute('style','display:none');
            URL.revokeObjectURL(output.src) // free memory
          }
        };
      </script>


@endsection

















