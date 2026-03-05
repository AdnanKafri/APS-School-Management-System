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
                <h3 class="mb-0">تعديل القسم السفلي للموقع Footer </h3>
              </div>


            </div>
          </div>





          <div class="card-body" style="width: 700px">
            <form method="post" action="{{ route('admin.footer_update',$footer->id) }}" enctype="multipart/form-data">
                @csrf
                @method('put')





            <div class="col-lg-12">
                <div class="form-group">
                <label class="form-control-label" for="input-first-name">المحتوى بالعربية</label>
                <textarea name="content_ar" id=""  maxlength="255" cols="30" class="form-control" rows="3">{{ $footer->content_ar }}</textarea>

                </div>
            </div>


            <div class="col-lg-12">
                <div class="form-group">
                <label class="form-control-label" for="input-first-name">المحتوى بالإنكليزية</label>
                <textarea name="content_en" id=""  maxlength="255" cols="30" style="text-align:left" class="form-control" rows="3">{{ $footer->content_en }}</textarea>

                </div>
            </div>




  <div class="col-lg-6">
    <div class="form-group">
      <label class="form-control-label" for="input-first-name">  مكان المدرسة بالعربية</label>

      <input type="text" name="address_ar" class="form-control" style="width: 500px" maxlength="100" value="{{ $footer->address_ar }}" id="">
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group">
      <label class="form-control-label" for="input-first-name">  مكان المدرسة بالإنكليزية</label>

      <input type="text" name="address_en" class="form-control" style="width: 500px;text-align:left" maxlength="100" value="{{ $footer->address_en }}" id="">
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-group">
      <label class="form-control-label" for="input-first-name">البريد الإلكتروني</label>

      <input type="email" maxlength="100" class="form-control"style="width: 500px;text-align:left"  name="email" value="{{ $footer->email }}" id="">
    </div>
  </div>


  <div class="col-lg-6">
    <div class="form-group">
      <label class="form-control-label" for="input-first-name">الهاتف</label>

      <input type="text" maxlength="20" class="form-control" style="width: 500px;text-align:left;direction:ltr" name="phone" value="{{ $footer->phone }}" id="">
    </div>
  </div>


  <div class="col-lg-6">
    <div class="form-group">
      <label class="form-control-label" for="input-first-name">رابط صفحة الفيسبوك</label>

      <input type="text" maxlength="255" class="form-control" style="width: 500px;text-align:left" name="facebook" value="{{ $footer->facebook }}" id="">
    </div>
  </div>



  <div class="col-lg-6">
    <div class="form-group">
      <label class="form-control-label" for="input-first-name">رابط صفحة التويتر</label>

      <input type="text" maxlength="255" class="form-control" style="width: 500px;text-align:left" name="twitter" value="{{ $footer->twitter }}" id="">
    </div>
  </div>


  <div class="col-lg-6">
    <div class="form-group">
      <label class="form-control-label" for="input-first-name">رابط حساب تلغرام</label>

      <input type="text" maxlength="255" class="form-control" style="width: 500px;text-align:left" name="google" value="{{ $footer->google }}" id="">
    </div>
  </div>


  <div class="col-lg-6">
    <div class="form-group">
      <label class="form-control-label" for="input-first-name">رابط حساب انستغرام</label>

      <input type="text" maxlength="255" class="form-control" style="width: 500px;text-align:left" name="instgram" value="{{ $footer->instgram }}" id="">
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

</script>
@endsection

