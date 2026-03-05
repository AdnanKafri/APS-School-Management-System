@extends('admin.layouts.app')
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
            [data-overlay]::before {

background-color: none !important;

}
</style>
</head>
@section('content')
<div class="col" style="direction:rtl;text-align:right">
    <div class="card">
@if(session()->has('success'))


  <div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     {{ session()->get('success') }}
    </div>
@endif

<div class="alert alert-success alert-dismissible" id="success2" role="alert" style="text-align: right;  display: none; font-size: 30px">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     {{ session()->get('success') }}
    </div>
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">فرص العمل</h3>

            </div>
<div class="table-responsive">
    <a href=".createJobModal" class=" btn btn-success" data-toggle="modal"
    data-id=""><i class="material-icons" data-toggle="tooltip">إنشاء فرصة عمل </i></a>

              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">الرقم</th>-->
                    <th scope="col" class="sort" data-sort="budget">العنوان</th>
                    <th scope="col" class="sort" data-sort="status">الوصف</th>
                    <th scope="col" class="sort" data-sort="completion">العملية</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">
                @foreach ($jobs as $item)

               <tr id="job_{{ $item->id }}">
                    <!--<th scope="row">-->
                    <!--{{$item->id}}-->
                    <!--</th>-->
                    <td class="budget">
                    {{$item->title_ar}}

                  </td>

                  <td class="budget">

                
                        {{$item->description_ar}}
       

                  </td>







                  <td class="text-right">
                    <a class="edit_job btn btn-success btn-sm"
                    data-title_ar="{{ $item->title_ar }}"
                    data-title_en="{{ $item->title_en }}"
                    data-description_ar="{{ $item->description_ar }}"
                    data-description_en="{{ $item->description_en }}"

                    data-id="{{ $item->id }}"
                    href=".editJobModal" data-toggle="modal">تعديل</i>
                    </a>

                    <a class="one delete_job" data-id="{{ $item->id }}"
                    href=".active_result" data-toggle="modal"
                 > <i style="font-size: 30px; color: red" class="ni ni-fat-remove"></i>
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
                            {{ $jobs->links() }}
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




            <div class="modal fade editJobModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form  action="{{ route('admin.job.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="job_id" id="job_id" value="">

                            <div class="modal-header">
                                <h4 class="modal-title">تحديث فرصة عمل </h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">


                                <div class="form-group">
                                    <label>المسمى الوظيفي بالعربية </label>
                                    <input type="text" name="title_ar" id="title_ar" class="form-control"
                                        value="" style="direction: rtl" maxlength="100"
                                        placeholder="اكتب المسمى الوظيفي" required>
                                </div>

                                <div class="form-group">
                                    <label>المسمى الوظيفي بالإنكليزية </label>
                                    <input type="text" name="title_en" id="title_en" class="form-control"
                                        value=""  maxlength="100"
                                        placeholder="Type job title" required>
                                </div>


                                <div class="form-group">
                                    <label> وصف العمل بالعربية </label>


                                        <textarea  id="description_ar" maxlength="600" style="direction: rtl" name="description_ar" class="form-control"
                                        cols="30" rows="5"  required>

                                        </textarea>
                                </div>


                                <div class="form-group">
                                    <label> وصف العمل بالإنكليزية </label>


                                        <textarea  maxlength="600" id="description_en" name="description_en" class="form-control"
                                        cols="30" rows="5"  required>

                                        </textarea>
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






            <div class="modal fade createJobModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form_update" action="{{ route('admin.job.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header">
                                <h4 class="modal-title">إنشاء فرصة عمل </h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">


                                <div class="form-group">
                                    <label>المسمى الوظيفي بالعربية </label>
                                    <input type="text" name="title_ar" class="form-control"
                                        value="" style="direction: rtl" maxlength="100"
                                        placeholder="اكتب المسمى الوظيفي" required>
                                </div>

                                <div class="form-group">
                                    <label>المسمى الوظيفي بالإنكليزية </label>
                                    <input type="text" name="title_en" class="form-control"
                                        value="" style="" maxlength="100"
                                        placeholder="Type job title" required>
                                </div>


                                <div class="form-group">
                                    <label> وصف العمل بالعربية </label>


                                        <textarea name="description_ar" style="direction: rtl" id="" maxlength="600"  class="form-control"
                                        cols="30" rows="5"  required>

                                        </textarea>
                                </div>


                                <div class="form-group">
                                    <label> وصف العمل بالإنكليزية </label>


                                        <textarea name="description_en"  id="" maxlength="600"  class="form-control"
                                        cols="30" rows="5"  required>

                                        </textarea>
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
$('.delete_event').attr('href',`{{ route('admin.job.delete') }}`);

$('.delete_event').data('id',id);

});
                $(document).on('click','.delete_event',function(e){
                    var id=$(this).data('id');
                e.preventDefault();
                $.ajax({

                    type:'post',
                    url:"{{ route('admin.job.delete') }}",
                    enctype:'multipart/form-data',
                    data:{
                        '_token':"{{ csrf_token() }}",
                        'id':id,

                    },
                    success:function(data){
                $(`#job_${id}`).remove();


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






                $(document).on('click','.edit_job',function(e){
    var id=$(this).data('id');
e.preventDefault();

var image=$(this).data('image');

$('#job_id').val(id);
$('#title_ar').val($(this).data('title_ar'));
$('#title_en').val($(this).data('title_en'));

$('#description_ar').val($(this).data('description_ar'));
$('#description_en').val($(this).data('description_en'));


});
                </script>


@endsection
