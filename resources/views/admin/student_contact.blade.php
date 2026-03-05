@extends('admin.master')
@section('style')
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!--link for select-->
 <link rel="stylesheet" href="{{asset('teachers_2/assets/vendors/select2/select2.min.css')}}" />
 <link rel="stylesheet" href="{{asset('teachers_2/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css')}}" />
    <style>
    
        .contacts li>.info-combo>h3.name {
            font-size: 12px;
        }

        .contacts li .message-time {
            text-align: right;
            display: block;
            margin-left: -15px;
            width: 70px;
            height: 25px;
            line-height: 28px;
            font-size: 14px;
            font-weight: 600;
            padding-right: 5px;
        }

        .contacts li>.info-combo>h5 {
            width: 180px;
            font-size: 12px;
            height: 28px;
            font-weight: 500;
            overflow: hidden;
            white-space: normal;
            text-overflow: ellipsis;
        }

        .contacts li>.info-combo>h3 {
            width: 167px;
            height: 20px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .info-combo>h3 {
            margin: 3px 0;
        }

        .no-margin-bottom {
            margin-bottom: 0 !important;
        }

        .info-combo>h5 {
            margin: 2px 0 6px 0;
        }

        /* Messages */
        .messages-panel img.img-circle {
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .medium-image {
            width: 45px;
            height: 45px;
            margin-right: 5px;
        }

        .img-circle {
            border-radius: 50%;
        }

        .messages-panel {
            width: 100%;
            /*height: calc(100vh - 0px);*/
            min-height: fit-content;
            border-radius: 10px;
            background-color: #fbfcff;
            display: inline-block;
            border-top-left-radius: 5px;
            margin-bottom: 0;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
        }

        .messages-panel img.img-circle {
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .messages-panel .tab-content {
            border: none;
            background-color: transparent;
        }

        .contacts-list {
            background-color: #fff;
            border-right: 1px solid #cfdbe2;
            width: 305px;
            height: 100%;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            float: left;
        }

        .contacts-list .inbox-categories {
            width: 100%;
            padding: 0;
            margin-left: 0;
        }

        .contacts-list .inbox-categories>div {
            float: left;
            width: 76px;
            padding: 15px 5px;
            font-size: 14px;
            text-align: center;
            border-right: 1px solid rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.75);
            cursor: pointer;
            font-weight: 700;
        }

        .contacts-list .inbox-categories>div:nth-child(1) {
            color: #2da9e9;
            border-right-color: rgba(45, 129, 233, 0.06);
            border-bottom: 4px solid #2da9e9;
            border-top-left-radius: 5px;
        }

        .contacts-list .inbox-categories>div:nth-child(1).active {
            color: #fff;
            background-color: #2da9e9;
            border-bottom: 4px solid rgba(0, 0, 0, 0.15);
        }

        .contacts-list .inbox-categories>div:nth-child(2) {
            color: #0ec8a2;
            border-right-color: rgba(14, 200, 162, 0.06);
            border-bottom: 4px solid #0ec8a2;
        }

        .contacts-list .inbox-categories>div:nth-child(2).active {
            color: #fff;
            background-color: #0ec8a2;
            border-bottom: 4px solid rgba(0, 0, 0, 0.15);
        }

        .contacts-list .inbox-categories>div:nth-child(3) {
            color: #a5c9ff;
            border-right-color: rgba(255, 152, 14, 0.06);
            border-bottom: 4px solid #a5c9ff;
        }

        .contacts-list .inbox-categories>div:nth-child(3).active {
            color: #fff;
            background-color: #a5c9ff;
            border-bottom: 4px solid rgba(0, 0, 0, 0.15);
        }

        .contacts-list .inbox-categories>div:nth-child(4) {
            color: #314557;
            border-bottom: 4px solid #314557;
            border-right-color: transparent;
        }

        .contacts-list .inbox-categories>div:nth-child(4).active {
            color: #fff;
            background-color: #314557;
            border-bottom: 4px solid rgba(0, 0, 0, 0.35);
        }

        .contacts-list .panel-search>input {
            margin-left: 5px;
            background-color: rgba(0, 0, 0, 0);
        }

        .contacts-outter-wrapper {
            position: relative;
            width: 305px;
            direction: rtl;
            min-height: 405px;
            overflow: hidden;
        }

        .contacts-outter-wrapper:after,
        .contacts-outter-wrapper:nth-child(1):after {
            content: "";
            position: absolute;
            width: 100%;
            height: 5px;
            bottom: 0;
            background-color: #2da9e9;
            border-bottom-left-radius: 4px;
        }

        .contacts-outter-wrapper:nth-child(2):after {
            background-color: #0ec8a2;
        }

        .contacts-outter-wrapper:nth-child(3):after {
            background-color: #a5c9ff;
        }

        .contacts-outter-wrapper:nth-child(4):after {
            background-color: #314557;
        }

        .contacts-outter {
            position: relative;
            height: calc(100vh - -37px);
            width: 345px;
            direction: rtl;
            overflow-y: scroll;
            padding-left: 20px;
        }

        @media screen and (min-color-index:0) and(-webkit-min-device-pixel-ratio:0) {
            @media {
                .contacts-outter-wrapper {
                    direction: ltr;
                }

                .contacts-outter {
                    direction: ltr;
                    padding-left: 0;
                }
            }
        }

        .contacts {
            direction: ltr;
            width: 305px;
            margin-top: 0px;
        }

        .contacts li {
            width: 100%;
            border-top: 1px solid transparent;
            border-bottom: 1px solid rgba(205, 211, 237, 0.2);
            border-left: 4px solid rgba(255, 255, 255, 0);
            padding: 8px 12px;
            position: relative;
            background-color: rgba(255, 255, 255, 0);
        }

        .contacts li:first-child {
            border-top: 1px solid rgba(205, 211, 237, 0.2);
        }

        .contacts li:first-child.active {
            border-top: 1px solid rgba(205, 211, 237, 0.75);
        }

        .contacts li:hover {
            background-color: rgba(255, 255, 255, 0.25);
        }

        .contacts li.active,
        .contacts.info li.active {
            border-left: 4px solid #2da9e9;
            border-top-color: rgba(205, 211, 237, 0.75);
            border-bottom-color: rgba(205, 211, 237, 0.75);
            background-color: #fbfcff;
        }

        .contacts.success li.active {
            border-left: 4px solid #0ec8a2;
        }

        .contacts.warning li.active {
            border-left: 4px solid #a5c9ff;
        }

        .contacts.danger li.active {
            border-left: 4px solid #a5c9ff;
        }

        .contacts.dark li.active {
            border-left: 4px solid #a5c9ff;
        }

        .contacts li>.info-combo {
            width: 172px;
            cursor: pointer;
        }

        .contacts li>.info-combo>h3 {
            width: 167px;
            height: 20px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .contacts li .contacts-add {
            width: 50px;
            float: right;
            z-index: 23299;
        }

        .contacts li .message-time {
            text-align: right;
            display: block;
            margin-left: -15px;
            width: 70px;
            height: 25px;
            line-height: 28px;
            font-size: 14px;
            font-weight: 600;
            padding-right: 5px;
        }

        .contacts li .contacts-add .fa-trash-o {
            position: absolute;
            font-size: 14px;
            right: 12px;
            bottom: 15px;
            color: #a6a6a6;
            cursor: pointer;
        }

        .contacts li .contacts-add .fa-paperclip {
            position: absolute;
            font-size: 14px;
            right: 34px;
            bottom: 15px;
            color: #a6a6a6;
            cursor: pointer;
        }

        .contacts li .contacts-add .fa-trash-o:hover {
            color: #a5c9ff;
        }

        .contacts li .contacts-add .fa-paperclip:hover {
            color: #a5c9ff;
        }

        .contacts li>.info-combo>h5 {
            width: 180px;
            font-size: 12px;
            height: 28px;
            font-weight: 500;
            overflow: hidden;
            white-space: normal;
            text-overflow: ellipsis;
        }

        .contacts li .message-count {
            position: absolute;
            top: 8px;
            left: 5px;
            width: 20px;
            height: 20px;
            line-height: 20px;
            text-align: center;
            background-color: #a5c9ff;
            border-radius: 50%;
            color: #fff;
            font-weight: 600;
            font-size: 10px;
        }

        .message-body {
            background-color: #fbfcff;
            height: 100%;
            width: calc(100% - 305px);
            float: right;
        }

        .message-body .message-top {
            display: inline-block;
            width: 100%;
            position: relative;
            min-height: 53px;
            height: auto;
            background-color: #fff;
            border-bottom: 1px solid rgba(205, 211, 237, 0.5);
        }

        .message-body .message-top .new-message-wrapper {
            width: 100%;
        }

        .message-body .message-top .new-message-wrapper>.form-group {
            width: 100%;
            padding: 10px 10px 0 10px;
            height: 50px;
        }

        .message-body .message-top .new-message-wrapper .form-group .form-control {
            width: calc(100% - 50px);
            float: left;
        }

        .message-body .message-top .new-message-wrapper .form-group a {
            width: 40px;
            padding: 6px 6px 6px 6px;
            text-align: center;
            display: block;
            float: right;
            margin: 0;
        }

        .message-body .message-top>.btn {
            height: 53px;
            line-height: 53px;
            padding: 0 20px;
            float: right;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            margin: 0;
            font-size: 15px;
            opacity: 0.9;
        }

        .message-body .message-top>.btn:hover,
        .message-body .message-top>.btn:focus,
        .message-body .message-top>.btn.active {
            opacity: 1;
        }

        .message-body .message-top>.btn>i {
            margin-right: 5px;
            font-size: 18px;
        }

        .new-message-wrapper {
            position: absolute;
            max-height: 400px;
            top: 53px;
            background-color: #fff;
            z-index: 105;
            padding: 20px 15px 30px 15px;
            border-bottom: 1px solid #cfdbe2;
            border-bottom-left-radius: 3px;
            border-bottom-right-radius: 3px;
            box-shadow: 0 7px 10px rgba(0, 0, 0, 0.25);
            transition: 0.5s;
            display: none;
        }

        .new-message-wrapper.closed {
            opacity: 0;
            max-height: 0;
        }

        .chat-footer.new-message-textarea {
            display: block;
            position: relative;
            padding: 0 10px;
        }

        .chat-footer.new-message-textarea .send-message-button {
            right: 35px;
        }

        .chat-footer.new-message-textarea .upload-file {
            right: 85px;
        }

        .chat-footer.new-message-textarea .send-message-text {
            padding-right: 100px;
            height: 90px;
        }

        .message-chat {
            width: 100%;
            /*overflow: hidden;*/
            overflow: inherit;
        }

        .chat-body {
            width: calc(98% + 17px);
           /* min-height: 100%;
            height: calc(100vh - 56px);*/
            max-height: 650px;
            background-color: #fbfcff;
            margin-bottom: 0px;
            padding: 30px 5px 5px 5px;
            overflow-y: scroll;
        }

        .message {
            position: relative;
            width: 100%;
        }

        .message br {
            clear: both;
        }

        .message .message-body {
            position: relative;
            width: auto;
            max-width: calc(100% - 150px);
            float: left;
            background-color: #fff;
            border-radius: 4px;
            border: 1px solid #dbe3e8;
            margin: 0 5px 20px 15px;
            color: #788288;
        }

        .message:after {
            content: "";
            position: absolute;
            top: 11px;
            left: 63px;
            float: left;
            z-index: 100;
            border-top: 10px solid transparent;
            border-left: none;
            border-bottom: 10px solid transparent;
            border-right: 13px solid #fff;
        }

        .message:before {
            content: "";
            position: absolute;
            top: 10px;
            left: 62px;
            float: left;
            z-index: 99;
            border-top: 11px solid transparent;
            border-left: none;
            border-bottom: 11px solid transparent;
            border-right: 13px solid #dbe3e8;
        }

        .message .medium-image {
            float: left;
            margin-left: 10px;
        }

        .message .message-info {
            width: 100%;
            height: 22px;
        }

        .message .message-info>h5>i {
            font-size: 11px;
            font-weight: 700;
            margin: 0 2px 0 0;
            color: #a2b8c5;
        }

        .message .message-info>h5 {
            color: #a2b8c5;
            margin: 8px 0 0 0;
            font-size: 12px;
            float: right;
            padding-right: 10px;
        }

        .message .message-info>h4 {
            font-size: 14px;
            font-weight: 600;
            margin: 7px 13px 0 10px;
            color: #65addd;
            float: left;
        }

        .message hr {
            margin: 4px 2%;
            width: 96%;
            opacity: 0.75;
        }

        .message .message-text {
            text-align: left;
            padding: 3px 13px 10px 13px;
            font-size: 14px;
        }

        .message.my-message .message-body {
            float: right;
            /*margin-right:20px !important;*/
            margin: 0 15px 20px 5px;
        }

        .message.my-message:after {
            content: "";
            position: absolute;
            top: 11px;
            left: auto;
            right: 72px;
            float: left;
            z-index: 100;
            border-top: 10px solid transparent;
            border-left: 13px solid #fff;
            border-bottom: 10px solid transparent;
            border-right: none;
        }

        .message.my-message:before {
            content: "";
            position: absolute;
            top: 10px;
            left: auto;
            right: 72px;
            float: left;
            z-index: 99;
            border-top: 11px solid transparent;
            border-left: 13px solid #dbe3e8;
            border-bottom: 11px solid transparent;
            border-right: none;
        }

        .message.my-message .medium-image {
            float: right;
            margin-left: 0px;
            margin-right: 25px;
        }

        .message.my-message .message-info>h5 {
            float: left;
            padding-left: 10px;
            padding-right: 0;
        }

        .message.my-message .message-info>h4 {
            float: right;
        }

        .message.info .message-body {
            background-color: #a5c9ff;
            border: 1px solid #a5c9ff;
            color: #fff;
        }

        .message.info:after,
        .message.info:before {
            border-right: 13px solid #a5c9ff;
        }

        .message.success .message-body {
            background-color: #a5c9ff;
            border: 1px solid #a5c9ff;
            color: #fff;
        }

        .message.success:after,
        .message.success:before {
            border-right: 13px solid #a5c9ff;
        }

        .message.warning .message-body {
            background-color: #a5c9ff;
            border: 1px solid #a5c9ff;
            color: #fff;
        }

        .message.warning:after,
        .message.warning:before {
            border-right: 13px solid #a5c9ff;
        }

        .message.danger .message-body {
            background-color: #a5c9ff;
            border: 1px solid #a5c9ff;
            color: #fff;
        }

        .message.danger:after,
        .message.danger:before {
            border-right: 13px solid #a5c9ff;
        }

        .message.dark .message-body {
            background-color: #314557;
            border: 1px solid #314557;
            color: #fff;
        }

        .message.dark:after,
        .message.dark:before {
            border-right: 13px solid #314557;
        }

        .message.info .message-info>h4,
        .message.success .message-info>h4,
        .message.warning .message-info>h4,
        .message.danger .message-info>h4,
        .message.dark .message-info>h4 {
            color: #fff;
        }

        .message.info .message-info>h5,
        .message.info .message-info>h5>i,
        .message.success .message-info>h5,
        .message.success .message-info>h5>i,
        .message.warning .message-info>h5,
        .message.warning .message-info>h5>i,
        .message.danger .message-info>h5,
        .message.danger .message-info>h5>i,
        .message.dark .message-info>h5,
        .message.dark .message-info>h5>i {
            color: #fff;
            opacity: 0.9;
        }

        .chat-footer {
            position: relative;
            width: 100%;
            padding: 0 80px;
        }

        .chat-footer .send-message-text {
            position: relative;
            display: block;
            width: 100%;
            min-height: 55px;
            max-height: 75px;
            background-color: #fff;
            border-radius: 5px;
            padding: 5px 95px 5px 10px;
            font-size: 13px;
            resize: vertical;
            outline: none;
            border: 1px solid #e0e6eb;
        }

        .chat-footer .send-message-button {
            display: block;
            position: absolute;
            width: 35px;
            height: 35px;
            right: 100px;
            top: 0;
            bottom: 0;
            margin: auto;
            border: 1px solid rgba(0, 0, 0, 0.05);
            outline: none;
            font-weight: 600;
            border-radius: 50%;
            padding: 0;
        }

        .chat-footer .send-message-button>i {
            font-size: 16px;
            margin: 0 0 0 -2px;
        }

        .chat-footer label.upload-file input[type="file"] {
            position: fixed;
            top: -1000px;
        }

        .chat-footer .upload-file {
            display: block;
            position: absolute;
            right: 150px;
            height: 30px;
            font-size: 20px;
            top: 0;
            bottom: 0;
            margin: auto;
            opacity: 0.25;
        }

        .chat-footer .upload-file:hover {
            opacity: 1;
        }

        @media screen and (max-width: 767px) {
            .messages-panel {
                min-width: 0;
                display: inline-block;
            }

            .contacts-list,
            .contacts-list .inbox-categories>div:nth-child(4) {
                border-top-right-radius: 5px;
                border-right: none;
            }

            .contacts-list,
            .contacts-outter-wrapper,
            .contacts-outter,
            .contacts {
                width: 100%;
                direction: ltr;
                padding-left: 0;
            }

            .contacts-list .inbox-categories>div {
                width: 25%;
            }

            .message-body {
                width: 100%;
                margin: 20px 0;
                border: 1px solid #dce2e9;
                background-color: #fff;
            }

            .message .message-body {
                max-width: calc(100% - 85px);
            }

            .message-body .chat-body {
                background-color: #fff;
                width: 100%;
            }

            .chat-footer {
                margin-bottom: 20px;
                padding: 0 20px;
            }

            .chat-footer .send-message-button {
                right: 40px;
            }

            .chat-footer .upload-file {
                right: 90px;
            }

            .message-body .message-top>.btn {
                border-radius: 0;
                width: 100%;
            }

            .contacts-add {
                display: none;
            }
        }

        /* Profile page */

        .profile-main {
            background-color: #fff;
            border: 1px solid #dce2e9;
            border-radius: 3px;
            position: relative;
            margin-bottom: 20px;
        }

        .profile-main .profile-background {

            background-repeat: no-repeat;
            background-size: 100%;
            background-position: center;
            width: 100%;
            height: 260px;
        }

        .profile-main .profile-info {
            width: calc(100% - 380px);
            max-width: 1100px;
            margin: 0 auto;
            background-color: #fff;
            height: 70px;
            border-radius: 0 0 3px 3px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .profile-main .profile-info>div {
            margin: 0 10px;
        }

        .profile-main .profile-info>div:last-child {
            padding-right: 25px;
        }

        .profile-main .profile-info>div h4 {
            font-size: 16px;
            margin-bottom: 0;
        }

        .profile-main .profile-info>div h5 {
            margin-top: 5px;
            font-weight: 500;
        }

        .profile-main .profile-button {
            padding: 8px 0;
            position: absolute;
            right: 25px;
            bottom: 16px;
            width: 150px;
        }

        .profile-main .profile-picture {
            width: 150px;
            height: 150px;
            border: 4px solid #fff;
            position: absolute;
            left: 25px;
            bottom: 14px;
        }

        @media screen and (max-width: 767px) {

            .profile-main .profile-info .profile-status,
            .profile-main .profile-info .profile-posts,
            .profile-main .profile-info .profile-date {
                display: none;
            }
        }

        .contacts li>.info-combo {
            display: inline-block;
        }

        small {
            position: relative;
            left: 0;
        }
        @media(min-width:100px) and (max-width:900px){
            .mcontainer{
                padding-bottom: 325% !important;
            }
        }
.live {
    display: flex;
    justify-content: center;
    color: #fff;
    width: 120px;
    height: 50px;
    border-radius: 5%;
    /* background: linear-gradient(30deg, #d3aeff 20%, #995FDE 80%); */
    background: linear-gradient(30deg, #a5c9ff 20%, #4382E0 80%);
    transition: all 0.3s ease-in-out 0s;
    box-shadow: rgba(193, 244, 246, 0.698) 0px 0px 0px 0px;
    animation: 1.2s cubic-bezier(0.8, 0, 0, 1) 0s infinite normal none running pulse;
    align-items: center;
    border: 0;
}
.select2-results {
    text-align: end;
    display: block;
}
        /*end new design*/
        
        
.p-4{
    padding: 0px !important;
}






.lds-hourglass {
   float: left;
  padding-top: 100px;
  padding-left: 136px;
   margin: auto;
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-hourglass:after {
  content: " ";
  display: block;
  border-radius: 50%;
  width: 0;
  height: 0;
  margin: 8px;
  margin: auto;
  box-sizing: border-box;
  border: 32px solid #4382E0 ;
  border-color: #4382E0  transparent #4382E0  transparent;
  animation: lds-hourglass 1.2s infinite;
}
@keyframes lds-hourglass {
  0% {
    transform: rotate(0);
    animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
  }
  50% {
    transform: rotate(900deg);
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
  }
  100% {
    transform: rotate(1800deg);
  }
}

    </style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection



@section('breadcrumbs')

<nav class="breadcrumbs">
    <a class="breadcrumbs__item is-active "> قسم التواصل مع الطلاب   </a>

    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')

@if(session()->has('success'))

  <div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     {{ session()->get('success') }}
    </div>
@endif



@php
$about = \App\About_us::find(1);
@endphp


{{-- ////////// --}}





<div class="card" style="margin: 30px">
    <div class="card-body" style="text-align: right;">
       <div class="content-wrapper pb-0">  
        
            <div class="row" style="">
                <div class="col-md-4">
                    <a href="{{ route('admin_contact') }}" class="live" style="text-decoration: none;
    font-weight: bold;">
                       ارسال رسالة للكل
                    </a>   
                </div>
            
           
             <div class=" col-12 col-lg-3" style="font-size: large;
    font-weight: bold;">
                <label for=""> من :  </label>
                <input  type="date" class="form-control" id="start_date" style="display: inline-block;width: 70% ; font-size: medium;
    font-weight: bold;">
            </div>
            <div class=" col-12 col-lg-3">
                <label for="" style="font-size: large;
    font-weight: bold;"> الى :  </label>
                <input type="date" class="form-control" id="end_date" style="display: inline-block;width: 70%; font-size: medium;
    font-weight: bold;">
            </div>
            <div class=" col-12 col-lg-2" style="text-align: left;">
                <a class="btn live" id="search" style="color:white; font-size: large;
    font-weight: bold;" > بحث  </a>
            </div>
            </div>
            <br>
            <div class="row" style="justify-content: center;">
             <div class="col-sm-5">
                    <div class="form-group newselect" style="font-weight: bold;">
                        <select class="js-example-basic-single " id="classes_select" style="width: 100%;direction: rtl;">
                            <option value="" style="text-align: end;">اختر الصف </option>
                            @foreach ($classes as $item)
                                <option value="{{ $item->id }}" style="text-align: end;"> {{ $item->name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group newselect" style="font-weight: bold;">
                        <select class="js-example-basic-single " id="rooms_classes" style="width: 100%;direction: rtl;">
                            <option value="" style="text-align: end;">اختر الشعبة</option>
                        </select>
                    </div>
                </div>
               
            </div>
            <!--new design-->
            <div class=" container mcontainer" style="padding-top: 100px; padding-bottom:100px">
                <div class="panel messages-panel" style="border: 1px solid #4da2eb;">
                    <div class="contacts-list">
                        <div class="tab-content">
                            <div id="inbox" class="contacts-outter-wrapper tab-pane active">
                                <div class="contacts-outter">
                     
                                    <ul class="list-unstyled contacts" style="z-index: 10000;">
                                            @php
                                          $stu=[];
                                          @endphp
                                         @foreach ($student as $item)
                                            @if ($item->message_admin_count > 0)
                                              @if(!in_array($item->id,$stu))
                                                <li  aria-selected="true" data-toggle="tab" data-target="#std{{ $item->id }}" data-image="{{ $item->image}}"  data-id="{{ $item->id }}" class="act_student message1">
                                                    <div class="message-count number">{{ $item->message_admin_count }}</div>
                                                    @if ($item->image)
                                                        <img src="{{ asset('storage/' . $item->image) }}"
                                                            class="img-circle medium-image" />
                                                    @else
                                                        <img src=" {{ asset('student/avatar.png') }}"
                                                            class="img-circle medium-image" />
                                                    @endif
                                                    <!--img alt="" class="img-circle medium-image"
                                                    src="https://bootdey.com/img/Content/avatar/avatar1.png"-->
   
                                                    <div class="vcentered info-combo">
                                                        <h3 class="no-margin-bottom name"> {{ $item->first_name }}
                                                            {{ $item->last_name }}</h3>
                                                    </div>
                                                    @foreach ($item->room as $item1)
                                                        <div class="contacts-add">
                                                            <span class="message-time"> {{ $item1->classes->name }}</span>
                                                            <small>{{ $item1->name }}</small>
                                                        </div>
                                                    @endforeach
                                                </li>
                                            @endif
                                              @php
                                            $stu[]=$item->id;
                                            @endphp
                                             @endif
                                        @endforeach


                                        @foreach ($student as $item)
                                          @if ($item->message_admin_count == 0)
                                           @if(!in_array($item->id,$stu))
                                                <li data-toggle="tab" data-target="#std{{ $item->id }}" data-id="{{ $item->id }}" data-image="{{ $item->image}}" class="act_student message1">
                                                    <div class="message-count">{{ $item->message_admin_count }}</div>
                                                    @if ($item->image)
                                                        <img src="{{ asset('storage/' . $item->image) }}"
                                                            class="img-circle medium-image" />
                                                    @else
                                                        <img src=" {{ asset('student/avatar.png') }}"
                                                            class="img-circle medium-image" />
                                                    @endif

                                                    <div class="vcentered info-combo">
                                                        <h3 class="no-margin-bottom name"> {{ $item->first_name }}
                                                            {{ $item->last_name }}</h3>
                                                    </div>
                                                    @foreach ($item->room as $item1)
                                                        <div class="contacts-add">
                                                            <span class="message-time"> {{ $item1->classes->name }}</span>
                                                            <small>{{ $item1->name }}</small>
                                                        </div>
                                                    @endforeach
                                                </li>
                                            @endif
                                              @php
                                            $stu[]=$item->id;
                                            @endphp
                                             @endif
                                        @endforeach

                                    </ul>
                                </div>
                            </div>



                        </div>
                    </div>
                      
                 <div class="tab-content  tab-content10">
                      

                    </div>

                                        <div class="col-12">

                                          <div class="position-relative">
                                            <div class="chat-messages p-4 messages-content " id="messages">

                                            </div>
                                          </div>



                                        </div>
                                        <!--my msg-->



                                    </div>
                                    <div class="flex-grow-0 py-3 px-4 border-top">
                                        <div class="input-group">
                                        
                                        
                                         <!-- <textarea type="text" class="message-box form-control message_send"  name="message" placeholder="اكتب رسالتك"> </textarea>-->
                                       
                                        
                                        </div>
                                      </div>

                                </div>


                 

                    </div>
                    <!--tab-content-->
                </div>
            </div>

   
<input type="hidden" name="year_id" id="years" value="{{$year2->id}}" >
@endsection

@section('js')

<script src="{{asset('teachers_2/assets/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{asset('teachers_2/assets/vendors/jquery-bar-rating/jquery.barrating.min.js')}}"></script>
<script src="{{asset('teachers_2/assets/vendors/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('teachers_2/assets/vendors/flot/jquery.flot.js')}}"></script>
<script src="{{asset('teachers_2/assets/vendors/flot/jquery.flot.resize.js')}}"></script>
<script src="{{asset('teachers_2/assets/vendors/flot/jquery.flot.categories.js')}}"></script>
<script src="{{asset('teachers_2/assets/vendors/flot/jquery.flot.fillbetween.js')}}"></script>
<script src="{{asset('teachers_2/assets/vendors/flot/jquery.flot.stack.js')}}"></script>
<!-- End plugin js for this page -->
<script src="{{asset('teachers_2/assets/vendors/select2/select2.min.js')}}"></script>
<script src="{{asset('teachers_2/assets/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>
<script src="{{asset('teachers_2/assets/js/select2.js')}}"></script>
<!-- inject:js -->
<!-- endinject -->
<!-- Custom js for this page -->


<script>


     $(document).on('keypress', 'input', function(event) { 
    if (event.which == 13) {
         message_send=$(this).parent().find(`.message_send`).val();
        student_id=$(this).parent().find(`.student_id`).val();
             var url = "{{ route('send_message_admin_reply') }}";
            $.ajax({
                url: url,
                data: {
                    'message':message_send,
                    'student_id': student_id
                },
                type: "get",
                contentType: 'application/json',
                success: function(data) {
                $(`#std${student_id}`).children().children().find('.chat-body1').append(` <div class="message my-message">
                @if(isset($item1))
                                                @if ($item1->image)
                                                    <img src="{{ asset('storage/' . $item1->image) }}" class="img-circle medium-image" />
                                                @else
                                                    <img src=" {{ asset('teachers_2/icons/teacher.png') }}" class="img-circle medium-image" />
                                                @endif
                                                  @endif
                                                <div class="message-body">
                                                    <div class="message-body-inner">
                                                        <!--div class="message-info">
                                                        <h4> Dennis Novac2 </h4>
                                                        <h5> <i class="fa fa-clock-o"></i> 2:28 PM </h5>
                                                    </div>
                                                    <hr-->
                                                        <div class="message-text">
                                                           ${ message_send}
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                  `);
                   $('.message_send').val('')

                }

            })
 
    }})
$(document).on('click', '.send', function() {

        message_send=$(this).parent().find(`.message_send`).val();
        student_id=$(this).parent().find(`.student_id`).val();
             var url = "{{ route('send_message_admin_reply') }}";
            $.ajax({
                url: url,
                data: {
                    'message':message_send,
                    'student_id': student_id
                },
                type: "get",
                contentType: 'application/json',
                success: function(data) {
                $(`#std${student_id}`).children().children().find('.chat-body1').append(` <div class="message my-message">
                 @if(isset($item1))
                                                @if ($item1->image)
                                                    <img src="{{ asset('storage/' . $item1->image) }}" class="img-circle medium-image" />
                                                @else
                                                    <img src=" {{ asset('teachers_2/icons/teacher.png') }}" class="img-circle medium-image" />
                                                @endif
                                                  @endif
                                                <div class="message-body">
                                                    <div class="message-body-inner">
                                                        <!--div class="message-info">
                                                        <h4> Dennis Novac2 </h4>
                                                        <h5> <i class="fa fa-clock-o"></i> 2:28 PM </h5>
                                                    </div>
                                                    <hr-->
                                                        <div class="message-text">
                                                           ${ message_send}
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                  `);
                   $('.message_send').val('')

                }

            })



    })




      $('#classes_select').change(function () {
            var year_id=$('#years').val();
    var class_id=$(this).val();
    var url = "{{ URL::to('SMT/admin/classes/rooms2_role') }}/" + class_id +"/"+ year_id;
    $('#rooms_classes').empty();
    $('#rooms_student').empty();
 
    $('#rooms_classes').append(`<option style="text-align: end;" value="">جميع الشعب</option>`);
    $.ajax({
        url: url,
        type: "get",
        contentType: 'application/json',
        success: function (data) {
            $.each(data, function (key, value) {
                $('#rooms_classes').append(`<option style="text-align: end;" value="${value.id}">${value.name}</option>`);
            });
        },


    });
               
        })
        
          $("#search").on("click", function(e) {
              
              
            
              var start_date= $('#start_date').val();  
              var end_date= $('#end_date').val();
             $('.list-unstyled').empty();
               $('.list-unstyled').append(`<div class="lds-hourglass"></div>`);
              $('.tab-content10').empty();
               chat=[]
            
            var url = "{{ route('getstudents_contact_date') }}";
            $.ajax({
                url: url,
                data: {
                    'start_date': $('#start_date').val(),
                    'end_date': $('#end_date').val(),
                     'room': $('#rooms_classes').val(),
                     'class': $('#classes_select').val(),
                },
                type: "get",
                contentType: 'application/json',
                success: function(data) {
                    student_array=[];
                    $('.list-unstyled').empty();
                    $.each(data, function(index, value) {
                     
                           if (value.image){
                            image=`<img src="{{ asset('storage/') }}/${value.image}"
                                class="img-circle medium-image" />` }
                           else{
                             image=`<img src=" {{ asset('student/avatar.png') }}"
                               class="img-circle medium-image" />`
                           }


                         if(jQuery.inArray(value.id,student_array) === -1){
                              if (value.message_count > 0) {
                            $('.list-unstyled').prepend(`
                                <li data-toggle="tab" data-target="#std${ value.id }" data-id="${ value.id }" data-image="${ value.image }" class="act_student message1">
                                    <div class="message-count number">${ value.message_admin_count }</div>
                                      ${image}

                                    <div class="vcentered info-combo">
                                        <h3 class="no-margin-bottom name"> ${ value.first_name } ${ value.last_name }</h3>
                                    </div>
                                    <div class="contacts-add">
                                        <span class="message-time"> ${ value.room[0].classes.name }</span>
                                            <small>${ value.room[0].name }</small>
                                    </div>
                                </li>
                            `);
                        } else {
                            $('.list-unstyled').append(`
                                <li data-toggle="tab" data-target="#std${ value.id }" data-id="${ value.id }" data-image="${ value.image }" class="act_student message1 "  >
                                    <div class="message-count number">${ value.message_admin_count }</div>
                                    ${image}

                                    <div class="vcentered info-combo">
                                        <h3 class="no-margin-bottom name"> ${ value.first_name } ${ value.last_name }</h3>
                                    </div>
                                    <div class="contacts-add">
                                        <span class="message-time"> ${ value.room[0].classes.name }</span>
                                            <small>${ value.room[0].name }</small>
                                    </div>
                                </li>

                            `);
                        } 
                           student_array.push(value.id);
                         }
                      
                        
                           
                    });
                     
                }
            })

        })  
      $("#rooms_classes,#classes_select").on("change", function(e) {
           $('#start_date').val('');
           $('#end_date').val('');
            console.log($('#classes_select').val());
             $('.list-unstyled').empty();
               $('.list-unstyled').append(`<div class="lds-hourglass"></div>`);
              $('.tab-content10').empty();
               chat=[]
            
            var url = "{{ route('getstudents_contact') }}";
            $.ajax({
                url: url,
                data: {
                    'class': $('#classes_select').val(),
                    'room': $('#rooms_classes').val()
                },
                type: "get",
                contentType: 'application/json',
                success: function(data) {
                    $('.list-unstyled').empty();
                    $.each(data, function(index, value) {
                           if (value.image){
                            image=`<img src="{{ asset('storage/') }}/${value.image}"
                                class="img-circle medium-image" />` }
                           else{
                             image=`<img src=" {{ asset('student/avatar.png') }}"
                               class="img-circle medium-image" />`
                           }



                        if (value.message_count > 0) {
                            $('.list-unstyled').prepend(`
                                <li data-toggle="tab" data-target="#std${ value.id }" data-id="${ value.id }" data-image="${ value.image }" class="act_student message1">
                                    <div class="message-count number">${ value.message_admin_count }</div>
                                      ${image}

                                    <div class="vcentered info-combo">
                                        <h3 class="no-margin-bottom name"> ${ value.first_name } ${ value.last_name }</h3>
                                    </div>
                                    <div class="contacts-add">
                                        <span class="message-time"> ${ value.room[0].classes.name }</span>
                                            <small>${ value.room[0].name }</small>
                                    </div>
                                </li>
                            `);
                        } else {
                            $('.list-unstyled').append(`
                                <li data-toggle="tab" data-target="#std${ value.id }" data-id="${ value.id }" data-image="${ value.image }" class="act_student message1 "  >
                                    <div class="message-count number">${ value.message_admin_count }</div>
                                    ${image}

                                    <div class="vcentered info-combo">
                                        <h3 class="no-margin-bottom name"> ${ value.first_name } ${ value.last_name }</h3>
                                    </div>
                                    <div class="contacts-add">
                                        <span class="message-time"> ${ value.room[0].classes.name }</span>
                                            <small>${ value.room[0].name }</small>
                                    </div>
                                </li>

                            `);
                        }
                        
                           
                    });
                     
                }
            })

        })  
           
      
         
       $(document).on('click', '.message1', function() {
        var id =$(this).data('id') ;
        var element =$(this) ;
           var image_student =$(this).data('image') ;
            if (image_student){
                            image=`<img src="{{ asset('storage/') }}/${image_student}"
                                class="img-circle medium-image" />` }
                           else{
                             image=`<img src=" {{ asset('student/avatar.png') }}"
                               class="img-circle medium-image" />`
                           }
        $('.tab-content10').empty();
        chat=[];
         var url = "{{ URL::to('SMT/admin/student_message') }}/" +id ;
                  $.ajax({
                      url: url,

                      type: "get",
                      contentType: 'application/json',
                      success: function (data) {
                          console.log(data);
                          element.find('.number').text('0');
                          $('.tab-content10').empty();
                              $.each(data, function(index1, value1) {
                                     var dt = new Date(value1.created_at);
var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
var twoDigitMonth = ((dt.getMonth().length+1) === 1)? (dt.getMonth()+1) : '0' + (dt.getMonth()+1);

var date = dt.getDate() + "/" + twoDigitMonth + "/" + dt.getFullYear();
                                if(value1.type == '1' ){
                                  chat.push(`<div class="message info">
                                                  ${image}
                                                    <div class="message-body">
                                                        <div class="message-info">

                                                    <h5><i class="fa fa-clock-o"></i>   ${ time } - ${ date }  </h5>
                                                </div>
                                                <hr>
                                                        <div class="message-text">
                                                            ${ value1.message }
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>`  )
                                }
                              else if(value1.type == '0'){
                                  chat.push(`
                               
                                            <div class="message my-message">
                                             
                                                    <img src=" {{ asset('teachers_2/icons/teacher.png') }}" class="img-circle medium-image" />
                                          
                                                <div class="message-body">
                                                    <div class="message-body-inner">
                                                        <div class="message-info">

                                                        <h5> <i class="fa fa-clock-o"></i>  ${ time } - ${ date }  </h5>
                                                    </div>
                                                    <hr>
                                                        <div class="message-text">
                                                            ${ value1.message }
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                            </div> ` )
                                }
                                
                            })
                     
                         
                         $('.tab-content10').append(`<div class="tab-pane message-body " id="std${id}" style="">
                                <div class="message-chat">

                                    <div class="chat-body " id="${id}">
                                     <div class="chat-body1">
                                   ${chat}
                                
                                 
                                        <!--end std msg-->

                                        <!--my msg-->

                                        </div>

                                        <div class="col-12">

                                          <div class="position-relative">
                                            <div class="chat-messages p-4 messages-content " id="messages">

                                            </div>
                                          </div>



                                        </div>
                                        <!--my msg-->



                                    </div>
                                    <div class="flex-grow-0 py-3 px-4 border-top">
                                          <div class="input-group">

                                          <input type="hidden" class="student_id" name="student_id" value="${ id }">
                                         <!-- <textarea type="text" class="message-box form-control message_send"  name="message" placeholder="اكتب رسالتك"> </textarea>-->
                                          <input type="text" class="message-box form-control message_send"
                                            name="message" placeholder="اكتب رسالتك">
                                          <button class="btn  send" style="height: auto;
                                            width: fit-content;
                                            background-image: linear-gradient(#152c4f00, #ffffff00), linear-gradient(137.48deg, #a5c9ff 10%,#152C4F 45%, #a5c9ff 67%, #152C4F 87%);
                                            color: white;
                                            border-radius: 0px;">ارسال</button>
                                        </div>
                                      </div>

                                </div>


                            </div>`); 
 $('.message-body').show();
 $(`#std${id}`).addClass("active");
   var contentHeight = document.getElementById(`${id}`).scrollHeight;

  // Get the height of the div
  var divHeight = document.getElementById(`${id}`).clientHeight;

  // Scroll to the bottom of the content inside the div
  document.getElementById(`${id}`).scrollTop = contentHeight - divHeight;
                      }})

  })
        
        
        
$(document).on('click', '.act_student', function() {

$.each($(".act_student"), function(index, value) {
    $(value).removeClass('active')  ;
})
$(this).addClass("active");

var id=$(this).data("id");

$.each($(".message-body"), function(index, value1) {
    $(value1).removeClass('active')  ;

})

$(`#std${id}`).addClass("active");
   var contentHeight = document.getElementById(`${id}`).scrollHeight;

  // Get the height of the div
  var divHeight = document.getElementById(`${id}`).clientHeight;

  // Scroll to the bottom of the content inside the div
  document.getElementById(`${id}`).scrollTop = contentHeight - divHeight;
 
})
 $('.friend-drawer--onhover').on('click', function() {

            $('.chat-bubble').hide('slow').show('slow');

        });
</script>
@endsection


