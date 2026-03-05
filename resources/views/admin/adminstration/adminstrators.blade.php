@extends('admin.master')
@section('style')
    <style>
        .custom-file-label {
            display: none !important;
        }

        .custom-file-label {
            display: none;
        }

        .pagination {
            justify-content: center !important;
        }

        button.close {
            margin: 0px !important;
            padding: 0px !important;
            float: left !important;
        }

        .modal-header {
            direction: rtl;
        }
    </style>
@endsection


@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a class="breadcrumbs__item is-active">قسم مدراء الأفرع </a>
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
    </nav>
@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{-- <div class="col" > --}}
    <div class="card" style="direction:rtl; text-align:right;margin: 20px;">

        <!--@if (session()->has('success'))
    -->


        <!--<div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
        <!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <!--    {{ session()->get('success') }}-->
        <!--    </div>-->

        <!--
    @endif-->



        <div class="card-header border-0">
            <h3 class="mb-0">جدول    مدراء الافرع</h3>
        </div>

        <div class="table-responsive">
            @can('create_class')
                <a href=".createClassModal" class=" btn btn-success" data-toggle="modal" data-id=""><i
                        class="material-icons" data-toggle="tooltip">إنشاء مدير جديد</i></a>
            @endcan
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                        <th scope="col" class="sort" data-sort="budget"> الاسم الاول </th>
                        <th scope="col" class="sort" data-sort="budget"> الكنية</th>
                        <th scope="col" class="sort" data-sort="budget">  الهاتف </th>
                        <th scope="col" class="sort" data-sort="budget">  الفرع </th>
                        <th scope="col" class="sort" data-sort="budget"> العمليات</th>

                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($adminstrators as $item)
                    <tr>

                        <td class="budget" style="font-weight:bold;font-size:15px">
                            {{ $item->first_name }}
                        </td>

                        <td class="budget" style="font-weight:bold;font-size:15px">
                            {{ $item->last_name }}
                        </td>

                        <td class="budget" style="font-weight:bold;font-size:15px">
                            {{ $item->phone }}
                        </td>
                        
                        
                        <td class="budget" style="font-weight:bold;font-size:15px">
                            {{ $item->mainDepartment->name }}
                        </td>

                        <td class="text-right">
                            {{-- <a href="{{ route('adminEmployees', $item->id) }}" class="btn btn-success"
                                style="margin-left: 10px"> الموظفين الااداريين</a> --}}


    <a style="font-size:18px !important" class="share_administrator btn btn-info btn-sm" data-toggle="modal" data-target="#user_name_modal" data-username="{{ $item->user->email }}" data-name="{{ $item->first_name." ".$item->last_name }}" data-pass="{{ $item->user->view_password }}" title = "معلومات الأيميل">
                             <i class="fa fa-send fa-x" style="color: #eff0f1"></i>
                        </a>


                        </td>
                    </tr>
                    @endforeach


                </tbody>
            </table>

        </div>

        <div class="clearfix" style="padding-left:10px;text-align: center">
            <div class="hint-text">Showing
                <b>{{ !request('page') ? '1' : request('page') }}</b>
                out of <b>{{ ceil($count / paginate_num) }}</b> entries
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{ $adminstrators->links() }}
                </div>
            </div>
        </div>


    </div>



<div class="modal fade" id="user_name_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" id="dvContainer">
                <div class="row">
                    <div class="col-lg-4 col-12" >
                        <img src="{{asset("storage/")}}/{{$school_data->logo}}" style="width: inherit;height: inherit;">
                    </div>
                    <div class="col-lg-8 col-12">
                        <div style="height: 5%"></div>
                        <div class="form-group" style="height: 30%">
                            <label for="" style="font-size: 30px;font-weight: 600;text-align: center;display: block;color: #001586">اسم المدرس </label>
                            <p style="color: black;font-size: 20px;display: block;text-align: center" id="name_share"></p>
                        </div>
                        <div class="form-group" style="height: 30%">
                            <label for="" style="font-size: 30px;font-weight: 600;text-align: center;display: block;color: #001586">اسم المستخدم </label>
                            <p style="color: black;font-size: 20px;display: block;text-align: center" id="username_share"></p>
                        </div>
                        <div class="form-group" style="height: 30%">
                            <label for="" style="font-size: 30px;font-weight: 600;text-align: center;display: block;color: #001586">كلمة المرور  </label>
                            <p style="color: black;font-size: 20px;display: block;text-align: center" id="pass_share"></p>
                        </div>
                        <div style="height: 5%"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="direction: rtl;justify-content: right;">
                <a class="btn btn-info ml-2" data-dismiss="modal">اغلاق</a>
                <a class="btn btn-success ml-2" id="screenshot">تنزيل</a>
            </div>
        </div>
    </div>
</div>


    <div class="modal fade createClassModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="" action="{{ route('adminstrator_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">اضافة مدير</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" style="text-align:right">
                            <label>الاسم الأول</label>
                            <input type="text" name="first_name" class="form-control" value=""
                                style="direction: rtl" placeholder="مثال :أول" maxlength="20" required>
                        </div>

                        <div class="form-group" style="text-align:right">
                            <label>الكنية</label>
                            <input type="text" name="last_name" class="form-control" value=""
                                style="direction: rtl" placeholder="مثال :أول" maxlength="20" required>
                        </div>

         <div class="form-group" style="text-align:right">
                            <label> الاسم بالانكليزية  </label>
                            <input type="text" name="name_en" class="form-control english_name" value=""
                                style="direction: rtl" placeholder="مثال :name" maxlength="20" required>
                        </div>
                        
                        <div class="form-group" style="text-align:right">
                            <label>الهاتف</label>
                            <input type="text" name="phone" class="form-control" value=""
                                style="direction: rtl"  maxlength="20" required>
                        </div>
                        
                            <div class="form-group" style="text-align:right">
                            <label>الإدارة التابع لها</label>
                           
                           <select name="mainDepartment_id" class="form-control">
                               <option>اختر اسم الادارة</option>
                               @foreach($mainDepartments as $item)
                              <option value="{{$item->id}}">{{$item->name}}</option>

                               @endforeach
                           </select>
                           
                        </div>
                        


                    </div>
                    <div class="modal-footer" style="justify-content: right;">
                        <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                        <button class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>







    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

   $(".english_name").keypress(function (event) {
        var ew = event.which;
        if (ew == 32)
            return true;
        if (48 <= ew && ew <= 57)
            return true;
        if (65 <= ew && ew <= 90)
            return true;
        if (97 <= ew && ew <= 122)
            return true;
        return false;
    });
    
    $(document).on("click",".share_administrator",function () {
    $('#pass_share').text($(this).data("pass"));
    $('#username_share').text($(this).data("username"));
    $('#name_share').text($(this).data("name"));
});

</script>

@endsection
