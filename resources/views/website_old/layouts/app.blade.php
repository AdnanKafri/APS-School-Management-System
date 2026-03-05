<!doctype html>
<html lang="en" class="no-js">

<head>

    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="  aladham School  ">
    <meta neme="keywords" content=" مدرسة الادهم       ">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--====== Title ======-->
    <title>  {{ __('site.Smart Syrian School') }}    </title>

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>

    <!-- ===== Fontawesome CDN Link ===== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>

    <link href="{{ asset('website/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('website/css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('website/css/royalslider.css') }}" rel="stylesheet">
    <link id="packed-styles-css"  href="{{ asset('website/css/__packed.css') }}" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="{{ asset('website/css/main_style.css') }}">
    <link id="theme-skin-css" href="{{ asset('website/css/kinder.css') }}" rel="stylesheet" type="text/css" media="all">
    <style id="theme-skin-inline-css" type="text/css"></style>
    <link rel="stylesheet" href="{{asset('website/css/style2.css')}}">
    <link id="responsive-css" href="{{ asset('website/css/responsive.css') }}" rel="stylesheet" type="text/css" media="all">


    <link rel="icon" type="image/x-icon" href="{{ asset('storage/'.$other->logo) }}" style="width: 30px;">
    <!--<link rel="stylesheet" type="text/css" media="all" href="custom_tools/css/custom_tools.css">-->
    <link href="../cdn.jsdelivr.net/npm/bootstrap%405.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../cdn.jsdelivr.net/npm/bootstrap%405.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
       <link href="{{URL::asset('teachers/notify/css/notifIt.css')}}" rel="stylesheet"/>
  @if (LaravelLocalization::setLocale()=="en")
      <style>
            @media (min-width:200px) and (max-width:500px){
            .log_en{
                left: 95px !important;
            }
            .log_en2{
                left: 95px !important
            }
        }
        @media (min-width:600px) and (max-width:2000px){
    .input-container label{
        left: 130px !important;

    }
}
@media (min-width:200px) and (max-width:500px){
    .newwidth2{
        width:24% !important
    }
}
      </style>
    @endif



    <style>
        .footer-down{
            background-color: #001e4b;
            height: 100%;
            color: #fff;
            padding-bottom: 20px !important;
            padding-top: 20px !important
        }

    @media (max-width:1002px){
        footer{
    background-color: #001e4b;
    width: 100%;
    height: 204% !important;
    padding-top: 50px;
    justify-content: center;
    text-align: center
   }

 .logo223{
    display: none !important
 }
 .width2{
    margin-left: -33px
 }

    }

@media (max-width:335px){
        .wwidth{
    width:29% !important;
    margin: 0 auto;
    text-align: initial

 }
    }
    @media (min-width:240px) and (max-width:426px){
        .wwidth{

    margin: 0 auto;
    text-align: initial;



 }
    }
    @media (min-width:427px) and (max-width:551px){
        .wwidth{
    width:20% !important;
    margin: 0 auto;
    text-align: initial;


 }
    }
    @media (min-width:552px) and (max-width:694px){
        .wwidth{
    width:16% !important;
    margin: 0 auto;
    text-align: initial

 }
    }

    @media (min-width:695px) and (max-width:991px){
        .wwidth{
    width:12% !important;
    margin: 0 auto;
    text-align: initial;
    left:5px

 }
    }


   footer {
    background-color: #001e4b;
    width: 100%;

    padding-top: 40px
   }

   @media (max-width:1005px){
    .adden{
        width:100% !important;

    }
   }
@media (min-width:1252px)and(max-width:1352px)
{
    .lo222{
        width:97% !important;
        margin-top: -77px
    }
}



  @media (max-width:412px){
    .lang1{
        margin-left: -127px !important
    }
  }

    .log{

  /*background: #5E5DF0;*/
     font-weight: 600!important;
    font-family: "Cairo", "Montserrat", sans-serif !important;
  background: linear-gradient(to right ,rgb(0,200,255),rgb(0, 30,75) );
  border-radius: 999px;
  box-shadow: #5E5DF0 0 10px 20px -10px;
  box-sizing: border-box;
  color: #FFFFFF !important;
  cursor: pointer;
  width: 150px !important;
  text-align: center !important;
  font-size: 20px;
  font-weight: 700;
  line-height: 24px;
  opacity: 1;
  outline: 0 solid transparent;
  padding: 8px 8px;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;

  word-break: break-word;
  border: 0;
}
/*for social icons*/

.social-buttons {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 8px;
}
.social-button {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  outline: none;
  width: 64px;
  height: 64px;
  text-decoration: none;
  border-radius: 100%;
  background: #fff;
  text-align: center;
}
.social-button::after {
  content: '';
  position: absolute;
  top: -1px;
  left: 50%;
  display: block;
  width: 0;
  height: 0;
  border-radius: 100%;
  transition: 0.3s;
}
.social-button:focus, .social-button:hover {
  color: #fff;
}
.social-button:focus::after, .social-button:hover::after {
  width: calc(100% + 2px);
  height: calc(100% + 2px);
  margin-left: calc(-50% - 1px);
}
.social-button i, .social-button svg {
  position: relative;
  z-index: 1;
  transition: 0.3s;
}
.social-button i {
  font-size: 25.6px;
}
.social-button svg {
  height: 40%;
  width: 40%;
}
.social-button--mail {
  color: #0072c6;
}
.social-button--mail::after {
  background: #0072c6;
}
.social-button--facebook {
  color: #3b5999;
}
.social-button--facebook::after {
  background: #3b5999;
}
.social-button--linkedin {
  color: #0077b5;
}
.social-button--linkedin::after {
  background: #0077b5;
}
.social-button--github {
  color: #6e5494;
}
.social-button--github::after {
  background: #6e5494;
}
.social-button--codepen {
  color: #212121;
}
.social-button--codepen::after {
  background: #212121;
}
.social-button--steam {
  color: #7da10e;
}
.social-button--steam::after {
  background: #7da10e;
}
.social-button--snapchat {
  color: #eec900;
}
.social-button--snapchat::after {
  background: #eec900;
}
.social-button--twitter {
  color: #55acee;
}
.social-button--twitter::after {
  background: #55acee;
}
.social-button--instagram {
  color: #e4405f;
}
.social-button--instagram::after {
  background: #e4405f;
}
.social-button--npmjs {
  color: #c12127;
}
.social-button--npmjs::after {
  background: #c12127;
}
@media (max-width:412px){
    .religion{
         width:13% !important
    }
}
@media(min-width:408px)and (max-width:507px){
    .religion{
         width:6% !important
    }

}
@media(min-width:508px)and (max-width:1012px){
    .religion{
         width:6% !important
    }

}

