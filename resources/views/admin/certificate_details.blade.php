@extends('admin.master')

@section('style')
<style>
    *{
        direction: rtl !important;
        /* text-align: center; */
    }
    button,a{
        color: white !important;
    }
    .form-group{
        text-align: right;
    }
    label{
        font-size: 20px;
        color: black;
    }
    input{
        font-size: 17px !important;
    }
    th{
        font-size: 20px;
        border: 0px  !important;
        text-align: center !important;
    }
    td{
        font-size: 17px;
        color: black;
        border: 0px !important;
        text-align: center;
    }
    tr{
        border-bottom: 1px solid #008991 !important;
        border-top: 1px solid #008991 !important;
    }
    a.page-link{
        color: #7571f9 !important;
    }
    .pagination{
        justify-content: center;
    }
    .form-group{
        margin: 0px !important;
    }
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">تفاصيل الشهادة </a>
     <a href="{{ route('certificate_fields') }}" class="breadcrumbs__item "> قسم الشهادات</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection


@section('content')


@php
$about = \App\About_us::find(1);
@endphp







<div class="card" style="margin: 30px">
    <div class="card-body">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول تفاصيل الشهادة</h1>
        </div>
          <div class="">
            <table class="table align-items-center " id="table_xx">
                <thead style="color: black">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">الرقم</th>-->
                    <th scope="col" class="sort" data-sort="budget">الاسم </th>
                    <th scope="col" class="sort" data-sort="budget">السطر الاول  </th>
                            <th scope="col" class="sort" data-sort="budget">  اسم المدرسة   </th>
                   <th scope="col" class="sort" data-sort="budget">السطر   الثاني   </th>
                    <th scope="col" class="sort" data-sort="budget">السطر   الثالث   </th>
                     <th scope="col" class="sort" data-sort="budget">   مدير المدرسة الافتراضية    </th>
                      <th scope="col" class="sort" data-sort="budget">   رئيس مجلس الادارة    </th>
                       <th scope="col" class="sort" data-sort="budget">   صورة الباركود     </th>
                       <th scope="col" class="sort" data-sort="budget">   صورة   اللوغو     </th>
                             <th scope="col" class="sort" data-sort="budget">      تعديل     </th>
                  </tr>
                </thead>
                <tbody class="list" id="mydiv">
                    <tr>
                        <td>{{$certificate->name}}</td>
                        <td>{{$certificate->title}}</td>
                        <td>{{$certificate->school_name}}</td>
                        <td>{{$certificate->text1}}</td>
                        <td>{{$certificate->text2}}</td>
                        <td>{{$certificate->school_manager}}</td>
                        <td>{{$certificate->chairman}}</td>
                        <td>  <img src="{{ asset('storage/'.$certificate->barcode) }}"  width="100px" height="100px"> </td>
                        <td> <img src="{{ asset('storage/'.$certificate->logo) }}"  width="100px" height="100px"></td>
                        <td><button class="btn mb-1 btn-success"    data-toggle="modal" data-target="#create_teacher">تعديل </button>
                       <div class="modal fade" id="create_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('certificate_update')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">تعديل حقول الشهادة  </h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>اسم الشهادة  </label>
                             <input type="text" name="id"  value="{{$certificate->id}}"  hidden>
                        <input type="text" name="name" class="form-control a" style="direction:rtl"
                            value="{{$certificate->name}}"  
                            placeholder="اسم الشهادة " required>
                    </div>

                    <div class="form-group">
                        <label> </label>
                        <input type="text" name="title" class="form-control b"
                        value="{{$certificate->title}}"    style="direction:rtl"
                            placeholder=" السطر الاول" required> 
                    </div>
                    <div class="form-group">
                        <label> اسم المدرسة </label>
                        <input type="text" name="school_name" class="form-control a english_name" style="direction:rtl"
                           value="{{$certificate->school_name}}"   
                            placeholder="اسم المدرسة  " required>
                    </div>

                    <div class="form-group">
                        <label> السطر الثاني </label>
                        <input type="text" name="text1" class="form-control b english_name"
                           value="{{$certificate->text1}}"         style="direction:rtl"
                            placeholder="السطر الثاني " required>
                    </div>
                        <div class="form-group">
                            <label> السطر الثالث</label>
                            <input type="text" name="text2" class="form-control b" value="{{$certificate->text2}}"   style="direction:rtl" placeholder="السطر الثالث">
                        </div>

                        <div class="form-group">
                            <label>مدير المدرسة الافتراضية </label>
                            <input type="text" name="school_manager" class="form-control b"  value="{{$certificate->school_manager}}"  placeholder="مدير المدرسة الافتراضية  " style="direction:rtl">
                        </div>

                        <div class="form-group">
                            <label>مدير مجلس الادارة </label>
                            <input type="text" name="chairman" class="form-control b" value="{{$certificate->chairman}}"  placeholder="مدير مجلس الادارة " style="direction:rtl" maxlength="20" required="">
                        </div>

                        <div class="form-group">
                                <label for=""> صورة اللوغو  </label>
                                <input type="file" name="logo" value="{{$certificate->logo}}"  class="form-control">
                        </div>
                        <div class="form-group">
                                <label for="">صورة  الباركود  </label>
                                <input type="file" name="barcode"  value="{{$certificate->barcode}}" class="form-control">
                        </div>
                </div>
                <div class="modal-footer" style="text-align: right;direction: rtl;display: block;">
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</a>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

                       
                       
                       
                        </td>
                    </tr>


                </tbody>
              </table>



        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>


@endsection
