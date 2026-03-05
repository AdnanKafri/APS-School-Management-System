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

    .tabs input[name="tab-control"] {
        display: none;
    }

    .tabs .content section h2,
    .tabs ul li label {
        font-family: "Montserrat";
        font-weight: bold;
        font-size: 18px;
        color: #428bff;
    }

    .tabs ul {
        list-style-type: none;
        padding-left: 0;
        display: flex;
        flex-direction: row;
        margin-bottom: 10px;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;

    }

    .tabs ul li {
        box-sizing: border-box;
        flex: 1;
        width: 25%;
        padding: 0 10px;
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

    .tabs input[name="tab-control"]:nth-of-type(1):checked~ul>li:nth-child(1)>label {
        cursor: default;
        color: #f38639;
        font-size: 22px;
    }

    .tabs input[name="tab-control"]:nth-of-type(1):checked~ul>li:nth-child(1)>label svg {
        fill: #f38639;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(1):checked~ul>li:nth-child(1)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(1):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(1):checked~.content>section:nth-child(1) {
        display: block;
    }

    .tabs input[name="tab-control"]:nth-of-type(2):checked~ul>li:nth-child(2)>label {
        cursor: default;
        color: #f38639;
        font-size: 22px;
    }

    .tabs input[name="tab-control"]:nth-of-type(2):checked~ul>li:nth-child(2)>label svg {
        fill: #f38639;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(2):checked~ul>li:nth-child(2)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(2):checked~.slider {
        transform: translateX(100%);
    }

    .tabs input[name="tab-control"]:nth-of-type(2):checked~.content>section:nth-child(2) {
        display: block;
    }

    .tabs input[name="tab-control"]:nth-of-type(3):checked~ul>li:nth-child(3)>label {
        cursor: default;
        color: #f38639;
        font-size: 22px;
    }

    .tabs input[name="tab-control"]:nth-of-type(3):checked~ul>li:nth-child(3)>label svg {
        fill: #f38639;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(3):checked~ul>li:nth-child(3)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(3):checked~.slider {
        transform: translateX(200%);
    }

    .tabs input[name="tab-control"]:nth-of-type(3):checked~.content>section:nth-child(3) {
        display: block;
    }

    /*tab 4*/
    .tabs input[name="tab-control"]:nth-of-type(4):checked~ul>li:nth-child(4)>label {
        cursor: default;
        color: #f38639;
        font-size: 22px;
    }

    .tabs input[name="tab-control"]:nth-of-type(4):checked~ul>li:nth-child(4)>label svg {
        fill: #f38639;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(4):checked~ul>li:nth-child(4)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(4):checked~.slider {
        transform: translateX(0%);
    }

    .tabs input[name="tab-control"]:nth-of-type(4):checked~.content>section:nth-child(4) {
        display: block;
    }

    .tabs input[name="tab-control"]:nth-of-type(5):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(5):checked~.content>section:nth-child(5) {
        display: block;
    }

    /*tab 5*/
    .tabs input[name="tab-control"]:nth-of-type(5):checked~ul>li:nth-child(5)>label {
        cursor: default;
        color: #f38639;
        font-size: 22px;
    }

    .tabs input[name="tab-control"]:nth-of-type(5):checked~ul>li:nth-child(5)>label svg {
        fill: #f38639;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(5):checked~ul>li:nth-child(5)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(5):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(5):checked~.content>section:nth-child(5) {
        display: block;
    }

    /*tab 6*/
    .tabs input[name="tab-control"]:nth-of-type(6):checked~ul>li:nth-child(6)>label {
        cursor: default;
        color: #f38639;
        font-size: 22px;
    }

    .tabs input[name="tab-control"]:nth-of-type(6):checked~ul>li:nth-child(6)>label svg {
        fill: #f38639;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(6):checked~ul>li:nth-child(6)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(6):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(6):checked~.content>section:nth-child(6) {
        display: block;
    }

    /*tab 7*/
    .tabs input[name="tab-control"]:nth-of-type(7):checked~ul>li:nth-child(7)>label {
        cursor: default;
        color: #428bff;
    }

    .tabs input[name="tab-control"]:nth-of-type(7):checked~ul>li:nth-child(7)>label svg {
        fill: #428bff;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(7):checked~ul>li:nth-child(7)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(7):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(7):checked~.content>section:nth-child(7) {
        display: block;
    }

    /*tab 8*/
    .tabs input[name="tab-control"]:nth-of-type(8):checked~ul>li:nth-child(8)>label {
        cursor: default;
        color: #428bff;
    }

    .tabs input[name="tab-control"]:nth-of-type(8):checked~ul>li:nth-child(8)>label svg {
        fill: #428bff;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(8):checked~ul>li:nth-child(8)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(8):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(8):checked~.content>section:nth-child(8) {
        display: block;
    }

    /*tab 9*/
    .tabs input[name="tab-control"]:nth-of-type(9):checked~ul>li:nth-child(9)>label {
        cursor: default;
        color: #428bff;
    }

    .tabs input[name="tab-control"]:nth-of-type(9):checked~ul>li:nth-child(9)>label svg {
        fill: #428bff;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(9):checked~ul>li:nth-child(9)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(9):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(9):checked~.content>section:nth-child(9) {
        display: block;
    }

    /*tab 10*/
    .tabs input[name="tab-control"]:nth-of-type(10):checked~ul>li:nth-child(10)>label {
        cursor: default;
        color: #428bff;
    }

    .tabs input[name="tab-control"]:nth-of-type(10):checked~ul>li:nth-child(10)>label svg {
        fill: #428bff;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(10):checked~ul>li:nth-child(10)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(10):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(10):checked~.content>section:nth-child(10) {
        display: block;
    }

    /*tab 11*/
    .tabs input[name="tab-control"]:nth-of-type(11):checked~ul>li:nth-child(11)>label {
        cursor: default;
        color: #428bff;
    }

    .tabs input[name="tab-control"]:nth-of-type(11):checked~ul>li:nth-child(11)>label svg {
        fill: #428bff;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(11):checked~ul>li:nth-child(11)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(11):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(11):checked~.content>section:nth-child(11) {
        display: block;
    }

    /*tab 12*/
    .tabs input[name="tab-control"]:nth-of-type(12):checked~ul>li:nth-child(12)>label {
        cursor: default;
        color: #428bff;
    }

    .tabs input[name="tab-control"]:nth-of-type(12):checked~ul>li:nth-child(12)>label svg {
        fill: #428bff;
    }

    @media (max-width: 600px) {
        .tabs input[name="tab-control"]:nth-of-type(12):checked~ul>li:nth-child(12)>label {
            background: rgba(0, 0, 0, 0.08);
        }
    }

    .tabs input[name="tab-control"]:nth-of-type(12):checked~.slider {
        transform: translateX(300%);
    }

    .tabs input[name="tab-control"]:nth-of-type(12):checked~.content>section:nth-child(12) {
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
        max-width: 15.95em;
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
        border-bottom: 2px solid #f38639;
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
        border-bottom-color: #f38639;
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

    /*start design new table */




    table {
        width: 100%;
        min-width: auto;
        margin-bottom: 2.4rem;
        background-color: #20262e;
        color: #fff;
        overflow: hidden;
    }

    table tr:nth-child(even) {
        background-color: rgb(46, 53, 62);
    }

    table th,
    table td:before {
        color: #28b1de;
    }

    table th {
        display: none;
    }

    table th,
    table td {
        margin: .5rem 2rem;
        text-align: left;
    }

    table td {
        display: block;
        font-size: 90%;
    }

    table td:first-child {
        padding-top: 1rem;
    }

    table td:last-child {
        padding-bottom: 1rem;
    }

    table td:before {
        content: attr(data-th) ':\00a0';
        font-weight: bold;
        min-width: 8rem;
        display: inline-block;
    }

    .table-2 table td:before {
        min-width: 0;
    }

    .table-3 table {
        background-color: rgb(46, 53, 62);
    }

    .table-3 table tr:nth-child(even) {
        background-color: transparent;
    }

    .table-3 table td:before {
        width: 100%;
        font-weight: normal;
        opacity: .8;
    }

    .table-3 table td {
        margin: 0;
        padding: 1.5rem 2rem 0 2rem;
        font-weight: bold
    }

    .table-3 table tr td:first-child {
        background-color: #20262e;
        padding-top: 1.5rem;
        padding-bottom: 1.5rem;
    }

    .table-3 table tr td:last-child {
        padding-bottom: 1.5rem;
        border-bottom: 4px solid rgba(255, 255, 255, .3)
    }

    .table-3 table tr:last-child td:last-child {
        border-bottom: none;
    }

    @media (min-width: 1000px) {
        table td:before {
            display: none;
        }

        table th,
        table td {
            display: table-cell;
        }

        table th,
        table td,
        table td:first-child,
        table td:last-child {
            padding: 1.5rem 2rem;
        }

        .table-3 table {
            background-color: #20262e;
        }

        .table-3 table tr:nth-child(even) {
            background-color: rgb(46, 53, 62);
        }

        .table-3 table td {
            margin: .5rem 2rem;
            padding: 1.5rem 2rem;
            font-weight: normal
        }

        .table-3 table tr td:first-child {
            background-color: transparent;
        }

        .table-3 table tr td:last-child {
            border-bottom: none;
        }
    }

    /*end design new table */
    /*design for link*/

    #wrapper {
        display: block;
        margin-bottom: 100px;
    }



    #madeby {
        color: #666;
        text-decoration: none;
        position: fixed;
        bottom: 20px;
        right: 20px;
    }

    #madeby:after {
        content: '';
        position: absolute;
        width: 0;
        height: 100%;
        top: 0;
        right: 0;
        padding-bottom: 5px;
        border-bottom: 1.5px solid rgb(194, 116, 116);
        transition: color 0.3s ease;
        transition: 0.3s width ease;
    }

    #madeby:hover:after {
        left: 0;
        width: 100%;
        transition: 0.3s width ease;
    }

    #madeby:hover {
        color: rgb(83, 5, 5);
        transition: color 0.3s ease;
    }

    .button {
        text-decoration: none;
        color: #094e89;
        font-weight: bold;
        font-size: 20px;
        position: relative;
        padding: 10px;
    }


    /* BUTTON EEN */

    a.button.one:before,
    a.button.one:after {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        transition: all 0.3s ease;
    }

    a.button.one:before {
        top: -2.5%;
        left: -1%;
        border-top: 2px solid #f38639;
        border-left: 2px solid #f38639;
    }

    a.button.one:after {
        bottom: -2.5%;
        right: -1%;
        border-bottom: 2px solid #f38639;
        border-right: 2px solid #f38639;
    }

    a.button.one:hover:before,
    a.button.one:hover:after {
        width: 100%;
        height: 100%;
        transition: all 0.3s ease;
    }


    /* BUTTON TWEE */

    a.button.two:before,
    a.button.two:after {
        opacity: 0;
        transition: all 0.3s ease;
        font-size: 20px;
    }

    a.button.two:before {
        content: '[';
    }

    a.button.two:after {
        content: ']';
    }

    a.button.two:hover:before {
        margin-right: 10px;
        content: '[';
        -webkit-transform: translateX(20px);
        -moz-transform: translateX(20px);
        transform: translateX(20px);
        opacity: 1;
    }

    a.button.two:hover:after {
        margin-left: 10px;
        content: ']';
        -webkit-transform: translateX(-20px);
        -moz-transform: translateX(-20px);
        transform: translateX(-20px);
        opacity: 1;
    }



    /* BUTTON DRIE */

    a.button.three:before,
    a.button.three:after {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        opacity: 0;
    }

    a.button.three:before {
        top: 0;
        left: 0;
        border-top: 2px solid white;
        border-right: 2px solid white;
    }

    a.button.three:after {
        bottom: 0;
        right: 0;
        border-bottom: 2px solid white;
        border-left: 2px solid white;
    }

    a.button.three:hover:before {
        animation: first 0.3s forwards;
        opacity: 1;
    }

    a.button.three:hover:after {
        animation: second 0.3s forwards;
    }

    @keyframes first {
        0% {
            width: 0%;
            height: 0%;
        }

        25% {
            width: 100%;
            height: 0%;
        }

        50% {
            width: 100%;
            height: 100%;
        }

        100% {
            width: 100%;
            height: 95%;
        }
    }

    @keyframes second {
        0% {
            width: 0%;
            height: 0%;
        }

        50% {
            width: 0%;
            height: 0%;
        }

        75% {
            width: 100%;
            height: 0%;
            opacity: 1;
        }

        100% {
            width: 100%;
            height: 95%;
            opacity: 1;
        }
    }


    /* BUTTON VIER */

    a.button.four:before,
    a.button.four:after {
        content: '';
        position: absolute;
        width: 0%;
        height: 100%;
        border-bottom: 2px solid white;
        transition: width 0.3s ease;
    }

    a.button.four:before {
        bottom: 0;
        right: 50%;
    }

    a.button.four:after {
        bottom: 0;
        left: 50%;
    }

    a.button.four:hover:after,
    a.button.four:hover:before {
        width: 40%;
        transition: width .2s ease;
    }



    /* button vijf */

    a.button.five:after {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;

        width: 0%;
        height: 100%;

        border-bottom: 2px solid white;

        transition: width 0.3s ease;
    }

    a.button.five:hover:after {
        left: 0;
        width: 100%;
        transition: width .3s ease;
    }


    /* Button six */

    a.button.six:after {
        content: '';
        width: 100%;
        height: 120%;
        top: 0;
        left: 0;
        position: absolute;
        border-bottom: 2px solid white;
        opacity: 0;

        transition: all .2s ease;
    }

    a.button.six:hover:after {
        opacity: 1;
        height: 100%;

        transition: all 0.3s ease;
    }

    /* button seven */

    a.button.seven:after {
        content: '';
        width: 100%;
        height: 85%;
        top: 0;
        left: 0;
        position: absolute;
        border-bottom: 2px solid white;
        opacity: 0;

        transition: all .2s ease;
    }

    a.button.seven:hover:after {
        opacity: 1;
        height: 100%;

        transition: all 0.3s ease;
    }

    /* Button eight */

    a.button.eight:before,
    a.button.eight:after {
        content: '';
        position: absolute;
        width: 100%;
    }

    a.button.eight:after {
        height: 100%;
        border-bottom: 2px solid white;
        bottom: 0;
        left: 0;
        transition: transform 0.2s ease;
    }

    a.button.eight:before {
        height: 0%;
        border-top: 2px solid white;
        bottom: 0;
        left: 0;
        transition: height .3s ease;

    }

    a.button.eight:hover:before {
        height: 100%;
        transform: scale(1.08);
        transition: all 0.3s ease;
    }

    a.button.eight:hover:after {
        transform: scale(1.08);
        transition: transform 0.4s ease;
    }



    /* Button Nine */

    a.button.nine {
        border: 2px solid #333;
    }

    a.button.nine:after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: -2px;
        left: -2px;
        border: 2px solid white;
        transform: translate(20px, -20px);
        opacity: 0;
        transition: all 0.3s ease;
    }

    a.button.nine:hover:after {
        opacity: 1;
        animation: nine 0.3s forwards;
    }

    @keyframes nine {
        0% {
            transform: translate(-20px, 20px);
        }

        100% {
            transform: translate(0px, 0px);
        }
    }


    /* Button ten */
    a.button.ten {
        color: #333;
    }

    a.button.ten:after {
        content: 'But not this time...';
        position: absolute;
        top: 10px;
        left: 0;
        width: 100%;
        height: 100%;
        color: white;
        transform: translate(-20px, -20px);
        transition: all 0.2s ease;
        opacity: 0;
    }

    a.button.ten:hover:after {
        transform: translate(0px, 0px);
        opacity: 1;
        transition: all 0.2s ease;
    }

    /* button eleven */

    a.button.eleven {
        border: 2px solid white;
        transition: all 0.3s ease;
        transform: translate(0px 10px);
    }

    a.button.eleven:hover {
        box-shadow: 0px 15px 10px -10px #fff;
        transform: translate(0px 0px);
    }

    /*end design */
