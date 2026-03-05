@extends('admin.master')
@section('style')

<style>
.content-body{
        min-height: 0px !important;
}


</style>
       @endsection
         @section('breadcrumbs')

         <nav class="breadcrumbs">

            <a class="breadcrumbs__item is-active">  الرسائل</a>
            <a href="{{ route('websitecontactus') }}" class="breadcrumbs__item "> اتصل بنا</a>
            <a href="{{ route('websitecontroller') }}" class="breadcrumbs__item ">قسم التحكم الكامل بالموقع</a>
            <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
        </nav>

@endsection
@section('content')
<br><br>
<div class="col" style="direction:rtl;text-align:right">
    <div class="card">
<!--@if(session()->has('success'))-->


<!--  <div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
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
              <h3 class="mb-0">جدول التواصل</h3>

            </div>
<div class="table-responsive">



  <table class="table align-items-center table-bordered" id="table_xx"  style="color: black; text-align:center">
    <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">الرقم</th>-->
                    <th  style="text-align: center;">الاسم</th>
                    <th  style="text-align: center;">البريد الالكتروني</th>


                    <th  style="text-align: center;">الموضوع</th>

                    <th  style="text-align: center;">الرسالة</th>

                    <th  style="text-align: center;">الإجابة</th>
                    <th  style="text-align: center;">تاريخ الارسال </th>
                    <th  style="text-align: center;">اظهار على الموقع  </th>
                    <th  style="text-align: center;">العملية</th>
                  </tr>
                </thead>
                <tbody class="list" id="mydiv">
                  @foreach ($contacts as $item)

                  <tr id="contact_{{ $item->id }}">
                       <!--<th scope="row">-->
                       <!--{{$item->id}}-->
                       <!--</th>-->
                       <td >
                       {{$item->name}}

                     </td>

                     <td >
                       {{$item->email}}

                     </td>




                     <td >
                       {{$item->subject}}

                     </td>


                     <td >
                         <!--<textarea name="" id="" cols="30" rows="5" disabled>-->
                              {{$item->message_ar}}
                              <!--</textarea>-->


                     </td>


                     <td >
                       <!--<textarea name="" id="" cols="30" rows="5" disabled> -->
                       {{$item->answer_ar}}
                       <!--</textarea>-->


                   </td>
                     <td >
                       <!--<textarea name="" id="" cols="30" rows="5" disabled> -->
                       {{$item->created_at}}
                       <!--</textarea>-->


                   </td>

                   <td style="vertical-align: initial;" >
                    @if($item->type==1)
                    <i class="fa fa-check" aria-hidden="true" style="color: green"></i>
                    @endif


                  </td>

                       <td class="text-right">

                           <a class="delete_contact one" data-id="{{ $item->id }}"

                       href=".active_result" data-toggle="modal"
                             > <i style="font-size: 30px; color: red" class="ni ni-fat-remove"></i>
                           </a>

                           <a href=".AnswerModal" class=" btn btn-success answer btn-sm" data-toggle="modal"
                           data-id="{{ $item->id }}"
                           data-question_ar="{{ $item->message_ar }}"
                           data-question_en="{{ $item->message_en }}"
                           data-answer_ar="{{ $item->answer_ar }}"
                           data-answer_en="{{ $item->answer_en }}"
                           data-type="{{ $item->type }}"

                           >Answer</a>

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
                            {{ $contacts->links() }}
                        </div>
                    </div>
                </div>



    </div></div>




    <div class="modal fade AnswerModal">
      <div class="modal-dialog">
          <div class="modal-content">
              <form id="form_update" action="{{ route('contact.answer') }}" method="POST" enctype="multipart/form-data">
                  @csrf

                  <div class="modal-header" style="direction: ltr">
                      <h4 class="modal-title">إجابة عن السؤال</h4>
                      <button type="button" class="close" data-dismiss="modal"
                          aria-hidden="true">&times;</button>
                  </div>

                  <div class="modal-body" style="text-align: right">
                      <div class="form-group">
                          <label>السؤال بالعربية</label>

                              <textarea name="message_ar" style="direction: rtl" cols="30" maxlength="255" rows="3"
                               required class="form-control question_ar">
                              </textarea>
                      </div>

                          <div class="form-group">
                              <label>السؤال بالإنكليزية</label>

                                  <textarea name="message_en"  style="width: 100%"  cols="30" maxlength="255" rows="3"
                                   required class="form-control question_en">
                                  </textarea>
                          </div>


                      <div class="form-group">
                          <label>الإجابة بالعربية</label>

                              <textarea name="answer_ar" style="direction: rtl" cols="30" maxlength="255" rows="3"
                               required class="form-control answer_ar">
                              </textarea>
                      </div>


                      <div class="form-group">
                          <label>الإجابة بالإنكليزية</label>

                              <textarea name="answer_en" cols="30" maxlength="255" rows="3"
                               required class="form-control answer_en">
                              </textarea>
                      </div>
                      <div class="form-group" >
                        <label> اظهار في   الموقع </label>
                       <input type="checkbox" class="type" name="type">
                    </div>

                      <input type="hidden" name="contact_id" id="contact_id">

                  </div>

                  <div class="modal-footer">
                      <a class="btn btn-default" data-dismiss="modal">الغاء</a>
                      <button class="btn btn-info">حفظ</button>
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
              <a  class="btn btn-white delete_event" id="delete_event" data-id="" href="">Ok, Got it</a>
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
$('.delete_event').attr('href',`{{ route('admin.contact.delete') }}`);

$('.delete_event').data('id',id);

});



$(document).on('click','.delete_event',function(e){
    var id=$(this).data('id');

e.preventDefault();
$.ajax({

    type:'post',
    url:"{{ route('admin.contact.delete') }}",
    enctype:'multipart/form-data',
    data:{
        '_token':"{{ csrf_token() }}",
        'id':id,

    },
    success:function(data){
$(`#contact_${id}`).remove();


$('.close').click();
        $(".modal").modal('hide');

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


$(document).ready(function () {



$('.answer').on('click',function(){

var contact_id= $(this).data('id');
$('#contact_id').val(contact_id);
$('.question_ar').val($(this).data('question_ar'));
    $('.question_en').val($(this).data('question_en'));
    $('.answer_ar').val($(this).data('answer_ar'));
    $('.answer_en').val($(this).data('answer_en'));
    if($(this).data('type')){
    $('.type').attr( 'checked', true )
 }
 else{
    $('.type').removeAttr('checked');
 }
});
});
</script>

@endsection
