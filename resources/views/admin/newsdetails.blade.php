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
</style>

@endsection
     @section('breadcrumbs')

<nav class="breadcrumbs">

    <a  class="breadcrumbs__item is-active">  تفاصيل الخبر  </a>
      <a  href="{{ route('news') }}" class="breadcrumbs__item ">الاخبار  </a>
    <a  href="{{ route('websitecontroller') }}" class="breadcrumbs__item ">قسم التحكم الكامل بالموقع</a>
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

<div class="alert alert-success alert-dismissible" id="success2" role="alert" style="text-align: right;  display: none; font-size: 30px">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     {{ session()->get('success') }}
    </div>


            <div class="card-header border-0">
              <h3 class="mb-0">جدول  الاخبار</h3>
            </div>

    <div class="table-responsive">
<a href=".createNewsModal" class=" btn btn-success" data-toggle="modal"
    data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء خبر جديد</i></a>


              <table class="table align-items-center table-bordered" id="table_xx"  style="color: black; text-align:center">
                <thead class="thead-light">
                  <tr >
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th   style="text-align: center;
                    color: black;"> العنوان بالعربي </th>
            <th style="text-align: center;
            color: black;" > العنوان بالانكليزي  </th>

                    <th  style="text-align: center;
                    color: black;"> النص بالعربي </th>

                    <th  style="text-align: center;
                    color: black;"> النص بالانكليزي</th>
                    <th  style="text-align: center;
                    color: black;"> المقطع الاول بالعربي </th>
                     <th  style="text-align: center;
                     color: black;"> المقطع الاول بالانكليزي </th>


                    <th  style="text-align: center;
                    color: black;">  صورة المقطع الاول</th>

                    <th style="text-align: center;
                    color: black;">المقطع الثاني بالعربي  </th>

                    <th  style="text-align: center;
                    color: black;"> المقطع الثاني بالعربي </th>

                    <th style="text-align: center;
                    color: black;">  صورة المقطع الثاني</th>

                    <th style="text-align: center;
                    color: black;" >  المقطع الثالث بالعربي  </th>
                    <th style="text-align: center;
                    color: black;">  المقطع الثالث بالانكليزي</th>
                    <th style="text-align: center;
                    color: black;">  صورة المقطع الثالث</th>
                    <th style="text-align: center;
                    color: black;">المقطع الرابع بالعربي  </th>
                    <th style="text-align: center;
                    color: black;">  المقطع الرابع بالانكليزي</th>
                    <th style="text-align: center;
                    color: black;"> صورة المقطع الرابع </th>
                    <th style="text-align: center;
                    color: black;" >   موجود على الصفحة الرئيسية  </th>



                    <th style="text-align: center;
                    color: black;">   حذف </th>

                    <th style="text-align: center;
                    color: black;">   تعديل </th>

                  </tr>
                </thead>
                <tbody class="list">
                @foreach ($newsdetails as $item)

               <tr id="news_{{ $item->id }}">



                <td style="vertical-align: initial;" >
                    <textarea readonly cols="10" rows="3" style="border: none;"> {{$item->title_ar}}</textarea>



                  </td>

                  <td style="vertical-align: initial;" >
                    <textarea readonly cols="10" rows="3" style="border: none;"> {{$item->title_en}}</textarea>


                  </td>

                  <td style="vertical-align: initial;" >
                    <textarea readonly cols="40" rows="3" style="border: none;">{{$item->content_ar}}</textarea>



                  </td>
                  <td style="vertical-align: initial;" >
                    <textarea readonly cols="40" rows="3" style="border: none;">{{$item->content_en}}</textarea>



                  </td>
                  <td style="vertical-align: initial;" >
                    <textarea readonly cols="40" rows="3" style="border: none;"> {{$item->part1_ar}}</textarea>



                  </td>
                  <td style="vertical-align: initial;" >
                    <textarea readonly cols="40" rows="3" style="border: none;"> {{$item->part1_en}}</textarea>



                  </td>

                    <td>
                        @if($item->image1)
                        <img src="{{ asset('storage/'.$item->image1) }}" style="width: 150px;">
                        @endif

                    </td>
                  <td style="vertical-align: initial;" >
                    <textarea readonly cols="40" rows="3" style="border: none;">  {{$item->part2_ar}}</textarea>



                  </td>
                  <td style="vertical-align: initial;" >
                    <textarea readonly cols="40" rows="3" style="border: none;"> {{$item->part2_en}}</textarea>



                  </td>
                   <td>
                         @if($item->image2)
                        <img src="{{ asset('storage/'.$item->image2) }}" style="width: 150px;">
                        @endif

                    </td>
                   <td style="vertical-align: initial;" >
                    <textarea readonly cols="40" rows="3" style="border: none;">{{$item->part3_ar}}</textarea>



                  </td>
                   <td style="vertical-align: initial;" >
                    <textarea readonly cols="40" rows="3" style="border: none;">  {{$item->part3_ra}}</textarea>



                  </td>
                   <td>
                         @if($item->image3)
                        <img src="{{ asset('storage/'.$item->image3) }}" style="width: 150px;">
                        @endif

                    </td>
                   <td style="vertical-align: initial;" >
                    <textarea readonly cols="40" rows="3" style="border: none;">  {{$item->part4_ar}}</textarea>



                  </td>
                   <td style="vertical-align: initial;" >
                    <textarea readonly cols="40" rows="3" style="border: none;"> {{$item->part4_en}}</textarea>



                  </td>
 <td>
       @if($item->image4)
                        <img src="{{ asset('storage/'.$item->image4) }}" style="width: 150px;">
                        @endif

                    </td>



                  <td style="vertical-align: initial;" >
                    @if($item->type==1)
                    <i class="fa fa-check" aria-hidden="true" style="color: green"></i>
                    @endif


                  </td>

      <td class="delete"> <a class="delete_news one" data-id="{{ $item->id }}"

                    href=".active_result" data-toggle="modal"> حذف
                    </a>

         </td>
   <td style="vertical-align: initial;" >

                    <a class="edit_news btn btn-success btn-sm"
                    data-title_ar="{{ $item->title_ar }}"
                    data-content_ar="{{ $item->content_ar }}"


                    data-part1_ar="{{ $item->part1_ar }}"
                    data-part2_ar="{{ $item->part2_ar }}"
                    data-part3_ar="{{ $item->part3_ar }}"
                    data-part4_ar="{{ $item->part4_ar }}"

                    data-title_en="{{ $item->title_en }}"
                    data-content_en="{{ $item->content_en }}"

                    data-part1_en="{{ $item->part1_en }}"
                    data-part2_en="{{ $item->part2_en }}"
                    data-part3_en="{{ $item->part3_en }}"
                    data-part4_en="{{ $item->part4_en }}"

                    data-image1="{{ $item->image1 }}"
                    data-image2="{{ $item->image2 }}"
                    data-image3="{{ $item->image3 }}"
                    data-image4="{{ $item->image4 }}"
                    data-type="{{ $item->type }}"

                    data-id="{{ $item->id }}"
                    href=".editNewsModal" data-toggle="modal">تعديل</i>
                    </a>

         </td>



                  </tr>


               @endforeach


                </tbody>
              </table>

            </div>

            <div class="clearfix" style="padding-left:10px;text-align: center">
                    <div class="hint-text">Showing
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/paginate_num) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-12" >
                            {{ $newsdetails->links() }}
                        </div>
                    </div>
            </div>


    </div>
{{-- </div> --}}



