@extends('students.layouts.app4')
@section('title')
School
@endsection
@section('css')
<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
     <style>
      table {
    border: 1px solid #ccc;
    border-collapse: collapse !important;
    margin: 0 !important;
    padding: 0 !important;
    width: 100% !important;
    margin-top: 20px !important;
}
.sidebar {
    min-height: calc(100vh - 19px);
}
.line {
  width: 100%;
  height: 4rem;
  overflow: hidden;
  /*border: 1px solid black;*/
  padding: 0;
  margin-bottom: 16px;
}

/* subtle zoom to attention and then back */
.pop-outin {
  animation: 4s anim-popoutin ease infinite;
  font-size: 22px !important;
  letter-spacing: inherit !important;
  position: relative;
  top: 10px;
}

@keyframes anim-popoutin {
  0% {
    color: #152C4F;
    transform: scale(0);
    opacity: 0;
    text-shadow: 0 0 0 rgba(0, 0, 0, 0);
  }
  25% {
    color: #a5c9ff;
    transform: scale(2);
    opacity: 1;
    text-shadow: 3px 10px 5px rgba(0, 0, 0, 0.5);
  }
  50% {
    color: #152C4F;
    transform: scale(1);
    opacity: 1;
    text-shadow: 1px 0 0 rgba(0, 0, 0, 0);
  }
  100% {
    /* animate nothing to add pause at the end of animation */
    transform: scale(1);
    opacity: 1;
    text-shadow: 1px 0 0 rgba(0, 0, 0, 0);
  }
}
/*style for upload file*/
/*.form22 {
  background-color: none !important;
  box-shadow: 0 10px 60px rgb(218, 229, 255) !important;
  border: 1px solid rgb(159, 159, 160);
  border-radius: 20px;
  padding: 2rem .7rem .7rem .7rem;
  text-align: center;
  font-size: 1.125rem;
  max-width: 320px;
}*/

.form-title {
  color: #000000;
  font-size: 1.8rem;
  font-weight: 500;
}

.form-paragraph {
  margin-top: 10px;
  font-size: 0.9375rem;
  color: rgb(105, 105, 105);
}

.drop-container {
  background-color: #fff;
  position: relative;
  display: flex;
  gap: 10px;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 10px;
  margin-top: 2.1875rem;
  border-radius: 10px;
  border: 2px dashed #a5c9ff  ;
  color: #444;
  cursor: pointer;
  transition: background .2s ease-in-out, border .2s ease-in-out;
}

.drop-container:hover {
  background: #ecdefd;
  border-color: #a5c9ff;
}

.drop-container:hover .drop-title {
  color: #222;
}

.drop-title {
  color: #444;
  font-size: 20px;
  font-weight: bold;
  text-align: center;
  transition: color .2s ease-in-out;
  background: none !important;
}

#file-input {
  width: 350px;
  max-width: 100%;
  color: #444;
  padding: 4px;
  background: #fff;
  border-radius: 10px;
  border: 1px solid rgba(8, 8, 8, 0.288);
}

#file-input::file-selector-button {
  margin-right: 0px;
  border: none;
  background: #152C4F ;
  padding: 10px 20px;
  border-radius: 10px;
  color: #fff;
  cursor: pointer;
  transition: background .2s ease-in-out;
}

#file-input::file-selector-button:hover {
  background: #a5c9ff ;
}
      </style>
@endsection

@section('content')
@if (session()->has('success'))

<script>
    window.onload = function() {
        notif({
            msg: "  تم  رفع الوصل   ",
            type: "success"
        })
    }

</script>
@endif

