@extends('admin.layouts.app')
<head>

    
    
    <style>
    .custom-file-label{
    display:none !important;
    }
        .custom-file-label{
            display:none;
        }
    </style>
</head>
@section('content')
<div class="col" style="direction:rtl; text-align:right">
    <div class="card">

        <!--@if(session()->has('success'))-->


        <!--<div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
        <!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <!--    {{ session()->get('success') }}-->
        <!--    </div>-->

        <!--@endif-->



            <div class="card-header border-0">
              <h3 class="mb-0">جدول الصفوف</h3>
            </div>

    <div class="table-responsive">

    <a href=".createClassModal" class=" btn btn-success" data-toggle="modal"
    data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء صف جديد</i></a>


              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget"> الاسم بالعربية</th>
            <th scope="col" class="sort" data-sort="budget"> الاسم بالانكليزية</th>

                    <th scope="col" class="sort" data-sort="budget"> القسط السنوي</th>

                    <th scope="col" class="sort" data-sort="budget"> الصورة</th>
                    <th scope="col" class="sort" data-sort="budget"> العمليات</th>

                  </tr>
                </thead>
                <tbody class="list">
                @foreach ($classes as $item)

               <tr>
                <!--    <th scope="row">-->
                <!--    {{$item->id}}-->
                <!--</th>-->


                <td class="budget" style="font-weight:bold;font-size:15px">
                    {{$item->name}}
                  </td>

                  <td class="budget"style="font-weight:bold;font-size:15px">
                    {{$item->name_en}}
                  </td>

                  <td class="budget">
                    {{$item->annual_installment}}

                  </td>

                  <td>
                      @if ($item->image !=null)
<img src="{{ asset('storage/'.$item->image) }}" width="50px" height="50px"  alt="">
                      @endif
                  </td>



                    <!--<td>-->
                    <!--  <div class="avatar-group">-->
                    <!--    <a href="#" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="Ryan Tompson">-->
                    <!--      <img alt="Image placeholder" src="{{asset('assets/img/theme/team-1.jpg')}}">-->
                    <!--    </a>-->

                    <!--  </div>-->
                    <!--</td>-->



                    <td class="text-right">
                      <!--<div class="dropdown">-->
                      <!--  <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                      <!--    <i class="fas fa-ellipsis-v"></i>-->
                      <!--  </a>-->
                      <!--  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">-->
                      <!--  <a href=".deleteEmployeeModal" class="delete dropdown-item" data-toggle="modal"-->
                      <!--              data-id="{{$item->id}}"><i class="material-iconsni ni ni-fat-remove" data-toggle="tooltip"-->
                      <!--                  title="Delete">&#xE872; Delete</i></a>-->
                      <!--    <a class="dropdown-item" href="#">Another action</a>-->
                      <!--    <a class="dropdown-item" href="#">Something else here</a>-->
                      <!--  </div>-->
                      <!--</div>-->
                      <a href=".editClassModal" class="edit" data-name="{{ $item->name }}" data-name_en="{{ $item->name_en }}"
                      data-image="{{$item->image}}"
                      data-cost="{{ $item->annual_installment }}" data-id="{{ $item->id }}"data-toggle="modal"  >   <i class="ni ni-settings"></i></a>

                      <a href="{{route('admin.classroom',$item->id)}}" class="btn btn-success" style="margin-left: 10px">الشعب</a>
                    </td>


                  </tr>


               @endforeach
   

                </tbody>
              </table>

            </div>








            <div class="clearfix" style="padding-left:10px">
                    <div class="hint-text">Showing
                        <b>{{ !request('page')? "1" : request('page') }}</b>
                        out of <b>{{ ceil($count/paginate_num) }}</b> entries</div>
                    <div class="row">
                        <div class="col-md-10">
                            {{ $classes->links() }}
                        </div>
                    </div>
                </div>


    </div>
</div>





            <div class="modal fade createClassModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="" action="{{ route('admin.class_store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header">
                                <h4 class="modal-title">اضافة صف</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:right">
                                    <label>اسم الصف بالعربية</label>
                                    <input type="text" name="class_name" class="form-control"
                                        value="" style="direction: rtl"
                                        placeholder="مثال :أول" maxlength="20" required>
                                </div>

                                <div class="form-group" style="text-align:right">
                                    <label>اسم الصف بالانكليزية</label>
                                    <input type="text" name="class_name_en" class="form-control"
                                        value=""
                                        placeholder="example :first" maxlength="20" required>
                                </div>


                                <div class="form-group" style="text-align:right">
                                    <label>المبلغ</label>
                                    <input type="number" name="annual_installment" class="form-control"
                                        value="" style="direction: rtl"
                                        placeholder=""  required>
                                </div>


                                <div class="form-group" style="text-align:right">
                        <label>الصورة</label>

                        <input type="file" name="image" onchange="loadFile(event)" id="input_image11"  class="input_image form-control" required>
                                                <label class="custom-file-label" for="customFileLang">Select file</label>

                               <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">
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





            <div class="modal fade editClassModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form_update" method="POST" action="{{ route('admin.class_update') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="class_id" id="class_id">
                            <div class="modal-header">
                                <h4 class="modal-title">تعديل الصف</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" style="text-align:right">
                                    <label>اسم الصف بالعربية</label>
                                    <input type="text" name="class_name" class="form-control"
                                        value="" style="direction: rtl" id="name"
                                        placeholder="مثال :أول" maxlength="20" >
                                </div>

                                <div class="form-group" style="text-align:right">
                                    <label>اسم الصف بالانكليزية</label>
                                    <input type="text" name="class_name_en" id="name_en" class="form-control"
                                        value=""  
                                        placeholder="example :first" maxlength="20" required>
                                </div>

                                <div class="form-group" style="text-align:right">
                                    <label>المبلغ</label>
                                    <input type="number" name="annual_installment" id="cost" class="form-control"
                                        value="" style="direction: rtl"
                                        placeholder=""  required>
                                </div>



                                <div class="form-group" style="text-align:right">
                        <label>الصورة الأولى</label>
                        <br>
<input type="hidden" class="del" name="del_img1" value="del_img1" disabled="disabled">

<img src="" width="50px" height="50px" class="del_edit_img" id="image" alt="Not found" >
<span class="close-btn del_icon" title="الغاء" id="" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld">&times;</span>


<input type="file" name="image" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image1" lang="en">
<label class="custom-file-label" for="customFileLang">Select file</label>


<span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>
<img id="output" class="output" style=" display: none"src=""  width="200px" alt="">

                                </div>



                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                                <button class="btn btn-info">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <div class="modal fade deleteEmployeeModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="form_delete" method="POST">
                                        @csrf
                                        @method('delete')
                                        <div class="modal-header">
                                            <h4 class="modal-title">Delete element</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
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

$('.delete').on('click', function () {
    var id = $(this).data('id');
    var url = "{{URL::to('SMARMANger/admin/students')}}";
    $('#form_delete').attr("action", url);


});



$('.edit').on('click', function () {
    var id = $(this).data('id');
    var name=$(this).data('name');
    var name_en=$(this).data('name_en');
var image=$(this).data('image');
    var cost=$(this).data('cost');
    $('#class_id').val(id);
    $('#name').val(name);
    $('#name_en').val(name_en);
    $('#image').attr('src',`{{asset('storage/${image}')}}`);
    $('#cost').val(cost);




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
