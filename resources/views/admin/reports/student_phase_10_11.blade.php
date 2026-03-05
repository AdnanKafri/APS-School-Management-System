@extends('admin.master')

@section('style')
<link href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

<style>
    * {
        direction: rtl !important;
        /* text-align: center; */
    }

    button,
    a {
        color: white !important;
    }

    .form-group {
        text-align: right;
    }

    label {
        font-size: 20px;
        color: black;
    }

    input {
        font-size: 17px !important;
    }

    th {
        font-size: 20px;
    }

    td {
        font-size: 17px;
    }

    a.page-link {
        color: #7571f9 !important;
    }

    .pagination {
        justify-content: center;
    }

    .dropdown-item {
        color: black !important;
        width: auto !important;
    }

    .fa-folder {
        margin: 2px;
    }

    .dorat {
        color: blue !important;
    }

    img {
        border-radius: 50%;
    }

    /* ///////////////////////////////////// */


    .wrapper {
        display: inline-flex;
        background: #fff;
        height: 100px;
        width: 400px;
        align-items: center;
        justify-content: space-evenly;
        border-radius: 5px;
        padding: 20px 15px;
        margin-left: 25px;
        box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.2);
    }

    .wrapper .option {
        background: #fff;
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        margin: 0 10px;
        border-radius: 5px;
        cursor: pointer;
        padding: 0 10px;
        border: 2px solid lightgrey;
        transition: all 0.3s ease;
    }

    .wrapper .option .dot {
        height: 20px;
        width: 20px;
        background: #d9d9d9;
        border-radius: 50%;
        position: relative;
    }

    .wrapper .option .dot::before {
        position: absolute;
        content: "";
        top: 4px;
        left: 4px;
        width: 12px;
        height: 12px;
        background: #0069d9;
        border-radius: 50%;
        opacity: 0;
        transform: scale(1.5);
        transition: all 0.3s ease;
    }

    .wrapper input[type="radio"] {
        display: none;
    }

    #option-1:checked:checked~.option-1,
    #option-2:checked:checked~.option-2 {
        border-color: #0069d9;
        background: #0069d9;
    }

    #option-1:checked:checked~.option-1 .dot,
    #option-2:checked:checked~.option-2 .dot {
        background: #fff;
    }

    #option-1:checked:checked~.option-1 .dot::before,
    #option-2:checked:checked~.option-2 .dot::before {
        opacity: 1;
        transform: scale(1);
    }

    .wrapper .option span {
        font-size: 20px;
        color: #808080;
    }

    #option-1:checked:checked~.option-1 span,
    #option-2:checked:checked~.option-2 span {
        color: #fff;
    }

    .wrapper_lang {
        display: inline-flex;
        background: #fff;
        height: 100px;
        width: 400px;
        align-items: center;
        justify-content: space-evenly;
        border-radius: 5px;
        padding: 20px 15px;
        margin-left: 25px;
        box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.2);
    }

    .wrapper_lang .option {
        background: #fff;
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        margin: 0 10px;
        border-radius: 5px;
        cursor: pointer;
        padding: 0 10px;
        border: 2px solid lightgrey;
        transition: all 0.3s ease;
    }

    .wrapper_lang .option .dot {
        height: 20px;
        width: 20px;
        background: #d9d9d9;
        border-radius: 50%;
        position: relative;
    }

    .wrapper_lang .option .dot::before {
        position: absolute;
        content: "";
        top: 4px;
        left: 4px;
        width: 12px;
        height: 12px;
        background: #0069d9;
        border-radius: 50%;
        opacity: 0;
        transform: scale(1.5);
        transition: all 0.3s ease;
    }

    .wrapper_lang input[type="radio"] {
        display: none;
    }

    #option-lang1:checked:checked~.option-lang1,
    #option-lang2:checked:checked~.option-lang2 {
        border-color: #0069d9;
        background: #0069d9;
    }

    #option-lang1:checked:checked~.option-lang1 .dot,
    #option-lang2:checked:checked~.option-lang2 .dot {
        background: #fff;
    }

    #option-lang1:checked:checked~.option-lang1 .dot::before,
    #option-lang2:checked:checked~.option-lang2 .dot::before {
        opacity: 1;
        transform: scale(1);
    }

    .wrapper_lang .option span {
        font-size: 20px;
        color: #808080;
    }

    #option-lang1:checked:checked~.option-lang1 span,
    #option-lang2:checked:checked~.option-lang2 span {
        color: #fff;
    }

    th {
        font-size: 20px;
        border-bottom: 1px solid #008991 !important;
        text-align: center !important;
    }

    td {
        font-size: 17px;
        border-bottom: 1px solid #008991 !important;
        color: black;
        text-align: center;
    }
    .table .thead-light th {
    color: #495057;
    background-color: white;
    /* border-color: #dee2e6; */
}
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection

@section('breadcrumbs')

<nav class="breadcrumbs">
    <a class="breadcrumbs__item ">الطلاب</a>
    <a href="{{ route('reports') }}" class="breadcrumbs__item ">قسم التقارير</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item is-active">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')

<!------------------------------------------------>

@php
$about = \App\Other::find(1);
@endphp
{{-- <div class=" col-12 col-lg-2" style="text-align: left;">
    <a class="btn btn-success" >  <a href="{{ route('export_student1') }}"></a>تصدير الطلاب </a>
</div> --}}



{{-- ////////// --}}






<div class="card" style="margin: 30px">
    <div class="card-body" style="text-align: right;">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">وثيقة اتمام مرحلة </h1>
        </div>
        <a class="btn btn-primary"  href="{{ asset('storage/'.$student->details->phase_class9) }}"
            download="{{ $student->first_name }}{{ $student->last_name }}.pdf">
            تنزيل الملف
        </a>
        <br>
        <br>

  <div class="row" style="justify-content: center;">
            @if ($student->details->phase_class9!=null)
            <iframe src = "{{ asset('storage/'.$student->details->phase_class9) }}"
                width = "100%" height = "800px">
                Sorry your browser does not support inline frames.
             </iframe>
             @else

             <h4 style="text-align:center">لايوجد وثيقة للطالب {{ $student->first_name }} {{ $student->last_name }}</h4>
             @endif
        </div>
    </div>
</div>

@endsection

@section('js')

@endsection