.iicon{
    transform: rotate(180deg);
    float: left;
}
.iicon:hover{
    background: none;
    width: 30px !important;
}
.tit :hover{
    color: yellow;
    font-size: 15px;
    -webkit-transition: all 0.4s linear;
    transition: all 0.4s linear;
}
.border{
    border: 2px solid white;
    padding-top: 8px;
    padding-bottom: 2px;
    padding-left: 14px;
    padding-right: 14px;
    border-radius: 100%

}
.border:hover{
    border: 2px solid #eec900;
}
.fa:hover{
     color: #eec900 !important
}
@media  (max-width:768px){
      .widget_advert_inner{
          margin-left: -110px !important

      }

 }
 @media  (max-width:412px){
      .widget_advert_inner{
          margin-left: -36px !important

      }

 }

 @media (max-width:412){
    .widgetWrap{
        width: 100% !important;
    }
 }


 .fa-home.fa1:before{
    color:#d6a800 !important
 }
 .fa-envelope.fa2:before{
    color:#d6a800 !important
 }

 .fa-phone.fa3:before{
    color:#d6a800 !important
 }
 /*style login */
 @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');



.container3 {
	display: flex;
	align-items: center;
	justify-content: center;
	min-height: 100vh;
}

.screen {
	background-color: #001e4b;
	position: relative;
	height:480px;
	width: 533px;
    border-radius: 10%;
	/*box-shadow: 0px 0px 24px #001e4b;*/
}
 /*end style login*/

 /*responsive login in en*/
  @media(min-width:200px) and (max-width:410px){
    .screen{
        width: 274px !important
     }
     .butt{
        margin-top: 50px !important;
       width: 150px !important;
       margin-left: 57px !important
     }

     .ar_icon{
        margin-left: 0 !important
     }
     .log_ar2{
        margin-left:3px !important
     }
     .input-container input:focus ~ label, .input-container input:valid ~ label{
      top:-26px !important;
      left: 55px !important
 }
  }

 @media (min-width:411px) and (max-width:600px){
     .screen{
        width: 374px !important
     }
     .butt{
        margin-top: 50px !important;
        margin-left: 12px !important
     }

     .ar_icon{
        margin-left: 0 !important
     }
     .log_ar2{
        margin-left:3px !important
     }
     .input-container input:focus ~ label, .input-container input:valid ~ label{
    top:-26px !important
 }

 }
 @media (min-width:601px) and (max-width:998px){

     .ar_icon{
        margin-left: 0 !important
     }
     .log_ar2{
        margin-left: 3px !important
     }
     .input-container input:focus ~ label, .input-container input:valid ~ label{
    top:-26px !important
 }

 }
 @media (min-width:1000px) and (max-width:4960px){
    .log_ar{
        margin-left: 4px !important
    }
 }

 @media (min-width:200px) and (max-width:600px){
    .fnew{
        display: -webkit-box;
         display: -moz-box;
         display: -ms-flexbox;
         display: -webkit-flex;
         display: flex;


       /* Reverse Column Order */
  -webkit-flex-flow: column-reverse !important;
  flex-flow: column-reverse !important;

 }
 .newwidth{
    display: inline-table !important;
    margin: 0 auto !important;
 }
 .social1{
    margin-top: 9px !important
 }

}
@media (min-width:601px) and (max-width:990px){
    .newwidth{
    display: inline-table !important;
    margin: 0 auto !important;
 }
 .social1{
    margin-top: 9px !important
 }


}

 /*end responsive login*/


 /*style for input */

 @import url('https://fonts.googleapis.com/css?family=Noto+Sans:400,400i,700,700i&subset=greek-ext');



.input-container{
	position:relative;
	margin-bottom:25px;
    margin: 0 auto !important;
     text-align: center !important;

}
.input-container label{
	position:absolute;
	top:0px;
	left: 130px;
	font-size:30px;
	color:#fff;
    pointer-event:none;
	transition: all 0.5s ease-in-out;

}
.input-container input{
  border:0;
  border-bottom: 2px solid #fff;
  background:transparent !important;
  width:60%;
  padding:8px 12px 5px 12px;
  font-size:16px;
  color:#fff;

}
.input-container input:focus{
 border:none;
 outline:none;
 border-bottom:1px solid white;
}

