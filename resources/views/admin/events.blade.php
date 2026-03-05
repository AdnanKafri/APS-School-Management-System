@extends('admin.master')
<!--@section('search')
<!--<form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">-->
<!--    <div class="form-group mb-0">-->
<!--      <div class="input-group input-group-alternative input-group-merge">-->
<!--        <div class="input-group-prepend">-->
<!--          <span class="input-group-text"><i class="fas fa-search"></i></span>-->
<!--        </div>-->
<!--        <input class="form-control" name="search_teacher" id="search_teacher" placeholder="Search" type="text">-->
<!--      </div>-->
<!--    </div>-->
<!--    <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">-->
<!--      <span aria-hidden="true">×</span>-->
<!--    </button>-->
<!--  </form>-->
<!--@endsection-->
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
<div class="col" style="direction:rtl;text-align:right">
    <div class="card">
<!--@if(session()->has('success'))-->


<!--  <div class="alert alert-success alert-dismissible" id="success" role="alert" style="text-align: right; font-size: 30px">-->
<!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--     {{ session()->get('success') }}-->
<!--    </div>-->
<!--@endif-->

<!--<div class="alert alert-success alert-dismissible" id="success2" role="alert" style="text-align: right;  display: none; font-size: 30px">-->
<!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--     {{ session()->get('success') }}-->
<!--    </div>-->

            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">جدول الأحداث</h3>

            </div>
<div class="table-responsive">
    <a href=".createEventModal" class=" btn btn-success" data-toggle="modal"
    data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء حدث جديد</i></a>

              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">الرقم</th>-->
                    <th scope="col" class="sort" data-sort="budget">العنوان</th>
                    <th scope="col" class="sort" data-sort="status">المحتوى</th>
                    <th scope="col" class="sort" data-sort="status">الصورة</th>
                    <th scope="col" class="sort" data-sort="status">العنوان</th>

                    <th scope="col" class="sort" data-sort="status">وقت البداية</th>
                    <th scope="col" class="sort" data-sort="status">وقت النهاية</th>

                    <th scope="col" class="sort" data-sort="completion">العملية</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">
                @foreach ($events as $item)

               <tr id="event_{{ $item->id }}">
                    <!--<th scope="row">-->
                    <!--{{$item->id}}-->
                    <!--</th>-->
                    <td class="budget">
                    {{$item->header_ar}}

                  </td>

                  <td class="budget">
                  

                        {{$item->content_ar}}



                  </td>



                  <td class="budget">

                    @if ($item->image != null)
                    <img src="{{ asset('storage/'.$item->image) }}" width="50px" height="50px">
                    @endif
                  </td>


                  <td class="budget">
                    {{$item->address_ar}}

                  </td>

                  <td class="budget">
                    {{$item->start_time}}

                  </td>


                  <td class="budget">
                    {{$item->end_time}}

                  </td>


                  <td>
                      
                  <a class="edit_event btn btn-success btn-sm"
                    data-header_ar="{{ $item->header_ar }}"
                    data-content_ar="{{ $item->content_ar }}"
                    data-header_en="{{ $item->header_en }}"
                    data-content_en="{{ $item->content_en }}"

                    data-address_ar="{{ $item->address_ar }}"
                    data-address_en="{{ $item->address_en }}"

                    data-start_time="{{ $item->start_time }}"
                    data-end_time="{{ $item->end_time }}"

                    data-image="{{ $item->image }}"


                    data-id="{{ $item->id }}"
                    href=".editEventModal" data-toggle="modal">تعديل</i>
                    </a>


                    <a  data-id="{{ $item->id }}" class="one"
                    href=".active_result" data-toggle="modal">
                         <i style="font-size: 30px; color: red" class="ni ni-fat-remove"></i>
                    </a>
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
                            {{ $events->links() }}
                        </div>
                    </div>
                </div>



    </div></div>







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
              <a  class="btn btn-white delete_event" id="delete_event" data-id="" href="">Ok, Got it</a>
              <a class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</a>
          </div>
        </form>
      </div>
  </div>
</div>

</div>





            <div class="modal fade editEventModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form_update" action="{{ route('admin.events.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header">
                                <h4 class="modal-title">تحديث صفحة الأخبار</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="event_id" value="">

                                <div class="form-group">
                                    <label>العنوان بالعربية</label>
                                    <input type="text" id="header_ar" name="header_ar" class="form-control"
                                        value=""  maxlength="100" style="text-align:right"
                                        placeholder="" >
                                </div>

                                <div class="form-group">
                                    <label>العنوان بالإنكليزية</label>
                                    <input type="text" id="header_en" name="header_en" class="form-control"
                                        value=""  maxlength="100" style="text-align:left"
                                        placeholder="" >
                                </div>

                                {{-- ----------------- --}}
                                <div class="form-group">
                                    <label>المحتوى بالعربية</label>

                                    <textarea class="form-control" maxlength="255" id="content_ar" style="text-align:right" name="content_ar" cols="30" rows="4" ></textarea>
                                </div>

                                <div class="form-group">
                                    <label>المحتوى بالإنكليزية</label>

                                    <textarea class="form-control" maxlength="255" id="content_en" name="content_en" cols="30" rows="4" ></textarea>
                                </div>


                                {{-- ------------------- --}}

                                <div class="form-group">
                                    <label>وقت البداية</label>

                                    <input type="datetime-local" name="start_time" id="start_time" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>وقت البداية</label>

                                    <input type="datetime-local" name="end_time" id="end_time" class="form-control" required>
                                </div>

                                <div class="form-group" id="div_image">
                                    <label>الصورة</label>
                                    <br>
                                    
        <img src="" width="50px" height="50px" class="del_edit_img" id="image" alt="Not found" >
                        <span class="del_icon" title="الغاء" id="" style ="display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointerld"></span>


                        <input type="file" name="image" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image1" lang="en">
                        <label class="custom-file-label" for="customFileLang">Select file</label>


                            <span class="close-btn del_img" title="الغاء" id="" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">

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




