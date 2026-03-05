@extends('coordinators.master')
@section('css')
<style>
    @import "bourbon";
    @import 'https://fonts.googleapis.com/css?family=Montserrat:400,700|Raleway:300,400';

    .tabs {
        left: 50%;
        transform: translateX(-50%);
        position: relative;
        background: white;
        padding: 20px;
        padding-bottom: 80px;
        width: 99%;
        height: auto;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        border-radius: 5px;
        min-width: 240px;
    }

    .tabs input[name="type"] {
        display: none;
    }

    .tabs .content section h2,
    .tabs ul li label {
        font-family: "Montserrat";
        font-weight: bold;
        font-size: 18px;
        color: #f38639;
    }

    .tabs ul {
        list-style-type: none;
        padding-left: 0;
        display: flex;
        flex-direction: row;
        margin-bottom: 10px;
        /* justify-content: space-between;*/
        align-items: flex-end;
        flex-wrap: wrap;

    }

    .tabs ul li {
        box-sizing: border-box;
        flex: 1;
        width: 25%;
        padding: 0 5px;
        text-align: center;
    }

    .tabs ul li label {
        transition: all 0.3s ease-in-out;
        color: #929daf;
        padding: 5px auto;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        white-space: nowrap;
        -webkit-touch-callout: none;
    }

    .tabs ul li label br {
        display: none;
    }

    .tabs ul li label svg {
        fill: #929daf;
        height: 1.2em;
        vertical-align: bottom;
        margin-right: 0.2em;
        transition: all 0.2s ease-in-out;
    }

    .tabs ul li label:hover,
    .tabs ul li label:focus,
    .tabs ul li label:active {
        outline: 0;
        color: #bec5cf;
    }

    .tabs ul li label:hover svg,
    .tabs ul li label:focus svg,
    .tabs ul li label:active svg {
        fill: #bec5cf;
    }

    .tabs .slider {
        position: relative;
        width: 25%;
        transition: all 0.33s cubic-bezier(0.38, 0.8, 0.32, 1.07);
    }

    .tabs .slider .indicator {
        position: relative;
        width: 50px;
        max-width: 100%;
        margin: 0 auto;
        height: 4px;
        background: #cc151525;
        border-radius: 1px;
    }

    .tabs .content {
        margin-top: 30px;
    }

    .tabs .content section {
        display: none;
        animation-name: content;
        animation-direction: normal;
        animation-duration: 0.3s;
        animation-timing-function: ease-in-out;
        animation-iteration-count: 1;
        line-height: 1.4;
    }

    .tabs .content section h2 {
        color: #f38639;
        display: none;
    }

    .tabs .content section h2::after {
        content: "";
        position: relative;
        display: block;
        width: 30px;
        height: 3px;
        background: #f38639;
        margin-top: 5px;
        left: 1px;
    }

    .tabs input[name="type"]:nth-of-type(1):checked~ul>li:nth-child(1)>label {
        cursor: default;
        color: #f38639;
        font-size: 20px;


    }

    .tabs input[name="type"]:nth-of-type(1):checked~ul>li:nth-child(1)>label svg {
        fill: #f38639;


    }

    @media (max-width: 600px) {
        .tabs input[name="type"]:nth-of-type(1):checked~ul>li:nth-child(1)>label {
            background: rgba(0, 0, 0, 0.08);

        }
    }

    .tabs input[name="type"]:nth-of-type(1):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="type"]:nth-of-type(1):checked~.content>section:nth-child(1) {
        display: block;

    }

    .tabs input[name="type"]:nth-of-type(2):checked~ul>li:nth-child(2)>label {
        cursor: default;
        color: #f38639;
        font-size: 22px;

    }

    /*tab 2*/
    .tabs input[name="type"]:nth-of-type(2):checked~ul>li:nth-child(2)>label svg {
        fill: #f38639;
    }

    @media (max-width: 600px) {
        .tabs input[name="type"]:nth-of-type(2):checked~ul>li:nth-child(2)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="type"]:nth-of-type(2):checked~.slider {
        transform: translateX(100%);
    }

    .tabs input[name="type"]:nth-of-type(2):checked~.content>section:nth-child(2) {
        display: block;
    }

    .tabs input[name="type"]:nth-of-type(3):checked~ul>li:nth-child(3)>label {
        cursor: default;
        color: #f38639;
        font-size: 22px;
    }

    .tabs input[name="type"]:nth-of-type(3):checked~ul>li:nth-child(3)>label svg {
        fill: #f38639;
    }

    @media (max-width: 600px) {
        .tabs input[name="type"]:nth-of-type(3):checked~ul>li:nth-child(3)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="type"]:nth-of-type(3):checked~.slider {
        transform: translateX(200%);
    }

    .tabs input[name="type"]:nth-of-type(3):checked~.content>section:nth-child(3) {
        display: block;
    }

    /*tab 4*/
    .tabs input[name="type"]:nth-of-type(4):checked~ul>li:nth-child(4)>label {
        cursor: default;
        color: #f38639;
        font-size: 22px;
    }

    .tabs input[name="type"]:nth-of-type(4):checked~ul>li:nth-child(4)>label svg {
        fill: #f38639;
    }

    @media (max-width: 600px) {
        .tabs input[name="type"]:nth-of-type(4):checked~ul>li:nth-child(4)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="type"]:nth-of-type(4):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="type"]:nth-of-type(4):checked~.content>section:nth-child(4) {
        display: block;
    }

    .tabs input[name="type"]:nth-of-type(5):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="type"]:nth-of-type(5):checked~.content>section:nth-child(5) {
        display: block;
    }

    /*tab 5*/
    .tabs input[name="type"]:nth-of-type(5):checked~ul>li:nth-child(5)>label {
        cursor: default;
        color: #f38639;
        font-size: 22px;
    }

    .tabs input[name="type"]:nth-of-type(5):checked~ul>li:nth-child(5)>label svg {
        fill: #f38639;
    }

    @media (max-width: 600px) {
        .tabs input[name="type"]:nth-of-type(5):checked~ul>li:nth-child(5)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="type"]:nth-of-type(5):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="type"]:nth-of-type(5):checked~.content>section:nth-child(5) {
        display: block;
    }

    /*tab 6*/
    .tabs input[name="type"]:nth-of-type(6):checked~ul>li:nth-child(6)>label {
        cursor: default;
        color: #f38639;
        font-size: 22px;
    }

    .tabs input[name="type"]:nth-of-type(6):checked~ul>li:nth-child(6)>label svg {
        fill: #f38639;
    }

    @media (max-width: 600px) {
        .tabs input[name="type"]:nth-of-type(6):checked~ul>li:nth-child(6)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="type"]:nth-of-type(6):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="type"]:nth-of-type(6):checked~.content>section:nth-child(6) {
        display: block;
    }

    /*tab 7*/
    .tabs input[name="type"]:nth-of-type(7):checked~ul>li:nth-child(7)>label {
        cursor: default;
        color: #f38639;
        font-size: 22px;
    }

    .tabs input[name="type"]:nth-of-type(7):checked~ul>li:nth-child(7)>label svg {
        fill: #f38639;
    }

    @media (max-width: 600px) {
        .tabs input[name="type"]:nth-of-type(7):checked~ul>li:nth-child(7)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="type"]:nth-of-type(7):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="type"]:nth-of-type(7):checked~.content>section:nth-child(7) {
        display: block;
    }

    /*tab 8*/
    .tabs input[name="type"]:nth-of-type(8):checked~ul>li:nth-child(8)>label {
        cursor: default;
        color: #f38639;
        font-size: 22px;
    }

    .tabs input[name="type"]:nth-of-type(8):checked~ul>li:nth-child(8)>label svg {
        fill: #f38639;
    }

    @media (max-width: 600px) {
        .tabs input[name="type"]:nth-of-type(8):checked~ul>li:nth-child(8)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="type"]:nth-of-type(8):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="type"]:nth-of-type(8):checked~.content>section:nth-child(8) {
        display: block;
    }

    /*tab 9*/
    .tabs input[name="type"]:nth-of-type(9):checked~ul>li:nth-child(9)>label {
        cursor: default;
        color: #428bff;
    }

    .tabs input[name="type"]:nth-of-type(9):checked~ul>li:nth-child(9)>label svg {
        fill: #428bff;
    }

    @media (max-width: 600px) {
        .tabs input[name="type"]:nth-of-type(9):checked~ul>li:nth-child(9)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="type"]:nth-of-type(9):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="type"]:nth-of-type(9):checked~.content>section:nth-child(9) {
        display: block;
    }

    /*tab 10*/
    .tabs input[name="type"]:nth-of-type(10):checked~ul>li:nth-child(10)>label {
        cursor: default;
        color: #428bff;
    }

    .tabs input[name="type"]:nth-of-type(10):checked~ul>li:nth-child(10)>label svg {
        fill: #428bff;
    }

    @media (max-width: 600px) {
        .tabs input[name="type"]:nth-of-type(10):checked~ul>li:nth-child(10)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="type"]:nth-of-type(10):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="type"]:nth-of-type(10):checked~.content>section:nth-child(10) {
        display: block;
    }

    /*tab 11*/
    .tabs input[name="type"]:nth-of-type(11):checked~ul>li:nth-child(11)>label {
        cursor: default;
        color: #428bff;
    }

    .tabs input[name="type"]:nth-of-type(11):checked~ul>li:nth-child(11)>label svg {
        fill: #428bff;
    }

    @media (max-width: 600px) {
        .tabs input[name="type"]:nth-of-type(11):checked~ul>li:nth-child(11)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="type"]:nth-of-type(11):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="type"]:nth-of-type(11):checked~.content>section:nth-child(11) {
        display: block;
    }

    /*tab 12*/
    .tabs input[name="type"]:nth-of-type(12):checked~ul>li:nth-child(12)>label {
        cursor: default;
        color: #428bff;
    }

    .tabs input[name="type"]:nth-of-type(12):checked~ul>li:nth-child(12)>label svg {
        fill: #428bff;
    }

    @media (max-width: 600px) {
        .tabs input[name="type"]:nth-of-type(12):checked~ul>li:nth-child(12)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="type"]:nth-of-type(12):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="type"]:nth-of-type(12):checked~.content>section:nth-child(12) {
        display: block;
    }

    @keyframes content {
        from {
            opacity: 0;
            transform: translateY(5%);
        }

        to {
            opacity: 1;
            transform: translateY(0%);
        }
    }

    @media (max-width: 1000px) {
        .tabs ul li label {
            white-space: initial;
        }

        .tabs ul li label br {
            display: initial;
        }

        .tabs ul li label svg {
            height: 1.5em;
        }
    }

    @media (max-width: 600px) {
        .tabs ul li label {
            padding: 5px;
            border-radius: 5px;
        }

        .tabs ul li label span {
            display: none;
        }

        .tabs .slider {
            display: none;
        }

        .tabs .content {
            margin-top: 20px;
        }

        .tabs .content section h2 {
            display: block;
        }
    }

    /*end section add content */

    /* upload input */
    .panel {
        max-width: 500px;
        text-align: center;
        font-size: large;
    }

    .button_outer {
        background: #4972a8;
        border-radius: 30px;
        text-align: center;
        height: 50px;
        width: 200px;
        display: inline-block;
        transition: .2s;
        position: relative;
        overflow: hidden;
    }

    .btn_upload {
        padding: 17px 30px 12px;
        color: #fff;
        text-align: center;
        position: relative;
        display: inline-block;
        overflow: hidden;
        z-index: 3;
        white-space: nowrap;
    }

    .btn_upload input {
        position: absolute;
        width: 100%;
        left: 0;
        top: 0;
        width: 100%;
        height: 105%;
        cursor: pointer;
        opacity: 0;
    }

    .file_uploading {
        width: 100%;
        height: 10px;
        margin-top: 20px;
        background: #ccc;
    }

    .file_uploading .btn_upload {
        display: none;
    }

    .processing_bar {
        position: absolute;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        border-radius: 30px;
        background: #f38639;
        transition: 3s;
    }

    .file_uploading .processing_bar {
        width: 100%;
    }

    .success_box {
        display: none;
        width: 50px;
        height: 50px;
        position: relative;
    }

    .success_box:before {
        content: '';
        display: block;
        width: 9px;
        height: 18px;
        border-bottom: 6px solid #fff;
        border-right: 6px solid #fff;
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
        position: absolute;
        left: 17px;
        top: 10px;
    }

    .file_uploaded .success_box {
        display: inline-block;
    }

    .file_uploaded {
        margin-top: 0;
        width: 50px;
        background: #3a3b7c;
        height: 50px;
    }

    .uploaded_file_view {
        max-width: 300px;
        margin: 40px auto;
        text-align: center;
        position: relative;
        transition: .2s;
        opacity: 0;
        border: 2px solid #ddd;
        padding: 15px;
    }

    .file_remove {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: block;
        position: absolute;
        background: #aaa;
        line-height: 30px;
        color: #fff;
        font-size: 12px;
        cursor: pointer;
        right: -15px;
        top: -15px;
    }

    .file_remove:hover {
        background: #222;
        transition: .2s;
    }

    .uploaded_file_view img {
        max-width: 100%;
    }

    .uploaded_file_view.show {
        opacity: 1;
    }

    .error_msg {
        text-align: center;
        color: #f00
    }


    .panel2 {
        max-width: 500px;
        text-align: center;
        font-size: large;
    }

    .button_outer2 {
        background: #4972a8;
        border-radius: 30px;
        text-align: center;
        height: 50px;
        width: 200px;
        display: inline-block;
        transition: .2s;
        position: relative;
        overflow: hidden;
    }

    .btn_upload2 {
        padding: 17px 30px 12px;
        color: #fff;
        text-align: center;
        position: relative;
        display: inline-block;
        overflow: hidden;
        z-index: 3;
        white-space: nowrap;
    }

    .btn_upload2 input {
        position: absolute;
        width: 100%;
        left: 0;
        top: 0;
        width: 100%;
        height: 105%;
        cursor: pointer;
        opacity: 0;
    }

    .file_uploading2 {
        width: 100%;
        height: 10px;
        margin-top: 20px;
        background: #ccc;
    }

    .file_uploading2 .btn_upload2 {
        display: none;
    }

    .processing_bar2 {
        position: absolute;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        border-radius: 30px;
        background: #f38639;
        transition: 3s;
    }

    .file_uploading2 .processing_bar2 {
        width: 100%;
    }

    .success_box2 {
        display: none;
        width: 50px;
        height: 50px;
        position: relative;
    }

    .success_box2:before {
        content: '';
        display: block;
        width: 9px;
        height: 18px;
        border-bottom: 6px solid #fff;
        border-right: 6px solid #fff;
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
        position: absolute;
        left: 17px;
        top: 10px;
    }

    .file_uploaded2 .success_box2 {
        display: inline-block;
    }

    .file_uploaded2 {
        margin-top: 0;
        width: 50px;
        background: #3a3b7c;
        height: 50px;
    }

    .uploaded_file_view2 {
        max-width: 300px;
        margin: 40px auto;
        text-align: center;
        position: relative;
        transition: .2s;
        opacity: 0;
        border: 2px solid #ddd;
        padding: 15px;
    }

    .file_remove2 {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: block;
        position: absolute;
        background: #aaa;
        line-height: 30px;
        color: #fff;
        font-size: 12px;
        cursor: pointer;
        right: -15px;
        top: -15px;
    }

    .file_remove2:hover {
        background: #222;
        transition: .2s;
    }

    .uploaded_file_view2 img {
        max-width: 100%;
    }

    .uploaded_file_view2.show {
        opacity: 1;
    }

    .error_msg {
        text-align: center;
        color: #f00
    }


    .panel3 {
        max-width: 500px;
        text-align: center;
        font-size: large
    }

    .button_outer3 {
        background: #4972a8;
        border-radius: 30px;
        text-align: center;
        height: 50px;
        width: 200px;
        display: inline-block;
        transition: .2s;
        position: relative;
        overflow: hidden;
    }

    .btn_upload3 {
        padding: 17px 30px 12px;
        color: #fff;
        text-align: center;
        position: relative;
        display: inline-block;
        overflow: hidden;
        z-index: 3;
        white-space: nowrap;
    }

    .btn_upload3 input {
        position: absolute;
        width: 100%;
        left: 0;
        top: 0;
        width: 100%;
        height: 105%;
        cursor: pointer;
        opacity: 0;
    }

    .file_uploading3 {
        width: 100%;
        height: 10px;
        margin-top: 20px;
        background: #ccc;
    }

    .file_uploading3 .btn_upload3 {
        display: none;
    }

    .processing_bar3 {
        position: absolute;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        border-radius: 30px;
        background: #f38639;
        transition: 3s;
    }

    .file_uploading3 .processing_bar3 {
        width: 100%;
    }

    .success_box3 {
        display: none;
        width: 50px;
        height: 50px;
        position: relative;
    }

    .success_box3:before {
        content: '';
        display: block;
        width: 9px;
        height: 18px;
        border-bottom: 6px solid #fff;
        border-right: 6px solid #fff;
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
        position: absolute;
        left: 17px;
        top: 10px;
    }

    .file_uploaded3 .success_box3 {
        display: inline-block;
    }

    .file_uploaded3 {
        margin-top: 0;
        width: 50px;
        background: #3a3b7c;
        height: 50px;
    }

    .uploaded_file_view3 {
        max-width: 300px;
        margin: 40px auto;
        text-align: center;
        position: relative;
        transition: .2s;
        opacity: 0;
        border: 2px solid #ddd;
        padding: 15px;
    }

    .file_remove3 {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: block;
        position: absolute;
        background: #aaa;
        line-height: 30px;
        color: #fff;
        font-size: 12px;
        cursor: pointer;
        right: -15px;
        top: -15px;
    }

    .file_remove3:hover {
        background: #222;
        transition: .2s;
    }

    .uploaded_file_view3 img {
        max-width: 100%;
    }

    .uploaded_file_view3.show {
        opacity: 1;
    }

    .error_msg {
        text-align: center;
        color: #f00
    }

    .panel4 {
        max-width: 500px;
        text-align: center;
        font-size: large
    }

    .button_outer4 {
        background: #4972a8;
        border-radius: 30px;
        text-align: center;
        height: 50px;
        width: 200px;
        display: inline-block;
        transition: .2s;
        position: relative;
        overflow: hidden;
    }

    .btn_upload4 {
        padding: 17px 30px 12px;
        color: #fff;
        text-align: center;
        position: relative;
        display: inline-block;
        overflow: hidden;
        z-index: 3;
        white-space: nowrap;
    }

    .btn_upload4 input {
        position: absolute;
        width: 100%;
        left: 0;
        top: 0;
        width: 100%;
        height: 105%;
        cursor: pointer;
        opacity: 0;
    }

    .file_uploading4 {
        width: 100%;
        height: 10px;
        margin-top: 20px;
        background: #ccc;
    }

    .file_uploading4 .btn_upload4 {
        display: none;
    }

    .processing_bar4 {
        position: absolute;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        border-radius: 30px;
        background: #f38639;
        transition: 3s;
    }

    .file_uploading4 .processing_bar4 {
        width: 100%;
    }

    .success_box4 {
        display: none;
        width: 50px;
        height: 50px;
        position: relative;
    }

    .success_box4:before {
        content: '';
        display: block;
        width: 9px;
        height: 18px;
        border-bottom: 6px solid #fff;
        border-right: 6px solid #fff;
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
        position: absolute;
        left: 17px;
        top: 10px;
    }

    .file_uploaded4 .success_box4 {
        display: inline-block;
    }

    .file_uploaded4 {
        margin-top: 0;
        width: 50px;
        background: #3a3b7c;
        height: 50px;
    }

    .uploaded_file_view4 {
        max-width: 300px;
        margin: 40px auto;
        text-align: center;
        position: relative;
        transition: .2s;
        opacity: 0;
        border: 2px solid #ddd;
        padding: 15px;
    }

    .file_remove4 {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: block;
        position: absolute;
        background: #aaa;
        line-height: 30px;
        color: #fff;
        font-size: 12px;
        cursor: pointer;
        right: -15px;
        top: -15px;
    }

    .file_remove4:hover {
        background: #222;
        transition: .2s;
    }

    .uploaded_file_view4 img {
        max-width: 100%;
    }

    .uploaded_file_view4.show {
        opacity: 1;
    }

    .error_msg {
        text-align: center;
        color: #f00
    }

    .panel5 {
        max-width: 500px;
        text-align: center;
        font-size: large;
    }

    .button_outer5 {
        background: #4972a8;
        border-radius: 30px;
        text-align: center;
        height: 50px;
        width: 200px;
        display: inline-block;
        transition: .2s;
        position: relative;
        overflow: hidden;
    }

    .btn_upload5 {
        padding: 17px 30px 12px;
        color: #fff;
        text-align: center;
        position: relative;
        display: inline-block;
        overflow: hidden;
        z-index: 3;
        white-space: nowrap;
    }

    .btn_upload5 input {
        position: absolute;
        width: 100%;
        left: 0;
        top: 0;
        width: 100%;
        height: 105%;
        cursor: pointer;
        opacity: 0;
    }

    .file_uploading5 {
        width: 100%;
        height: 10px;
        margin-top: 20px;
        background: #ccc;
    }

    .file_uploading5 .btn_upload5 {
        display: none;
    }

    .processing_bar5 {
        position: absolute;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        border-radius: 30px;
        background: #f38639;
        transition: 3s;
    }

    .file_uploading5 .processing_bar5 {
        width: 100%;
    }

    .success_box5 {
        display: none;
        width: 50px;
        height: 50px;
        position: relative;
    }

    .success_box5:before {
        content: '';
        display: block;
        width: 9px;
        height: 18px;
        border-bottom: 6px solid #fff;
        border-right: 6px solid #fff;
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
        position: absolute;
        left: 17px;
        top: 10px;
    }

    .file_uploaded5 .success_box5 {
        display: inline-block;
    }

    .file_uploaded5 {
        margin-top: 0;
        width: 50px;
        background: #3a3b7c;
        height: 50px;
    }

    .uploaded_file_view5 {
        max-width: 300px;
        margin: 40px auto;
        text-align: center;
        position: relative;
        transition: .2s;
        opacity: 0;
        border: 2px solid #ddd;
        padding: 15px;
    }

    .file_remove5 {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: block;
        position: absolute;
        background: #aaa;
        line-height: 30px;
        color: #fff;
        font-size: 12px;
        cursor: pointer;
        right: -15px;
        top: -15px;
    }

    .file_remove5:hover {
        background: #222;
        transition: .2s;
    }

    .uploaded_file_view5 img {
        max-width: 100%;
    }

    .uploaded_file_view5.show {
        opacity: 1;
    }

    .error_msg {
        text-align: center;
        color: #f00
    }

    .panel6 {
        max-width: 500px;
        text-align: center;
        font-size: large;
    }

    .button_outer6 {
        background: #4972a8;
        border-radius: 30px;
        text-align: center;
        height: 50px;
        width: 200px;
        display: inline-block;
        transition: .2s;
        position: relative;
        overflow: hidden;
    }

    .btn_upload6 {
        padding: 17px 30px 12px;
        color: #fff;
        text-align: center;
        position: relative;
        display: inline-block;
        overflow: hidden;
        z-index: 3;
        white-space: nowrap;
    }

    .btn_upload6 input {
        position: absolute;
        width: 100%;
        left: 0;
        top: 0;
        width: 100%;
        height: 105%;
        cursor: pointer;
        opacity: 0;
    }

    .file_uploading6 {
        width: 100%;
        height: 10px;
        margin-top: 20px;
        background: #ccc;
    }

    .file_uploading6 .btn_upload6 {
        display: none;
    }

    .processing_bar6 {
        position: absolute;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        border-radius: 30px;
        background: #f38639;
        transition: 3s;
    }

    .file_uploading6 .processing_bar6 {
        width: 100%;
    }

    .success_box6 {
        display: none;
        width: 50px;
        height: 50px;
        position: relative;
    }

    .success_box6:before {
        content: '';
        display: block;
        width: 9px;
        height: 18px;
        border-bottom: 6px solid #fff;
        border-right: 6px solid #fff;
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
        position: absolute;
        left: 17px;
        top: 10px;
    }

    .file_uploaded6 .success_box6 {
        display: inline-block;
    }

    .file_uploaded6 {
        margin-top: 0;
        width: 50px;
        background: #3a3b7c;
        height: 50px;
    }

    .uploaded_file_view6 {
        max-width: 300px;
        margin: 40px auto;
        text-align: center;
        position: relative;
        transition: .2s;
        opacity: 0;
        border: 2px solid #ddd;
        padding: 15px;
    }

    .file_remove6 {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: block;
        position: absolute;
        background: #aaa;
        line-height: 30px;
        color: #fff;
        font-size: 12px;
        cursor: pointer;
        right: -15px;
        top: -15px;
    }

    .file_remove6:hover {
        background: #222;
        transition: .2s;
    }

    .uploaded_file_view6 img {
        max-width: 100%;
    }

    .uploaded_file_view6.show {
        opacity: 1;
    }

    .error_msg {
        text-align: center;
        color: #f00
    }

    .panel7 {
        max-width: 500px;
        text-align: center;
        font-size: large;
    }

    .button_outer7 {
        background: #4972a8;
        border-radius: 30px;
        text-align: center;
        height: 50px;
        width: 200px;
        display: inline-block;
        transition: .2s;
        position: relative;
        overflow: hidden;
    }

    .btn_upload7 {
        padding: 17px 30px 12px;
        color: #fff;
        text-align: center;
        position: relative;
        display: inline-block;
        overflow: hidden;
        z-index: 3;
        white-space: nowrap;
    }

    .btn_upload7 input {
        position: absolute;
        width: 100%;
        left: 0;
        top: 0;
        width: 100%;
        height: 105%;
        cursor: pointer;
        opacity: 0;
    }

    .file_uploading7 {
        width: 100%;
        height: 10px;
        margin-top: 20px;
        background: #ccc;
    }

    .file_uploading7 .btn_upload7 {
        display: none;
    }

    .processing_bar7 {
        position: absolute;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        border-radius: 30px;
        background: #f38639;
        transition: 3s;
    }

    .file_uploading7 .processing_bar6 {
        width: 100%;
    }

    .success_box7 {
        display: none;
        width: 50px;
        height: 50px;
        position: relative;
    }

    .success_box7:before {
        content: '';
        display: block;
        width: 9px;
        height: 18px;
        border-bottom: 6px solid #fff;
        border-right: 6px solid #fff;
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
        position: absolute;
        left: 17px;
        top: 10px;
    }

    .file_uploaded7 .success_box6 {
        display: inline-block;
    }

    .file_uploaded7 {
        margin-top: 0;
        width: 50px;
        background: #3a3b7c;
        height: 50px;
    }

    .uploaded_file_view7 {
        max-width: 300px;
        margin: 40px auto;
        text-align: center;
        position: relative;
        transition: .2s;
        opacity: 0;
        border: 2px solid #ddd;
        padding: 15px;
    }

    .file_remove7 {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: block;
        position: absolute;
        background: #aaa;
        line-height: 30px;
        color: #fff;
        font-size: 12px;
        cursor: pointer;
        right: -15px;
        top: -15px;
    }

    .file_remove7:hover {
        background: #222;
        transition: .2s;
    }

    .uploaded_file_view7 img {
        max-width: 100%;
    }

    .uploaded_file_view7.show {
        opacity: 1;
    }

    .error_msg {
        text-align: center;
        color: #f00
    }


    /*edit name */

    .launch {
        height: 50px;
        margin-left: 180px;
        text-align: center;
        width: 170px;
    }

    .close {
        font-size: 21px;
        cursor: pointer
    }

    .modal-body {
        height: 250px
    }

    .nav-tabs {
        border: none !important
    }

    .nav-tabs .nav-link.active {
        color: #495057;
        background-color: #fff;
        border-color: #ffffff #ffffff #fff;
        border-top: 3px solid rgb(224, 117, 224) !important
    }

    .nav-tabs .nav-link {
        margin-bottom: -1px;
        border: 1px solid transparent;
        border-top-left-radius: 0rem;
        border-top-right-radius: 0rem;
        border-top: 3px solid #eee;
        font-size: 20px
    }

    .nav-tabs .nav-link:hover {
        border-color: #e9ecef #ffffff #ffffff
    }

    .nav-tabs {
        display: table !important;
        width: 100%
    }

    .nav-item {
        display: table-cell
    }

    .form-control {
        border-bottom: 1px solid #eee !important;
        border: none;
        font-weight: 600;
    }

    .form-control:focus {
        color: #495057;
        background-color: #fff;
        border-color: #8bbafe;
        outline: 0;
        box-shadow: none
    }

    .inputbox {
        position: relative;
        margin-bottom: 20px;
        width: 100%
    }

    .inputbox span {
        position: absolute;
        top: 7px;
        left: 11px;
        transition: 0.5s
    }

    .inputbox i {
        position: absolute;
        top: 13px;
        right: 8px;
        /*transition: 0.5s;color: #3F51B5*/
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0
    }

    .inputbox input:focus~span {
        transform: translateX(-0px) translateY(-15px);
        font-size: 12px
    }

    .inputbox input:valid~span {
        transform: translateX(-0px) translateY(-15px);
        font-size: 12px
    }

    .pay button {
        height: 47px;
        border-radius: 37px
    }

    /*end edit name */
    input[type="datetime-local"] {
        background-color: rgb(214, 214, 231);
        outline: none;
    }

    input[type="datetime-local"]::-webkit-clear-button {
        font-size: 18px;
        height: 30px;
        position: relative;


    }

    input[type="datetime-local"]::-webkit-inner-spin-button {
        height: 28px;

    }

    input[type="datetime-local"]::-webkit-calendar-picker-indicator {
        font-size: 15px;

    }

    html:focus-within {
        scroll-behavior: inherit;



    }

    /*cards*/

    .data-card {
        display: flex;
        flex-direction: column;
        max-width: 20.75em;
        min-height: auto;
        overflow: hidden;
        border-radius: 0.5em;
        text-decoration: none;
        background: white;
        margin: 1em;
        padding: 2.75em 2.5em;
        box-shadow: 0 1.8em 2.7em -0.7em rgba(0, 0, 0, 0.3);
        transition: transform 0.45s ease, background 0.45s ease;
    }

    .data-card h3 {
        color: #2E3C40;
        font-size: 3.5em;
        font-weight: 600;
        line-height: 1;
        padding-bottom: 0.5em;
        margin: 0 0 0.142857143em;
        border-bottom: 2px solid #753BBD;
        transition: color 0.45s ease, border 0.45s ease;
    }

    .data-card h4 {
        color: #627084;
        text-transform: uppercase;
        font-size: 1.125em;
        font-weight: 700;
        line-height: 1;
        letter-spacing: 0.1em;
        margin: 0 0 1.777777778em;
        transition: color 0.45s ease;
    }

    .data-card p {
        opacity: 0;
        color: #FFFFFF;
        font-weight: 600;
        line-height: 1.8;
        margin: 0 0 1.25em;
        transform: translateY(-1em);
        transition: opacity 0.45s ease, transform 0.5s ease;
    }

    .data-card .link-text {
        display: block;
        color: #753BBD;
        font-size: 1.125em;
        font-weight: 600;
        line-height: 1.2;
        margin: auto 0 0;
        transition: color 0.45s ease;
    }

    .data-card .link-text svg {
        margin-left: 0.5em;
        transition: transform 0.6s ease;
    }

    .data-card .link-text svg path {
        transition: fill 0.45s ease;
    }

    .data-card:hover {
        background: #FFFFFF;
        transform: scale(1.02);
    }

    .data-card:hover h3 {
        color: #FFFFFF;
        border-bottom-color: #A754C4;
    }

    .data-card:hover h4 {
        color: #FFFFFF;
    }

    .data-card:hover p {
        opacity: 1;
        transform: none;
    }

    .data-card:hover .link-text {
        color: #FFFFFF;
    }

    .data-card:hover .link-text svg {
        animation: point 1.25s infinite alternate;
    }

    .data-card:hover .link-text svg path {
        fill: #FFFFFF;
    }

    @keyframes point {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(0.125em);
        }
    }


    /*end cards*/
    /*select and option */
    :root {
        --background-gradient: linear-gradient(30deg, #4986fc 30%, #4986fc);
        --gray: #4972a8;
        --darkgray: #4972a8;
    }

    select {
        /* Reset Select */
        appearance: none;
        outline: 0;
        border: 0;
        box-shadow: none;
        /* Personalize */
        flex: 1;
        padding: 0 1em;
        color: white;
        background-color: var(--darkgray);
        background-image: none;
        cursor: pointer;
        text-align: center;


    }

    /* Remove IE arrow */
    select::-ms-expand {
        display: none;
    }

    /* Custom Select wrapper */
    .select {
        position: relative;
        display: flex;
        width: 15em;
        height: 3em;
        border-radius: .25em;
        overflow: hidden;
        color: #4972a8;



    }

    /* Arrow */
    .select::after {
        content: '\25BC';
        position: absolute;
        top: 0;
        right: 0;
        padding: 1em;
        background-color: #4972a8;
        transition: .25s all ease;
        pointer-events: none;


    }

    /* Transition */
    .select:hover::after {
        color: white;



    }

    /* Other styles*/


    /*end select */
    .tab1cards {
        display: flex;
        flex-direction: row;
        justify-content: center;
    }
</style>
@endsection
@section('content')

<!-- END nav -->


<section class="hero-wrap hero-wrap-2" style="background-image:url( {{  asset('teachers/ppp.jpg') }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2">
                        <!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
                        <h1 class="mb-0 bread">اضافة مذاكرة </h1>
            </div>
        </div>
    </div>
</section>
@if (session()->has('success'))
<script>
    window.onload = function () {
        notif({
            msg: "تمت   اضافة المذاكرة بنجاح ",
            type: "success"
        })
    }
</script>
@endif
@if (session()->has('error'))
<script>
    window.onload = function () {
        notif({
            msg: " يرجى تعديل الوقت  ",
            type: "error"
        })
    }
</script>
@endif
 <nav class="breadcrumbs">
    
         <a  class="breadcrumbs__item is-active">اضافة المذاكرات </a>
    <a  href=" {{ route('coordinator_lesson',[$class_id->id,$lesson_id->id]) }}" class="breadcrumbs__item ">{{ $lesson_id->name }} </a>
   
    <a  href="{{ route('dashboard.coordinator_subject',$class_id->id ) }}" class="breadcrumbs__item ">{{ $class_id->name }}   </a>
     <a   href="{{ route('dashboard.coordinator') }}" class="breadcrumbs__item ">الواجهة الرئيسية 
</a>
</nav>
<!-- start new-->
<!-- start section of content lesson -->

<section class="ftco-section bg-light">
    <div class="container">
        <a href="{{ route('coordinator_table_quize',[$class_id->id ,$lesson_id->id]) }}" class="btn btn-primary"  type="button"  style="margin-top: 30px;">
            المذاكرات  &nbsp;  </a>
        {{-- <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading"></span>
                <h2 class="mb-4" style="color:#f38639;">اضافة محتوى </h2>
            </div>
        </div> --}}
        <!-- start add content -->


        <form action="{{ route('dashboard.store_items1') }}" method="post" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="lesson_id" value="{{ $lesson_id->id }}">

            <input type="hidden" name="class_id" value="{{ $class_id->id }}">





            <div class="tabs" id="class">


                <input type="radio" value="2" id="tab1" name="type" checked>

                <ul>




                    <li title="اضافة مذاكرة "><label for="tab1" role="button"><svg viewBox="0 0 24 24">
                                <path
                                    d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                            </svg>
                            <span>اضافة مذاكرة </span><br></label></li></label></li>




                </ul>


                <div class="">
                    <div class="indicator"></div>
                </div>

                <div class="content" style="text-align: right;">
                    @if(session()->has('message'))
<div class="alert alert-danger">
    {{ session()->get('message') }}
</div>
@endif
                    <!-- start homework section-->

                    <!-- end homework section-->
                    <!-- start video section-->




                    <!-- end video section-->

                    <!-- start audio section-->

                    <!-- end  audio  section-->

                    <!-- start quize  section-->

                    <section style="text-align:right; direction:rtl">
                        <h2>اضافة مذاكرة </h2>
                        <!-- start cards-->
                        <div class="row" style="justify-content: center;">
                            <div class="data-card">
                                <div class="text pl-3">
                                    <h5 style="color: #094e89;"> الفصل </h5>
                                    <div class="select">
                                        <select name="term_id">
                                            <option value="{{ $term->id }}">{{ $term->term }}</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="data-card">
                                <div class="text pl-3">
                                    <h5 style="color: #094e89;"> الشعب </h5>

                                        @foreach ($class_id->room as $item )

                                        <input type="checkbox" name="room_id[]"  id="roo{{ $item->id }}"  value="{{ $item->id }}">
                                        <label for="roo{{ $item->id }}">{{ $item->name }}</label>
                                        <br>
                                        @endforeach



                                </div>
                            </div>

                            <div class="data-card">

                                <h5 style="color: #094e89;">اضف اسم المذاكرة </h5>
                                <br>

                                <input name="name_quize" placeholder="ادخل اسم المذاكرة "
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter video name'"
                                    class="common-input mb-20 form-control" type="text">


                            </div>
                        </div>
                        <div class="row" style="justify-content: center;">

                            <div class="data-card">

                                <h5 style="color: #094e89;">اضف بداية الوقت </h5>
                                <br>
                                <input name="quize_start_time" placeholder="ادخل بداية الوقت "
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter start quize time'"
                                    class="common-input mb-20 form-control" type="datetime-local">
                            </div>
                            <div class="data-card">

                                <h5 style="color: #094e89;">اضف نهاية الوقت </h5>
                                <br>
                                <input name="quize_end_time" placeholder="ادخل نهاية الوقت "
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter start quize time'"
                                    class="common-input mb-20 form-control" type="datetime-local">
                            </div>
                        </div>

                        <div class="row" style="justify-content: center;">
                            <div class="data-card">

                                <h5>اضف رابط خارجي </h5>
                                <br>

                                <input name="quize_link" placeholder="ادخل رابط خارجي " onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Enter  name'"
                                    class="common-input mb-20 form-control" type="text">


                            </div>


                            <div class="data-card">

                                <h5 style="color: #094e89;">تحميل ملف </h5>
                                <br>
                                <!-- start upload -->
                                <div>
                                    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                                    <div>
                                        <main class="main_full">
                                            <div class="container">
                                                <div class="panel5">
                                                    <div class="button_outer5">
                                                        <div class="btn_upload5">
                                                            <input type="file" id="upload_file5" name="quize"
                                                                accept="file_extension/*">
                                                            تحميل ملف
                                                        </div>
                                                        <div class="processing_bar5"></div>
                                                        <div class="success_box5"></div>
                                                    </div>
                                                </div>
                                                <div class="error_msg5"></div>
                                                <div class="uploaded_file_view5" id="uploaded_view5">
                                                    <span class="file_remove5">X</span>
                                                </div>
                                            </div>
                                        </main>
                                    </div>
                                </div>

                                <!--- end upload -->
                            </div>
                            <div class="data-card">
                                <h5 style="color: #094e89;">اضافة اختبار </h5>
                                <br>
                                <br>
                                <a class="btn btn-primary btn-circle"
                                href="{{ route('coordinator_add_auto',[$class_id->id ,$lesson_id->id]) }}">
                                         اضافة محتوى مؤتمت
                                </a>
                            </div>
                        </div>
                        <!-- end cards-->

                        <br>
                        <div class="tab1cards">

                            <button class="btn btn-primary " type="submit"
                                style="width: 150px;font-size: 20px;">حفظ</button>

                        </div>


                    </section>
                    <!-- end  quize  section-->
                    <!-- start exam section-->



                    <!-- end  exam section-->

                    <!-- start file section-->




                    <!-- end  exam section-->


                </div>
            </div>
        </form>

        <!-- end add content -->

    </div>
</section>

<!-- end section  of content lesson-->


<br>
<br>
<br>
<br>

<div id="ftco-loader" class="show fullscreen">
    <svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
            stroke="#F96D00" />
    </svg>
</div>


@endsection
@section('js')
<script>
    var btnUpload = $("#upload_file"),
        btnOuter = $(".button_outer");
    btnUpload.on("change", function (e) {
        var ext = btnUpload.val().split('.').pop().toLowerCase();
        if (false) {
            $(".error_msg").text("Not an Video...");
        } else {
            $(".error_msg").text("");
            btnOuter.addClass("file_uploading");
            setTimeout(function () {
                btnOuter.addClass("file_uploaded");
            }, 3000);
            var uploadedFile = URL.createObjectURL(e.target.files[0]);
            setTimeout(function () {
                $("#uploaded_view").append('<img src="' + uploadedFile + '" />').addClass("show");
            }, 3500);
        }
    });
    $(".file_remove").on("click", function (e) {
        $("#uploaded_view").removeClass("show");
        $("#uploaded_view").find("img").remove();
        btnOuter.removeClass("file_uploading");
        btnOuter.removeClass("file_uploaded");
    });
    /* two upload*/
    var btnUpload2 = $("#upload_file2"),
        btnOuter2 = $(".button_outer2");
    btnUpload2.on("change", function (e) {
        var ext = btnUpload2.val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['mp3']) == -1) {
            $(".error_msg2").text("Not an audio...");
        } else {
            $(".error_msg2").text("");
            btnOuter2.addClass("file_uploading2");
            setTimeout(function () {
                btnOuter2.addClass("file_uploaded2");
            }, 3000);
            var uploadedFile2 = URL.createObjectURL(e.target.files[0]);
            setTimeout(function () {
                $("#uploaded_view2").append('<img src="' + uploadedFile2 + '" />').addClass("show");
            }, 3500);
        }
    });
    $(".file_remove2").on("click", function (e) {
        $("#uploaded_view2").removeClass("show");
        $("#uploaded_view2").find("img").remove();
        btnOuter2.removeClass("file_uploading2");
        btnOuter2.removeClass("file_uploaded2");
    });
    /* three upload*/
    var btnUpload3 = $("#upload_file3"),
        btnOuter3 = $(".button_outer3");
    btnUpload3.on("change", function (e) {
        var ext = btnUpload3.val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['pdf', 'xlsx', 'text']) == -1) {
            $(".error_msg3").text("Not an file...");
        } else {
            $(".error_msg3").text("");
            btnOuter3.addClass("file_uploading3");
            setTimeout(function () {
                btnOuter3.addClass("file_uploaded3");
            }, 3000);
            var uploadedFile3 = URL.createObjectURL(e.target.files[0]);
            setTimeout(function () {
                $("#uploaded_view3").append('<img src="' + uploadedFile3 + '" />').addClass("show");
            }, 3500);
        }
    });
    $(".file_remove3").on("click", function (e) {
        $("#uploaded_view3").removeClass("show");
        $("#uploaded_view3").find("img").remove();
        btnOuter3.removeClass("file_uploading3");
        btnOuter3.removeClass("file_uploaded3");
    });
    /* four upload*/
    var btnUpload4 = $("#upload_file4"),
        btnOuter4 = $(".button_outer4");
    btnUpload4.on("change", function (e) {
        var ext = btnUpload4.val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['pdf', 'xlsx', 'text']) == -1) {
            $(".error_msg4").text("Not an file...");
        } else {
            $(".error_msg4").text("");
            btnOuter4.addClass("file_uploading4");
            setTimeout(function () {
                btnOuter4.addClass("file_uploaded4");
            }, 3000);
            var uploadedFile4 = URL.createObjectURL(e.target.files[0]);
            setTimeout(function () {
                $("#uploaded_view4").append('<img src="' + uploadedFile4 + '" />').addClass("show");
            }, 3500);
        }
    });
    $(".file_remove4").on("click", function (e) {
        $("#uploaded_view4").removeClass("show");
        $("#uploaded_view4").find("img").remove();
        btnOuter4.removeClass("file_uploading4");
        btnOuter4.removeClass("file_uploaded4");
    });
    /* five upload*/
    var btnUpload5 = $("#upload_file5"),
        btnOuter5 = $(".button_outer5");
    btnUpload5.on("change", function (e) {
        var ext = btnUpload5.val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['pdf', 'xlsx', 'text']) == -1) {
            $(".error_msg5").text("Not an file...");
        } else {
            $(".error_msg5").text("");
            btnOuter5.addClass("file_uploading5");
            setTimeout(function () {
                btnOuter5.addClass("file_uploaded5");
            }, 3000);
            var uploadedFile5 = URL.createObjectURL(e.target.files[0]);
            setTimeout(function () {
                $("#uploaded_view5").append('<img src="' + uploadedFile5 + '" />').addClass("show");
            }, 3500);
        }
    });
    $(".file_remove5").on("click", function (e) {
        $("#uploaded_view5").removeClass("show");
        $("#uploaded_view5").find("img").remove();
        btnOuter5.removeClass("file_uploading5");
        btnOuter5.removeClass("file_uploaded5");
    });

    /* six upload*/
    var btnUpload6 = $("#upload_file6"),
        btnOuter6 = $(".button_outer6");
    btnUpload6.on("change", function (e) {
        var ext = btnUpload6.val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['pdf', 'xlsx', 'text']) == -1) {
            $(".error_msg6").text("Not an file...");
        } else {
            $(".error_msg6").text("");
            btnOuter6.addClass("file_uploading6");
            setTimeout(function () {
                btnOuter6.addClass("file_uploaded6");
            }, 3000);
            var uploadedFile6 = URL.createObjectURL(e.target.files[0]);
            setTimeout(function () {
                $("#uploaded_view6").append('<img src="' + uploadedFile6 + '" />').addClass("show");
            }, 3500);
        }
    });
    $(".file_remove6").on("click", function (e) {
        $("#uploaded_view6").removeClass("show");
        $("#uploaded_view6").find("img").remove();
        btnOuter6.removeClass("file_uploading6");
        btnOuter6.removeClass("file_uploaded6");
    });
    /* six upload*/
    var btnUpload7 = $("#upload_file7"),
        btnOuter7 = $(".button_outer7");
    btnUpload7.on("change", function (e) {
        var ext = btnUpload7.val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['pdf', 'xlsx', 'text']) == -1) {
            $(".error_msg6").text("Not an file...");
        } else {
            $(".error_msg7").text("");
            btnOuter7.addClass("file_uploading7");
            setTimeout(function () {
                btnOuter7.addClass("file_uploaded7");
            }, 3000);
            var uploadedFile7 = URL.createObjectURL(e.target.files[0]);
            setTimeout(function () {
                $("#uploaded_view7").append('<img src="' + uploadedFile7 + '" />').addClass("show");
            }, 3500);
        }
    });
    $(".file_remove7").on("click", function (e) {
        $("#uploaded_view7").removeClass("show");
        $("#uploaded_view7").find("img").remove();
        btnOuter7.removeClass("file_uploading7");
        btnOuter7.removeClass("file_uploaded7");
    });
</script>
@endsection
