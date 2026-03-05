<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>وثيقة انتقال</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
      .element {
        text-orientation: mixed;
        writing-mode: vertical-rl;
        transform: rotate(179deg);
        position: relative;
      }
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
      button{
                margin: auto;
                width: inherit;
            }
            .hide-in-pdf {
        display: none;
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
            <h5 style="text-align: center; direction: rtl">وثيقة انتقال</h5>
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
            <h5 style="text-align: end; direction: rtl; padding-left: 5%">
              رقم المجلد :{{$student->details->number_file}}
            </h5>
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
            <h5 style="text-align: start; direction: rtl; padding-left: 5%">
              للتعليم الأساسي الحلقة ( &nbsp;&nbsp; )
            </h5>
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
                <th rowspan="2" class="">رقم السجل العام</th>
                <th rowspan="2">اسم التلميذ ولقبه</th>
                <th rowspan="2">الاب</th>
                <th rowspan="2">الجد</th>
                <th rowspan="2">الام</th>
                <th rowspan="2">مكان وتاريخ الولادة</th>
                <th rowspan="2" class="">الصف الذي انتسب اليه</th>
                <th rowspan="2" class="">تاريخ انتسابه المدرسة</th>
                <th rowspan="1" colspan="2">اللغة الاجنبية</th>
                <th rowspan="1" colspan="2">الصفوف التي رسب بها</th>
                <th rowspan="1" colspan="2">ايام الغياب</th>
                <th rowspan="2" class="">تاريخ تركه للمدرسة</th>
              </tr>
              <tr>
                <th>ك</th>
                <th>ف</th>
                <th>الصف</th>
                <th>العام الدراسي</th>
                <th>مبرر</th>
                <th>غير مبرر</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <!-- //2 -->
                <th scope="row" rowspan="3">{{$student->public_record_number}}</th>
                <td scope="row" rowspan="3"> {{ $student->first_name }} {{ $student->last_name }}</td>
                <td scope="row" rowspan="3">{{ $student->details->father_name }}</td>
                <td scope="row" rowspan="3">{{ $student->details->grandfather_name }}</td>
                <td scope="row" rowspan="3">{{ $student->details->mother_name }}</td>
                <td scope="row" rowspan="3">{{ $student->place_birth }}{{ $student->date_birth }}</td>
                <td scope="row" rowspan="3">  @foreach ($student->room as $item)
                    <span>{{ $item->classes->name }}</span>
                    @endforeach</td>
                <td scope="row" rowspan="3">{{ $student->created_at->format('m/d/Y') }}</td>
                 <td scope="row" rowspan="3">
                  <!--  @if ($student->lang == 0 )
                     فرنسي
                     @else
                     <span></span>
                    @endif-->
                </td>
                <td scope="row" rowspan="3">
                  <!--  @if ($student->lang == 1 )
                     روسي
                     @else
                     <span></span>
                    @endif-->
                </td>

            @php
            $finalResult= [
            1 => " لم ينهي العام الدراسي",
            2 => " ناجح",
            3 => " راسب",
            ]
        @endphp
                <td scope="row" rowspan="3">
                    @if (! $item->report_cards->isEmpty() )
                    @if ( $item->report_cards[0]->final_result)
                    {{ $finalResult[$item->report_cards[0]->final_result] }}
                    @endif

                    @endif

                </td>
                <td scope="row" rowspan="3">
                    @if (! $item->report_cards->isEmpty() )
                    @if ( $item->report_cards[0]->final_result)
                    {{ App\Year::where('id',$item->year_id)->first()->name }}
                    @endif

                    @endif
                </td>
                <td scope="row" rowspan="3">{{$student->details->days_absence}}</td>
                <td scope="row" rowspan="3">{{$student->details->days_unabsence}}</td>
                <td scope="row" rowspan="3">{{$student->details->leaving_school}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="container pt-3">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <h5
              style="
                text-align: center;
                direction: rtl;
                padding-left: 5%;
                padding-bottom: 10px;
              "
            >
              الكتب المدرسية التي استلمها
            </h5>
          </div>
        </div>
      </div>
    </div>

    <div class="continer" style="width: 90%; margin: auto">
      <div class="row">
        <div class="col-md-12">
          <table class="table table-bordered" style="direction: rtl">
            <thead>
              <tr>
                <th scope="col" style="text-align: center; width: 20px">
                  اسم الكتاب
                </th>
                <th scope="col" style="text-align: center">{{$student->details->book1}}</th>
                <th scope="col" style="text-align: center">{{$student->details->book2}}</th>
                <th scope="col" style="text-align: center">{{$student->details->book3}}</th>
                <th scope="col" style="text-align: center">{{$student->details->book4}}</th>
                <th scope="col" style="text-align: center">{{$student->details->book5}}</th>
                <th scope="col" style="text-align: center">{{$student->details->book6}}</th>
                <th scope="col" style="text-align: center"></th>
                <th scope="col" style="text-align: center"></th>
                <th scope="col" style="text-align: center"></th>
                <th scope="col" style="text-align: center"></th>
                <th scope="col" style="text-align: center"></th>
                <th scope="col" style="text-align: center"></th>
                <th scope="col" style="text-align: center"></th>
                <th scope="col" style="text-align: center"></th>
                <th scope="col" style="text-align: center"></th>
                <th scope="col" style="text-align: center"></th>
                <th scope="col" style="text-align: center"></th>
                <th scope="col" style="text-align: center"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <!-- //2 -->
                <th scope="row" style="text-align: center">حالته</th>
                <td scope="row" style="text-align: center">{{$student->details->book_state1}}</td>
                <td scope="row" style="text-align: center">{{$student->details->book_state2}}</td>
                <td scope="row" style="text-align: center">{{$student->details->book_state3}}</td>
                <td scope="row" style="text-align: center">{{$student->details->book_state4}}</td>
                <td scope="row" style="text-align: center">{{$student->details->book_state5}}</td>
                <td scope="row" style="text-align: center">{{$student->details->book_state6}}</td>
                <td scope="row" style="text-align: center"></td>
                <td scope="row" style="text-align: center"></td>
                <td scope="row" style="text-align: center"></td>
                <td scope="row" style="text-align: center"></td>
                <td scope="row" style="text-align: center"></td>
                <td scope="row" style="text-align: center"></td>
                <td scope="row" style="text-align: center"></td>
                <td scope="row" style="text-align: center"></td>
                <td scope="row" style="text-align: center"></td>
                <td scope="row" style="text-align: center"></td>
                <td scope="row" style="text-align: center"></td>
                <td scope="row" style="text-align: center"></td>
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
            للنشاط : <span class="content">{{$student->details->status_activity}}</span>&nbsp;
            للمطبوعات <span class="content">{{$student->details->status_books}}</span>
        </div>
    </div>
    <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;">
        <div class="row">
            إن التلميذ /ة المثبت اسم ه/ها اعلاه من تلاميذ الصف &nbsp;<b>  @foreach ($student->room as $item)
                {{ $item->classes->name }}
            @endforeach
            </b> &nbsp; للتعليم الاساسي في مدرستنا
            خلال العام الدراسي &nbsp;<b>
                 @foreach ($student->room as $item)
                {{ App\Year::where('id',$item->year_id)->first()->name }} م
            @endforeach</b>
        </div>
    </div>
    <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;">
        <div class="row">
            وبناءاعلى طلب ولي ه /ها أعطيت هذه الوثيقة في <b>{{ $date }}</b>م&nbsp;&nbsp;
            المحافظة التي انتقل إليها &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            المدرسة التي انتقل إليها &nbsp;
        </div>
    </div>
    <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;">
      <div class="row">
        <b>ملاحظة: </b>&nbsp;&nbsp;<b style="text-decoration: underline;"> تصدق هذه الوثيقة من مديرية التربية عند استعمالها</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <!-- المحافظة -->
        <span class="content" style="width: 166px;">{{$student->details->transfer_country}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <!-- اسم المدرسة -->
        <span class="content"style="width: 166px;">{{$student->details->transfer_school}}</span>
      </div>
    </div>
    <div class="container" style="text-align: right; direction: rtl;">
      <div class="row">
        <b style="text-decoration: underline;padding-right: 70px;">في مدرسة خاصة أو خارج المحافظة أو القطر</b>
      </div>
    </div>
    <div class="container" style="text-align: right; direction: rtl;padding-bottom: 20px;padding-right: 33%;">
      <div class="row">
        مدير المدرسة : <span class="content">{{$student->details->head_teacher}}</span>
      </div>
    </div>
  <br>
  <br>
  <div class="container" style="text-align: right; direction: rtl;">
    <div class="row">
      إلى إدارة مدرسة &nbsp;<span class="content"> {{$student->details->transfer_school}}</span>&nbsp; للتعليم الأساسي &nbsp;&nbsp; وافانا التلميذ &nbsp; <span class="content">  {{ $student->first_name }}
        {{ $student->last_name }}</span>&nbsp;&nbsp;
      بوثيقة انتقال
    </div>
  </div>
  <div class="container" style="text-align: right; direction: rtl;padding-top: 10px;">
    <div class="row">
      ذات الرقم &nbsp;&nbsp; <span class="content" style="width: 120px;">{{$student->details->number_file}}</span> &nbsp; المؤرخة في &nbsp; <span class="content" style="width: 130px;">{{ $date }} </span> م &nbsp;&nbsp;
      يرجى ارسال استمارت ه /ها بالسرعة الممكنة في &nbsp;&nbsp;<span class="content" style="width: 130px;">{{$student->details->date_seend}}</span>م
    </div>
  </div>
  <div class="container" style="text-align: right; direction: rtl;padding-top: 10px;">
    <div class="row">
      <span style="padding-right: 50px;width: 262px;">أمين السر</span>
      مدير مدرسة &nbsp;<span class="content">{{$student->details->transfer_school}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      الاسم &nbsp;<span class="content" style="width: 215px">{{$student->details->head_teacher}}</span>
    </div>
  </div>
  <div class="container" style="text-align: right; direction: rtl;padding-top: 13px;">
    <div class="row">
      الاسم &nbsp;<span class="content" style="width: 120px;">{{$student->details->secret_keeper}}</span>&nbsp;
       <span style="padding-right: 195px;width: 299px;">للتعليم الأساسي</span>

    </div>
  </div>
  <div class="container" style="text-align: left; direction: ltr;">
    <div class="row" style="margin-top: -28px;position: relative;margin-left: 37%;">
        <div class="col-md-1">
            <b style="">التوقيع <br>والخاتم</b>
        </div>

    </div>
  </div>
  <div class="container" style="text-align: right; direction: rtl;">
    <div class="row" style="margin-top: -23px;position: relative;">
        <div class="col-md-1">
            <span style="margin-right: -25%;">التوقيع</span>
        </div>

    </div>
  </div>

  <br>
  <br>
  <br>
  <br>
  <div class="container" style="padding-bottom: 100px">
    <div class="row justify-content-center" >
        <div class="col-md-4">
            <button id="downloadBtn" class="btn btn-primary 'hide-in-pdf">تنزيل الملف</button>

        </div>
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
