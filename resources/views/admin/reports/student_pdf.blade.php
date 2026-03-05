@extends('admin.master')

@section('style')
<style>
    *{
        direction: rtl !important;
        /* text-align: center; */
    }
    button,a{
        color: white !important;
    }
    .form-group{
        text-align: right;
    }
    label{
        font-size: 20px;
        color: black;
    }
    input{
        font-size: 17px !important;
    }
    th{
        font-size: 20px;
    }
    td{
        font-size: 17px;
    }
    a.page-link{
        color: #7571f9 !important;
    }
    .pagination{
        justify-content: center;
    }
    .dropdown-item{
        color: black !important;
        width: auto !important;
    }
    .fa-folder{
        margin: 2px;
    }
    .dorat{
        color: blue !important;
    }

    /* ///////////////////////////////////// */


.wrapper{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper input[type="radio"]{
  display: none;
}
#option-1:checked:checked ~ .option-1,
#option-2:checked:checked ~ .option-2{
  border-color: #0069d9;
  background: #0069d9;
}
#option-1:checked:checked ~ .option-1 .dot,
#option-2:checked:checked ~ .option-2 .dot{
  background: #fff;
}
#option-1:checked:checked ~ .option-1 .dot::before,
#option-2:checked:checked ~ .option-2 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper .option span{
  font-size: 20px;
  color: #808080;
}
#option-1:checked:checked ~ .option-1 span,
#option-2:checked:checked ~ .option-2 span{
  color: #fff;
}








.wrapper_lang{
  display: inline-flex;
  background: #fff;
  height: 100px;
  width: 400px;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
  padding: 20px 15px;
  margin-left: 25px;
  box-shadow: 5px 5px 30px rgba(0,0,0,0.2);
}
.wrapper_lang .option{
  background: #fff;
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  margin: 0 10px;
  border-radius: 5px;
  cursor: pointer;
  padding: 0 10px;
  border: 2px solid lightgrey;
  transition: all 0.3s ease;
}
.wrapper_lang .option .dot{
  height: 20px;
  width: 20px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.wrapper_lang .option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 12px;
  height: 12px;
  background: #0069d9;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
.wrapper_lang input[type="radio"]{
  display: none;
}
#option-lang1:checked:checked ~ .option-lang1,
#option-lang2:checked:checked ~ .option-lang2{
  border-color: #0069d9;
  background: #0069d9;
}
#option-lang1:checked:checked ~ .option-lang1 .dot,
#option-lang2:checked:checked ~ .option-lang2 .dot{
  background: #fff;
}
#option-lang1:checked:checked ~ .option-lang1 .dot::before,
#option-lang2:checked:checked ~ .option-lang2 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.wrapper_lang .option span{
  font-size: 20px;
  color: #808080;
}
#option-lang1:checked:checked ~ .option-lang1 span,
#option-lang2:checked:checked ~ .option-lang2 span{
  color: #fff;
}

th{
    font-size: 20px;
    border-bottom: 1px solid #008991 !important;
    text-align: center !important;
}
td{
    font-size: 17px;
    border-bottom: 1px solid #008991 !important;
    color: black;
    text-align: center;
}
.buttons-excel{
    color: black !important;
    font-size: 25px !important
}
.span_pdf{
    font-size: 20px !important;
    color: black;
    line-height: 2
}
</style>

<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">

@endsection

@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item  is-active">قسم تقارير الطلاب</a>
    <a href="{{ route('reports') }}" class="breadcrumbs__item ">قسم التقارير و الاحصائيات</a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')

<!------------------------------------------------>

@php
$about = \App\About_us::find(1);
@endphp