<div class="modal fade editNewsModal"style="text-align: end;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_update" action="{{ route('news.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">تحديث صفحة الأخبار</h4>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="news_id" value="">

                    <div class="form-group">
                        <label>العنوان بالعربية</label>
                        <input type="text" id="title_ar" name="title_ar" class="form-control"
                            value=""  maxlength="100" style="direction: rtl"
                            placeholder="" >
                    </div>

                    <div class="form-group">
                        <label>العنوان بالإنكليزية</label>
                        <input type="text" id="title_en" name="title_en" class="form-control"
                            value=""  maxlength="100" style="direction: rtl"
                            placeholder="" >
                    </div>

                    {{-- ----------------- --}}
                    <div class="form-group">
                        <label>المحتوى بالعربية</label>

                        <textarea class="form-control" style="direction:rtl" maxlength="255" id="content_ar" name="content_ar" cols="30" rows="4" ></textarea>
                    </div>

                    <div class="form-group">
                        <label>المحتوى بالإنكليزية</label>

                        <textarea class="form-control" maxlength="255" id="content_en" name="content_en" cols="30" rows="4" ></textarea>
                    </div>



                    {{-- -------------------- --}}
                    <div class="form-group">
                        <label>الجزء الأول بالعربية</label>

                        <textarea class="form-control" style="direction:rtl" maxlength="600" id="part1_ar" name="part1_ar" id="" cols="30" rows="4" ></textarea>
                    </div>

                    <div class="form-group">
                        <label>الجزء الأول بالإنكليزية</label>

                        <textarea class="form-control" maxlength="600" id="part1_en" name="part1_en" id="" cols="30" rows="4" ></textarea>
                    </div>

                    {{-- ------------------------ --}}

                    <div class="form-group">
                        <label>الصورة الأولى</label>
                        <br>
