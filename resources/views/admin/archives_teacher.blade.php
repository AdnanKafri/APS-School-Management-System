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
        border: 0px  !important;
        text-align: center !important;
    }
    td{
        font-size: 17px;
        color: black;
        border: 0px !important;
        text-align: center;
    }
    tr{
        border-bottom: 1px solid #008991 !important;
        border-top: 1px solid #008991 !important;
    }
    a.page-link{
        color: #7571f9 !important;
    }
    .pagination{
        justify-content: center;
    }
    .form-group{
        margin: 0px !important;
    }

.dt-button{
    font-size: 20px !important;
    color: black !important;
    line-height: 2
}
  .content-body{
                min-height: auto !important;
        }
#report_wrapper{
    overflow: auto;
}
</style>
<link href="{{ asset('assets/admin/plugins/toastr/css/toastr.min.css')  }}" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item  is-active">ارشفة   المعلمين  </a>
    <a href="{{ route('archives') }}" class="breadcrumbs__item ">قسم  الارشفة  </a>
    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الصفحة الرئيسية</a>
</nav>

@endsection


@section('content')





<div class="card" style="margin: 30px">
    <div class="card-body">
        <div class="card-title">
            <h1 style="text-align: center;color: #001586">جدول  المعلمين </h1>
        </div>
       
         
            
             <form action="{{ route('export_teacher_archive') }}" method="post">
                   @csrf
        <div class="row" >
         
            
            <div class=" col-12 col-lg-3" style="    text-align: justify;">
                <label for="">  حدد السنة  </label>
               
                <select class="form-control a"   id="search" required name="year_id" >
                    <option value="">  اختر السنة  </option>
                    @foreach ($years as $year)
                        <option value="{{$year->id}}">  {{$year->name}} </option>
                    @endforeach
                </select>
            </div>
        
             <div class=" col-12 col-lg-3" style="
            text-align: center;">
                  
                  <div id="disabled">
                      <button class="btn btn-success" type="submit" id="export" style="margin-top: 40px;" >  تصدير  المعلمين    </button>
                  </div>
                
               
            </div> 
            
        </div>
         </form>
        
            {{-- <div class=" col-12 col-lg-12" style="
            text-align: center;">
                <a class="btn btn-success" id="search" > بحث  </a>
            </div> --}}
       
        <br>
        <br>
        <div id="nodata">
            <p style="font-size: x-large;
    text-align: center;">لايوجد بيانات </p>  </div>
        <div class="report" style="display:none">
            @can('student_phone')
            <input type="hidden"  id="hidden_student_phone" value="1">
                @endcan
            <table class="table align-items-center " id="table_xx" >
                <thead style="color: black">
                  <tr>
                  
                    <th scope="col" class="sort" data-sort="budget">الاسم الأول</th>
                    <th scope="col" class="sort" data-sort="status">الكنية</th>
                    <th scope="col" class="sort" data-sort="status">تاريخ الميلاد</th>
                    <th scope="col" class="sort" data-sort="completion">العنوان</th>
                    <th scope="col" class="sort" data-sort="completion">الهاتف</th>
                    <th scope="col" class="sort" data-sort="completion">الصورة </th>
                    
                  </tr>
                </thead>
                <tbody class="list" id="mydiv">


                </tbody>
              </table>



        </div>
    </div>
</div>



@endsection

@section('js')
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.p"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

<script>


     var table_test = $('#table_xx').DataTable({
   
    });
    $(document).on('change', '#search', function () {
    $('#disabled').empty();
    $('#disabled').append(`<button class="btn btn-success" type="submit" id="export" style="margin-top: 40px;" >  تصدير معلمين   </button>`);

        if ($.fn.DataTable.isDataTable('#table_xx')) {
            $('#table_xx').DataTable().destroy();
        }
   $('#nodata').hide();
  $('.report').show();
     year =$(this).val();
    
        var table_test = $('#table_xx').DataTable({

processing: true,
oLanguage: {
    sProcessing: "<h1>Proccessing</h1>"
},
serverSide: true,
"pageLength": 10,
"ajax": {
    "type": "GET",
    "url": "{{ route('archive_teacher_year') }}",
    data: function (d) {
        d.year_id = year;

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
                    return `${full.date_birth}`;
                }, orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.address}`;
                },orderable : false
            },
            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.phone != null ? full.phone : ''}`;
                }, orderable : false
            },
          

            {
                data: 'id',
                render: function (data, type, full) {
                    return `${full.image != null ? `<img width="80" height="80" src="{!! asset('storage') !!}/${full.image}" >` : ""}`;
                },orderable : false
            },
       
        ]


});

//      }
//      else{
//         var table_test = $('#table_xx').DataTable({

// processing: true,
// oLanguage: {
//     sProcessing: "<h1>Proccessing</h1>"
// },
// serverSide: true,
// "pageLength": 10,
// "ajax": {
//     "type": "GET",
//     "url": "{{ route('archive_student_year') }}",
//     data: function (d) {
//         d.year_id = year;

//     },
//     "type": "GET",
//     "dataSrc": function (json) {
//         console.log(json.aaData);

//         return json.aaData;
//     }
// },

// columns: [

//       {

//         data: 'id',
//         render: function (data, type, full) {
//             return  `${full.id}`;
//         },orderable : false
//     },

// {

//         data: 'id',
//         render: function (data, type, full) {
//             return  `${full.first_name}`;
//         },orderable : false
//     },
//     {
//         data: 'id',
//         render: function (data, type, full) {
//             return `${full.last_name}`;
//         },orderable : false
//     },
//     {
//         data: 'id',
//         render: function (data, type, full) {
//             return `${full.address}`;
//         },orderable : false
//     },
    

//     {
//         data: 'id',
//         render: function (data, type, full) {
//             return `${full.details.personal_image != null ? `<img width="80" height="80" src="{!! asset('storage') !!}/${full.details.personal_image}" >` : ""}`;
//         },orderable : false
//     },

//     {
//         data: 'id',
//         render: function (data, type, full) {
//             return `${full.classname != null ? full.classname: ""}`;
//         },orderable : false
//     },
//     {
//         data: 'id',
//         render: function (data, type, full) {
//             v=full.room[0].id;
//             return `${full.room[0] != null ? full.room[0].name : ""}`;
//         },orderable : false
//     },
//     {
//         data: 'id',
//         render: function (data, type, full) {
//             v=full.room[0].id;
//             return `${full.key_country} ${full.total}`;
//         },orderable : false
//     },
//     {
//         data: 'id',
//         render: function (data, type, full) {

//             return ` <a href="{{ url('SMT/admin/archives_students_details') }}/${full.id}"  style="color: #0083FF"><i class="fa fa-eye fa-2x" style="color: #008CC4;font-size: medium"></i></a>`;
//         },orderable : false
//     },

  

// ],
// // dom: 'Bfrtip',
// buttons: [

//     'excelHtml5',

// ]


// });

//      }
  

});

</script>
@endsection
