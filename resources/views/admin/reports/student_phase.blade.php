<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>وثيقة اتمام الحلقة الأولى من مرحلة التعليم الأساسي</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/css/bootstrap-modal-bs3patch.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/css/bootstrap-modal-bs3patch.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/css/bootstrap-modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/css/bootstrap-modal.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modal.min.js"></script> --}}

     <style>

            body{
                margin: auto;
                width: 90%;
            }
            button{
                margin: auto;
                width: inherit;
            }
            .hidden {
            display: none;
           }
    *{
        font-size: 20px
    }
    .content{
        position: relative;
    /* padding-right: 20%; */
    margin: auto;
    /* right: 4%; */
    }
    .modal-backdrop{
        display: none
    }


        </style>
</head>

<body>
 @php
  $school_data = \App\School_data::first();
   @endphp
    <div class="container">

        <div class="col-12 pt-3">
            <h5 style="text-align: start;direction: rtl;">الجمهورية العربية السورية</h5>
            <h4 style="text-align: start;direction: rtl;padding-right: 4%;">وزارة التربية</h4>
        </div>
    </div>
    <div class="container">
        <div class="col-md-12 pt-3">
            <h6 style="text-align: right">مديرية التربية في محافظة حماه </h6>
        </div>

    </div>
    <div class="container">
        <div class="col-md-12 ">
            <h5 style="text-align: start;direction: rtl;">  {{$school_data->name}} </h5>
        </div>
    </div>
    <div class="container">
        <div class="col-md-12 pt-3" style="top: -153px;">
            <div class="col-md-3" style="text-align: end;margin-right: 129px;">
                <h6>رقم السجل &nbsp;<b id="number_file_span" style="font-size: 15px"></b></h6>
                <h6>رقم الوثيقة &nbsp;<b id="number_document_span" style="font-size: 15px"></b></h6>
                <h6>رقم المجلد  &nbsp;<b id="number_folder_span" style="font-size: 15px"></b></h6>
            </div>

        </div>
    </div>

    <br>

    <div class="row" style="direction: rtl">
        <div class="col-md-12">
            <h3 style="text-align: center; font-weight: bold"
            >وثيقة إتمام مرحلة   التعليم الابتدائي</h3>
        </div>
        <div class="content">
        <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;padding-top:60px">
            <div class="row" style="word-spacing: 2.1px;">
              تبين من مراجعة سجلات مدرستناواضبارة السيد &nbsp;<b>  {{ $student->first_name }}
                {{ $student->last_name }}</b>&nbsp;
              بن السيد &nbsp;
              <b>   {{ $student->details->father_name }}</b>&nbsp;
            </div>
        </div>

        <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;">
            <div class="row" style="word-spacing: 8px;">
              المولود في &nbsp;&nbsp;<b>   {{ $student->place_birth }} </b> &nbsp; عام &nbsp;
              <b> {{ $student->date_birth }}</b> &nbsp;
              أنه كان تلميذا في الصف
              &nbsp;&nbsp;
               @foreach ($student->room as $item)
              <b>{{ $item->classes->name }}</b>
              @endforeach

            </div>
        </div>
        <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;">
            <div class="row">
            من {{$school_data->name}}
                خلال العام الدراسي &nbsp; <b> @foreach ($student->room as $item)
                    {{ App\Year::where('id',$item->year_id)->first()->name }} م
                @endforeach</b>&nbsp;
                وأنه داوم بصورة
            </div>
        </div>
        <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;">
            <div class="row" style="word-spacing: 3px;">
                قانونية منتظمة خلال العام  &nbsp;
                <b>    @foreach ($student->room as $item)
                    {{ App\Year::where('id',$item->year_id)->first()->name }} م
                @endforeach</b>&nbsp;
                في الصف  &nbsp;<b>
                    @foreach ($student->room as $item)
                    <b>{{ $item->classes->name }}</b>
                    @endforeach</b>&nbsp;
                 في مدرستنا وأتمه بنجاح
            </div>
        </div>

        <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;">
            <div class="row">
              وهو ذو سلوك &nbsp;
              <b id="behavior_span" ></b>
                {{-- @if ($student->details->behavior != '')
                {{$student->details->behavior}}
                @else
                جيد
                @endif --}}
                &nbsp;
               و ذو اجتهاد  &nbsp;
               <b id="diligence_span" ></b>
                {{-- @if ($student->details->behavior != '')
                {{$student->details->behavior}}
                @else
                جيد
                @endif --}}




            </div>
        </div>
        <div class="container" >
            <div class="row" style="text-align: left;
            direction: ltr;">
                <small style="margin-left: 28px;margin-top: -43px;">مدير المدرسة</small>
            </div>

        </div>
        <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;">
            <div class="row" style="font-size: 16px">

                أعطيت بتاريخ &nbsp;&nbsp;<b>{{$date}}</b>

                <small style="margin-right: 49%">الأسم الصريح: <b style="font-size: 13px" id="name_teacher_span"></b> </small>
            </div>
            <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;">
                <div class="row"  style="font-size: 16px">
                    <small style="margin-right: 78%"> الخاتم والتوقيع: <b style="font-size: 13px" ></b> </small>
                </div>
        </div>
       </div>

    <br>
    <br>
    <br>
    <div class="container" style="padding-bottom: 100px;padding-top:50px">
        <div class="row justify-content-center" >
            <div class="col-md-4">
                <button id="downloadBtn" class="btn btn-primary hide-in-pdf">تنزيل الملف</button>
            </div>
            <div class="col-md-4">
                <button id="edit"  data-toggle="modal" data-target="#create_coordinator" class="btn btn-primary hide-in-pdf">اضافة البيانات</button>
            </div>
        </div>
    </div>


    <div class="modal fade" id="create_coordinator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none; padding-right: 17px;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form >
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                    <div class="modal-header">
                        <h5> اضافة بيانات الوثيقة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body" style="text-align: right;">
                            <div class="form-group">
                                <label>رقم السجل</label>
                                <input type="text" name="number_file" class="form-control a" value="" placeholder="" maxlength="30" style="direction:rtl" required="">
                            </div>

                            <div class="form-group">
                                <label>رقم الوثيقة </label>
                                <input type="text" name="number_document" class="form-control b" value="" placeholder="" maxlength="30" style="direction:rtl" required="">
                            </div>
                            <div class="form-group">
                                <label>رقم الجلد  </label>
                                <input type="text" name="number_folder" class="form-control a english_name" value=""  maxlength="30" style="direction:rtl" required="">
                            </div>

                            <div class="form-group">
                                <label> السلوك  </label>
                                <input type="text" name="behavior" class="form-control b english_name" value=""  maxlength="30" style="direction:rtl" required="">
                            </div>

                            <div class="form-group">
                                <label>الاجتهاد </label>
                                <input type="text" name="diligence" class="form-control b" value="" style="direction:rtl" >
                            </div>

                            <div class="form-group">
                                <label>اسم المدير</label>
                                <input type="text" name="name_teacher" class="form-control b" value="" maxlength="100"  style="direction:rtl">
                            </div>
                    </div>
                    <div class="modal-footer" style="text-align: right;direction: rtl;display: block;">
                        <a type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</a>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- html2pdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script>