{{-- ////////// --}}

<input type="hidden" name="year_id" id="years" value={{$year2->id}} >


  <!-- Modal -->
  <div class="modal fade" id="selectexport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="min-width: 850px">

      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel"></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div id="divIdToPrint" class="m-4"  >
                <div class="pl-lg-4">

                <div class="row mt-5 mb-5" >
                    <div class="col-12" style="text-align: center" >
                        <h3 style="text-align: center">مدارس البيان النموذجية</h3>
                    </div>
                </div>
                  <div class="row">

                    <div class="col-lg-6">
                      <div class="form-group">
                          <label class="form-control-label" for="input-first-name"> الإسم الأول بالعربية :</label>
                          <span class="mr-3 span_pdf" id="first_name_ar" > احمد </span>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-last-name">الكنية بالعربية :</label>
                        <span class="mr-3 span_pdf" id="last_name_ar" > احمد </span>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">الإسم الأول بالانكليزية : </label>
                        <span class="mr-3 span_pdf" id="first_name_en" > احمد </span>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-last-name">الكنية بالانكليزية : </label>
                        <span class="mr-3 span_pdf" id="last_name_en" > احمد </span>
                      </div>
                    </div>


                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">اسم الأب : </label>
                        <span class="mr-3 span_pdf" id="father_name" > احمد </span>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">رقم الأب : </label>
                        <span class="mr-3 span_pdf" id="father_phone" > احمد </span>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-last-name">اسم الأم : </label>
                        <span class="mr-3 span_pdf" id="mother_name" > احمد </span>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-last-name"> رقم الأم : </label>
                        <span class="mr-3 span_pdf" id="mother_phone" > احمد </span>
                      </div>
                    </div>


                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-last-name">عمل الأم : </label>
                        <span class="mr-3 span_pdf" id="mother_job" > احمد </span>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-last-name"> عمل الأب : </label>
                        <span class="mr-3 span_pdf" id="father_job" > احمد </span>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-last-name">تاريخ الميلاد : </label>
                        <span class="mr-3 span_pdf" id="birthday" > احمد </span>
                      </div>
                    </div>


                    <div class="col-lg-12">
                      <div class="form-group">
                          <label>الديانة : </label>
                          <span class="mr-3 span_pdf" id="religion" > احمد </span>
                      </div>
                    </div>


                  </div>

                </div>
                <hr class="my-4">
                <!-- Address -->
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-address">العنوان : </label>
                        <span class="mr-3 span_pdf" id="student_address" > احمد </span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-city">الجنسية : </label>
                        <span class="mr-3 span_pdf" id="nationality" > احمد </span>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-country">مكان الولادة : </label>
                        <span class="mr-3 span_pdf" id="place_birth" > احمد </span>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-country">الخانة : </label>
                        <span class="mr-3 span_pdf" id="box_birth" > احمد </span>
                      </div>
                    </div>

                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-country">شعبة التجنيد : </label>
                        <span class="mr-3 span_pdf" id="army_room" > احمد </span>
                      </div>
                    </div>


                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-country">الهاتف : </label>
                        <span class="mr-3 span_pdf" id="student_phone" > احمد </span>
                      </div>
                    </div>

                  </div>
                </div>
                <hr class="my-4">

          </div>
          <div id="divIdToPrint2" class="m-4"  >
            <div class="row" >

                <div class="col-6">
                  <div class="form-group">
                      <label class="form-control-label" for="input-country"> الصورة الشخصية</label>
                      <br>
                      <img id="personal_image" class="output"  src="" width="200px" alt="">
                  </div>
                </div>



                <div class="col-6">
                  <div class="form-group">
                      <label class="form-control-label" for="input-country">دفتر العائلة</label>
                      <br>
                      <img id="family_notebook" class="output"  src="" width="200px" alt="">
                  </div>
                </div>


                <div class="col-6">
                  <div class="form-group">
                      <label class="form-control-label" for="input-country">صورة هوية الأم</label>
                      <br>
                      <img id="mother_image" class="output"  src="" width="200px" alt="">
                  </div>
                </div>



                <div class="col-6">
                  <div class="form-group">
                      <label class="form-control-label" for="input-country">صورة هوية الأب</label>
                      <br>
                      <img id="father_image" class="output"  src="" width="200px" alt="">
                  </div>
                </div>


                <div class="col-6">
                  <div class="form-group">
                      <label class="form-control-label" for="input-country">اخراج القيد</label>
                      <br>
                      <img id="bond" class="output"  src="" width="200px" alt="">
                  </div>
                </div>


                <div class="col-6">
                  <div class="form-group">
                      <label class="form-control-label" for="input-country"> جواز السفر </label>
                      <br>
                      <img id="passport" class="output"  src="" width="200px" alt="">
                  </div>
                </div>


                <div class="col-6">
                  <div class="form-group">
                      <label class="form-control-label" for="input-country">دفتر العائلة صفحة الأم</label>
                      <br>
                      <img id="mother_notebook" class="output"  src="" width="200px" alt="">
                  </div>
                </div>


                <div class="col-6">
                  <div class="form-group">
                      <label class="form-control-label" for="input-country">دفتر العائلة صفحة الأب</label>
                      <br>
                      <img id="father_notebook" class="output"  src="" width="200px" alt="">
                  </div>
                </div>


                <div class="col-6">
                  <div class="form-group">
                      <label class="form-control-label" for="input-country">تسلسل دراسي</label>
                      <br>
                      <img id="sequence" class="output"  src="" width="200px" alt="">
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                      <label class="form-control-label" for="input-country">اخر شهادة</label>
                      <br>
                      <img id="last_cert" class="output"  src="" width="200px" alt="">
                  </div>
                </div>

                <div class="col-6">
                  <div class="form-group">
                      <label class="form-control-label" for="input-country"> شهادة التاسع</label>
                      <br>
                      <img id="ninth_cert" class="output"  src="" width="200px" alt="">
                  </div>
                </div>


              </div>
          </div>
        </div>
        <div class="modal-footer" style="display: flex;justify-content: flex-start;" >
          <a class="btn btn-secondary" data-dismiss="modal">اغلاق</a>
        </div>
    </div>
    </div>
  </div>

<div class="card" style="margin: 30px">
    <div class="card-body" style="text-align: right;">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول الطلاب</h1>
        </div>
        <br>
        <div class="row" >
            <select class="form-control col-12 col-lg-3" id="class_id_filter" >
                    <option value="">اختر صف</option>
                   @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
            </select>
            <select class="form-control col-12 col-lg-3" id="room_id_filter" >
                    <option value="">اخترشعبة</option>
            </select>


        </div>
        <div class="m-4">
            <table class="table align-items-center" id="table_xx">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="sort" data-sort="budget">الإسم الأول</th>
                        <th scope="col" class="sort" data-sort="status">الكنية</th>
                        <th scope="col" class="sort" data-sort="completion">العنوان</th>
                        <th scope="col" class="sort" data-sort="completion">الهاتف</th>
                        <th scope="col" class="sort" data-sort="completion">الصف</th>
                        <th scope="col" class="sort" data-sort="completion">الشعبة</th>
                        <th scope="col" class="sort" data-sort="completion"></th>
                      </tr>
                </thead>
                <tbody >

                </tbody>
              </table>

        </div>
    </div>
</div>



@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.p"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script src="https://unpkg.com/html2canvas@1.0.0-rc.5/dist/html2canvas.js"></script>
<script>

    $(document).ready(function () {
        $(document).on("click",'.export_pdf', function () {

            id = $(this).data('id');
            $.ajax({
                type: "get",
                url: `{{ url('SMT/admin/getstudentsdetails') }}/${id}`,
                success: function (data) {

                    $('#first_name_ar').text(data.first_name);
                    $('#first_name_en').text(data.first_name_en);

                    $('#last_name_ar').text(data.last_name);
                    $('#last_name_en').text(data.last_name_en);

                    $('#father_name').text(data.details.father_name);
                    $('#father_phone').text(data.details.father_phone);
                    $('#father_job').text(data.details.father_job);

                    $('#mother_name').text(data.details.mother_name);
                    $('#mother_phone').text(data.details.mother_phone);
                    $('#mother_job').text(data.details.mother_job);

                    $('#birthday').text(data.date_birth);
                    $('#religion').text(data.religion == "0" ? "مسلم" : "مسيحي");
                    $('#student_address').text(data.address);

                    $('#nationality').text(data.nationality);
                    $('#place_birth').text(data.place_birth);
                    $('#box_birth').text(data.box_birth);

                    $('#student_phone').text(data.details.phone);
                    $('#army_room').text(data.army_room);

                    $('#personal_image').prop('src',"{{ asset('storage/') }}/"+data.details.personal_image);
                    $('#family_notebook').prop('src',"{{ asset('storage/') }}/"+data.details.family_book);
                    $('#mother_image').prop('src',"{{ asset('storage/') }}/"+data.details.mother_image);
                    $('#father_image').prop('src',"{{ asset('storage/') }}/"+data.details.father_image);
                    $('#bond').prop('src',"{{ asset('storage/') }}/"+data.details.fourth_image);

                    $('#passport').prop('src',"{{ asset('storage/') }}/"+data.details.passport);
                    $('#mother_notebook').prop('src',"{{ asset('storage/') }}/"+data.details.mother_page);
                    $('#father_notebook').prop('src',"{{ asset('storage/') }}/"+data.details.father_page);
                    $('#sequence').prop('src',"{{ asset('storage/') }}/"+data.details.study_sequence);
                    $('#last_cert').prop('src',"{{ asset('storage/') }}/"+data.details.certification);
                    $('#ninth_cert').prop('src',"{{ asset('storage/') }}/"+data.details.certification_nine);

                    const input = document.getElementById('divIdToPrint');
                    const input2 = document.getElementById('divIdToPrint2');
                    const pdf = new jsPDF("p","mm","a3");
                        html2canvas(input)
                            .then((canvas) => {
                            const imgData = canvas.toDataURL('image/png');
                            var width = pdf.internal.pageSize.getWidth;
                        var height = pdf.internal.pageSize.getHeight;
                        pdf.addFont('Helvetica', 'Helvetica', 'normal')
                        pdf.setFont('Helvetica')
                        pdf.setFontSize(80);
                        pdf.addImage(imgData, 'png', -2, 20,);
                        html2canvas(input2)
                            .then((canvas) => {
                            const imgData = canvas.toDataURL('image/png');
                            var width = pdf.internal.pageSize.getWidth;
                        var height = pdf.internal.pageSize.getHeight;
                        pdf.addPage();
                        pdf.setPage(2)
                        pdf.addFont('Helvetica', 'Helvetica', 'normal')
                        pdf.setFont('Helvetica')
                        pdf.setFontSize(80);
                        pdf.addImage(imgData, 'png', -2, 20);
                        pdf.save("download.pdf");
                    });
                    });

                }
            });



        });
    });

</script>

<script>

var table_test = $('#table_xx').DataTable({
        processing: true,
        oLanguage: {
            sProcessing: "<h1>Proccessing</h1>"
        },
        serverSide: true,
        "pageLength": 25,
        "ajax": {
            "type": "GET",
            "url": "{{ route('getstudents') }}",
            data : function (d) {
                d.class_id = $('#class_id_filter').val();
                d.room_id= $('#room_id_filter').val();
            },
            "type": "GET",
            "dataSrc": function (json) {
                console.log(json.aaData);
                return json.aaData;
            }
        },
        columns: [
            {

                data: 'id',
                render: function (data, type, full) {
                    return `${full.first_name}`;
                }
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.last_name}`;
                }
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.address}`;
                }
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.details.phone != null ? full.details.phone : ''}`;
                }
            },

            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.room[0] != null ? full.room[0].classes.name : ""}`;
                }
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.room[0] != null ? full.room[0].name : ""}`;
                }
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `<i class="fa fa-file-pdf fa-2x export_pdf" data-toggle="modal" data-target="#selectexport" style="color:#ff6060" data-id="${full.id}"  ></i>`;
                }
            },
        ]
    });


          $('#room_id_filter,#class_id_filter').change(function () {
                table_test.draw();
        })


    $(document).on('click','.delete_class_modal',function (e) {
        $('#delete_class_id').val( $(this).data('id') );
        $('#h4_text').text( " هل انت متأكد من حذف الطالب "+" "+$(this).data('name') );
    });


    $(document).on('click','.change_lang',function(){

        $('#student_change_lang_id').val($(this).data('id'));

        if($(this).data('lang')=='0') {
        $('#option-lang1').prop("checked", true);

        }else if($(this).data('lang')=='1'){
            $('#option-lang2').prop("checked", true);
        }

    });


$(document).on('click','.edit_teacher',function (e) {
    var data = $(this).data('data');

    $('#edit_teacher_id').val(data.id);
    $('#edit_first_name').val(data.first_name);
    $('#edit_last_name').val(data.last_name);
    $('#edit_date_birth').val(data.date_birth);
    $('#edit_address').val(data.address);
    $('#edit_phone').val(data.phone);
    $('#edit_email').val(data.email);

    console.log(data.id);
});



$(document).on('click', '.financial_account', function () {
        var student_id = $(this).data('id');
        var class_id = $(this).data('class');
        var student_name = $(this).data('name');

        $('#student_financial_id').val($(this).data('id'));
        $('#class_id').val($(this).data('class'));
        $('.student_name').text($(this).data('name'));

        var url ="{{ URL::to('SMT/admin/students/invoices_details')}}/"+student_id;
        // $('.details').attr('href',url);
        var url = "{{ URL::to('SMT/admin/students/remain_account') }}/" + student_id +"/"+ class_id;
        $.ajax({
        url: url,
        type: "get",
        contentType: 'application/json',
        success: function (data) {

                $('#full_account').text(data.full_amount);
                $('#remaining_account').text(data.remain_amount);
                $('#amount_paid').text(data.amount_paid);

                $('#invoice_amount').attr('max',data.remain_amount);

                if(data.remain_amount==0){

                    $('.add_reciept').hide();

                }else{
                    $('.add_reciept').show();

                }

            },

        });

});



$(document).on('change', '#classes', function () {
        var class_id = $(this).val();

        var url = "{{ URL::to('SMT/admin/classes/rooms') }}/" + class_id ;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {

                $('#class_room').empty();
                var type = `

                    <option value="">اختر الشعبة الدراسية</option>

                    `;

                $.each(data, function (key, value) {


                    type += `
<option value="${value.id}">${value.name}</option>

                      `;

                });


                $('#class_room').append(type);

            },
            error: function (xhr) {

            }

        });
    });


    $(document).on('change', '#classes_select', function () {

    var year_id=$('#years').val();
    var class_id=$(this).val();
    var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id +"/"+ year_id;
    $('#rooms_classes').empty();
    $('#rooms_classes').append(`<option value="%">جميع الشعب</option>`);
    $.ajax({
        url: url,
        type: "get",
        contentType: 'application/json',
        success: function (data) {
            $.each(data, function (key, value) {
                $('#rooms_classes').append(`<option value="${value.id}">${value.name}</option>`);
            });
        },


    });
    });


    $(document).on('change', '#class_id_filter', function () {

        var year_id=$('#years').val();
        var class_id=$(this).val();
        var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id +"/"+ year_id;
       $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
                $('#room_id_filter').empty();
                $('#room_id_filter').append(`<option value="">اخترشعبة</option>`);
                $.each(data, function (key, value) {
                   $('#room_id_filter').append(`<option value="${value.id}">${value.name}</option>`);
                });
            },


        });
    });




    $(document).on('change', '#classes_change', function () {
        $('#mydivroom').empty();

        var year_id=$('#years').val();
        var class_id=$(this).val();

        var type="";

        var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id +"/"+ year_id;
       $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {
                var type = `
                <label>الشعبة</label>

                <select name="room_change_id" id="" class="form-control dep"
                    style="min-height: 36px;direction:rtl" required>
                    <option value="">اختر الشعبة الدراسية</option>

                    `;

                $.each(data, function (key, value) {
                    type += `<option value="${value.id}">${value.name}</option>`;
                });

                type+=`</select>`;
                $('#mydivroom').append(type);
            },


        });
    });


    $('input:radio[name=select]').on('click', function () {

        $('#mydivclass').empty();

        var val=$(this).val();
        var type="";
        type+=`
                <br>
                <div class="form-group" style="text-align:right">
                <label >الصف</label>

                <select name="class_change_id" id="classes_change" class="form-control dep"
                    style="min-height: 36px;direction: rtl" required>
                    <option value="">اختر الصف الدراسي</option>

                @foreach ($classes as $class)

                <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach

                </select>

            </div>
        `;
        $('#mydivclass').append(type);

    });



$(document).on('click','.change_student',function(){

$('#student_id').val($(this).data('id'));

        var student_id = $(this).data('id');
        var student_name = $(this).data('name');
        var url = "{{ URL::to('SMARMANger/admin/students/student_detail_prev') }}/" + student_id;
$.ajax({
url: url,
type: "get",
contentType: 'application/json',
success: function (data) {
        $('.student_name').text(student_name+ " عام "+ data.year_name  +" كان" + " في الصف  " + data.class_name + " " + data.room_name);
    },
error: function (xhr) {

}

});

});



    $(document).on('click','.student_less',function(e){
        var student_id=$(this).data('id');
        e.preventDefault();
        $.ajax({
            type:'post',
            url:"{{ route('student.less') }}",
            enctype:'multipart/form-data',
            data:{
                '_token':"{{ csrf_token() }}",
                'id':student_id,
            },
            success:function(data){
            $(`#super_${student_id}`).attr('style','color:blue');
            $(`#super_${student_id}`).parent().attr('class','student_super')
            },
        });
    });

    $(document).on('click','.student_super',function(e){
        var student_id=$(this).data('id');
        e.preventDefault();
        $.ajax({

            type:'post',
            url:"{{ route('student.super') }}",
            enctype:'multipart/form-data',
            data:{
                '_token':"{{ csrf_token() }}",
                'id':student_id,
            },


            success:function(data){
            $(`#super_${student_id}`).attr('style','color:green');
            $(`#super_${student_id}`).parent().attr('class','student_less')
                    swal({
                        title: "حسناً",
                        text: "! تمت العملية بنجاح",
                        icon: "success",
                        button: "OK",
                        timer: 2000
                    });
            },

        });

    });