<div class="main-panel" style="background: #f8f9fb;">
  <ul class="breadcrumbs" style="padding-bottom: 7px;
	padding-top: 11px;">

	  <li class="li"><a href="{{ route('dashboard.student.lessons',$student->id) }}">الصفحة الرئيسية</a></li>
	  <li class="li"><a href="#">القسم المالي </a></li>

   </ul>
   @error('file')
    <div class="alert alert-danger">{{ $message }}</div>
   @enderror
  <div class="content-wrapper pb-0">

    <!--content of payment-->
    <div class="container" style="padding-top: 20px;padding-bottom: 30px;" >
      <div class="row" style="justify-content: center;">
        <div class="col-md-3" style="padding-left: 57px;">

          <!--a class="btn third" href="#modal" style="font-size: 22px;">تسديد المبلغ</a-->
          @if ($remain_amount!=0)
          <div class="frame">
            <a  href="#modal" class="custom-btn btn-12"><span style="color: white;">ادفع</span><span>تسديد المبلغ</span></a>
          </div>
          @endif

         </div>

         <div class="col-md-3" style="padding-left: 57px;">

          <!--a class="btn third" href="#modal" style="font-size: 22px;">تسديد المبلغ</a-->
          <div class="frame">
            <a  href="#"  data-toggle="modal" data-target="#demoModal" class="custom-btn btn-12"><span style="color: white;">رفع وصل</span><span>رفع وصل الدفع  </span></a>
          </div>

         </div>
        <!--div class="col-md-3" style="padding-left: 57px;">

          <a class="btn third" href="#modal" style="font-size: 22px;">تسديد المبلغ</a>


         </div-->
                <!---modal popup-->

    <!--end modal popup-->
      </div>
  </div><!--end container-->
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>المبلغ الكلي</th>
            <th>المبلغ المدفوع</th>
            <th>المبلغ المتبقي</th>

          </tr>
        </thead>
        <tbody>

          <tr>
            <td><span>{{ $full_amount }}</span></td>
            <td>{{ $amount_paid }}</td>
            <td>{{ $remain_amount }}</td>
          </tr>
        </tbody>
      </table>
    </div>

     <div class="container" style="padding-top: 50px;">
       <div class="row" style="justify-content: center;padding-left: 20px;">
         <div class="col-md-4">
         <!--div class="newcar">
          <p class="ppp">
            <span>
              تفاصيل المدفوعات
            </span>
          </p>
         </div-->


          <div class='line'>
            <h2 class='pop-outin'>تفاصيل المدفوعات</h2>
          </div>

         </div>
       </div>
     </div>
     <div class="table-responsive" style="position: relative;padding-bottom: 80px;">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>رقم الفاتورة</th>
            <th>المبلغ المدفوع</th>
            <th>تاريخ الدفع</th>

          </tr>
        </thead>
        <tbody>
          @foreach ($invoices as $item)
          <tr>
            <td>{{ $item->invoice_number }}</td>
            <td>{{ $item->invoice_amount }}</td>
            <td>{{ $item->created_at->format('d/m/Y') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
     <!--content of table-->

     <!--end content of table-->

    <!--end content for payment-->
   </div>

 </div>

 <div id="modal" style="z-index: 9;">
  <a href="#"></a>
  <section>

    <form action="{{ route('dashboard.checkout') }}" method="post" style="direction: rtl; text-align: right;position: relative;
    top: -30px;">
      @csrf
      <div class="controls">
        <a href="#"><i class="fa fa-times"></i></a>
      </div>
      <h3 style="text-align: center;">ادخال المبلغ</h3>
      <!--content of form-->
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="py-8">
              <label for="default" class="block text-sm leading-5 font-medium text-gray-700 mb-4"></label>
              <!-- This is a normal file input -->
              <input type="number" required name="amount"  placeholder="ادخل المبلغ"  class="form-control">
            </div>
          </div><!--end col-->
        </div><!--end row-->
        <div class="row" style="justify-content: center;top: 20px;">
          <div class="col-md-5">
           <!--submit button-->
           <button type="submit" style="color:white; text-align: center;"  class="custom-btn btn-10"  style="text-align: center;">حفظ</button>

           <!--end submit button-->
          </div>

        </div>

      </div><!--end container-->


      <!--end contetn of foem-->
    </form>

  </section>
</div>
<div class="modal fade auto-off"id="demoModal" tabindex="-1" role="dialog" aria-labelledby="demoModal" aria-hidden="true">
  <div class="modal-dialog animated zoomInLeft modal-dialog-centered" role="document">
      <div class="modal-content" style="padding-top: 50px !important;">
          <div class="container-fluid">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: white !important;">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4  style="color: #152C4F;text-align: center;font-size: 25px; "> وصل الدفع</h4>
              <form action="{{route('add_payment_receipts')}}" style="text-align: right;direction: rtl;" method="post" enctype="multipart/form-data">
                @csrf
              <div class="container">
                <div class="row">
                  <div class="col-md-12">
                    <div class="py-8">
                      <label for="default" class="block text-sm leading-5 font-medium text-gray-700 mb-4"></label>
                      <!-- This is a normal file input -->
                      <!--input type="text" name="default" placeholder="ادخل المبلغ"  class="form-control"-->
                      <label> الا تتجاوز حجم الصورة الوصل 2m  </label>
                      <label for="file-input" class="drop-container">
                        <span class="drop-title"> </span>
                        <input type="file" accept="image/*" name="file" required="" id="file-input">
                      </label>
                    </div>
                  </div><!--end col-->
                </div><!--end row-->
                <div class="row" style="justify-content: center;">
                  <div class="col-md-5">
                   <!--submit button-->
                   <button type="submit" class="custom-btn btn-10"  style="text-align: center;">حفظ</button>
                   <!--end submit button-->
                  </div>
                </div>

              </div>

          </form>
        </div>
      </div>
  </div>
</div>
@endsection
@section('js')

<script>
     $(document).ready(function(){
      $('.m11').addClass('active') ;
    })
</script>
@endsection



