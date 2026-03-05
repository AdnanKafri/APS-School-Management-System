@extends('students.layouts.app4')
@section('title')
School
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('student/assets/css/demo_1/style.css') }}" />
     <style>

table {
  border: 1px solid #ccc ;
  border-collapse: collapse !important;
  margin: 0 !important;
  padding: 0 !important;
  width: 100% !important;
  margin-top:150px !important;
}

table caption {
  font-size: 1.5em !important;
  margin: .25em 0 .75em !important;
}

table tr {
  background: #f8f8f8 !important;
  border: 1px solid #ddd ;
  padding: .35em !important;
}

table th, table td {
  padding: .625em !important;
  text-align: center !important;
}

table th {
  font-size: 20px !important;

}

table td img { text-align: center; }
@media screen and (max-width: 600px) {

table { border: none !important; }


table thead { display: none !important; }

table tr {
  /*border-bottom: 3px solid #ddd!important ;*/
  border-bottom: none !important;
  border-top: none !important;
  border-left: none !important;
  border-right: none !important;
  display: block!important;
  margin-bottom: .625em !important;
}

table td {
  padding: 10px !important;
  border-top: 1px solid #ddd !important;
  border-bottom: none !important;
  display: block !important;
  font-size: .8em !important;
  text-align: right !important;
}

table td:before {
  content: attr(data-label) !important;
  float: left !important;
  font-weight: bold !important;

}

table td:last-child {
border-bottom: 1px solid #ddd !important;
border-right: 1px solid #ddd;
 }


}
.butt{
    margin: 2px;
    margin-top:10px !important;
}
@media (min-width: 992px){
    .modal-lg, .modal-xl {
    max-width: 34%;
}
}

	 </style>
@endsection
@section('content')
@if (session()->has('success'))

<script>
    window.onload = function() {
        notif({
            msg: "  تم التخزين بنجاح  ",
            type: "success"
        })
    }

</script>
@endif
@if (session()->has('otherday'))

<script>
    window.onload = function() {
        notif({
            msg: " {{ session()->get('otherday') }} ",
            type: "warning"
        })
    }

</script>
@endif
@if (session()->has('othertime'))

<script>
    window.onload = function() {
        notif({
            msg: " {{ session()->get('othertime') }} ",
            type: "warning"
        })
    }

</script>
@endif
@if ($errors->any())

    @foreach ($errors->all() as $error)
    {{-- <li>{{ $error }}</li> --}}
    <script>
        window.onload = function() {
            notif({
                msg: `{{  $error }}`  ,
                type: "error"
            })
        }

    </script>
    @endforeach

@endif
<div class="main-panel" >
  <ul class="breadcrumbs" style="padding-bottom: 7px;
	padding-top: 11px;">

	  <li class="li"><a href="{{ route('dashboard.student.lessons',$student->id) }}">الصفحة الرئيسية</a></li>
	  <li class="li"><a href="{{route('dashboard.student.medical_profile',['room_id'=>$room_id,'student_id'=>$student->id])}}">الملف الطبي</a></li>
    <li class="li"><a href="#">  الأمراض و الأوبئة قبل المدارسة</a></li>

   </ul>
    <div class="content-wrapper pb-0">
      <!--content -->
      <!--css foe modal-->
      <!--end css for mdal-->
      <div class="container" style="position: relative; top: -95px;">

          <div class="row">
            <!--table of exams-->
           <div class="col-md-12">

              <table class=""  >
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">اسم اللقاح</th>
                      <th scope="col"> الوصف  </th>
                      <th scope="col"> الأعراض  </th>
                      <th scope="col"> تاريخ المرض  </th>
          

                    </tr>
                  </thead>
                  <tbody>
            <?php $i = 1 ;
                    $background = '#fff';
                ?>
                
                                @if($old_illness)

                @foreach(json_decode($old_illness,true) as $item)
                <tr>
                
                <th data-label=" #"  scope="row">{{ $i++ }}</th>
                <td scope="row" data-label=" اليوم 
                ">
                {{$item['old_illness_name']}}
                </td>
                
                
                            <td scope="row" data-label=" اليوم 
                ">
                {{$item['old_illness_description']}}
                </td>
                
                
                            <td scope="row" data-label=" اليوم 
                ">
                {{$item['old_illness_treatment']}}
                </td>
                
                                            <td scope="row" data-label=" اليوم 
                ">
                {{$item['date_old_illness']}}
                </td>
                
                
                
                </tr>
            @endforeach
                        @endif

                  </tbody>
                </table>

        <!--end content of table-->
           </div><!--end col-md-12-->



           </div><!--end row-->

            <div class="modal fade" id="upload_files">
              <div class="modal-dialog modal-lg">
                  <div class="modal-content" style="direction: rtl; text-align:right">
              <a href="#"></a>
              <section>

                  <div class="controls">
                    <a href="#" data-dismiss="modal"><i class="fa fa-times"></i></a>
                  </div>
                  <h3 style="text-align: center;">ترفيع الملف</h3>
                  <!--content of form-->
                  <form  action="{{ route('dashboard.student.upload_exam_files') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="exam_id" id="exam_id" value="" class="exam_id">
                  <div class="container">
                    <div class="row">
                      <div class="col-md-12">
                        <div>
                          <label for="">  اسم المحتوى  </label>
                          <span><i class="fa fa-file"></i></span>
                          <input type="text"  name="content_name" id="content_name" value="" readonly class=" content_name form-control" style="padding: 0.94rem 3.375rem;">
                        </div>
                      </div><!--end col-->
                      <div class="col-md-12">
                        <div>
                          <label for="">اسم المادة </label>
                          <span><i class="fa fa-file"></i></span>
                          <input type="text"name="content_name" id="lesson_name"  value="  " readonly class=" lesson_name form-control" style="padding: 0.94rem 3.375rem;">
                        </div>
                      </div><!--end col-->
                      <div class="col-md-12">
                        <div>
                          <label for="">ترفيع  الحل */يمكن رفع عدة ملفات معاً/* : </label>
                          <input name="file[]" id="file" class="common-input mb-20 form-control"  type="file" multiple>

                        </div>
                      </div><!--end col-->

                    </div>
                    <div class="form-group modal-footer row justify-content-around px-3">
                      <button class="btn btn-success " type="submit" style="width: 35%">تأكيد </button>
                    <button  class="btn btn-dark " data-dismiss="modal" style="width: 35%">خروج</button>
                </div>
    </form>
                  </div>



                  <!--end contetn of foem-->

              </section>
            </div>
              </div>
            </div>
            <!--end modal popup-->
            <!--end table of exams-->

          </div>
        </div>

      <!--end content-->
        <!---modal popup-->
    

</div>


  
    @endsection
