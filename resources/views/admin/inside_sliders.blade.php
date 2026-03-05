@extends('admin.master')
@section('search')


@endsection
@section('content')

<!--@if(session()->has('success'))-->

<!--  <div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
<!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--     {{ session()->get('success') }}-->
<!--    </div>-->
<!--@endif-->



<div class="row" style="direction:rtl; text-align:right">



      <div class="col-xl-12 order-xl-1">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
              <div class="col-8">
                <h3 class="mb-0">تعديل السلايدرات </h3>
              </div>


            </div>
          </div>





          <div class="card-body">
            <form method="post" action="{{ route('admin.inside_slider.store',$slider->id) }}" enctype="multipart/form-data">
                @csrf
                @method('put')







<div class="pl-lg-4 col-md-12">
    <div class="form-group">
        <label class="form-control-label" for="input-country"> صورة الأخبار</label>
        @if ($slider->news_image!=null)

    <img src="{{ asset('storage/'.$slider->news_image) }}" width="100%" alt="">
    @endif
                            <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">

        <input type="file" name="news_image" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image1">
        
        


    </div>
  </div>


  <div class="pl-lg-4 col-md-12">
    <div class="form-group">
        <label class="form-control-label" for="input-country"> صورة الاحداث</label>
        @if ($slider->events_image!=null)

    <img src="{{ asset('storage/'.$slider->events_image) }}" width="100%" alt="">
    @endif

        <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">

        <input type="file" name="events_image" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image2">
        
    </div>
  </div>

  <div class="pl-lg-4 col-md-12">
    <div class="form-group">
        <label class="form-control-label" for="input-country"> صورة المقالات</label>
        @if ($slider->blogs_image!=null)

    <img src="{{ asset('storage/'.$slider->blogs_image) }}" width="100%" alt="">
    @endif

                <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">

        <input type="file" name="blogs_image" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image3">
    </div>
  </div>


  <div class="pl-lg-4 col-md-12">
    <div class="form-group">
        <label class="form-control-label" for="input-country"> صورة من نحن</label>
        @if ($slider->about_image!=null)

    <img src="{{ asset('storage/'.$slider->about_image) }}" width="100%" alt="">
    @endif

                <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">

        <input type="file" name="about_image" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image4">
    </div>
  </div>



  <div class="pl-lg-4 col-md-12">
    <div class="form-group">
        <label class="form-control-label" for="input-country"> صورة فرص العمل</label>
        @if ($slider->jobs_image!=null)

    <img src="{{ asset('storage/'.$slider->jobs_image) }}" width="100%" alt="">
    @endif

                <img id="output" class="output" style=" display: none"src=""  width="200px" alt="">

        <input type="file" name="jobs_image" onchange="loadFile_edit(event)"  class="form-control input_image" id="input_edit_image5">
    </div>
  </div>


              <button class="btn btn-success btn-block" >تحديث </button>
            </form>
          </div>





    </div>
      </div>

</div>







<script src="{{ asset('students/js/jquery-3.2.1.min.js') }}"></script>


<script>
    // $('.alert-success').hide(5000);

        var loadFile_edit = function(event) {
       var id=event.target.id;
        var input_image=document.getElementById(id);
            var output=input_image.previousElementSibling;
            var old_image=input_image.previousElementSibling.previousElementSibling;
            old_image.setAttribute('style','display:none');
            input_image.previousElementSibling.previousElementSibling.setAttribute('style','display:none');

            output.setAttribute('src',URL.createObjectURL(event.target.files[0]));
            output.onload = function() {

              output.setAttribute('style','display:inline');
            };

    };

</script>
@endsection