<input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">

<img src="" width="50px" height="50px" class="del_edit_img" id="image1" alt="Not found" >
<span class="close-btn del_icon" title="الغاء" id="" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>


<input type="file" name="image1" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image1" lang="en">
<label class="custom-file-label" for="customFileLang">Select file</label>


<span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>
<img id="output" class="output" style=" display: none"src=""  width="200px" alt="">
                    </div>

                    {{-- ================================= --}}

                    <div class="form-group">
                        <label>الجزء الثاني بالعربية</label>

                        <textarea class="form-control" style="direction:rtl" maxlength="600" id="part2_ar" name="part2_ar" id="" cols="30" rows="4" ></textarea>
                    </div>

                    <div class="form-group">
                        <label>الجزء الثاني بالإنكليزية</label>

                        <textarea class="form-control" maxlength="600" id="part2_en" name="part2_en" id="" cols="30" rows="4" ></textarea>
                    </div>

                    {{-- ------------------------ --}}
                    <div class="form-group">
                        <label>الصورة الثانية</label>
                        <br>
                <input type="hidden" name="del_img2" class="del" value="del_img2" disabled="disabled">

       <img src="" width="50px" height="50px" class="del_edit_img" id="image2" alt="Not found" >
                        <span class="close-btn del_icon" title="الغاء" id="" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>


                        <input type="file" name="image2" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image2" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>


                            <span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">

                    </div>

                    {{-- ================================= --}}


                    <div class="form-group">
                        <label>الجزء الثالث بالعربية</label>

                        <textarea class="form-control" style="direction:rtl" maxlength="600" id="part3_ar" name="part3_ar" id="" cols="30" rows="4" ></textarea>
                    </div>

                    <div class="form-group">
                        <label>الجزء الثالث بالإنكليزية</label>

                        <textarea class="form-control" maxlength="600" id="part3_en" name="part3_en" id="" cols="30" rows="4" ></textarea>
                    </div>

                    {{-- --------------------- --}}
                    <div class="form-group">
                        <label>الصورة الثالثة</label>
                        <br>
        <input type="hidden" name="del_img3" class="del" value="del_img3" disabled="disabled">

       <img src="" width="50px" height="50px" class="del_edit_img" id="image3" alt="Not found" >
                        <span class="close-btn del_icon" title="الغاء" id="" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>


                        <input type="file" name="image3" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image3" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>


                            <span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">
                    </div>

                    {{-- ================================= --}}

                    <div class="form-group">
                        <label>الجزء الرابع بالعربية</label>

                        <textarea class="form-control" style="direction:rtl" maxlength="600" id="part4_ar" name="part4_ar" id="" cols="30" rows="4" ></textarea>
                    </div>

                    <div class="form-group">
                        <label>الجزء الرابع بالإنكليزية</label>

                        <textarea class="form-control" maxlength="600" id="part4_en" name="part4_en" id="" cols="30" rows="4" ></textarea>
                    </div>
                    {{-- ------------------------- --}}

                    <div class="form-group">
                        <label>الصورة الرابعة</label>
                        <br>
                        <input type="hidden" class="del" name="del_img4" value="del_img4" disabled="disabled">

       <img src="" width="50px" height="50px" class="del_edit_img" id="image4" alt="Not found" >
                        <span class="close-btn del_icon" title="الغاء" id="" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>


                        <input type="file" name="image4" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image4" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>


                            <span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">
                    </div>

                    {{-- ================================= --}}
                    <br>
                    <br>
                    <div class="form-group">
                        <label> اظهار في الصفحة الرئيسية </label>
                       <input type="checkbox" class="type" name="type">
                    </div>
                </div>

                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal">إالغاء</a>
                    <button class="btn btn-info">تحديث</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade createNewsModal" style="text-align: end;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_update" action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">إنشاء خبر جديد</h4>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>العنوان بالعربية</label>
                        <input type="text" name="title_ar" class="form-control"
                            value=""  maxlength="100" style="direction: rtl"
                            placeholder="" required>
                    </div>

                    <div class="form-group">
                        <label>العنوان بالانكليزية</label>
                        <input type="text" name="title_en" class="form-control"
                            value=""  maxlength="100"
                            placeholder="" required>
                    </div>

                    <div class="form-group">
                        <label>المحتوى الصفحة الرئيسية بالعربي</label>

                        <textarea class="form-control" maxlength="255" name="content_ar" style="direction:rtl" id="" cols="30" rows="4" required></textarea>
                    </div>


                    <div class="form-group">
                        <label>المحتوى الصفحة الرئيسية بالانكليزية</label>

                        <textarea class="form-control" maxlength="255" name="content_en" id="" cols="30" rows="4" required></textarea>
                    </div>


                    <div class="form-group">
                        <label>الجزء الأول بالعربية</label>

                        <textarea class="form-control" maxlength="600" style="direction:rtl" name="part1_ar" id="" cols="30" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>الجزء الأول بالإنكليزية</label>

                        <textarea class="form-control" maxlength="600" name="part1_en" id="" cols="30" rows="4" required></textarea>
                    </div>



                    <div class="form-group">
                        <label>image1</label>