/*.btn:after{
	content:"";
	position:absolute;
	background:rgba(0,0,0,0.50);
	top:0;
	right:0;
	width:100%;
	height:100%;
}*/
.input-container input:focus ~ label,
.input-container input:valid ~ label{
	top:-26px;
	font-size:18px;

}

 /*end style for input */
 .fa-key{
    content: '&#xf084' !important ;
 }
 .user-popUp ul.loginHeadTab li a.loginFormTab:before{
    content: '\e6de';
 }
 .butt{

    justify-content: center !important;
       font-weight: 600!important;
    margin-left: 96px ;
    font-family: "Cairo", "Montserrat", sans-serif !important;
  background: linear-gradient(to right ,#00c8ff,#08a7d3 );
  border-radius: 999px;

  box-sizing: border-box;
  color: #FFFFFF !important;
  cursor: pointer;
  width: 350px;
  text-align: center !important;
  font-size: 20px;
  font-weight: 700;
  line-height: 24px;
  opacity: 1;
  outline: 0 solid transparent;
  padding: 20px 20px;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;

  word-break: break-word;
  border: 0;

 }
 .circle{
    margin: 0 auto;
    background: linear-gradient(to right ,rgb(206,229,235),rgb(180, 183,189) );
    border-radius: 50%;
    width: 180px;
    height: 180px;

    margin-top: -80px;
    border: 2px solid rgb(0, 30,75);

 }




  @media screen (max-width:412px){
    .respon{
    width: 150% !important;
 }
  }
  @media screen (max-width:500px){
    .respon{
    width: 100% !important;
    left: 70px !important
 }
 .respon1{
    width: 100% !important

    }
  }
  @media screen (max-width:912px){
    .respon{
    width: 100% !important;
    left: 70px !important
 }
 .respon1{
    width: 100% !important

    }
  }
  @media screen (max-width:412px){
    .responn{
    width: 100% !important;
 }
 .responn2{
    width: 100% !important;
    margin-left: 124px !important
 }
 .fa1{
   padding-left: -22px !important
 }
  }
  @media screen (max-width:500px){
    .responn{
    width: 100% !important;

 }

  }



 @media(max-width:412px){
    .logmob{
        display: none !important;
    }
 }
 .anlik {
    color: white !important
}


    </style>



        @yield('css')
 <style>
    h3{
        font-family: "Cairo", "Montserrat", sans-serif !important;
    }
    *{

       font-weight: 600!important;
    font-family: "Cairo", "Montserrat", sans-serif !important;


    }
    .topWrap .topMenuStyleLine>ul>li.line:after{
        background: none !important
    }

    @media screen (max-width:412px){
    .ensocial {
     position: relative;
     left: -40px !important
    }
  }
   @media (max-width:472px){
    .icons{
        display: none !important
    }
   }
   @media(min-width:300px)and (max-width:426px){
        .arsocial{
            margin-left: 20px !important;
            width: 88% !important
        }
    }
   @media(min-width:427px)and (max-width:500px){
        .arsocial{
            margin-left: 61px !important;
            width: 71% !important
        }
    }
    @media(min-width:501px)and (max-width:600px){
        .arsocial{
            margin-left: 73px !important;
            width: 71% !important;
            margin-top: 6px !important;
        }
    }
    @media(min-width:601px)and (max-width:1000px){
        .arsocial{
            margin-left: 120px !important;
            width: 71% !important
        }
    }
@media (min-width:1007px )and (max-width:1330px){
    .social1{
        width: 180%  !important;
        margin-left: -67px
    }
}
@media (min-width:1342px)and (max-width:1800px){
    .newcop{
        margin-right: 413px !important
    }
}
@media (min-width:300px)and (max-width:516px){
    .newcop{
       margin-left: 42px !important
    }
}
@media (min-width:517px)and (max-width:545px){
    .newcop{
       margin-left: 30px !important
    }
}
@media (min-width:545px)and (max-width:582px){
    .newcop{
       margin-left: 18px !important
    }
}
@media (min-width:597px)and (max-width:782px){
    .newcop{
       margin-left: 60px !important
    }
}

/*@media(min-width:1000px)and (max-width:1340px){
    .social1{
     width:146% !important;
     margin-left: -20px
    }
}*/

@media (min-width:312px)and (max-width:550px){
    .col-en{
        width:36% !important;
        margin: 0 auto;
        text-align: initial;
        left: 8px
    }
}
@media (min-width:551px)and (max-width:555px){
    .col-en{
        width:36% !important;
        margin: 0 auto;
        text-align: initial;
        left: 47px
    }
}

@media (min-width:556px)and (max-width:654px){
    .col-en{
        width:19% !important;
        margin: 0 auto;
        text-align: initial;
        left: 8px
    }
}
@media (min-width:655px)and (max-width:689px){
    .col-en{
        width:19% !important;
        margin: 0 auto;
        text-align: initial;
        left: 8px
    }
}
@media (min-width:699px)and (max-width:964px){
    .col-en{
        width:19% !important;
        margin: 0 auto;
        text-align: initial;
        left: 23px
    }
}
@media(min-width:300px)and (max-width:576px){
    .newic{
        margin-left: 10px !important
    }
    .newic2{
        margin-left: 10px !important
    }
}
@media(min-width:577px)and (max-width:725px){
    .newic{
        margin-left: 72px !important
    }
    .newic2{
        margin-left: 67px !important
    }
}
@media(min-width:726px) and (max-width:999px){
    .newic{
        margin-left: 27px !important
    }
    .newic2{
        margin-left: 21px !important
    }
}
@media(min-width:768px) and (max-width:995px){
    .add{
        width:100% !important
    }

}
@media (min-width:200px) and (max-width:500px){
    .newwidth2{
        display: inline-table !important;
        margin-left: 53px !important
    }
}
@media (min-width:501px) and (max-width:982px){
    .newwidth2{
        display: inline-table !important;
        margin-left: 53px !important

    }
}
@media (min-width:800px) and (max-width:1023px){
    .responsive_menu .menuTopWrap>ul{
        padding-left: 43px !important
    }
}
@media (min-width:433px) and (max-width:599px){
    .input-container label{
        left: 94px !important;

    }
}

.close{
    width: 20px;
    left: -25px;
    position: relative;
    top: -89px;
    color: white;
}

 </style>
     @if (LaravelLocalization::setLocale()=="ar")

<style>

 /*responsive login*/
  @media(min-width:200px) and (max-width:410px){
    .screen{
        width: 274px !important
     }
     .butt{
        margin-top: 50px !important;
       width: 150px !important;
       margin-left: 57px !important
     }
     .log_ar{
        margin-left: 72px !important
     }
     .ar_icon{
        margin-left: 0 !important
     }
     .log_ar2{
        margin-left: 100px !important
     }
     .input-container input:focus ~ label, .input-container input:valid ~ label{
      top:-26px !important;
      left: -3px !important
 }
  }

 @media (min-width:411px) and (max-width:600px){
     .screen{
        width: 374px !important
     }
     .butt{
        margin-top: 50px !important;
        margin-left: 12px !important
     }
     .log_ar{
        margin-left: 72px !important
     }
     .ar_icon{
        margin-left: 0 !important
     }
     .log_ar2{
        margin-left: 100px !important
     }
     .input-container input:focus ~ label, .input-container input:valid ~ label{
    top:-26px !important
 }

 }
 @media (min-width:601px) and (max-width:998px){

     .ar_icon{
        margin-left: 0 !important
     }
     .log_ar2{
        margin-left: 187px !important
     }
     .input-container input:focus ~ label, .input-container input:valid ~ label{
      top:-26px !important
 }

 }

 @media (min-width:200px) and (max-width:600px){
    .fnew{
        display: -webkit-box;
         display: -moz-box;
         display: -ms-flexbox;
         display: -webkit-flex;
         display: flex;


       /* Reverse Column Order */
  -webkit-flex-flow: column-reverse !important;
  flex-flow: column-reverse !important;

 }
 .newwidth{
    display: inline-table !important;
    margin: 0 auto !important;
 }
 .social1{
    margin-top: 9px !important
 }

}
@media (min-width:601px) and (max-width:990px){
    .newwidth{
    display: inline-table !important;
    margin: 0 auto !important;
 }
 .social1{
    margin-top: 9px !important
 }


}

 /*end responsive login*/
    @media (min-width:1321px)and (max-width:1343px){
        .logo223{
           width:30% !important;
           margin-top: -67px !important;
           margin-left: 22px

        }
    }
    @media (min-width:1345px)and (max-width:1365px){
        .logo223{
           width:30% !important;
           margin-top: -70px !important;
           margin-left: 22px

        }
    }
    @media (min-width:1366px)and (max-width:1465px){
        .logo223{
           width:30% !important;
           margin-top: -80px !important;
           margin-left: 22px

        }
    }
    @media (min-width:1466px)and (max-width:1502px){
        .logo223{
           width:30% !important;
           margin-top: -95px !important;
           margin-left: 22px

        }
    }
    /*@media (min-width:1504px)and (max-width:1600px){
        .logo223{
           width:29% !important;
           margin-top: -107px !important;
           margin-left: 42px

        }
    }*/
    @media (min-width:1007px)and (max-width:1044px){
        .logo223{
            margin-top: -50px !important
        }
    }

    @media(min-width:300px)and (max-width:500px){
      .eye2{
        margin-left: 10px !important
      }
      .eye4{
        margin-left: 3px !important
      }
    }
    @media(min-width:501px)and (max-width:976px){
      .eye2{
        margin-left: 10px !important
      }
      .eye4{
        margin-left: 3px !important
      }
    }

   @media (max-width:989px){
    /*.add{
        width: 89% !important;
        margin:0 auto;
    }*/
    .tit2{
       padding-left: 48px !important
    }
    .tit3{
        padding-left: 30px !important
    }
}


    @media (min-width:1005px){
        .font1{
            font-size: 11px !important
        }
        .font2{
            font-size: 11px !important;
            margin-left: 89px !important
        }
       .font3{
        font-size: 27px !important
       }
       .font4{
        width: 172% !important
       }
    }
    @media (min-width:1005px){
        .font1{
            font-size: 11px !important
        }
        .font2{
            font-size: 11px !important;
            margin-left: 89px !important
        }
       .font3{
        font-size: 27px !important
       }
       .font4{
        width: 172% !important
       }
    }



    @media (max-width:412px){
        .respon{
           width:100% !important;
           margin-left: 31px !important
        }
    }

     @media screen (max-width:412px){
    .lang1{
        margin-left: -1px !important
    }
  }

   .ar_con{
       direction: rtl !important ;
   }
   .ar_ph{
    transform: rotate(260deg) !important ;
   }

   .ar_con11{
    direction: rtl !important ;
    text-align: right;
   }
   .ar_news{
    float: left!important;
   }
   /*.topWrap .topMenuStyleLine{
    text-align: center!important;
   }*/
   .logo_left{
    float: right!important;
   }
   .log_ar{
   text-align: right !important;
    direction: rtl !important;
    margin-left: 133px !important;

   }







@media (max-width:412px){
    .lang1{
        width: 82% !important;
    }
}
@media(max-width:412px){
    .foot1{
        margin-left: 25px;
    }
}

@media(min-width:320px) and  (max-width:484px){
    .img22{
        width:42%  ;
        margin-left: 25px ;
    }
}
@media (min-width:484px) and (max-width:516px){
    .img22{
        width:16% !important ;
        margin-left: -26px ;
    }
}
@media(min-width:520px) and (max-width:996px){
    .img22{
        width:8% !important;
        margin-left: -34px ;
    }
}
@media(min-width:997px) and (max-width:1020px){
    .img22{
        width:6% !important;
        margin-left: -34px ;
    }
}
@media(min-width:288px)and (max-width:472px){
  .text_ar{
    margin-top: -66px !important;
  }
}
@media (min-width:410px) and (max-width:460px){
    .input-container label{
       margin-left: 20px !important
    }
}
   @media (min-width:200px) and (max-width:412px){
    .wwidth{
        width:30% !important
    }
   }

</style>

@endif


</head>

<body class="theme_skin_kinder">

@if (session()->has('error'))
<script>
    window.onload = function () {
        notif({
            msg: "   البريد الالكتروني وكلمة السر غير متطابقين  ",
            type: "error"
        })
    }
</script>
@endif

    <div id="box_wrapper">

<header id="header" class="menu_right with_user_menu noFixMenu">
     <!--top nav-->
     <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="topWrap">
                    <div class="usermenu_area">
                        <div class="container">
                            <div class="menuUsItem menuItemRight">
                                <ul id="usermenu" class="usermenu_list sf-arrows"
                                style="margin-right: -5px !important;">

                                     <li >
                                        <div class="menuUsItem menuItemLeft">
                                            <a href="#"  > <i class="fa fa-envelope" aria-hidden="true" ></i>
                                                 &nbsp;  {{$footer->email}}</a>

                                         </div>
                                     </li>
                                     &nbsp;&nbsp;
                                     <li >
                                        <div class="menuUsItem menuItemLeft " >
                                            <i class="fa fa-phone ar_con" aria-hidden="true" ></i>&nbsp;+
                                          @foreach(json_decode($footer->phone) as $item1)
                                            @if($item1 != null)
                                            {{$item1}} &nbsp;
                                                @endif
                                                @endforeach

                                        </div>

                                     </li>


                                </ul>
                            </div>

                            <div class="menuUsItem icons" style="padding-top: 5px" >

                               <a href="{{$footer->facebook}}" target="_blank">
                                 <i class="fa fa-facebook" aria-hidden="true"  style="font-size: 17px;"></i>
                                </a>
                                   &nbsp;&nbsp;
                                <a href="{{$footer->instgram}}"  target="_blank">
                                    <i class="fa fa-instagram" aria-hidden="true"
                                    style="font-size: 17px;"></i>
                                   </a>
                                   &nbsp;&nbsp;
                                   <a href="https://api.whatsapp.com/send?phone={{$footer->WhatsApp}}"  target="_blank">
                                    <i class="fa fa-whatsapp" aria-hidden="true" style="font-size: 17px;"></i>
                                   </a>
                                   &nbsp;&nbsp;

                                   <a href="{{$footer->twitter}}"  target="_blank">
                                    <i class="fa fa-twitter" aria-hidden="true" style="font-size: 17px;"></i>
                                   </a>
                                   &nbsp;&nbsp;
                                   <!--a href="#">
                                    <i class="whatsapp"  style="font-size: 15px;color: aliceblue;"></i>
                                   </a-->



                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end top nav-->
    <!--top nav-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="topWrap">
                    <div class="usermenu_area">
                        <div class="container">
                            <div class="menuUsItem menuItemRight">
                                <ul id="usermenu" class="usermenu_list sf-arrows">
                                   <!--lang-->



                                </ul>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <!--new login-->

 <!--end new login-->



    <!--end top nav-->
     <!-- The Modal for login  -->
     <div class="modal fade" id="myModal1">
         <div class="modal-dialog">
            <div class="container3">
                @if($errors->any())

                <div class="error-msg1" style="text-align:center; color:red">
                <i class="fa fa-times-circle"></i>
                <h6>{{$errors->first()}}</h6>
                </div>

              @endif

                <!--button title="Close (Esc)" type="button" class="mfp-close">×</button-->
                <div class="screen">
                    <div class="">

                      <form class="login" method="POST" action="{{ route('login1') }}">
                            <div class="circle">
                                <img src="{{asset('website/logo.png')}}" style="padding: 14px !important">

                           </div>
                           <button type="button" class="close" data-dismiss="modal">&times;</button>

                            @csrf
                            <!--div class="form__group field">
                                <input type="input" class="form__field" placeholder="Name" name="name" id='name' required />
                                <label for="name" class="form__label"><i class="fa fa-envelope"></i> Email</label>
                              </div-->
                              <br>
                              <br>

                          <div class="input-container">
                                <input  style="width: 50%;background-color: none !important; text-align:center"
                                type="email" id="email"  class="@error('email') is-invalid @enderror login__input"
                                name="email"  >
                                <label class="log_ar log_en">
                                    <i class="fa fa-envelope "></i> {{ __('site.Email') }}</label>
                            </div>

                               <br>
                               <br>


                              <div class="input-container">
                                <input id="password"  style="width: 50%;background-color: none !important;text-align:center"
                                type="password"   class="@error('password') is-invalid @enderror login__input"
                                name="password">
                                <label class="log_ar log_en log_ar2 log_en2" style="left: 164px">
                                    <i class="fa fa-lock ar_icon"></i>
                                    {{ __('site.Password') }}</label>
                            </div>

                                <br>
                                <br>

                            <button class="butt" type="submit" id="login" >
                             {{ __('site.Login') }}

                            </button>

                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>
<!-- end model popup for login -->

    <!--end add slider-->
      <!--end login popup-->

            <!--new design for login modal-->

            <!--end new design for modal login-->




    @if (LaravelLocalization::setLocale()=="en")
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="topWrap">
                        <div class="container">
                            <div class="mainmenu_area">
                                <div class="logo logo_left with_text">
                                    <a href="index.html">
                                        <img src="{{ asset('storage/'.$other->logo) }}" class="logo_main" alt="">
                                        <img src="{{ asset('storage/'.$other->logo) }}" class="logo_fixed" alt="">
                                        <span class="logo_text  "> {{ __('site.Smart Syrian School') }} </span>
                                        <!--span class="logo_slogan">Premium Children HTML Theme</span-->
                                    </a>
                                </div>

                                <div class="search" title="Open/close search form" >
                                    <div class="searchForm">
                                        <form method="get" class="search-form" action="{{ route('website.search') }}">
                                            <button type="submit" class="searchSubmit" title="Start search">
                                                <span class="icoSearch"></span>
                                            </button>
                                            <input type="text" class="searchField" placeholder="Search …" value="" name="text" title="Search for:">
                                        </form>
                                    </div>
                                    <div class="ajaxSearchResults"></div>
                                </div>
                                <a href="#" class="openResponsiveMenu"> {{ __('site.Menu') }}</a>
                                <nav id="mainmenu_wrapper" class="menuTopWrap topMenuStyleLine">
                                    <ul id="mainmenu" class="nav sf-menu sf-arrows">
                                        <li class=" active">
                                            <a href="{{ route('website.index') }}#top" class="sf-with-ul">{{ __('site.Home') }}</a>

                                        </li>
                                        <li class="">
                                            <a href="{{route('website.about_us')  }}" class="sf-with-ul" >{{ __('site.About us') }} </a>

                                        </li>
                                        <!--li class="">
                                            <a href="index.html#classes" class="sf-with-ul" style="font-size: 13px  !important;"></a>

                                        </li-->

                                        <li class="">
                                            <a href="{{ route('website.news') }}" class="sf-with-ul" >{{ __('site.News') }}</a>

                                        </li>
                                        <li class="">
                                            <a href="{{ route('website.register') }}" class="sf-with-ul">Register student</a>

                                        </li>
                                        <li class="">
                                            <a href="{{route('website.contact')  }}" class="sf-with-ul" >
                                                {{ __('site.Contact Us') }}</a>
                                        </li>

                                     <li class="line" >
                                            @if (LaravelLocalization::setLocale()=="en")

                                            <a class="lang1" style="text-align: center !important" href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" >
                                                <img class="religion" src="{{ asset('website/icons8-syria-48.png') }}" style="width: 40%;" > </a>

                                            @else
                                            <a class="lang1" style="text-align: center !important"  href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}" >
                                        <img class="religion" src="{{ asset('website/icons8-usa-48.png') }}" style="width: 40%;" ></a>


                                            @endif
                                        </li>
                                        <li class="line">
                                            <button  data-toggle="modal" data-target="#myModal1"
                                             class="log" >
                                             <img class="iicon"
                                             src="{{asset('website/icons8-login-rounded-30.png')}}">

                                             LogIn</button>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                </div>

            </div>
        </div>
    </div>

    @else
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="topWrap" >
                        <div class="container ar_con">
                            <div class="mainmenu_area">
                                <div class="logo logo_left with_text">
                                    <a href="index.html">
                                        <img src="{{ asset('storage/'.$other->logo) }}" class="logo_main" alt="">
                                        <img src="{{ asset('storage/'.$other->logo) }}" class="logo_fixed" alt="">
                                        <span class="logo_text text_ar"> {{ __('site.Smart Syrian School') }} </span>
                                        <!--span class="logo_slogan">Premium Children HTML Theme</span-->
                                    </a>
                                </div>
                                <div class="search" title="Open/close search form"
                                style="float: left;margin-left:-40px;" >
                                    <div class="searchForm">
                                        <form method="get" class="search-form" action="{{ route('website.search') }}">
                                            <button type="submit" class="searchSubmit" title="Start search">
                                                <span class="icoSearch"></span>
                                            </button>
                                            <input type="text" class="searchField" placeholder="Search …" value="" name="text" title="Search for:">
                                        </form>
                                    </div>
                                    <div class="ajaxSearchResults"></div>
                                </div>


                                <a href="#" class="openResponsiveMenu"> {{ __('site.Menu') }}</a>


                                <nav id="mainmenu_wrapper mainmenu_wrapper1"
                                class="menuTopWrap topMenuStyleLine" style="float: left">
                                    <ul id="mainmenu" class="nav sf-menu sf-arrows">

                                        <li class="line">
                                            <button  data-toggle="modal" data-target="#myModal1"
                                             class="log" style="width: 160px !important;font-size:15px">
                                             <img class="iicon"
                                             src="{{asset('website/icons8-login-rounded-30.png')}}">

                                             تسجيل دخول </button>
                                        </li>

                                        <li class="line">
                                            @if (LaravelLocalization::setLocale()=="en")

                                            <a class="lang1"  style="text-align: center !important"
                                            href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}" >
                                            <img   src="{{ asset('website/icons8-syria-48.png') }}" style="width: 40%;"  class="img22"> </a>

                                            @else
                                            <a class="lang1" style="text-align: center !important" href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}" >
                                                 <img  class="img22"  src="{{ asset('website/icons8-usa-48.png') }}" style="width: 40%;" ></a>


                                            @endif
                                        </li>


                                        <li class="">
                                            <a href="{{route('website.about_us')  }}" class="sf-with-ul"
                                            >{{ __('site.About us') }} </a>

                                        </li>

                                        <li >
                                            <a href="{{ route('website.register') }}" class="sf-with-ul"
                                            >{{ __('site.Register student') }}</a>

                                        </li>
                                        <li class="">
                                            <a href="{{ route('website.news') }}"
                                             class="sf-with-ul"  >{{ __('site.News') }}</a>

                                        </li>
                                        <li class="">
                                            <a href="{{route('website.contact')  }}"
                                            class="sf-with-ul" >{{ __('site.Contact Us') }}</a>
                                        </li>
                                        <li class=" active">
                                            <a href="{{ route('website.index') }}#top"
                                             class="sf-with-ul">{{ __('site.Home') }}</a>

                                        </li>


                                    </ul>

                                </nav>


                            </div>

                        </div>
                </div>

            </div>
        </div>
    </div>

    @endif