const studentIdInput = document.querySelector('input[name="student_id"]');
const numberFileInput = document.querySelector('input[name="number_file"]');
const numberDocumentInput = document.querySelector('input[name="number_document"]');
const numberFolderInput = document.querySelector('input[name="number_folder"]');
const behaviorInput = document.querySelector('input[name="behavior"]');
const diligenceInput = document.querySelector('input[name="diligence"]');
const nameTeacherInput = document.querySelector('input[name="name_teacher"]');

const numberFileSpan = document.querySelector('#number_file_span');
const numberDocumentSpan = document.querySelector('#number_document_span');
const numberFolderSpan = document.querySelector('#number_folder_span');
const behaviorSpan = document.querySelector('#behavior_span');
const diligenceSpan = document.querySelector('#diligence_span');
const nameTeacherSpan = document.querySelector('#name_teacher_span');

function updateSpans() {
  numberFileSpan.textContent = numberFileInput.value;
  numberDocumentSpan.textContent = numberDocumentInput.value;
  numberFolderSpan.textContent = numberFolderInput.value;
  behaviorSpan.textContent = behaviorInput.value;
  diligenceSpan.textContent = diligenceInput.value;
  nameTeacherSpan.textContent = nameTeacherInput.value;
}

document.querySelector('form').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the form from submitting normally
  updateSpans(); // Update the spans with the input values

  const studentId = studentIdInput.value;
  localStorage.setItem(`numberFile_${studentId}`, numberFileInput.value);
  localStorage.setItem(`numberDocument_${studentId}`, numberDocumentInput.value);
  localStorage.setItem(`numberFolder_${studentId}`, numberFolderInput.value);
  localStorage.setItem(`behavior_${studentId}`, behaviorInput.value);
  localStorage.setItem(`diligence_${studentId}`, diligenceInput.value);
  localStorage.setItem(`nameTeacher_${studentId}`, nameTeacherInput.value);

  $('.modal').modal('hide'); // Assuming the modal is a Bootstrap modal, you can use the hide method to close it
});

// Check if there are saved values in localStorage and update the spans
const studentId = studentIdInput.value;
if (localStorage.getItem(`numberFile_${studentId}`)) {
  numberFileInput.value = localStorage.getItem(`numberFile_${studentId}`);
  numberDocumentInput.value = localStorage.getItem(`numberDocument_${studentId}`);
  numberFolderInput.value = localStorage.getItem(`numberFolder_${studentId}`);
  behaviorInput.value = localStorage.getItem(`behavior_${studentId}`);
  diligenceInput.value = localStorage.getItem(`diligence_${studentId}`);
  nameTeacherInput.value = localStorage.getItem(`nameTeacher_${studentId}`);
  updateSpans();
}

     </script>

   <script>

 $(document).ready(function () {
    $('#downloadBtn').click(function () {
        var studentName = "{{ $student->first_name }} {{ $student->last_name }}";
        // Get the student's name
     // Add the CSS class to the button
     $('.hide-in-pdf').addClass('hidden'); // Add the hidden class to the buttons
        // Create a new html2pdf instance
        html2pdf()
            .set({
                margin: 10,
                filename: studentName + '.pdf', // Set the filename based on the student's name
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 3, // Increase resolution for better quality
                    letterRendering: true
                },
                jsPDF: {
                    unit: 'pt',
                    format: 'a3',
                    orientation: 'portrait'
                }
            })
            .from(document.documentElement.outerHTML) // Convert the entire HTML document to PDF
            .save();
    });
});
    </script>



</body>

</html>
