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
@section('content')
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
              <h3 class="mb-0">جدول المتقدمين</h3>

            </div>
<div class="table-responsive">



              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget">المسمى الوظيفي</th>

                    <th scope="col" class="sort" data-sort="budget">الاسم</th>
                    <th scope="col" class="sort" data-sort="status">الكنية</th>
                    <th scope="col" class="sort" data-sort="budget">البريد الإلكتروني</th>
                    <th scope="col" class="sort" data-sort="status">الهاتف</th>

                    <th scope="col" class="sort" data-sort="status">الملف</th>
                    <th scope="col" class="sort" data-sort="completion">العمليات</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">
                @foreach ($applicants as $item)

               <tr id="applicant_{{ $item->id }}">
                    <!--<th scope="row">-->
                    <!--{{$item->id}}-->
                    <!--</th>-->
                    <td class="budget">
                        {{$item->job['title_ar']}}

                      </td>
                    <td class="budget">
                    {{$item->first_name}}

                  </td>

                  <td class="budget">
                    {{$item->last_name}}

                  </td>

                  <td class="budget">
                    {{$item->email}}

                  </td>

                  <td class="budget">
                    {{$item->phone}}

                  </td>

                  <td>

            <a href="{{ asset('storage/'.$item->file) }}" >

                @if ($item->extension=='docx')
            <img src="{{ asset('students/images/docx.jpg') }}" width="50px" height="50px" alt="">
            @else
            <img src="{{ asset('students/images/pdf.png') }}" width="50px" height="50px" alt="">

                @endif

            </a>


                  </td>



                  <td class="text-right">

                    <a class="one delete_applicant" 
                    data-id="{{ $item->id }}" 
                    href=".active_result" data-toggle="modal"> <i style="font-size: 30px; color: red" class="ni ni-fat-remove"></i>
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
                            {{ $applicants->links() }}
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

                <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>






                <script>
$('.alert-success').hide(5000);



$(document).on('click' , '.one' , function () {

var id=$(this).data('id');
$('.delete_event').attr('href',`{{ route('admin.applicant.delete') }}`);

$('.delete_event').data('id',id);

});


                $(document).on('click','.delete_event',function(e){
                    var id=$(this).data('id');
                e.preventDefault();
                $.ajax({

                    type:'post',
                    url:"{{ route('admin.applicant.delete') }}",
                    enctype:'multipart/form-data',
                    data:{
                        '_token':"{{ csrf_token() }}",
                        'id':id,

                    },
                    success:function(data){
                $(`#applicant_${id}`).remove();




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



                </script>


@endsection