<br>
<input type="file" name="image1" onchange="loadFile(event)" id="input_image1"  class="input_image form-control" required>
<label class="custom-file-label" for="customFileLang">Select file</label>

<span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
<img id="output" style=" display: none"src="" class="output"  width="200px" alt="">


                        </div>

                    {{-- ================================= --}}

                    <div class="form-group">
                        <label>الجزء الثاني بالعربية</label>

                        <textarea class="form-control" maxlength="600" style="direction:rtl" name="part2_ar" id="" cols="30" rows="4"></textarea>
                    </div>


                    <div class="form-group">
                        <label>الجزء الثاني بالإنكليزية</label>

                        <textarea class="form-control" maxlength="600" name="part2_en" id="" cols="30" rows="4"></textarea>
                    </div>


                  <div class="form-group">
                        <label>image2</label>
<br>
                        <input type="file" name="image2" onchange="loadFile(event)" id="input_image2"  class="input_image form-control">
                                                <label class="custom-file-label" for="customFileLang">Select file</label>

                               <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">

                        </div>

                    {{-- ================================= --}}


                    <div class="form-group">
                        <label>الجزء الثالث بالعربية</label>
                        <textarea class="form-control" maxlength="600" style="direction:rtl" name="part3_ar" id="" cols="30" rows="4" ></textarea>
                    </div>

                    <div class="form-group">
                        <label>الجزء الثالث بالإنكليزية</label>
                        <textarea class="form-control" maxlength="600" name="part3_en" id="" cols="30" rows="4" ></textarea>
                    </div>


                    <div class="form-group">
                        <label>image3</label>
                            <br>

                        <input type="file" name="image3" onchange="loadFile(event)" id="input_image3"  class="input_image form-control">
                                                <label class="custom-file-label" for="customFileLang">Select file</label>

                               <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">

                        </div>

                    {{-- ================================= --}}

                    <div class="form-group">
                        <label>الجزء الرابع بالعربية</label>
                        <textarea class="form-control" maxlength="600" style="direction:rtl" name="part4_ar" id="" cols="30" rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label>الجزء الرابع بالإنكليزية</label>
                        <textarea class="form-control" maxlength="600" name="part4_en" id="" cols="30" rows="4"></textarea>
                    </div>

                    <div class="form-group1">
                        <label>image4</label>
<br>
                        <input type="file" name="image4" onchange="loadFile(event)" id="input_image4"  class="input_image form-control">
                                                <label class="custom-file-label" for="customFileLang">Select file</label>

                               <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">


                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label> اظهار في الصفحة الرئيسية </label>
                           <input type="checkbox" class="type" name="type">
                        </div>

                </div>
                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                    <button class="btn btn-info">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>