</style>

@endsection
@section('content')


<div class="modal fade modal-fullscreen-xs-down alert_three" id="modal-fullscreen-xs-down3" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="direction:rtl">
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                <h4 class="modal-title" id="myModalLabel">انتباهك مطلوب </h4>
            </div>
            <div class="modal-body">
                <p>هل انت متأكد من حذف العنصر ؟</p>
            </div>
            <div class="modal-footer">
                <input id="s11" hidden type="text">
                <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                <button type="button " class="btn btn-primary confirm3">نعم , موافق</button>
            </div>
        </div>
    </div>
</div>
<section class="hero-wrap hero-wrap-2" style="background-image:  url( {{  asset('teachers/ppp.jpg') }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2">
                        <!--a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span>Certified Instructor <i class="fa fa-chevron-right"></i></span></p-->
                        <h1 class="mb-0 bread">محتوى الدرس </h1>
            </div>
        </div>
    </div>
</section>
 <nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">  محتوى الدرس </a>
     <a  href="{{ route('dashboard.coordinator_teacher_lesson',[$classes->id,$teacher->id,$lesson->id]) }}" class="breadcrumbs__item ">  الدروس</a>
     <a  href="{{ route('dashboard.coordinator_teacher',[$classes->id,$teacher->id, $lesson->id ]) }}" class="breadcrumbs__item "> {{ $teacher->first_name }}  {{ $teacher->last_name }}   </a>
    <a  href="{{ route('dashboard.coordinator_subject',$classes->id ) }}" class="breadcrumbs__item ">{{ $classes->name }}   </a>
     <a   href="{{ route('dashboard.coordinator') }}" class="breadcrumbs__item ">الواجهة الرئيسية 
