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
     <a  class="breadcrumbs__item is-active">ماذا نقدم </a>
      <a href="{{ route('websitehome') }}" class="breadcrumbs__item ">الصفحة الاساسية</a>
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



            <div class="card-header border-0">
              <h3 class="mb-0">جدول   ماذا نقدم</h3>
            </div>

    <div class="table-responsive">

    {{-- <a href=".createClassModal" class=" btn btn-success" data-toggle="modal"
    data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء  </i></a> --}}
       
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget"> OUR TEAMS </th>
                     <th scope="col" class="sort" data-sort="budget"> فريقنا  </th>

                    <th scope="col" class="sort" data-sort="budget"> JOIN US </th>

                    <th scope="col" class="sort" data-sort="budget"> انضم الينا </th>
                    <th scope="col" class="sort" data-sort="budget"> REGISTER STUDENT </th>
                    <th scope="col" class="sort" data-sort="budget">تسجيل الطالب </th>
                    <th scope="col" class="sort" data-sort="budget"> OUR CLASSES</th>
                    <th scope="col" class="sort" data-sort="budget"> صفوفنا </th>

                    {{-- <th scope="col" class="sort" data-sort="budget"> الصورة </th> --}}
                     <th scope="col" class="sort" data-sort="budget"> تعديل </th>

                  </tr>
                </thead>
                <tbody class="list">
                 
                 
                @foreach ($advantages as $item)

               <tr>

                <td class="budget" style="font-weight:bold;font-size:15px">
                    {{$item->ourteams_en}}
                  </td>

                  <td class="budget"style="font-weight:bold;font-size:15px">
                    {{$item->ourteams_ar}}
                  </td>

                  <td class="budget">
                    {{$item->joinus_en}}

                  </td>
                  <td class="budget">
                    {{$item->joinus_ar}}

                  </td>
                  <td class="budget">
                     {{$item->register_en}}
                  </td>
                  <td class="budget">
                    {{$item->register_ar}}
                 </td>
                 <td class="budget">
                    {{$item->ourclasses_en}}
                 </td>
                 <td class="budget" >
                    {{$item->ourclasses_ar}}
                 </td>




                    {{-- <td>
                        <img src="{{ asset('storage/'.$item->img) }}" style="width: 44px;">

                    </td> --}}
         {{--  data-ourteams_en="{{ $item->ourteams_en }}" 
            data-ourteams_ar="{{ $item->ourteams_ar }}" 
            data-joinus_en="{{ $item->joinus_en }}" 
            data-joinus_ar="{{ $item->joinus_ar }}" 
            data-register_en ="{{$item->register_en}}"
            data-register_ar ="{{$item->register_ar}}"
            data-ourclasses_en="{{$item->ourclasses_en}}"
           data-ourclasses_ar="{{$item->ourclasses_ar}}"--}}

     
         <td>
                                              
            <a href=".editEmployeeModal" class="model_bt btn btn-primary edit"
            data-toggle="modal"
            data-id="{{$item->id}}" 
            data-ourteams_en="{{ $item->ourteams_en }}" 
            data-ourteams_ar="{{ $item->ourteams_ar }}" 
            data-joinus_en="{{ $item->joinus_en }}" 
            data-joinus_ar="{{ $item->joinus_ar }}" 
            data-register_en ="{{$item->register_en}}"
            data-register_ar ="{{$item->register_ar}}"
            data-ourclasses_en="{{$item->ourclasses_en}}"
           data-ourclasses_ar="{{$item->ourclasses_ar}}"
          

            >

                 تعديل
           </a>




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
                            {{ $advantages->links() }}
                        </div>
                    </div>
            </div>


    </div>
{{-- </div> --}}


    <!--new edit modal-->
           <!-- The Modal -->
           <div class="modal fade editEmployeeModal">
            <div class="modal-dialog">
                <div class="modal-content">
                     <form id="" action="{{ route('advntages_store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                     
                       
                        <div class="modal-header">
                            <h4 class="modal-title">تعديل </h4>
                            <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <input class="delete1"  hidden   name="id" >
                            <div class="form-group" style="text-align:right">
                                <label>فريقنا  </label>
                                <input type="text" name="ourteams_ar"  class="form-control ourteams_ar"
                                    value="" style="direction: rtl"
                                      required>
                            </div>

                            <div class="form-group" style="text-align:right">
                                <label>OUR TEAMS  </label>
                                <input type="text" name="ourteams_en" class="form-control ourteams_en"
                                    value=""
                                  >
                            </div>
                             <div class="form-group" style="text-align:right">
                                <label>Join us  </label>
                                <textarea type="text" name="joinus_en" class="form-control joinus_en"
                                    value=""
                                    ></textarea>
                            </div>
                             <div class="form-group" style="text-align:right">
                                <label>انضم لنا </label>
                                <textarea type="text" name="joinus_ar" class="form-control joinus_ar"
                                    value=""
                                    ></textarea>
                            </div>
                            <div class="form-group" style="text-align:right">
                                <label>Register student</label>
                                <textarea type="text" name="register_en" class="form-control register_en"
                                    value=""
                                 ></textarea>
                            </div>
                            <div class="form-group" style="text-align:right">
                                <label>تسجيل الطالب </label>
                                <textarea type="text" name="register_ar" class="form-control register_ar"
                                    value=""
                                ></textarea>
                            </div>
                            <div class="form-group" style="text-align:right">
                                <label>our classes</label>
                                <textarea type="text" name="ourclasses_en" class="form-control ourclasses_en"
                                    value=""
                                    ></textarea>
                            </div>
                            <div class="form-group" style="text-align:right">
                                <label>صفوفنا </label>
                                <textarea type="text" name="ourclasses_ar" class="form-control ourclasses_ar"
                                    value=""
                                ></textarea>
                            </div>
                               {{-- <div class="form-group" style="text-align:right">
                                <label>الصورة  </label>
                                <input type="file" id="upload_file" name="img"
                                                       >
                            </div> --}}
                            <div class="modal-footer">
                                <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                <button class="btn btn-primary" type="submit">حفظ</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!--end new modal-->




           {{-- <div class="modal fade createClassModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="" action="{{ route('advntages_store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header">
                                <h4 class="modal-title">تعديل </h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input class="delete1"  hidden   name="id" >
                                <div class="form-group" style="text-align:right">
                                    <label>فريقنا  </label>
                                    <input type="text" name="ourteams_ar"  class="form-control ourteams_ar"
                                        value="" style="direction: rtl"
                                          required>
                                </div>
    
                                <div class="form-group" style="text-align:right">
                                    <label>OUR TEAMS  </label>
                                    <input type="text" name="ourteams_en" class="form-control ourteams_en"
                                        value=""
                                      >
                                </div>
                                 <div class="form-group" style="text-align:right">
                                    <label>Join us  </label>
                                    <textarea type="text" name="joinus_en" class="form-control joinus_en"
                                        value=""
                                        ></textarea>
                                </div>
                                 <div class="form-group" style="text-align:right">
                                    <label>انضم لنا </label>
                                    <textarea type="text" name="joinus_ar" class="form-control joinus_ar"
                                        value=""
                                        ></textarea>
                                </div>
                                <div class="form-group" style="text-align:right">
                                    <label>Register student</label>
                                    <textarea type="text" name="register_en" class="form-control register_en"
                                        value=""
                                     ></textarea>
                                </div>
                                <div class="form-group" style="text-align:right">
                                    <label>تسجيل الطالب </label>
                                    <textarea type="text" name="register_ar" class="form-control register_ar"
                                        value=""
                                    ></textarea>
                                </div>
                                <div class="form-group" style="text-align:right">
                                    <label>our classes</label>
                                    <textarea type="text" name="ourclasses_en" class="form-control ourclasses_en"
                                        value=""
                                        ></textarea>
                                </div>
                                <div class="form-group" style="text-align:right">
                                    <label>صفوفنا </label>
                                    <textarea type="text" name="ourclasses_ar" class="form-control ourclasses_ar"
                                        value=""
                                    ></textarea>
                                </div>
                                   {{-- <div class="form-group" style="text-align:right">
                                    <label>الصورة  </label>
                                    <input type="file" id="upload_file" name="img"
                                                           >
                                </div> }}
                                <div class="modal-footer">
                                    <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                                    <button class="btn btn-primary">حفظ</button>
                                </div>
    
                            </div>                        </form>
                    </div>
                </div>
            </div>


--}}

                        <div class="modal fade deleteEmployeeModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="form_delete" action="{{route('delete_advantges')}}" method="POST">
                                        @csrf


                                        <div class="modal-header">

                                            <h4 class="modal-title">Delete element</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                             {{-- <input class="delete1"  hidden   name="id" > --}}
                                            <p>Are you sure you want to delete these Records?</p>
                                            <p class="text-warning"><small>This action cannot be undone.</small></p>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn btn-default" data-dismiss="modal"
                                                value="Cancel">

                                            <button class="btn btn-danger">Delete</button>


                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

                <script>

$('.alert-success').hide(5000);


$(document).ready(function () {

$('.delete11').on('click', function () {
    var id = $(this).data('id');
    var title_ar = $(this).data('title_ar');
    var title_en = $(this).data('title_en');
    var text_en = $(this).data('text_en');
    var text_ar = $(this).data('text_ar');


    $('.delete1').val(id);
    $('.title_ar').val(title_ar);
    $('.title_en').val(title_en);
    $('.text_en').val(text_en);
    $('.text_ar').val(text_ar);





});



$('.edit').on('click', function () {
    var id = $(this).data('id');
    var ourteams_en=$(this).data('ourteams_en');
    var ourteams_ar=$(this).data('ourteams_ar');
    var joinus_en=$(this).data('joinus_en');
    var joinus_ar=$(this).data('joinus_ar');
    var register_en=$(this).data('register_en');
    var register_ar=$(this).data('register_ar');
    var ourclasses_en=$(this).data('ourclasses_en');
    var ourclasses_ar=$(this).data('ourclasses_ar');
    
    
    var name_en=$(this).data('name_en');
    var image=$(this).data('image');
    var cost=$(this).data('cost');

    $('.ourteams_en').val(ourteams_en);
    $('.ourteams_ar').val(ourclasses_ar);
    $('.joinus_en').val(joinus_en);
    $('.joinus_ar').val(joinus_ar);
    $('.register_en').val(register_en);
    $('.register_ar').val(register_ar);
    $('.ourclasses_en').val(ourclasses_en);
    $('.ourclasses_ar').val(ourclasses_ar);
    
     $('.delete1').val(id);
   





});


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

@endsection
