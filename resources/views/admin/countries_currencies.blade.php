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
    #table_xx_wrapper{
    overflow: auto;
}
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">قسم الدول والعملات</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection


@section('content')
{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@php
$about = \App\About_us::find(1);
@endphp



<div class="modal fade editNewsModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('update_countries_currencies') }}"  enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">تعديل المعلومات</h4>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="news_id" value="">

                    <div class="form-group">
                        <label>اسم البلد بالانكليزي</label>
                        <input type="text" name="name_en" id="name_en"    class="form-control a" style="direction:rtl"
                            value="" maxlength="20"
                            placeholder=" اسم البلد بالانكليزي" required>
                    </div>
                    <div class="form-group">
                        <label>اسم البلد بالعربي</label>
                        <input type="text" name="name_ar" id="name_ar" class="form-control a" style="direction:rtl"
                            value="" maxlength="20"
                            placeholder="اسم البلد  بالعربي" required>
                    </div>

                    <div class="form-group">
                        <label>رمز الدولة</label>
                        <input type="text" id="key_country" name="key_country" class="form-control a" style="direction:rtl"
                            value=""
                            placeholder="رمز البلد " >
                    </div>

                    <div class="form-group">
                        <label>عملة البلد</label>
                        <input type="text" id="currency_country"  name="currency_country" class="form-control a" style="direction:rtl"
                            value=""
                            placeholder="عملة البلد " >
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-dark text-light" data-dismiss="modal">الغاء</a>
                    <button class="btn btn-primary">حفظ</button>
                </div>

                </div>

            </form>
        </div>
    </div>




<div class="modal fade" id="create_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('add_countries_currencies')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">إنشاء بلد</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>اسم البلد بالانكليزي</label>
                        <input type="text" name="name_en" class="form-control a" style="direction:rtl"
                            value="" maxlength="20"
                            placeholder=" اسم البلد بالانكليزي" required>
                    </div>
                    <div class="form-group">
                        <label>اسم البلد بالعربي</label>
                        <input type="text" name="name_ar" class="form-control a" style="direction:rtl"
                            value="" maxlength="20"
                            placeholder="اسم البلد  بالعربي" required>
                    </div>

                    <div class="form-group">
                        <label>رمز الدولة</label>
                        <input type="text" name="key_country" class="form-control a" style="direction:rtl"
                            value="" maxlength="20"
                            placeholder="رمز البلد " required>
                    </div>

                    <div class="form-group">
                        <label>عملة البلد</label>
                        <input type="text" name="currency_country" class="form-control a" style="direction:rtl"
                            value="" maxlength="20"
                            placeholder="عملة البلد " required>
                    </div>
                </div>
                <div class="modal-footer" style="text-align: right;direction: rtl;display: block;">
                    <a type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</a>&nbsp;
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>




<div class="card" style="margin: 30px">
    <div class="card-body">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول الدول والعملات</h1>
        </div>
        @can('create_countries_currencies')
        <button type="button" class="btn mb-1 btn-success" data-toggle="modal" data-target="#create_teacher" style="font-size: 25px;font-weight: 600;float: right;background: #6ABAA3;border-color: #6ABAA3">إنشاء بلد </button>
            @endcan
        <div class="">
            <table class="table align-items-center " id="table_xx">
                <thead style="color: black">
                <tr>
                    <!--<th scope="col" class="sort" data-sort="name">الرقم</th>-->
                    <th scope="col" class="sort" data-sort="budget">اسم الدولة بالانكليزي </th>
                    <th scope="col" class="sort" data-sort="budget">اسم الدولة بالعربي </th>
                    <th scope="col" class="sort" data-sort="budget">رمز الدولة </th>
                    <th scope="col" class="sort" data-sort="budget"> عملة الدولة  </th>
                    <th scope="col" class="sort" data-sort="budget">عمليات التعديل</th>

                </tr>
                </thead>
                <tbody class="list" id="mydiv">
                    @foreach ($countries_currencies as $item)
                    <tr>
                        <td>{{$item->name_en}}</td>
                        <td>{{$item->name_ar}}</td>
                        <td>{{$item->key_country}}</td>
                        <td>{{$item->currency_country}}</td>

                            <td>
                                 @can('update_countries_currencies')
                                <a class="edit_news btn btn-success"
                                data-name_en="{{ $item->name_en }}"
                                data-name_ar="{{ $item->name_ar }}"
                                data-key_country="{{ $item->key_country }}"
                                data-currency_country="{{ $item->currency_country }}"
                                data-id="{{ $item->id }}"
                                href=".editNewsModal" data-toggle="modal">تعديل</i>
                                </a>
                                 @endcan
                                 @can('delete_countries_currencies')

                                {{-- <a href=".deleteClassModal" class="delete2 btn btn-warning text-light "
                                style="color: white !important;background: #4e90aa  !important;border-color: #008CC4 !important;
                                    " data-id="{{ $item->id }}" data-toggle="modal">
                                ارشفة
                            </a> --}}
                            <form class="pt-2"  action="{{ route('activate', $item->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="active" value="{{ $item->active }}">
                                <button type="submit" class="btn btn-{{ $item->active ? 'success' : 'danger' }}">
                                    {{ $item->active ? 'ارشفة' : 'إلغاء الارشفة' }}
                                </button>
                                 @endcan
                            </form>
                        </td>
                      </tr>

                    @endforeach

                </tbody>
              </table>



        </div>
    </div>
</div>



{{-- <div class="modal fade deleteClassModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_delete" action="{{ route('archive_countries_currencies') }}" method="POST" autocomplete="off">

                @csrf
                <input type="hidden" name="id" id="class_id_delete" required>

                <div class="modal-header">
                    <h4 class="modal-title" style="color: #f00">حذف البلد </h4>
                    <button type="button" class="close" style="color: #f00" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p class="text-center">هل أنت متأكد من ارشفة البلد ؟</p>
                </div>
                <div class="modal-footer" style="justify-content: right;">
                    <button class="btn btn-dark" data-dismiss="modal">الغاء </button>&nbsp;
                    <button class="btn btn-danger">نعم</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}




@endsection
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
@section('js')

<script>
 $(document).on('click', '.delete2', function() {
                var id = $(this).data('id');
                $('#class_id_delete').val(id);
            });




    $(document).on('click','.edit_news',function(e){
    var id=$(this).data('id');
    e.preventDefault();

$('#news_id').val(id);
$('#name_ar').val($(this).data('name_ar'));
$('#name_en').val($(this).data('name_en'));
$('#key_country').val($(this).data('key_country'));
$('#currency_country').val($(this).data('currency_country'));
});


</script>

@endsection