</a>
</nav>
<!-- start new-->
<!-- start section of content lesson -->
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading"></span>
                <h2 class="mb-4" style="color: #f38639;"> محتوى الدرس </h2>
            </div>
        </div>



        <div class="tabs" id="class">

            <input type="radio" id="tab1" name="tab-control">
            <input type="radio" id="tab2" name="tab-control">
            <input type="radio" id="tab3" name="tab-control">
            <input type="radio" id="tab4" name="tab-control">
            <input type="radio" id="tab5" name="tab-control">
            <input type="radio" id="tab6" name="tab-control" checked>

            <ul>
                <li title="الوظائف "><label for="tab1" role="button"><svg viewBox="0 0 24 24">
                            <path
                                d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                        </svg>
                        <span>الوظائف </span><br></label></li>

                <li title="مقاطع الفيديو "><label for="tab2" role="button"><svg viewBox="0 0 24 24">
                            <path
                                d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                        </svg>
                        <span>مقاطع الفيديو </span><br></label></li> </label></li>

                <li title="مقاطع الصوت  "><label for="tab3" role="button"><svg viewBox="0 0 24 24">
                            <path
                                d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                        </svg>
                        <span>مقاطع الصوت </span><br></label></li></label></li>

                <li title="الاختبارات  "><label for="tab4" role="button"><svg viewBox="0 0 24 24">
                            <path
                                d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                        </svg>
                        <span>اختبارات </span><br></label></li></label></li>

                {{-- <li title="الامتحانات "><label for="tab5" role="button"><svg viewBox="0 0 24 24">
                            <path
                                d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                        </svg>
                        <span>الامتحانات </span> <br></label></li> --}}

                <li title="الملفات "><label for="tab6" role="button"><svg viewBox="0 0 24 24">
                            <path
                                d="M14,2A8,8 0 0,0 6,10A8,8 0 0,0 14,18A8,8 0 0,0 22,10H20C20,13.32 17.32,16 14,16A6,6 0 0,1 8,10A6,6 0 0,1 14,4C14.43,4 14.86,4.05 15.27,4.14L16.88,2.54C15.96,2.18 15,2 14,2M20.59,3.58L14,10.17L11.62,7.79L10.21,9.21L14,13L22,5M4.93,5.82C3.08,7.34 2,9.61 2,12A8,8 0 0,0 10,20C10.64,20 11.27,19.92 11.88,19.77C10.12,19.38 8.5,18.5 7.17,17.29C5.22,16.25 4,14.21 4,12C4,11.7 4.03,11.41 4.07,11.11C4.03,10.74 4,10.37 4,10C4,8.56 4.32,7.13 4.93,5.82Z" />
                        </svg>
                        <span>الملفات </span> <br></label></li>


            </ul>


            <div class="">
                <div class="indicator"></div>
            </div>

            <div class="content">
                <section style="direction: rtl; text-align:right">

                    <h2>الوظائف </h2>
                    <div class="row" style="justify-content: center;">
                        @foreach ($tests as $item)
                        @if($item->test_link!=null && $item->test==null )
                        <div class="data-card" style="width: 400px;">
                            <h6 style="text-align:center;color: #094e89; "> &nbsp;&nbsp; {{ $item->namehomework }}
                                &nbsp;&nbsp;</h6>
                            <br>
                            <a href="{{$item->test_link  }}" target="_blank"> <img
                                    src="{{  asset('teachers/link.png')}}" style="height: 150px;width:150px"> </a>
                            <br>

                        </div>


                        @elseif($item->test )
                        <div class="data-card">
                            <h6 style="text-align:center;color: #094e89;"> {{ $item->namehomework }}
                            </h6>
                            <br>


                            @if ($item->extension=="docx")
                            <img src="{{  asset('teachers/photo/word.png')}}">
                            @elseif ($item->extension=="pdf")
                            <img src="{{  asset('teachers/photo/pdf1.png')}}">
                            @else
                            <img src="{{  asset('teachers/photo/pdf1.png')}}">
                            @endif
                            <br>
                            <div class="row ">
                                @if($item->test_link!=null )
                                <div style="justify-content: right; float: right;text-align: right;">

                                    <a href="{{ $item->test_link }}"> <img src="{{  asset('teachers/link.png')}}"
                                            style="height: 40px;width:40px" title="رابط الوظيفة "> </a>

                                </div>
                                @endif
                                &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;


                                <a href="#" style="justify-content: left; float: left; text-align: left;">
                                    <a href="{{ asset('storage/'.$item->test) }}" target="_blank">
                                        <img title=" تنزيل الملف "
                                            src="{{  asset('teachers/icons/icons8-download.gif')}}"
                                            style="height: 30px;width:30px"> </a>
                                </a>

                            </div>
                        </div>

                        @endif
                        @endforeach



                        <!-- end link for homeworkk -->


                    </div>

                </section>
                <!-- start homework section-->

                <!-- end homework section-->
                <!-- start video section-->

                <section style="direction: rtl; text-align:right">
                    <h2>مقاطع الفيديو </h2>
                    <!-- start cards-->
                    <div class="row" style="justify-content: center;">
                        @foreach ($videos as $item)
                        @if($item->video_link!=null && $item->video ==null)
                        <div class="data-card" style="width: 400px;">
                            <h6 style="text-align:center;color: #094e89; "> &nbsp;&nbsp; {{ $item->name_video }}
                                &nbsp;&nbsp;</h6>
                            <br>
                            <a href="{{$item->video_link  }}" target="_blank"> <img
                                    src="{{  asset('teachers/link.png')}}" style="height: 150px;width:150px"> </a>
                            <br>
                            <div class="row " style="justify-content: left; margin-top:31px;">





                                <!--a href="#" ><img src="./icons/icons8-edit-link-30.png" style="text-align: center;" title="تعديل  الامتحان ">  </a-->
                            </div>
                        </div>
                        @elseif($item->video)
                        <div class="data-card">
                            <h6 style="text-align:center;color: #094e89;"> {{ $item->name_video}} </h6>
                            <br>
                            <video controls style="border-radius: 10px;">
                                <source src="{{ asset('storage/'.$item->video) }}" type="video/mp4">
                            </video>
                            <br>
                            <!-- start edit -->
                            <div class="row ">
                                @if($item->video_link!=null)
                                <div style="justify-content: right; float: right;text-align: right;">
                                    <a href="{{ $item->video_link }}"> <img src="{{  asset('teachers/link.png')}}"
                                            style="height: 40px;width:40px" title="رابط الوظيفة "> </a>
                                </div>
                                @endif
                                &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;

                                &nbsp;

                            </div>
                            <!-- end edit -->


                        </div>
                        @endif



                        @endforeach


                        <!-- link for video -->



                        <!-- end link for video-->
                    </div>
                    <!-- end cards-->


                </section>


                <!-- end video section-->

                <!-- start audio section-->


                <section style="direction: rtl; text-align:right">
                    <h2>مقاطع الصوت </h2>
                    <!-- start cards-->
                    <div class="row" style="justify-content: center;">

                        @foreach ($voices as $item)
                        @if($item->audio_link!=null && $item->audio_file==null)
                        <div class="data-card" style="width: 400px;">
                            <h6 style="text-align:center;color: #094e89; "> &nbsp;&nbsp; {{ $item->name_audio}}
                                &nbsp;&nbsp;</h6>
                            <br>
                            <a href="{{ $item->audio_link }}"> <img src="{{  asset('teachers/link.png')}}"
                                    style="height: 150px;width:150px"> </a>
                            <div class="row " style="justify-content: left;">


                                <!--a href="#" ><img src="./icons/icons8-edit-link-30.png" style="text-align: center;" title="تعديل  الامتحان ">  </a-->
                            </div>
                        </div>

                        @elseif($item->audio_file)
                        <div class="data-card">
                            <h6 style="text-align:center;color: #094e89;"> {{ $item->name_audio}} </h6>
                            <br>
                            <audio style="width: 210px; margin: 0 auto;justify-content: center;"
                                src="{{asset("storage/")}}/{{$item->audio_file}}" controls="">
                            </audio>
                            <br>
                            <div class="row ">
                                @if ($item->audio_link!=null)
                                <div style="justify-content: right; float: right;text-align: right;">
                                    <a href="{{ $item->audio_link }}"> <img src="{{  asset('teachers/link.png')}}"
                                            style="height: 40px;width:40px" title="رابط مقطع الصوت "> </a>
                                </div>
                                @endif
                                &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;


                            </div>


                        </div>

                        @endif


                        <!-- link for audio -->

                        @endforeach



                        <!-- end link -->

                    </div>
                    <!-- end cards-->



                </section>
                <!-- end  audio  section-->

                <!-- start quize  section-->

                <section style="text-align:right; direction:rtl">
                    <h2>اختبارات </h2>
                    <!-- start cards-->
                    <div class="row">
                        @foreach ( $quizes1 as $item)
                        @if ($item->type=='8' && $item->name_quize1!=null )
                        <div class="data-card">
                            <h5 style="text-align:center;">{{ $item->name_quize1 }} </h5>
                            <br>
                            <a href="{{route('quest_exam1', [ $item->id,$room->id,$lesson->id ]) }}">
                                <img style="width:180px" src="{{  asset('teachers/photo/quiz44.jpg')}}">
                            </a>
                            <br>

                            @if ($now < $item->start_time && $now < $item->end_time)
                                    <h6 style="text-align: center"> {{ $item->start_time }}</h6>

                                    <div class="row " style="justify-content: center;">
                                        <a href="#" class="btn btn-primary circle"> بالانتظار </a> &nbsp;&nbsp;
                                    </div>

                                    @elseif($now > $item->start_time && $now < $item->end_time)
                                        <h6 style="text-align: center"> {{ $item->end_time }}</h6>

                                        <div class="row " style="justify-content: center;">
                                            <a href="#" class="btn btn-primary circle"> جاري </a> &nbsp;&nbsp;
                                        </div>
                                        @elseif($now > $item->start_time && $now > $item->end_time)
                                        <h6 style="text-align: center"> {{ $item->end_time }}</h6>

                                        <div class="row " style="justify-content: center;">
                                            <a href="#" class="btn btn-primary circle"> انتهى </a> &nbsp;&nbsp;
                                        </div>
                                        @endif

                                        <br>
                                        <div class="row ">


                                        </div>

                        </div>
                        @elseif( $item->type=='7')
                        @if ($item->quize1)
                        <div class="data-card">
                            <h5 style="text-align:center;">{{ $item->name_quize1 }} </h5>
                            <br>
                            <img src="{{  asset('teachers/photo/quiz44.jpg')}}">
                            <br>

                            @if ($now < $item->start_time && $now < $item->end_time)
                                    <h6 style="text-align: center"> {{ $item->start_time }}</h6>

                                    <div class="row " style="justify-content: center;">
                                        <a href="#" class="btn btn-primary circle"> بالانتظار </a> &nbsp;&nbsp;
                                    </div>

                                    @elseif($now > $item->start_time && $now < $item->end_time)
                                        <h6 style="text-align: center"> {{ $item->end_time }}</h6>


                                        <div class="row " style="justify-content: center;">
                                            <a href="#" class="btn btn-primary circle"> جاري </a> &nbsp;&nbsp;
                                        </div>
                                        @elseif($now > $item->start_time && $now > $item->end_time)
                                        <h6 style="text-align: center"> {{ $item->end_time }}</h6>

                                        <div class="row " style="justify-content: center;">
                                            <a href="#" class="btn btn-primary circle"> انتهى </a> &nbsp;&nbsp;
                                        </div>
                                        @endif
                                        <br>


                        </div>
                        @else
                        <div class="data-card">
                            <h5 style="text-align:center;"> {{ $item->name_quize1 }} </h5>
                            <br>
                            <!-- link for exam-->


                                <a href="{{ $item->quiz_link1 }}" target="_blank"><img
                                        src="{{  asset('teachers/link.png') }}" style="height: 150px;width:150px"> </a>
                                <div></div>



                            <!-- end link for exam-->
                            <br>
                            @if ($now < $item->start_time && $now < $item->end_time)
                                    <h6 style="text-align: center"> {{ $item->start_time }}</h6>

                                    <div class="row " style="justify-content: center;">
                                        <a href="#" class="btn btn-primary circle"> بالانتظار </a> &nbsp;&nbsp;
                                    </div>

                                    @elseif($now > $item->start_time && $now < $item->end_time)

                                        <h6 style="text-align: center"> {{ $item->end_time }}</h6>
                                        <div class="row " style="justify-content: center;">
                                            <a href="#" class="btn btn-primary circle"> جاري </a> &nbsp;&nbsp;
                                        </div>
                                        @elseif($now > $item->start_time && $now > $item->end_time)
                                        <h6 style="text-align: center"> {{ $item->end_time }}</h6>

                                        <div class="row " style="justify-content: center;">
                                            <a href="#" class="btn btn-primary circle"> انتهى </a> &nbsp;&nbsp;
                                        </div>
                                        @endif
                                        <br>



                        </div>



                        @endif
                        @endif



                        @endforeach

                    </div>
                    <!-- link for quiz-->





                </section>
                {{-- <section style="text-align:right; direction:rtl">
                    <h2>الامتحانات</h2>
                    <!-- start cards-->
                    <div class="row" style="justify-content: center;">
                        @foreach ( $exams as $item)
                        @if ($item->type=='5' && $item->name_exam!=null )
                        <div class="data-card">
                            <h5 style="text-align:center; color: #094e89;">{{ $item->name_exam }} </h5>
                            <br>
                            <a href="{{route('dashboard.quest_exam', $item->id ) }}">
                                <img src="{{  asset('teachers/icons/exam-image.png')}}" style="width: 180px;"> </a>
                            <br>
                            @if ($now < $item->start_time && $now < $item->end_time)
                                    <h6 style="text-align: center"> {{ $item->start_time }}</h6>

                                    <div class="row " style="justify-content: center;">
                                        <a href="#" class="btn btn-primary circle"> بالانتظار </a> &nbsp;&nbsp;
                                    </div>

                                    @elseif($now > $item->start_time && $now < $item->end_time)

                                        <h6 style="text-align: center"> {{ $item->end_time }}</h6>
                                        <div class="row " style="justify-content: center;">
                                            <a href="#" class="btn btn-primary circle"> جاري </a> &nbsp;&nbsp;
                                        </div>
                                        @elseif($now > $item->start_time && $now > $item->end_time)
                                        <h6 style="text-align: center"> {{ $item->end_time }}</h6>

                                        <div class="row " style="justify-content: center;">
                                            <a href="#" class="btn btn-primary circle"> انتهى </a> &nbsp;&nbsp;
                                        </div>
                                        @endif
                                        <br>

                                        <!-- end edit exam-->

                                        <div class="row ">
                                            <a href="#" style="text-align: center;"> <img title="حذف الملف"
                                                    src="{{  asset('teachers/icons/icons8-waste.gif')}}"
                                                    style="height: 30px;width:30px"> </a> &nbsp;

                                            <a href="{{ route('dashboard.teacher.exams',[$class_id,$lecture->id,$room_id]) }}"
                                                style="text-align: center;"><img
                                                    src="{{  asset('teachers/icons/icons8-edit-file-30.png')}}"
                                                    style="text-align: center;" title="تعديل  الملف"> </a>&nbsp;
                                            <a href="{{ route('dashboard.exams_addquestion',$item->id) }}"> <img
                                                    src="{{  asset('teachers/icons/icons8-plus (1).gif')}}"
                                                    style="width:30px; height: 30px" title=" اضافة سؤال "> </a>
                                        </div>

                        </div>

                        @elseif ($item->type=='3' )
                        @if ($item->exam_link)
                        <div class="data-card">
                            <h5 style="text-align:center;color: #094e89;">{{ $item->name_exam }} </h5>
                            <br>
                            <br>
                            <br>
                            <!-- link for exam-->
                            <span id="wrapper">

                                <a href="{{ $item->exam_link }}" target="_blank" class="button one"> رابط الامتحان </a>
                                <div></div>

                            </span>

                            <!-- end link for exam-->

                            @if ($now < $item->start_time && $now < $item->end_time)
                                    <h6 style="text-align: center"> {{ $item->start_time }}</h6>

                                    <div class="row " style="justify-content: center;">
                                        <a href="#" class="btn btn-primary circle"> بالانتظار </a> &nbsp;&nbsp;
                                    </div>

                                    @elseif($now > $item->start_time && $now < $item->end_time)

                                        <h6 style="text-align: center"> {{ $item->end_time }}</h6>
                                        <div class="row " style="justify-content: center;">
                                            <a href="#" class="btn btn-primary circle"> جاري </a> &nbsp;&nbsp;
                                        </div>
                                        @elseif($now > $item->start_time && $now > $item->end_time)
                                        <h6 style="text-align: center"> {{ $item->end_time }}</h6>

                                        <div class="row " style="justify-content: center;">
                                            <a href="#" class="btn btn-primary circle"> انتهى </a> &nbsp;&nbsp;
                                        </div>
                                        @endif
                                        <br>
                                        <div class="row " style="justify-content: left;">
                                            <a href="#" style="text-align: center;"> <img title="حذف الملف"
                                                    src="{{  asset('teachers/icons/icons8-waste.gif')}}"
                                                    style="height: 30px;width:30px"> </a> &nbsp;

                                        </div>
                        </div>
                        @elseif($item->exam)
                        <div class="data-card">
                            <h5 style="text-align:center; color: #094e89;">{{ $item->name_exam }} </h5>
                            <br>
                            <a href="#">
                                <img src="{{  asset('teachers/icons/exam-image.png')}}" style="width: 180px;"> </a>
                            <br>
                            @if ($now < $item->start_time && $now < $item->end_time)
                                    <h6 style="text-align: center"> {{ $item->start_time }}</h6>

                                    <div class="row " style="justify-content: center;">
                                        <a href="#" class="btn btn-primary circle"> بالانتظار </a> &nbsp;&nbsp;
                                    </div>

                                    @elseif($now > $item->start_time && $now < $item->end_time)

                                        <h6 style="text-align: center"> {{ $item->end_time }}</h6>
                                        <div class="row " style="justify-content: center;">
                                            <a href="#" class="btn btn-primary circle"> جاري </a> &nbsp;&nbsp;
                                        </div>
                                        @elseif($now > $item->start_time && $now > $item->end_time)
                                        <h6 style="text-align: center"> {{ $item->end_time }}</h6>

                                        <div class="row " style="justify-content: center;">
                                            <a href="#" class="btn btn-primary circle"> انتهى </a> &nbsp;&nbsp;
                                        </div>
                                        @endif
                                        <br>

                                        <!-- end edit exam-->

                                        <div class="row " style="justify-content: right;">
                                            <a href="{{ route('dashboard.exam.edit',$item->id) }}"
                                                style="text-align: center;"> <img title="حذف الملف"
                                                    src="{{  asset('teachers/icons/icons8-waste.gif')}}"
                                                    style="height: 30px;width:30px"> </a> &nbsp;

                                            <a href="{{ route('dashboard.exam.edit',$item->id) }}"
                                                style="text-align: center;"><img
                                                    src="{{  asset('teachers/icons/icons8-edit-file-30.png')}}"
                                                    style="text-align: center;" title="تعديل  الملف"> </a>&nbsp;

                                        </div>



                        </div>
                        @endif
                        @endif
                        @endforeach

                    </div>

                </section> --}}
                <!-- end  quize  section-->
                <!-- start exam section-->

                <!-- end  exam section-->

                <!-- start file section-->

                <section style="text-align: right; direction:rtl">
                    <h2>الملفات </h2>
                    <!-- start cards-->
                    <div class="row" style="justify-content: center;">
                        @foreach ($additions as $item4)
                        @if($item4->addition_link != null && $item4->addition ==null)
                        <div class="data-card" style="width: 400px;">
                            <h6 style="text-align:center;color: #094e89; "> &nbsp;&nbsp; {{ $item4->name }} &nbsp;&nbsp;
                            </h6>
                            <br>
                            <a href="{{ $item4->addition_link }}" target="_blank"> <img
                                    src="{{  asset('teachers/link.png')}}" style="height: 150px;width:150px"> </a>
                            <br>
                            <div class="row " style="justify-content: left; margin-top:31px;">
                            

                                <!--a href="#" ><img src="./icons/icons8-edit-link-30.png" style="text-align: center;" title="تعديل  الامتحان ">  </a-->
                            </div>
                        </div>

                        @elseif ($item4->addition !=null)
                        <div class="data-card">
                            <h6 style="text-align:center;color: #094e89;"> {{ $item4->name_addition}}</h6>
                            <br>
                            <br>
                            <br>
                            <!-- link for exam-->
                            @if ($item4->extension=="docx")
                            <img src="{{  asset('teachers/photo/word.png')}}">
                            @elseif ($item4->extension=="pdf")
                            <img src="{{  asset('teachers/photo/pdf1.png')}}">
                            @else
                            <img src="{{  asset('teachers/photo/pdf1.png')}}">
                            @endif
                            <br>
                            <div class="row ">
                                @if($item4->addition_link != null)
                                <div style="justify-content: right; float: right;text-align: right;">

                                    <a href="{{ $item4->addition_link }}"> <img src="{{  asset('teachers/link.png')}}"
                                            style="height: 40px;width:40px" title="رابط الوظيفة "> </a>

                                </div>
                                &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;
                                @endif

                                <a href="" style="justify-content: left; float: left;" class="three"
                                    data-id="{{ $item4->id }}" data-toggle="modal"
                                    data-target="#modal-fullscreen-xs-down3"> <img title="حذف الملف "
                                        data-id="{{ $item4->id }}" src="{{  asset('teachers/icons/icons8-waste.gif')}}"
                                        style="height: 30px;width:30px" title=" حذف الملف "> </a>

                                <a href="{{ asset('storage/'.$item4->addition) }}" target="_blank"
                                    style="justify-content: left; float: left; text-align: left;"> <img
                                        title=" تنزيل الملف " src=" {{  asset('teachers/icons/icons8-download.gif')}}"
                                        style="height: 30px;width:30px"> </a>
                            </div>
                        </div>
                        @endif
                        <!-- link for file-->


                        @endforeach



                    </div>
                </section>
                <!-- end  exam section-->


            </div>
        </div>
        <!-- end add content -->

    </div>
</section>

<!-- end section  of content lesson-->


<br>
<br>
<br>
<br>


<!-- loader -->
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
    $(document).on('click', '.three', function (e) {




        var id = $(this).data('id');

        $('#s11').val($(this).data('id'));
        $('.confirm3').data('id', id);



    });
    $(document).on('click', '.confirm3', function (e) {

        var id = $('#s11').val();;
        e.preventDefault();
        $.ajax({

            type: 'get',
            url: "{{ route('dashboard.addition.delete') }}",

            data: {

                'id': id,

            },
            success: function (data) {
                $(`#test_${id}`).remove();
                $(`#item3_${id}`).remove();
                $(".modal").modal('hide');

                $('.alert_three').hide();

                swal({
                    title: "Good job!",
                    text: "! تمت العملية بنجاح ",
                    icon: "success",
                    button: "OK",
                    timer: 2000

                });
                location.reload();
            },
            error: function (xhr) {

            }

        })


    });
</script>

@endsection