</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
<script >


$(document).on("click",".share_teacher",function () {
    $('#pass_share').text($(this).data("pass"));
    $('#username_share').text($(this).data("username"));
    $('#name_share').text($(this).data("name"));
});

$(document).on("click","#screenshot",function () {
    html2canvas(document.querySelector("#dvContainer")).then(canvas => {
		a = document.createElement('a');
		document.body.appendChild(a);
		a.download = $('#name_share').text()+".png";
		a.href =  canvas.toDataURL();
		a.click();
	});
 });


$(document).on('click','.edit_teacher',function (e) {
    var data = $(this).data('data');

    $('#edit_teacher_id').val(data.id);
    $('#edit_first_name').val(data.first_name);
    $('#edit_last_name').val(data.last_name);
    $('#edit_date_birth').val(data.date_birth);
    $('#edit_address').val(data.address);
    $('#edit_phone').val(data.phone);
    $('#edit_email').val(data.email);

    console.log(data.id);
});
$(".english_name").keypress(function(event){
    var ew = event.which;
    if(ew == 32)
        return true;
    if(48 <= ew && ew <= 57)
        return true;
    if(65 <= ew && ew <= 90)
        return true;
    if(97 <= ew && ew <= 122)
        return true;
    return false;
});
</script>


@endsection
