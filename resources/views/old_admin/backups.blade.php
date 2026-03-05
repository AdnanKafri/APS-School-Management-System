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

            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">جدول النسخ الاحتياطية</h3>

            </div>
<div class="table-responsive">
    <a href="{{ route('admin.get-backup') }}" class=" btn btn-success"
    data-id=""><i class="material-icons" data-toggle="tooltip">انشاء نسخة جديدة </i></a>

              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget">الملف</th>
                    <th scope="col" class="sort" data-sort="status">تاريخ الانشاء</th>
                    <th scope="col" class="sort" data-sort="status">العمليات </th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">
                @foreach ($backups as $item)

               <tr id="lesson_{{$item->id}}">

                    <td class="budget">
                        
                        
                        <a href="{{ route('admin.zip',$item) }}"><i class="fa fa-download fa-3x"></i></a>
              

                  </td>

                    <td class="budget">
                    {{$item->created_at}}

                  </td>
                  
                  
                  <td class="budget">

  <a  data-id="{{ $item->id }}" class="one"
                    href=".active_result" data-toggle="modal">
                         <i style="font-size: 30px; color: red" class="ni ni-fat-remove"></i>
                    </a>
                    
                    <!--<form action="{{ route('admin.backup_del',$item->id) }}" method="post">-->
                    <!--    @csrf-->
                    <!--    <button class="btn btn-danger brn-sm"><i class="fa fa-trash fa-2x"></i></button>-->
                    <!--</form>-->
                  </td>




                  </tr>


               @endforeach



                </tbody>
              </table>

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
              <h6 class="modal-title" id="modal-title-notification">يرجى الانتباه</h6>
              <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true" class="close">×</span>
              </a>
          </div>

          <div class="modal-body">

              <div class="py-3 text-center">
                  <i class="ni ni-bell-55 ni-3x"></i>
                  <h4 class="heading mt-4">! يجب ان تقرأ هذا</h4>
                  <p>هل انت متاكد من حذف هذا العنصر ؟</p>
              </div>

          </div>

          <div class="modal-footer">
              <a  class="btn btn-white delete_event" id="delete_event" data-id="" href="">نعم , موافق</a>
              <a class="btn btn-link text-white ml-auto" data-dismiss="modal">الغاء</a>
          </div>
        </form>
      </div>
  </div>
</div>

</div>






                <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>


<script>
    $(document).on('click' , '.one' , function () {

var id=$(this).data('id');


$('.delete_event').data('id',id);

});

$(document).on('click','.delete_event',function(e){
    e.preventDefault();

    var id=$(this).data('id');

$.ajax({

    type:'post',
    url:"{{ route('admin.backup_del') }}",
    enctype:'multipart/form-data',
    data:{
        '_token':"{{ csrf_token() }}",
        'id':id,

    },

    success:function(data){
$(`#lesson_${id}`).remove();
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

});


});
    
</script>


@endsection
