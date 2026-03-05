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
    img{
        border-radius:50%;
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
#table_xx_wrapper{
    overflow: auto;
}
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">

@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item is-active">      مدفوعات  </a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')




<div class="card" style="margin: 30px">
    <div class="card-body">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول الطلاب</h1>
        </div>
        <div class="row" style="direction: rtl">

                <select class="form-control col-lg-3" id="class_id_filter" style="margin-left: 15px;">
                    <option value="">اختر صف</option>
                    @foreach ($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
    
         
    
           
                <select class="form-control  col-lg-3" id="room_id_filter">
                    <option value="">اختر شعبة</option>
                </select>
      
        </div>
        <br>
        <div class="row" style="direction: rtl">
            <div class=" col-lg-2 col-sm-4 col-12">
                <label>  الفواتير من تاريخ  </label>
            </div>
                <div class=" col-lg-2 col-sm-4 col-12">
                <input type="date"  class="form-control" placeholder="" id="date1">
            </div>
   
                <div class=" col-lg-2 col-sm-4 col-12">
                <label> الى تاريخ </label>
                </div>
                <div class=" col-lg-2 col-sm-4 col-12">
                <input type="date"  class="form-control" placeholder="" id="date2">
            </div>
        </div>
        <div class="row">
        {{-- <div class=" col-12 col-lg-2" style="text-align: left;">
            @can('export_student_invoices')
            <a class="btn btn-success" id="export"> تصدير الطلاب </a>
            @endcan
        </div> --}}


        </div>
        <div class="m-4">
            <table class="table align-items-center" id="table_xx">
                <thead class="thead-light">
                    <tr>

                        <th scope="col" class="sort" data-sort="completion"> المبلغ  </th>
                        <th scope="col" class="sort" data-sort="completion">  الدولة</th>
                        <th scope="col" class="sort" data-sort="completion">نسبة  وزارة التربية  </th>
                        <th scope="col" class="sort" data-sort="completion">نسبة  المالية  </th>
                        <th scope="col" class="sort" data-sort="completion"> العملة</th>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.esm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.p"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>



<script>
       $(document).on('click','#export', function () {
     
           amount = $('#amount_balance').val();
                type= $('#type_filtter').val();
                class_id = $('#class_id_filter').val();
                room_id = $('#room_id_filter').val();
                date1 = $('#date1').val();
                date2 = $('#date2').val();
                if(!type){
                    type=0;
                }
                if(!class_id){
                    class_id=null;
                }
                if(!room_id){
                    room_id=null;
                }
                if(!date1){
                    date1=null;
                }
                if(!date2){
                    date2=null;
                }
                if(!amount){
                    amount=0;
                }
            window.open(`{{ url('SMT/admin/finastudent1') }}/${class_id}/${room_id}/${type}/${amount}/${date1}/${date2}`, '_blank');
       
    })
    $('#room_id_filter').change(function () {
        table_test.draw();
    })

    $(document).on('change', '#class_id_filter', function () {

var year_id = $('#years').val();
var class_id = $(this).val();
var url = "{{ URL::to('SMT/admin/classes/rooms2') }}/" + class_id + "/" + year_id;
$.ajax({
    url: url,
    type: "get",
    contentType: 'application/json',
    success: function (data) {
        $('#room_id_filter').empty();
        $('#room_id_filter').append(`<option value="">اخترشعبة</option>`);
        $.each(data, function (key, value) {
            $('#room_id_filter').append(
                `<option value="${value.id}">${value.name}</option>`);
        });
         table_test.draw();
    },


});
});

        $('#type_filtter').change(function () {
            if ($('#min').val()!='' && $('#max').val()!='' ) {
                table_test.draw();
            }
        })
        $('#date2').change(function () {
            if ($('#date1').val()!=''  ) {
                table_test.draw();
            }
        })
        $('#amount_balance').keyup(function () {
            if ($('#min').val()!='' && $('#max').val()!='' ) {
                table_test.draw();
            }
        })

var table_test = $('#table_xx').DataTable({
        processing: true,
        oLanguage: {
            sProcessing: "<h1>Proccessing</h1>"
        },
        
        serverSide: true,
        "pageLength": 10,
        "bFilter": false,
        "ajax": {
            "type": "GET",
            "url": "{{ route('getstudentsfina_datails') }}",
            "type": "GET",
            data : function (d) {
                d.amount = $('#amount_balance').val();
                d.type= $('#type_filtter').val();
                d.class_id = $('#class_id_filter').val();
                d.room_id = $('#room_id_filter').val();
                d.date1 = $('#date1').val();
                d.date2 = $('#date2').val();
                
            },
            "dataSrc": function (json) {
                console.log(json.aaData);
                return json.aaData;
            }
        },
        columns: [
              
            {

                data: 'id',
                render: function (data, type, full) {
                    return `${full.cost}`;
                }, orderable : false
            },
            {

                data: 'id',
                render: function (data, type, full) {
                    return `${full.key}`;
                }, orderable : false
            },

              
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.rate_ministerial}`;
                },
                orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.rate_financial}`;
                },
                orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.key_country}`;
                },
                 orderable : false
            },
         
        ],
       
      

    });




    $(document).on('click', '.financial_account', function () {
        var student_id = $(this).data('id');
        var class_id = $(this).data('class');
        var student_name = $(this).data('name');

        $('#student_financial_id').val($(this).data('id'));
        $('#class_id').val($(this).data('class'));
        $('.student_name').text($(this).data('name'));

        var url = "{{ URL::to('SMT/admin/students/invoices_details')}}/" + student_id;
        $('.details').attr('href',url);
        var url = "{{ URL::to('SMT/admin/students/remain_account') }}/" + student_id + "/" + class_id;
        $.ajax({
            url: url,
            type: "get",
            contentType: 'application/json',
            success: function (data) {

                $('#full_account').text(data.full_amount);
                $('#remaining_account').text(data.remain_amount);
                $('#amount_paid').text(data.amount_paid);

                $('#invoice_amount').attr('max', data.remain_amount);

                if (data.remain_amount == 0) {

                    $('.add_reciept').hide();

                } else {
                    $('.add_reciept').show();

                }

            },

        });

    });



</script>

@endsection
