
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>

<head>

	<title>Login Page</title>
   <!--Made with love by Mutiullah Samim -->

	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
    <style>
        /* Made with love by Mutiullah Samim*/

@import url('https://fonts.googleapis.com/css?family=Numans');


.info-msg,
.success-msg,
.warning-msg,
.error-msg {
  margin: 10px 0;
  padding: 10px;
  border-radius: 3px 3px 3px 3px;
}
.info-msg {
  color: #059;
  background-color: #BEF;
}
.success-msg {
  color: #270;
  background-color: #DFF2BF;
}
.warning-msg {
  color: #9F6000;
  background-color: #FEEFB3;
}
.error-msg {
  color: #D8000C;
  background-color: #FFBABA;
}



html,body{
   background-image:url({{asset('teachers/new_login.jpg')}});
   background-size: 100% 100%;

background-size: 100% contain;
background-repeat: no-repeat;
height: 100%;
font-family: 'Numans', sans-serif;
}

.container{
height: 100%;
align-content: center;
}

.btn-outline-warning{

    color:#FFC312 !important;border-color:#FFC312!important ;
}

.btn-outline-warning:hover{

    color:#000 !important
}


.card{
height: 370px;
margin-top: auto;
margin-bottom: auto;
width: 400px;
background-color: rgba(0,0,0,0.5) !important;
}

.social_icon span{
font-size: 60px;
margin-left: 10px;
color: #FFC312;
}

.social_icon span:hover{
color: white;
cursor: pointer;
}

.card-header h3{
color: white;
}

.social_icon{
position: absolute;
right: 20px;
top: -45px;
}

.input-group-prepend span{
width: 50px;
background-color: #FFC312;
color: black;
border:0 !important;
}

input:focus{
outline: 0 0 0 0  !important;
box-shadow: 0 0 0 0 !important;

}

.remember{
color: white;
}

.remember input
{
width: 20px;
height: 20px;
margin-left: 15px;
margin-right: 5px;
}

.login_btn{
color: black;
background-color: #FFC312;
width: 100px;
}

.login_btn:hover{
color: black;
background-color: white;
}

.links{
color: white;
}

.links a{
margin-left: 4px;
}

@media only screen and (max-width:900px) and (min-width: 480px){


    .xx{

margin-left: -137px;    }
}

@media only screen and (max-device-width: 480px){

    .xx{
                transform: scale(1.5) !important;
                top:20px;
margin-left: -137px;

    }
        .card{
        transform: scale(2.2) !important;
        top:470px;
    }
}
    </style>
</head>
<body >

<div class="container">
<div class="row" style="height: 30%">

                        <div class="col-11">

        </div>

        {{-- <div class="col-1 xx" style="margin-top:10px;">
            <!--<a href="{{ route('website.index') }}" class="btn btn-outline-success waves-effect">الصفحة الرئيسية</a>-->

                        <a class="btn btn-outline-warning btn-md waves-effect waves-light" style="margin-right:20px;"
             href="{{ route('website.index') }}"
            target="_blank">الصفحة الرئيسية<i class="fa fa-Home pl-2"></i></a>
        </div> --}}



                            <div class="col-12" >
   <br>
        <br>   <br>
        <br>

    <form method="POST" action="{{ route('login1') }}">
    @csrf


    <div class="row">

        <div class="col-12" style="">
            <div class="d-flex justify-content-center h-100" style="position:relative; top:-25px;">
                <div class="card" style="height:315px;margin-right:20px;margin-top:50px">
                    <div class="card-header">
                        <h3>Sign In</h3>
                        {{-- <div class="d-flex justify-content-end social_icon">
                            <span><i class="fab fa-facebook-square"></i></span>
                            <span><i class="fab fa-google-plus-square"></i></span>
                            <span><i class="fab fa-twitter-square"></i></span>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="email" class="form-control" placeholder="username">

                            </div>
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control" placeholder="password">
                            </div>
                            {{-- <div class="row align-items-center remember">
                                <input type="checkbox">Remember Me
                            </div> --}}
                            <div class="form-group">
                                <input type="submit" value="Login" class="btn float-right login_btn">
                            </div>


                        </form>
                    </div>

                              @if($errors->any())

<div class="error-msg1" style="text-align:center; color:red">
  <i class="fa fa-times-circle"></i>
  <h6>{{$errors->first()}}</h6>
</div>

@endif

                </div>
            </div>
        </div>




</form>




</div>
</div>


</div>
</div>









</body>
</html>
