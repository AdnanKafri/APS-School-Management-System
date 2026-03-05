@extends('admin.layouts.app')
@section('search')


@endsection
@section('content')

<!--@if(session()->has('success'))-->

<!--  <div class="alert alert-success alert-dismissible" role="alert" style="text-align: right; font-size: 30px">-->
<!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--     {{ session()->get('success') }}-->
<!--    </div>-->
<!--@endif-->



<div class="row" style="direction:rtl;text-align:right">



      <div class="col-xl-12 order-xl-1">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
              <div class="col-8">
                <h3 class="mb-0">تعديل صفحة من نحن </h3>
              </div>


            </div>
          </div>





          <div class="card-body">
            <form method="post" action="{{ route('admin.about_us.store',$about_us->id) }}" enctype="multipart/form-data">
                @csrf
                @method('put')





            <div class="col-lg-12">
                <div class="form-group">
                <label class="form-control-label" for="input-first-name">العنوان بالعربية</label>
                <input type="text" id=""  style="direction: rtl" name="header_ar" maxlength="100" class="form-control" value="{{ $about_us->header_ar }}">
                </div>
            </div>


            <div class="col-lg-12">
                <div class="form-group">
                <label class="form-control-label" for="input-first-name">العنوان بالإنكليزية</label>
                <input type="text" id="" name="header_en" maxlength="100" class="form-control"  style="text-align:left"  value="{{ $about_us->header_en }}">
                </div>
            </div>


            <div class="col-lg-12">
                <div class="form-group">
                <label class="form-control-label" for="input-first-name">المحتوى بالعربية</label>

                <textarea name="content_ar" style="direction: rtl" id="" maxlength="600" cols="30" class="form-control" rows="4">{{ $about_us->content_ar }}</textarea>

                </div>
            </div>


            <div class="col-lg-12">
                <div class="form-group">
                <label class="form-control-label" for="input-first-name">المحتوى بالإنكليزية</label>

                <textarea name="content_en" id="" maxlength="600" cols="30" style="text-align:left" class="form-control" rows="4">{{ $about_us->content_en }}</textarea>

                </div>
            </div>

              <div class="pl-lg-4 col-md-12">
                <div class="form-group">
                    <label class="form-control-label" for="input-country">الصورة</label>
                    @if ($about_us->image!=null)

                <img src="{{ asset('storage/'.$about_us->image) }}" width="100%" alt="">
                @endif

                    <input type="file" name="image"  class="form-control">
                </div>
              </div>



              <!--<div class="pl-lg-4 col-md-12">-->
              <!--  <div class="form-group">-->
              <!--      <label class="form-control-label" for="input-country">الصورة الموجودة اعلى هذه الصفحة</label>-->
              <!--      @if ($about_us->image_slider_top!=null)-->

              <!--  <img src="{{ asset('storage/'.$about_us->image_slider_top) }}" width="100%" alt="">-->
              <!--  @endif-->

              <!--      <input type="file" name="image_slider_top"  class="form-control">-->
              <!--  </div>-->
              <!--</div>-->


              <!--<div class="pl-lg-4 col-md-12">-->
              <!--  <div class="form-group">-->
              <!--      <label class="form-control-label" for="input-country">الصورة الموجودة أسفل هذه الصفحة</label>-->
              <!--      @if ($about_us->image_slider_bottom!=null)-->

              <!--  <img src="{{ asset('storage/'.$about_us->image_slider_bottom) }}" width="100%" alt="">-->
              <!--  @endif-->

              <!--      <input type="file" name="image_slider_bottom"  class="form-control">-->
              <!--  </div>-->
              <!--</div>-->


  <div class="col-lg-12">
    <div class="form-group">
      <label class="form-control-label" for="input-first-name">منهجنا بالعربية</label>

      <textarea name="mission_ar" style="direction: rtl" maxlength="400" id="" cols="30" class="form-control" rows="4">{{ $about_us->mission_ar }}</textarea>

    </div>
  </div>


  <div class="col-lg-12">
    <div class="form-group">
      <label class="form-control-label" for="input-first-name">منهجنا بالإنكليزية</label>

      <textarea name="mission_en" maxlength="400" id="" cols="30" style="text-align:left" class="form-control" rows="4">{{ $about_us->mission_en }}</textarea>

    </div>
  </div>

  {{-- ------------------------- --}}

  <div class="col-lg-12">
    <div class="form-group">
      <label class="form-control-label" for="input-first-name">رؤيتنا بالعربية</label>

      <textarea name="vission_ar" style="direction: rtl" maxlength="400" id="" cols="30" class="form-control" rows="4">{{ $about_us->vission_ar }}</textarea>

    </div>
  </div>

  <div class="col-lg-12">
    <div class="form-group">
      <label class="form-control-label" for="input-first-name">رؤيتنا بالإنكليزية</label>

      <textarea name="vission_en" maxlength="400" id="" cols="30" style="text-align:left" class="form-control" rows="4">{{ $about_us->vission_en }}</textarea>

    </div>
  </div>

  {{-- --------------------- --}}


  <div class="col-lg-12">
    <div class="form-group">
      <label class="form-control-label" for="input-first-name">أهدافنا بالعربية</label>

      <textarea name="objective_ar" maxlength="400" id="" cols="30" class="form-control" rows="4">{{ $about_us->objective_ar }}</textarea>

    </div>
  </div>



  <div class="col-lg-12">
    <div class="form-group">
      <label class="form-control-label" for="input-first-name">أهدافنا بالإنكليزية</label>

      <textarea name="objective_en" style="direction: rtl ;text-align:left" maxlength="400" id="" cols="30" class="form-control" rows="4">{{ $about_us->objective_en }}</textarea>

    </div>
  </div>

  {{-- ------------------ --}}



            <button class="btn btn-success btn-block" >تحديث </button>
            </form>
          </div>





    </div>
      </div>

</div>







<script src="{{ asset('students/js/jquery-3.2.1.min.js') }}"></script>

<script>
    
    $('.alert-success').hide(5000);

</script>
@endsection

