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

    <a  class="breadcrumbs__item is-active">  اعلان عن وظيفة   </a>

    <a  href="{{ route('websitejob') }}" class="breadcrumbs__item ">قسم   الوظائف</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection
@section('content')
{{-- <div class="col" > --}}
    <div class="card" style="direction:rtl; text-align:right;margin: 20px;">



<div class="alert alert-success alert-dismissible" id="success2" role="alert" style="text-align: right;  display: none; font-size: 30px">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     {{ session()->get('success') }}
    </div>


            <div class="card-header border-0">
              <h3 class="mb-0">جدول الوظائف </h3>
            </div>

    <div class="table-responsive">
        
        @can('create_work')
<a href=".createNewsModal" class=" btn btn-success" data-toggle="modal"
    data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء   فرصة عمل  </i></a>
    @endcan


              <table class="table align-items-center table-bordered" id="table_xx"  style="color: black; text-align:center">
                <thead class="thead-light">
                  <tr >
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th   style="text-align: center;
                    color: black;"> العنوان بالعربي </th>
            <th style="text-align: center;
            color: black;" > العنوان بالانكليزي  </th>

                    <th  style="text-align: center;
                    color: black;">  المحتوى  بالعربي </th>

                    <th  style="text-align: center;
                    color: black;"> المحتوى بالانكليزي</th>
                     <th style="text-align: center;
                     color: black;">       تاريخ  الانشاء  </th>
                     <th  style="text-align: center;
                     color: black;">  اظهار على الموقع</th>
                    

                    {{-- <th style="text-align: center;
                    color: black;">   حذف </th> --}}

                    <th style="text-align: center;
                    color: black;">   تعديل </th>

                  </tr>
                </thead>
                <tbody class="list">
                @foreach ($jobs as $item)

               <tr id="news_{{ $item->id }}">



                <td style="vertical-align: initial;" >
                     {{$item->title_ar}}



                  </td>

                  <td style="vertical-align: initial;" >
                     {{$item->title_en}}


                  </td>

                  <td style="vertical-align: initial;" >
                    {{$item->description_ar}}



                  </td>
                  <td style="vertical-align: initial;" >
                    {{$item->description_en}}
                  </td>
                  <td style="vertical-align: initial;" >
                    {{$item->created_at	}}
                  </td>
                  <td style="vertical-align: initial;" >
                    @if($item->type==0)
                    <i class="fa fa-check" aria-hidden="true" style="color: green"></i>
                    @endif


                  </td>


      {{-- <td class="delete"> <a class="delete_news one" data-id="{{ $item->id }}"

                    href=".active_result" data-toggle="modal"> حذف
                    </a>

         </td> --}}
   <td style="vertical-align: initial;" >
        @can('edit_work')
                    <a class="edit_news btn btn-success btn-sm"
                    data-title_ar="{{ $item->title_ar }}"
                    data-title_en="{{ $item->title_en }}"
                    data-content_ar="{{ $item->description_ar }}"
                    data-content_en="{{ $item->description_en }}"
                    data-type="{{ $item->type }}"

                    data-id="{{ $item->id }}"
                    href=".editNewsModal" data-toggle="modal">تعديل</i>
                    </a>
                    @endcan

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
                            {{ $jobs->links() }}
                        </div>
                    </div>
            </div>


    </div>
{{-- </div> --}}



<div class="modal fade editNewsModal"style="text-align: end;" >
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_update" action="{{ route('job.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header" style="direction: ltr;">
                    <h4 class="modal-title">تعديل على الفرصة   </h4>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="text-align: right;">
                    <input type="hidden" name="job_id" id="news_id" value="">

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

                        <textarea class="form-control" style="direction:rtl" maxlength="255" id="content_ar" name="description_ar" cols="30" rows="4" ></textarea>
                    </div>

                    <div class="form-group">
                        <label>المحتوى بالإنكليزية</label>

                        <textarea class="form-control" maxlength="255" id="content_en" name="description_en" cols="30" rows="4" ></textarea>
                    </div>
                    <div class="form-group">
                        <label> اظهار في  الموقع  </label>
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
            <form id="form_update" action="{{ route('job.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header" style="direction: ltr">
                    <h4 class="modal-title">إنشاء   فرصة عمل</h4>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="text-align: right">
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
                        <label>المحتوى   بالعربي</label>

                        <textarea class="form-control" maxlength="255" name="description_ar" style="direction:rtl" id="" cols="30" rows="4" required></textarea>
                    </div>


                    <div class="form-group">
                        <label>المحتوى   بالانكليزية</label>

                        <textarea class="form-control" maxlength="255" name="description_en" id="" cols="30" rows="4" required></textarea>
                    </div>


                    <div class="form-group">
                        <label> اظهار في  الموقع  </label>
                       <input type="checkbox"  name="type">
                    </div>

                        <div class="modal-footer">
                            <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                            <button class="btn btn-info">حفظ</button>
                        </div>
                </div>
            </form>
        </div>
    </div>
</div>







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



$('#news_id').val(id);
$('#title_ar').val($(this).data('title_ar'));
$('#title_en').val($(this).data('title_en'));

$('#content_ar').val($(this).data('content_ar'));
$('#content_en').val($(this).data('content_en'));

 if($(this).data('type')==0){
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
