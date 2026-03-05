@extends('admin.layouts.app')
<!--@section('search')
<!--<form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
<!--    <div class="form-group mb-0">
<!--      <div class="input-group input-group-alternative input-group-merge">
<!--        <div class="input-group-prepend">
<!--          <span class="input-group-text"><i class="fas fa-search"></i></span>
<!--        </div
<!--        <input class="form-control" name="search_teacher" id="search_teacher" placeholder="Search" type="text">
<!--      </div>
<!--    </div>
<!--    <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
<!--      <span aria-hidden="true">×</span>
<!--    </button>
<!--  </form>
<!--@endsection-->
@section('content')
<div class="col" style="direction:rtl; text-align:right">
    <div class="card">
<!--@if(session()->has('success'))-->


<!--  <div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
<!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--     {{ session()->get('success') }}-->
<!--    </div>-->
<!--@endif-->

            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">الفيديو الرئيسي</h3>

            </div>
<div class="table-responsive">
    <!--<a href=".createTermModal" class=" btn btn-success" data-toggle="modal"-->
    <!--data-id=""><i class="material-icons" data-toggle="tooltip">Create Video</i></a>-->

              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <!--<th scope="col" class="sort" data-sort="name">Id</th>-->
                    <th scope="col" class="sort" data-sort="budget">Youtube</th>
                    <th scope="col" class="sort" data-sort="status">Video</th>
                    <th scope="col" class="sort" data-sort="completion">Action</th>

                  </tr>
                </thead>
                <tbody class="list" id="mydiv">



               <tr>
                    <!--<th scope="row">-->

                    <!--{{ $video->id}}-->

                    <!--</th>-->
                    <td class="budget">

                    {{ $video->youtube }}

                  </td>

                  <td class="budget">

                    {{ $video->video }}

                  </td>

                  <td class="budget">


                    <a href=".updateVideoModal" class=" btn btn-success" data-toggle="modal"
                    data-id=""><i class="material-icons" data-toggle="tooltip">تعديل</i></a>

                  </td>





                  </tr>






                </tbody>
              </table>

            </div>









    </div></div>
    
    
    

            <div class="modal fade updateVideoModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form_update" action="{{ route('admin.video_update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="video_id" value="{{ $video->id }}">
                            <div class="modal-header">
                                <h4 class="modal-title">Update Video</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label>Link Youtube</label>

                                    <input type="text" maxlength="255" name="youtube" id="youtube" class="form-control">

                                </div>


                                <div class="form-group">
                                    <label>Video</label>

                                    <input type="file" name="video" id="video" class="form-control">

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



                <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

                <script>

$(document).ready(function () {

var youtube="";
var video="";

$('#youtube').on('click',function(){

video=$('#video').val();

if(video != ""){

    $('#video').val("");
}



    });

$('#video').on('click',function(){

youtube=$('#youtube').val();

if(youtube != ""){

    $('#youtube').val("");
}



    });



});

</script>


@endsection
