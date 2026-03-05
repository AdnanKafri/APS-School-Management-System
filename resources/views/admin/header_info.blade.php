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
                <h3 class="mb-0">تعديل معلومات الترويسة </h3>
              </div>


            </div>
          </div>





          <div class="card-body">
            <form method="post" action="{{ route('admin.header_info.store',$header_info->id) }}" enctype="multipart/form-data">
                @csrf
                @method('put')



                <div class="col-lg-12">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">البريد الإلكتروني</label>
                      <input type="email" id="" name="email" class="form-control" value="{{ $header_info->email }}" style="text-align:left; width:300px" required>
                    </div>
                  </div>


                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">العنوان بالعربية </label>
                      <input  type="text" id="" maxlength="18" name="address_ar" class="form-control" value="{{ $header_info->address_ar }}" required>
                    </div>
                  </div>


                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">العنوان بالإنكليزية </label>
                      <input type="text" id="" maxlength="18" name="address_en" class="form-control" value="{{ $header_info->address_en }}" style="text-align:left; width:300px" required>
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
