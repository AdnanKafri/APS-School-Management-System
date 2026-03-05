<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>وثيقة انتقال</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
      /* .element {
        text-orientation: mixed;
        writing-mode: vertical-rl;
        transform: rotate(179deg);
        position: relative;
      } */
      .table-bordered {
        border: 3px double #141516;
      }
      .table-bordered thead td,
      .table-bordered thead th {
        border-bottom-width: 2px;
        height: 20px;
        text-align: center;
        margin: auto;
      }
      .table td,
      .table th {
        padding: 10px;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
      }
      .table thead th {
        vertical-align: inherit;
        border-bottom: 2px solid #dee2e6;
      }
      .content{
    padding-right: 10px;
    top: -6px;
    position: relative;
    border-bottom: 1px dashed #141516;
    width: 250px;
      }
      .hide-in-pdf {
        display: none;
    }
    button{
    margin: auto;
    width: inherit;
    }
    </style>
  </head>
 @php
  $school_data = \App\School_data::first();
   @endphp
  <body>
    <div class="container pt-3">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-4">
            <!-- <h5 style="text-align: end;direction: rtl;">نموذج رقم أ/2 </h5> -->
          </div>
          <div class="col-md-4">
            <h5 style="text-align: center; direction: rtl">وثيقة انتقال رقم ({{$student->details->number_file}})</h5>
          </div>
          <div class="col-md-4">
            <h5 style="text-align: center; direction: rtl">
              الجمهورية العربية السورية
            </h5>
          </div>
        </div>
      </div>
    </div>

    <div class="container pt-3">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-6">
            <h5
              style="
                text-align: end;
                direction: rtl;
                padding-left: 10%;
                color: red;
              "
            >
                {{$student->details->number_document}}
            </h5>
          </div>
          <div class="col-md-6">
            <h5 style="text-align: center; direction: rtl; padding-left: 206px">
              وزارة التربية
            </h5>
          </div>
        </div>
      </div>
    </div>

    <div class="container pt-3">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-6">
            <h6 style="text-align: end;direction: rtl; padding-left: 8%;">مكتبة الاستقلال</h6>
            <h6 style="text-align: end;direction: rtl; padding-left: 5%">نموذج رقم 2005/66</h6>
          </div>
          <div class="col-md-6">
            <h5 style="text-align: start; direction: rtl">
                مديرية التربية في محافظة حماه
              </h5>
          </div>
        </div>
      </div>
    </div>

    <div class="container pt-3">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-7">
            {{-- <h5 style="text-align: start; direction: rtl; padding-left: 5%">
              للتعليم الثانوي الحلقة ( &nbsp;&nbsp; )
            </h5> --}}
          </div>
          <div class="col-md-5">
            <h5 style="text-align: start; direction: rtl">  {{$school_data->name}} </h5>
          </div>
        </div>
      </div>
    </div>

    <div class="continer" style="width: 90%; margin: auto">
      <div class="row">
        <div class="col-md-12">
          <table
            class="table table-bordered text-center"
            style="direction: rtl"
          >
            <thead>
              <tr>
                <th rowspan="2" class="element">الرقم</th>
                <th rowspan="2"> اسم الطالب وتاريخ الولادة</th>
                <th rowspan="2">اسم الأب وشهرته</th>
                <th rowspan="2">اسم الجد</th>
                <th rowspan="2">اسم الأم</th>
                <th rowspan="2">تاريخ دخوله المدرسة</th>
                <th rowspan="2" class="element">الصف الذي انتسب اليه</th>
                <th rowspan="2" >الصفوف التي رسب بها</th>
                <th rowspan="1" colspan="2">اللغة الاجنبية</th>
                <th rowspan="2" >أيام الدوام</th>
                <th rowspan="1" colspan="2">ايام الغياب</th>
                <th rowspan="2" class="element">تاريخ تركه للمدرسة</th>
              </tr>
              <tr>
                <th>ك</th>
                <th>ف</th>

                <th>مبرر</th>
                <th>غير مبرر</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <!-- //2 -->
                <th scope="row" rowspan="3">{{$student->public_record_number}}</th>
               <td scope="row" rowspan="3"> {{ $student->first_name }} {{ $student->last_name }} <br>
                       {{ $student->date_birth }} </td>
                <td scope="row" rowspan="3">{{ $student->details->father_name }}</td>
                <td scope="row" rowspan="3">{{ $student->details->grandfather_name }}</td>
                <td scope="row" rowspan="3">{{ $student->details->mother_name }}</td>
                <td scope="row" rowspan="3">{{ $student->created_at->format('m/d/Y') }}</td>
                <td scope="row" rowspan="3"> @foreach ($student->room as $item)
                    <span>{{ $item->classes->name }}</span>
                    @endforeach</td>
                <td scope="row" rowspan="3">  @php
                    $finalResult= [
                    1 => " لم ينهي العام الدراسي",
                    2 => " ناجح",
                    3 => " راسب",
                    ]
                @endphp
                  @if (! $item->report_cards->isEmpty() )
                  @if ( $item->report_cards[0]->final_result)
                  {{ $finalResult[$item->report_cards[0]->final_result] }}
                  @endif

                  @endif
                </td>
                 <td scope="row" rowspan="3">

                </td>
                <td scope="row" rowspan="3">
                     @if ($student->lang == 0 )
                     فرنسي
                     @else
                     <span></span>
                    @endif
                    @if ($student->lang == 1 )
                     روسي
                     @else
                     <span></span>
                    @endif
                </td>
                <td scope="row" rowspan="3">{{$student->details->working_days}}</td>
                <td scope="row" rowspan="3">{{$student->details->days_absence}}</td>
                <td scope="row" rowspan="3">{{$student->details->days_unabsence}}</td>
                <td scope="row" rowspan="3">{{$student->details->leaving_school}}</td>

              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>





    <br />
    <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;">
        <div class="row">
            وضع ه/ها بالنسبة للتعاون : <span class="content">{{$student->details->status_cooperation}}</span> &nbsp;


        </div>
    </div>
    <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;">
        <div class="row">
          إن الطالب /ة المثبت اسمه أعلاه وشهرت ه/ها  أعلاه من طلاب الصف
        &nbsp;&nbsp;  <span class="content" style="width: 120px;">
            @foreach ($student->room as $item)
            {{ $item->classes->name }}
            @endforeach
        </span>&nbsp;&nbsp;
        الشعبة
        &nbsp;<span class="content" style="width: 120px;">
           @foreach ($student->room as $item)
            {{ $item->name }}
            @endforeach
        </span>&nbsp;
        &nbsp;الفرع &nbsp;
        &nbsp;<span class="content"style="width: 120px;">
            {{$student->details->branch}}
        </span>&nbsp;
        &nbsp;في مدرستنا &nbsp;
        </div>
    </div>
    <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;">
        <div class="row">
            خلال العام الدراسي &nbsp;&nbsp;<span>
                @foreach ($student->room as $item)
                {{ App\Year::where('id',$item->year_id)->first()->name }} م
                @endforeach
            </span>&nbsp;&nbsp;
            من الطلاب ذات السلوك
            &nbsp;&nbsp;<span class="content" style="width: 600px;">
                {{$student->details->behavior}}</span>&nbsp;&nbsp;
        </div>
    </div>

    <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;">
        <div class="row">
            ونتيجة الامتحان &nbsp;&nbsp;
            <span class="content" style="width: 220px;">
                @php
             $finalResult= [
             1 => " لم ينهي العام الدراسي",
             2 => " ناجح",
             3 => " راسب",
             ]
         @endphp
                @if (! $item->report_cards->isEmpty() )
                @if ( $item->report_cards[0]->final_result)
                {{ $finalResult[$item->report_cards[0]->final_result] }}
                @endif

                @endif
            </span>&nbsp;&nbsp;
            وبناءاعلى طلب ولي ه /ها أعطيت هذه الوثيقة في <b>{{$date}}</b>م &nbsp;

        </div>
    </div>
    <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;">
        <div class="row">
            <b>ملاحظات: </b>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            المحافظة التي انتقل إليها &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            المدرسة التي انتقل إليها &nbsp;
        </div>
    </div>
    <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;">
      <div class="row">
        <b>(1) تدون المعلومات المتعلقةبالنسبة التي يتم فيها الانتقال </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <!-- المحافظة -->
        <span class="content" style="width: 166px;">{{$student->details->transfer_country}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <!-- اسم المدرسة -->
        <span class="content"style="width: 166px;">{{$student->details->transfer_school}}</span>
      </div>
    </div>
    <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;">
        <div class="row">
            <b>(2) يوضح وضع الطالب بأن يذكر أنه معفى اعفاء تام ,نصف إعفاء <br>
                &nbsp;&nbsp;&nbsp;من الصندوق التعاوني</b>
        </div>
    </div>
    <div class="container" style="text-align: right; direction: rtl;">
      <div class="row">
        <b style="width: 41%;">ملاحظة : تصدق هذه الوثيقة من مديرية التربية  عند استعمالها في مدرسة خاصة أو خارج المحافظة أو خارج القطر</b>
      </div>
    </div>
   <hr style="width: 90%;border: 2px solid;">
  <br>
  <div class="container" style="text-align: right; direction: rtl;">
    <div class="row">
    <b>إلى مدير المدرسة &nbsp;&nbsp;</b><span class="content">{{$student->details->head_teacher}}</span>
    </div>
  </div>
  <div class="container" style="text-align: right; direction: rtl;padding-top: 10px;">
    <div class="row">
      وافقنا على قبول الطالب  &nbsp;&nbsp;<span class="content">{{ $student->first_name }} {{ $student->last_name }}</span>&nbsp;&nbsp;&nbsp;&nbsp;
      الذي وافانا بوثيقة انتقال ذات الرقم &nbsp;&nbsp;<span class="content">{{$student->details->number_file}}</span>
    </div>
  </div>
  <div class="container" style="text-align: right; direction: rtl;padding-top: 10px;">
    <div class="row">
     المؤرخة في &nbsp;&nbsp;<span>{{$date}} </span> م   &nbsp;&nbsp; في مدرستنا , رجاء ارسال اضبارته
     بالسرعة الممكنة في  &nbsp;&nbsp;&nbsp; <span>{{$student->details->date_seend}}</span>
    </div>
  </div>
  <div class="container" style="text-align: right; direction: rtl;padding-top: 13px;">
    <div class="row">
      <b style="padding-right:50px">أمين السر </b> &nbsp;&nbsp; <span>{{$student->details->secret_keeper}}</span>
      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
      <b>مدير المدرسة </b> <span class="content">{{$student->details->transfer_school}}</span> &nbsp; <b>الرسمية</b>
    </div>
  </div>
  <div class="container" style="text-align: left; direction: ltr;">
    <div class="row" style="margin-top: 15px;position: relative;margin-left: 48%;">
        <div class="col-md-1">
            <b> الخاتم</b>
        </div>

    </div>
  </div>

  <div class="container" style="padding-bottom: 100px;padding-top: 100px;">
    <div class="row justify-content-center" >
        <div class="col-md-4">
            <button id="downloadBtn" class="btn btn-primary 'hide-in-pdf">تنزيل الملف</button>

        </div>
    </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
  <script>
  $(document).ready(function () {
  $('#downloadBtn').click(function () {
      var studentName = "{{ $student->first_name }} {{ $student->last_name }}";
      // Get the student's name
  // Add the CSS class to the button
  $(this).addClass('hide-in-pdf');
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