<div class="modal fade createEventModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_update" action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h4 class="modal-title">إنشاء حدث جديد</h4>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>العنوان بالعربية</label>
                        <input type="text" name="header_ar" class="form-control"
                            value=""  maxlength="100" style="direction: rtl"
                            placeholder="" required>
                    </div>

                    <div class="form-group">
                        <label>العنوان بالانكليزية</label>
                        <input type="text" name="header_en" class="form-control"
                            value=""  maxlength="100" style="text-align:left"
                            placeholder="" required>
                    </div>

                    {{-- -------------- --}}
                    <div class="form-group">
                        <label>المحتوى بالعربية</label>

                        <textarea class="form-control" maxlength="255" name="content_ar" style="text-align:right" id="" cols="30" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>المحتوى بالانكليزية</label>

                        <textarea class="form-control" maxlength="255" name="content_en" id="" style="text-align:left" cols="30" rows="4" required></textarea>
                    </div>

                    {{-- -------------------- --}}

                    <div class="form-group">
                        <label>الصورة</label>

                        <input type="file" name="image" onchange="loadFile(event)" id="input_image11"  class="input_image form-control" required>
                                                <label class="custom-file-label" for="customFileLang">Select file</label>

                               <span class="close-btn del_img" title="الغاء" id="del_img" style="display: none; font-weight:bold">&times;</span>
                            <img id="output" style=" display: none"src="" class="output"  width="200px" alt="">
                    </div>

               {{-- -------------- --}}
               <div class="form-group">
                <label>المكان بالعربية</label>

                <input type="text" name="address_ar" class="form-control"
                value=""  maxlength="100" style="direction: rtl" 
                placeholder="" required>

            </div>

            <div class="form-group">
                <label>المكان بالانكليزية</label>

                <input type="text" name="address_en" class="form-control"
                value=""  maxlength="100" style="text-align:left"
                placeholder="" required>
                </div>

            {{-- -------------------- --}}
                    <div class="form-group">
                        <label>وقت البداية</label>

                        <input type="datetime-local" name="start_time" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>وقت البداية</label>

                        <input type="datetime-local" name="end_time" class="form-control" required>
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




<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

<script>

$('.alert-success').hide(5000);

$(document).on('click' , '.one' , function () {

var id=$(this).data('id');
$('.delete_event').attr('href',`{{ route('admin.event.delete') }}`);

$('.delete_event').data('id',id);

});

$(document).on('click','.delete_event',function(e){
    var id=$(this).data('id');
e.preventDefault();
$.ajax({

    type:'post',
    url:"{{ route('admin.event.delete') }}",
    enctype:'multipart/form-data',
    data:{
        '_token':"{{ csrf_token() }}",
        'id':id,

    },
    success:function(data){
$(`#event_${id}`).remove();


document.getElementById('success2').innerText="Deleted Successfully !";
$('.close').click();

swal({
  title: "حسناً",
  text: "! تمت العملية بنجاح",
  icon: "success",
  button: "OK",
  timer: 2000

});

    },
    error: function (xhr) {

}

})


});



$(document).on('click','.edit_event',function(e){
    var id=$(this).data('id');
e.preventDefault();

var image=$(this).data('image');
console.log(image);
$('#event_id').val(id);
$('#header_ar').val($(this).data('header_ar'));
$('#header_en').val($(this).data('header_en'));

$('#content_ar').val($(this).data('content_ar'));
$('#content_en').val($(this).data('content_en'));
var start_time = ($(this).data('start_time') + '').replace(' ','T');
var end_time = ($(this).data('end_time') + '').replace(' ','T');

  $("#start_time").val(start_time);

$('#end_time').val(end_time);

if (image!="") {
    console.log(image);
        $('#image').attr('src',`{{ asset('storage/${image}') }}`);

}else{
    
  $('#image').hide();
  $('#del_img1').hide();
  
}


});












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

        });

</script>

<script>
document.
    var loadFile1 = function(event) {
        console.log(event.id);
      var output = document.getElementById('output1');
      output.src = URL.createObjectURL(event.target.files[0]);
      output.onload = function() {
document.getElementById('output1').setAttribute('style','display:inline');
document.getElementById('del_img').setAttribute('style','display:inline;font-size: 44px; color:red;font-weigh:bold;cursor:pointer');

        URL.revokeObjectURL(output.src) // free memory
      }
    };


    $(document).on('click' , '#del_img' , function () {


$('#output1').attr('style','display:none;');
$('#input_image1').val('');
$(this).hide();


    });
    
    $(document).on('click' , '#del_img1' , function () {

$('#div_image').append(`
<input type="hidden" name="del_img1" value="del_img1">

`)
$('#image').attr('style','display:none;');
$(this).hide();


    });

  </script>
@endsection