</header>
@yield('contain')
    </div>

    <!--new footer-->

        <footer class="footer " style="height:300px;">

            @if (LaravelLocalization::setLocale()=="en")
              <!--start col-->
        <div class="">
             <!--start col-->

             <div class="col-md-2 logo223" style="width:27% !important;margin-top:-45px">
                <img src="{{asset('website/new2.png')}}" alt="">

            </div>
            <!--end col-->
               <!--start col-->
               <div class="col-md-2 wwidth newwidth2" style="padding-top: 35px;width:10%">
                <h6 ><a href="{{ route('website.index') }}#top" class="tit" ><span style="color: #ffc600 !important"> > </span>HOME</a></h6>
                     <h6><a href="{{route('website.about_us')  }}" class="tit"><span style="color: #ffc600 !important"> > </span> About us</a></h6>
                     <h6><a href="{{ route('website.index') }}#classes"><span style="color: #ffc600 !important"> > </span> Classes</a></h6>

                     <h6 ><a href="{{ route('website.news') }}"><span style="color: #ffc600 !important"> > </span>news</a></h6>
                     <h6><a href="{{route('website.contact')  }}"><span style="color: #ffc600 !important"> > </span>Contact</a></h6>

             </div>
         <!--end col-->

                    <!--start col-->
                    <div class="col-md-2 col-en newwidth2" style="padding-top: 35px">
                        <h6><a href="{{ route('website.register') }}"><span style="color: #ffc600 !important"> > </span>Register stuent</a></h6>
                        <h6><a href="{{ route('website.ourteam') }}"><span style="color: #ffc600 !important"> > </span>Our teams</a></h6>

                        <h6><a href="{{ route('website.faqs') }}"><span style="color: #ffc600 !important"> > </span>FAQS</a></h6>

                        <h6><a href="{{ route('website.jobs') }}"><span style="color: #ffc600 !important"> > </span> Join us </a></h6>

                       </div>
                 <!--end col-->
                   <!--start col-->
                   <div class="col-md-3 adden" style="color:white;width:26%;padding-top: 35px
                   ">
                      <span class="sc_icon fa-home fa1" style="font-size: 27px;color:#ffc600 !important"></span>
                       <span style="font-size: 14px;"> {{$footer->address}}</span>&nbsp;

                    <br>
                    <br>
                          <span class="sc_icon fa-envelope fa2" style="font-size: 25px;color:#ffc600 !important"></span>
                           <span style="font-size:14px ;"> {{$footer->email}} </span>&nbsp;

                    <br>
                    <br>
                    <span class="sc_icon fa-phone fa3 ar_ph" style="font-size: 25px;color:#ffc600 !important"></span>
                              <span style="font-size: 14px;">&nbsp;+
                                @foreach(json_decode($footer->phone) as $item1)
                                @if($item1 != null)

                                {{$item1}} &nbsp;
                                    @endif
                                    @endforeach
                                </span>



                   </div>
                   <!--end col-->


            <div class="col-md-2" style="padding-top: 35px">
                <i class="fa fa-eye newic" style="font-size: 39px;
                color:#fff; text-align: center;margin-left:80px"></i>
                  <br>

                              <h5 class="newic2"  style="margin-top: 7px;margin-left:57px;font-size:29px;color:white">{{$counter->count}}</h5>
                              <div class="social1 arsocial"
                              style="margin-top:80px;width:126%">
                                  <!--socail icons-->
                                  <a href="{{$footer->facebook}}" class="border anlik">
                                    <i class="fa fa-facebook" aria-hidden="true"  style="font-size: 27px;"></i>
                                   </a>
                                      &nbsp;&nbsp;&nbsp;
                                   <a href="{{$footer->instgram}}" class="border anlik"
                                      style="

                                          padding-left: 11px;
                                          padding-right: 11px;
                                          padding-bottom: 4px;
                                          padding-top: 8px;
                                      ">
                                       <i class="fa fa-instagram" aria-hidden="true" style="font-size: 27px;"></i>
                                      </a>
                                      &nbsp;&nbsp;&nbsp;
                                      <a href="{{$footer->whatsapp}}" class="border border2 anlik"
                                          style="

                                          padding-left: 11px;
                                          padding-right: 11px;
                                          padding-bottom: 4px;
                                          padding-top: 8px;
                                          ">

                                            <i class="fa fa-whatsapp" aria-hidden="true" style="font-size: 27px;"></i>
                                          </a>
                                      &nbsp;&nbsp;&nbsp;
                                      <a href="{{$footer->twitter}}" class="border anlik"
                                          style="

                                              padding-bottom: 4px;
                                              padding-left: 10px;
                                              padding-right: 10px;
                                              padding-top: 8px;
                                          "
                                          >
                                       <i class="fa fa-twitter" aria-hidden="true" style="font-size: 27px;"></i>
                                      </a>
                              </div>
                                   <!--end social icons-->

                    </div>
                    <!--end col-->




                  </div>




                    @else


                    <div class="">

                        <div class="col-md-2">
                            <i class="fa fa-eye eye2" style="font-size: 39px;
                            color:#fff; text-align: center;margin-left:80px"></i>
                           <br>

                                     <h5 class="font3 eye4 "  style="margin-top: 7px;margin-left:57px;font-size:30px;color:white">{{$counter->count}}</h5>
                                          <div class="social1 arsocial font4"
                                          style="margin-top:100px;width:126%">
                                              <!--socail icons-->
                                              <a href="{{$footer->facebook}}" class="border anlik">
                                                <i class="fa fa-facebook" aria-hidden="true"  style="font-size: 27px;"></i>
                                               </a>
                                                  &nbsp;&nbsp;&nbsp;
                                               <a href="{{$footer->instgram}}" class="border anlik"
                                                  style="

                                                      padding-left: 11px;
                                                      padding-right: 11px;
                                                      padding-bottom: 4px;
                                                      padding-top: 8px;
                                                  ">
                                                   <i class="fa fa-instagram" aria-hidden="true" style="font-size: 27px;"></i>
                                                  </a>
                                                  &nbsp;&nbsp;&nbsp;
                                                  <a href="https://api.whatsapp.com/send?phone={{$footer->WhatsApp}}" class="border border2 anlik"
                                                      style="

                                                      padding-left: 11px;
                                                      padding-right: 11px;
                                                      padding-bottom: 4px;
                                                      padding-top: 8px;
                                                      ">

                                                        <i class="fa fa-whatsapp" aria-hidden="true" style="font-size: 27px;"></i>
                                                      </a>
                                                  &nbsp;&nbsp;&nbsp;
                                                  <a href="{{$footer->twitter}}" class="border anlik"
                                                      style="

                                                          padding-bottom: 4px;
                                                          padding-left: 10px;
                                                          padding-right: 10px;
                                                          padding-top: 8px;
                                                      "
                                                      >
                                                   <i class="fa fa-twitter" aria-hidden="true" style="font-size: 27px;"></i>
                                                  </a>
                                          </div>
                                               <!--end social icons-->

                                </div>
                                <!--end col-->
                                <!--start col-->
                                <div class="col-md-3 add"  style="color:white;margin-top:8px
                                ">
                                    <span class=""  style="font-size: 14px;"> {{$footer->address}}</span>&nbsp;
                                    <span class="sc_icon fa-home fa1" style="font-size: 27px;color:#ffc600 !important"></span>
                                 <br>
                                 <br>

                                        <span class=""  style="font-size:14px ;margin-left:40px"> {{$footer->email}} </span>&nbsp;
                                        <span class="sc_icon fa-envelope fa2" style="font-size: 25px;color:#ffc600 !important"></span>
                                 <br>
                                 <br>

                                           <span class=""  style="font-size: 14px;margin-left:100px">&nbsp;+
                                             @foreach(json_decode($footer->phone) as $item1)
                                             @if($item1 != null)

                                             {{$item1}} &nbsp;
                                                 @endif
                                                 @endforeach
                                             </span>
                                             <span class="sc_icon fa-phone fa3 ar_ph" style="font-size: 25px;color:#ffc600 !important"></span>


                                </div>
                                <!--end col-->

                                <!--start col-->
                               <div class="col-md-2 width2 newwidth" style="padding-top: 20px">

                                <h6 ><a href="{{ route('website.faqs') }}" >الاسئلة الشائعة</a><span style="color: #ffc600 !important"> < </span></h6>
                                <h6 ><a href="{{ route('website.register') }}" class="tit " style="padding-left: 10px" >تسجيل الطالب</a><span style="color: #ffc600 !important"> < </span></h6>
                                <h6 ><a href="{{ route('website.ourteam') }}" class="tit tit2" style="padding-left: 61px" >كادرنا</a><span style="color: #ffc600 !important"> < </span></h6>
                                <h6 ><a href="{{ route('website.jobs') }}" class="tit  tit3" style="padding-left: 44px">انضم الينا </a><span style="color: #ffc600 !important"> < </span></h6>

                               </div>
                         <!--end col-->

                            <!--start col-->
                                 <div class="col-md-2 wwidth newwidth" style="padding-top: 20px;width:10%">
                                    <h6 ><a href="{{ route('website.index') }}#top" class="tit" >{{__('site.Home')}}</a><span style="color: #ffc600 !important"> < </span></h6>
                                    <h6><a href="{{ route('website.index') }}#classes" class="tit">{{__('site.Classes')}}<span style="color: #ffc600 !important"> < </span></a></h6>
                                    <h6><a href="{{route('website.about_us')  }}">{{__('site.About us')}}<span style="color: #ffc600 !important"> < </span></a></h6>

                                    <h6 ><a href="{{route('website.contact')  }}"> {{__('site.Contact Us')}} <span style="color: #ffc600 !important"> < </span></a></h6>
                                    <h6><a href="{{ route('website.news') }}" style="padding-left: 10px">{{__('site.News')}}<span style="color: #ffc600 !important"> < </span></a></h6>

                                 </div>
                             <!--end col-->
                             <!--start col-->

                                 <div class="col-md-2 logo223" style="width:31%;margin-top:-70px">
                                    <img class="lo222" src="{{asset('website/new.png')}}" alt="">
                                </div>
                                <!--end col-->
                              </div>

        @endif
  </footer>
  @if (LaravelLocalization::setLocale()=="ar")
  <div class="footer-down">
     <div class="row" style="text-align:center">
         <span>Copyright <a href="https://sunrise-center.net/it"  target="_blank"> <b style="font-size: 14px">SunriseiT</b> </a>  All Right Reserved</span>
     </div>
  </div>
  @else
  <div class="footer-down">
    <div class="row" style="text-align: center">
        <span class="sspan newcop"  >Copyright <a href="https://sunrise-center.net/it"  target="_blank"> <b style="font-size: 14px">SunriseiT</b> </a> All Right Reserved</span>
    </div>
 </div>
 @endif




    <!--end new footer-->






<script src="{{ URL::asset('teachers/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('teachers/notify/js/notifit-custom.js') }}"></script>

    <script src="{{ asset('website/js/vendor/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('website/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('website/js/vendor/jquery.ui.totop.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('website/js/main/__packed.js') }}"></script>
    <script  type="text/javascript" src="{{ asset('website/js/main/shortcodes_init.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('website/js/main/_main.js') }}"></script>


<script >
$(document).on('click', '#login', function () {
  if($('#email').val() ){
      if( $('#password').val() ){
          $(this).hide();
      }
  }

});

</script>





    @yield('js')


</body>

</html>
