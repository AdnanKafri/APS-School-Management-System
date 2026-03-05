@extends('admin.master')


@section('style')
<style>
div,input,label{
    direction: rtl !important;
    text-align: right !important;
}
</style>
@endsection

@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">معلومات مشرف اكاديمي</a>
    <a href="{{ route('acadsupervisors') }}" class="breadcrumbs__item "> قسم المشرفين الاكادميين </a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')

<div class="row">


      <div class="col-xl-12 order-xl-1">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
              <div class="col-12">
                <h3 class="mb-0 " style="text-align: center">تعديل معلومات الحساب </h3>
              </div>
              <div class="col-4 text-right">
              </div>
            </div>
          </div>





          <div class="card-body">
            <form method="post" action="{{ route('acadsupervisor_update',$supervisor->id) }}" enctype="multipart/form-data">
                @csrf
                @method('put')
              <h3 class="text-muted mb-4" style="text-align: center;">معلومات المستخدم</h3>
              <div class="pl-lg-4">

                <div class="row">



                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-first-name">الإسم الأول</label>
                      <input type="text" id="input-first-name" name="first_name" class="form-control" value="{{ $supervisor->first_name }}">
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-last-name">الكنية</label>
                      <input type="text" id="input-last-name" name="last_name" class="form-control" value="{{ $supervisor->last_name }}">
                    </div>
                  </div>


              <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-control-label" for="input-email">البريد الإلكتروني</label>
                    <input type="email" id="input-email" name="email" class="form-control email" value="{{ $supervisor->email }}">

                    @error('email')
                    <div class="error er" style="color: red" >عذرا , الايميل موجود مسبقا</div>
                @enderror

                <span class="text-danger error validate_email">


                </span>
                </div>
                </div>



                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-control-label" for="input-username">تاريخ الميلاد</label>
                      <input type="date" id="input-last-name" name="date_birth" required class="form-control"  value="{{ $supervisor->date_birth }}">
                    </div>
                  </div>



    {{-- ------------------------------------- --}}

                </div>
              </div>
              <hr class="my-4">
              <!-- Address -->
              <h3 class=" text-muted mb-4" style="text-align: center">معلومات التواصل</h3>
              <div class="pl-lg-4">
                <div class="row">

                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="form-control-label" for="input-address">العنوان</label>
                      <input id="input-address" class="form-control" name="address" placeholder="Home Address" value="{{ $supervisor->address }}" type="text">
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-control-label" for="input-country">الهاتف</label>
                      <input type="text" id="input-phone" name="phone" class="form-control" value="{{ $supervisor->phone }}">
                    </div>
                  </div>
                </div>

              </div>
              <hr class="my-4">





              <div class="pl-lg-4 col-md-12">
                <div class="form-group">
                    <label class="form-control-label" for="input-country">الصورة الشخصية</label>
                    <br>
                    @if ($supervisor->image!=null)

                <img src="{{ asset('storage/'.$supervisor->image) }}" class="rounded-circle" width="10%" style="border-radius: 0% !important">
                @endif

                <input type="file" name="image"  class="form-control">
                </div>
              </div>



              <button class="btn btn-success btn-block" >تأكيد </button>
            </form>
          </div>





    </div>
      </div>




</div>

@endsection

@section('js')



<script src="{{ asset('students/js/jquery-3.2.1.min.js') }}"></script>





<script>


$(document).on('focusout','.email',function(){
    $('.er').hide();
    $('.validate_email').text('');
$('.er').hide();
var email=$(this).val();
     $.ajax({
url: "{{ URL::to('SMARMANger/admin/validate_email1') }}",
type: "get",
contentType: 'application/json',
data : {
    '_token':"{{ csrf_token() }}",
    'email':email,
},
success: function (data) {

       },
error: function (xhr) {
    $('.validate_email').html("<div >! عذرا , هذا الايميل موجود مسبقا</div> ");

}

});



});


$('.alert-success').hide(3000);

    </script>
@endsection
