@extends('admin.master')

@section('style')
<style>
    *{
        direction: rtl !important;
        /* text-align: center; */
    }
    button,a{
        color: rgb(255, 255, 255) ;
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
    #table_xx_wrapper{
    overflow: auto;
}
.modal-title {
    margin-bottom: 0;
    line-height: 1.5;
    margin: auto;
    padding-left: 90PX;
}
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active"> النسب الكلية     </a>
    <a href="{{ route('ministerial_and_financial_ratios') }}" class="breadcrumbs__item "> نسب الوزراة والمالية </a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection


@section('content')
{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@php
$about = \App\About_us::find(1);
@endphp



<div class="card" style="margin: 30px">
    <div class="card-body">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول   نسب   وزارة التربية  والمالية </h1>
        </div>
       

        <div class="">
            <table class="table align-items-center " id="table_xx">
                <thead style="color: black">
                <tr>
                    <th scope="col" class="sort" data-sort="budget">    الدولة </th>
                    <th scope="col" class="sort" data-sort="budget">    المبلغ الكلي  </th>
                    <th scope="col" class="sort" data-sort="budget">  نسبة  وزارة التربية   </th>
                    <th scope="col" class="sort" data-sort="budget"> نسبة المالية</th>
                    <th scope="col" class="sort" data-sort="budget">   العملة </th>
                 

                </tr>
                </thead>
                <tbody class="list" id="mydiv">
                @foreach ($rate as $key=>$item )
                    <tr>
                        <td>{{$key}}</td>
                        @foreach ($item as $item1 )
                        <td>{{$item1}}</td>
                      
                        @endforeach
                    </tr>
                @endforeach
                
              

                </tbody>
                </table>



        </div>
    </div>
</div>





@endsection
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
@section('js')

<script>
$(document).on('click', '.delete', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');

    $('#name_delete').val(name);
    $('#lesson_id_delete').val(id);
});

$(document).on('click','.edit_news',function(e){
var id=$(this).data('id');
var id=$(this).data('id');
var ministerial=$(this).data('ministerial');
var financial=$(this).data('financial');
$('#ministerial_id').val(id);
$('#ministerial').val(ministerial);
$('#financial').val(financial);


});


</script>

@endsection