<!--            <div class="modal fade editClassModal">-->
<!--                <div class="modal-dialog">-->
<!--                    <div class="modal-content">-->
<!--                        <form id="form_update" method="POST" action="{{ route('class_update') }}" enctype="multipart/form-data">-->
<!--                            @csrf-->
<!--                            <input type="hidden" name="class_id" id="class_id">-->
<!--                            <div class="modal-header">-->
<!--                                <h4 class="modal-title">تعديل الصف</h4>-->
<!--                                <button type="button" class="close" data-dismiss="modal"-->
<!--                                    aria-hidden="true">&times;</button>-->
<!--                            </div>-->
<!--                            <div class="modal-body">-->
<!--                                <div class="form-group" style="text-align:right">-->
<!--                                    <label>اسم الصف بالعربية</label>-->
<!--                                    <input type="text" name="class_name" class="form-control"-->
<!--                                        value="" style="direction: rtl" id="name"-->
<!--                                        placeholder="مثال :أول" maxlength="20" >-->
<!--                                </div>-->

<!--                                <div class="form-group" style="text-align:right">-->
<!--                                    <label>اسم الصف بالانكليزية</label>-->
<!--                                    <input type="text" name="class_name_en" id="name_en" class="form-control"-->
<!--                                        value=""-->
<!--                                        placeholder="example :first" maxlength="20" required>-->
<!--                                </div>-->

<!--                                <div class="form-group" style="text-align:right">-->
<!--                                    <label>المبلغ</label>-->
<!--                                    <input type="number" name="annual_installment" id="cost" class="form-control"-->
<!--                                        value="" style="direction: rtl"-->
<!--                                        placeholder=""  required>-->
<!--                                </div>-->



<!--                                <div class="form-group" style="text-align:right">-->
<!--                        <label>الصورة الأولى</label>-->
<!--                        <br>-->
<!--<input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">-->

<!--<img src="" width="50px" height="50px" class="del_edit_img" id="image" alt="Not found" >-->
<!--<span class="close-btn del_icon" title="الغاء" id="" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>-->


<!--<input type="file" name="image" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image1" lang="en">-->
<!--<label class="custom-file-label" for="customFileLang">Select file</label>-->


<!--<span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>-->
<!--<img id="output" class="output" style=" display: none"src=""  width="200px" alt="">-->

<!--                                </div>-->



<!--                            </div>-->
<!--                            <div class="modal-footer">-->
<!--                                <a class="btn btn-default" data-dismiss="modal">Cancel</a>-->
<!--                                <button class="btn btn-primary">Save</button>-->
<!--                            </div>-->
<!--                        </form>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->




<div class="col-md-4" class="delete_modal">
    {{-- <button type="button" class="btn btn-block btn-warning mb-3" data-toggle="modal" data-target="#modal-notification">Notification</button> --}}
    <div class="modal fade active_result" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
  <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
      <div class="modal-content bg-gradient-danger">
        <form id="form_delete" method="POST">
            @csrf
            @method('delete')
          <div class="modal-header">
              <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
              <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="close">×</span>
              </a>
          </div>

          <div class="modal-body">

              <div class="py-3 text-center">
                  <i class="ni ni-bell-55 ni-3x"></i>
                  <h4 class="heading mt-4">You should read this!</h4>
                  <p>Are you sure you want to delete the item ?</p>
              </div>

          </div>

          <div class="modal-footer">
              <a  class="btn btn-white delete_event" id="delete_event"
              data-id="" href="">Ok, Got it</a>
              <a class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
  </div>
</div>

</div>

<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

<script>

$('.alert-success').hide(5000);
$(document).ready(function () {
      $('#table_xx').DataTable({});
})
$(document).on('click' , '.one' , function () {

var id=$(this).data('id');
$('.delete_event').attr('href',`{{ route('admin.news.delete') }}`);

$('.delete_event').data('id',id);

});

$(document).on('click','.delete_event',function(e){
    var id=$(this).data('id');
e.preventDefault();
$.ajax({

    type:'post',
    url:"{{ route('news.delete') }}",
    enctype:'multipart/form-data',
    data:{
        '_token':"{{ csrf_token() }}",
        'id':id,

    },

success:function(data){

$(`#news_${id}`).remove();
$('#success2').show();
document.getElementById('success2').innerText="Deleted Successfully !";
$('.close').click();

$('#success2').hide(5000);

    },
    error: function (xhr) {

}

});


});



