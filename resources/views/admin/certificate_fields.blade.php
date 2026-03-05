@extends('admin.master')
@section('style')

<style>
.custom-file-label{
display:none !important;
}
    .custom-file-label{
        display:none;
    }
    .pagination{
        justify-content: center !important;
    }
        button.close{
    margin: 0px !important;
    padding: 0px !important;
    float: left !important;
}
.modal-header{
    direction: rtl;
}
</style>

@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم  الشهادات</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')
{{-- <div class="col" > --}}
    <div class="card" style="direction:rtl; text-align:right;margin: 20px;">

        <!--@if(session()->has('success'))-->


        <!--<div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
        <!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <!--    {{ session()->get('success') }}-->
        <!--    </div>-->

        <!--@endif-->



            <div class="card-header border-0">
              <h3 class="mb-0">الشهادات  </h3>
            </div>

    <div class="table-responsive">
 

              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget"> اسم الشهادة  </th>
                    <th scope="col" class="sort" data-sort="budget">  مشاهدة  </th>

                    <th scope="col" class="sort" data-sort="budget"> تفاصيل </th>

                  

                  </tr>
                </thead>
                <tbody class="list">
            

               <tr>
          


                <td class="budget" style="font-weight:bold;font-size:15px">
                        الشهادة الاولى
                  </td>

                  <td class="budget"style="font-weight:bold;font-size:15px">
                        <a class="btn" href="{{route('new231')}}" target="_blank">  مشاهدة </a>
                  </td>

                  <td class="budget" style="font-weight:bold;font-size:15px">
                    <a class="btn" href="{{route('certificate_details',1)}}" >   تفاصيل </a>

                  </td>


                   

                  </tr>
                <tr>
                          
                
                
                                <td class="budget" style="font-weight:bold;font-size:15px">
                                        الشهادة  الثانية
                                  </td>
                
                                  <td class="budget"style="font-weight:bold;font-size:15px">
                                        <a class="btn" href="{{route('newcertificaate')}}" target="_blank"> مشاهدة </a>
                                  </td>
                
                                  <td class="budget" style="font-weight:bold;font-size:15px">
                                    <a class="btn"  href="{{route('certificate_details',2)}}" > تفاصيل </a>
                
                                  </td>
                
                
                                   
                
                                  </tr>
                
                <tr>
                          
                
                
                                <td class="budget" style="font-weight:bold;font-size:15px">
                                        الشهادة الثالثة
                                  </td>
                
                                  <td class="budget"style="font-weight:bold;font-size:15px">
                                        <a class="btn" href="{{route('new44')}}" target="_blank" >  مشاهدة </a>
                                  </td>
                
                                  <td class="budget" style="font-weight:bold;font-size:15px">
                                    <a class="btn"href="{{route('certificate_details',3)}}" > تفاصيل </a>
                
                                  </td>
                
                
                                   
                
                                  </tr>
                  <tr>
          


                <td class="budget" style="font-weight:bold;font-size:15px">
                        الشهادة الرابعة
                  </td>

                  <td class="budget"style="font-weight:bold;font-size:15px">
                        <a class="btn" href="{{route('ncertificaate')}}" target="_blank"> مشاهدة </a>
                  </td>

                  <td class="budget" style="font-weight:bold;font-size:15px">
                    <a class="btn" href="{{route('certificate_details',4)}}" > تفاصيل </a>

                  </td>


                   

                  </tr>
                  <tr>
          


                <td class="budget" style="font-weight:bold;font-size:15px">
                        الشهادة الخامسة 
                  </td>

                  <td class="budget"style="font-weight:bold;font-size:15px">
                        <a class="btn"  href="{{route('newcerti')}}" target="_blank">    مشاهدة </a>
                  </td>

                  <td class="budget" style="font-weight:bold;font-size:15px">
                    <a class="btn" href="{{route('certificate_details',5)}}" > تفاصيل </a>

                  </td>


                   

                  </tr>
                     <tr>
          


                <td class="budget" style="font-weight:bold;font-size:15px">
                        الشهادة  السادسة 
                  </td>

                  <td class="budget"style="font-weight:bold;font-size:15px">
                        <a class="btn"  href="{{route('certificate_2')}}" target="_blank">    مشاهدة </a>
                  </td>

                  <td class="budget" style="font-weight:bold;font-size:15px">
                    <a class="btn" href="{{route('certificate_details',6)}}" > تفاصيل </a>

                  </td>


                   

                  </tr>
                        <tr>
          


                <td class="budget" style="font-weight:bold;font-size:15px">
                        الشهادة  السابعة 
                  </td>

                  <td class="budget"style="font-weight:bold;font-size:15px">
                        <a class="btn"  href="{{route('new2')}}" target="_blank">    مشاهدة </a>
                  </td>

                  <td class="budget" style="font-weight:bold;font-size:15px">
                    <a class="btn" href="{{route('certificate_details',7)}}" > تفاصيل </a>

                  </td>


                   

                  </tr>
                  <tr>
          


                <td class="budget" style="font-weight:bold;font-size:15px">
                        الشهادة    الثامنة 
                  </td>

                  <td class="budget"style="font-weight:bold;font-size:15px">
                        <a class="btn"  href="{{route('new3')}}" target="_blank">    مشاهدة </a>
                  </td>
  
                  <td class="budget" style="font-weight:bold;font-size:15px">
                    <a class="btn" href="{{route('certificate_details',8)}}" > تفاصيل </a>

                  </td>


                   

                  </tr>
                
                </tbody>
              </table>

            </div>



    </div>



@endsection