$(document).on('click','.edit_news',function(e){
    var id=$(this).data('id');
e.preventDefault();

var image1=$(this).data('image1');
var image2=$(this).data('image2');
var image3=$(this).data('image3');
var image4=$(this).data('image4');


$('#news_id').val(id);
$('#title_ar').val($(this).data('title_ar'));
$('#title_en').val($(this).data('title_en'));

$('#content_ar').val($(this).data('content_ar'));
$('#content_en').val($(this).data('content_en'));

$('#part1_ar').val($(this).data('part1_ar'));
$('#part2_ar').val($(this).data('part2_ar'));
$('#part3_ar').val($(this).data('part3_ar'));
$('#part4_ar').val($(this).data('part4_ar'));
$('#part1_en').val($(this).data('part1_en'));
$('#part2_en').val($(this).data('part2_en'));
$('#part3_en').val($(this).data('part3_en'));
$('#part4_en').val($(this).data('part4_en'));
 if($(this).data('type')){
    $('.type').attr( 'checked', true )
 }
 else{
    $('.type').removeAttr('checked');
 }


$('#category_name').val($(this).data('category_name'));

if (image1!="") {
    $('#image1').attr('src',`{{ asset('storage/${image1}') }}`);
}

if (image2!="") {
    $('#image2').attr('src',`{{ asset('storage/${image2}') }}`);

}
if (image3!="") {
    $('#image3').attr('src',`{{ asset('storage/${image3}') }}`);

}
if (image4!="") {
    $('#image4').attr('src',`{{ asset('storage/${image4}') }}`);

}



});


</script>


<script>


    var loadFile = function(event) {
       var id=event.target.id;
        var input_image=document.getElementById(id);
            var output=input_image.nextElementSibling.nextElementSibling.nextElementSibling;
            var del_img=input_image.nextElementSibling.nextElementSibling;
            output.setAttribute('src',URL.createObjectURL(event.target.files[0]));
            output.onload = function() {

              output.setAttribute('style','display:inline');
              del_img.setAttribute('style','display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
            };

    };


    var loadFile_edit = function(event) {
       var id=event.target.id;
        var input_image=document.getElementById(id);
            var output=input_image.nextElementSibling.nextElementSibling.nextElementSibling;
            var del_img=input_image.nextElementSibling.nextElementSibling;
            input_image.previousElementSibling.setAttribute('style','display:none');
            input_image.previousElementSibling.previousElementSibling.setAttribute('style','display:none');

            output.setAttribute('src',URL.createObjectURL(event.target.files[0]));
            output.onload = function() {

              output.setAttribute('style','display:inline');
              del_img.setAttribute('style','display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');
            };

    };


        $(document).on('click' , '.del_img' , function () {
            $(this).nextAll('.output').attr('style','display:none;');
            $(this).prevAll('.input_image:first').val('');
            $(this).hide();

        });

        $(document).on('click' , '.del_icon' , function () {
            $(this).prevAll('.del:first').attr('disabled',false );
            $(this).prevAll('.del_edit_img:first').hide();
            $(this).hide();

        });


  </script>


<script>
    var loadFile3 = function(event) {
      var output = document.getElementById('output3');
      output.src = URL.createObjectURL(event.target.files[0]);
      output.onload = function() {
document.getElementById('output3').setAttribute('style','display:inline');
document.getElementById('del_img3').setAttribute('style','display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');

        URL.revokeObjectURL(output.src) // free memory
      }
    };

    $(document).on('click' , '#del_img3' , function () {

$('#output3').attr('style','display:none;');
$('#input_image3').val('');
$(this).hide();


    });

  </script>



<script>
    var loadFile4 = function(event) {
      var output = document.getElementById('output4');
      output.src = URL.createObjectURL(event.target.files[0]);
      output.onload = function() {
document.getElementById('output4').setAttribute('style','display:inline');
document.getElementById('del_img4').setAttribute('style','display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');

        URL.revokeObjectURL(output.src) // free memory
      }
    };

    $(document).on('click' , '#del_img4' , function () {

$('#output4').attr('style','display:none;');
$('#input_image4').val('');
$(this).hide();


    });

  </script>


@endsection
