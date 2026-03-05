@extends('admin.master')
@section('style')

<style>
.content-body{
        min-height: 0px !important;
}
.text-white{
    margin: 0px !important;
}
.card{
    height: 200px;
    text-align: center !important
}
*{
    text-align: center !important;
    direction: rtl !important;
    /* font */
}
select , input:not(.select2-search__field) {
    width:75% !important;
    display:inline-block !important;
}
label{
    font-size: 20px;
    margin: 10px;
    color: black;
    font-weight: 600;
}

@media print {
    #myChart {
        width: 100% !important;
        max-width: none !important;
    }
}

</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

       @endsection


@section('breadcrumbs')

<nav class="breadcrumbs">
    <a  class="breadcrumbs__item  is-active">قسم تقارير مستوى الطلاب</a>

    <a href="{{ route('reports') }}" class="breadcrumbs__item ">قسم التقارير  </a>

    <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item ">الصفحة الرئيسية</a>
</nav>

@endsection

@section('content')
<h1 class="mt-5 mb-5 for_hide"  >  قسم تقارير مستوى الطلاب </h1>
 @php
  $school_data = \App\School_data::first();
   @endphp

<div class="row for_show" style="text-align: right !important;direction: rtl !important;margin: 0px;display: none;margin-top: 50px ;">
    <div  style="text-align: right !important;float: right;width: 50% !important" >
        <h2 style="text-align: center;width: 50%;" > الجمهورية العربية السورية </h2>
        <h2 style="text-align: center;width: 50%;" >      {{$school_data->name}}  </h2>
        <h3 style="text-align: center;width: 50%;" > تقرير الطلاب  </h3>
        <h3 style="text-align: center;width: 50%;" > {{ $year_name }}  </h3>
    </div>
    {{-- <div style="text-align: right !important;float: right;margin-right: 20%" > --}}
        {{-- <h3 style="text-align: center;width: 50%;" >  </h3> --}}
        {{-- @if( $room_name != '' )  <h3 style="text-align: center;width: 100%;" >  الشعبة : {{ $room_name }}  </h3>  @endif --}}
        {{-- @if( $lesson_name != '' )  <h3 style="text-align: center;width: 100%;" >  المادة : {{ $lesson_name }}  </h3>  @endif --}}
    {{-- </div> --}}
@php
$about = \App\Other::find(1);
@endphp

    <div  style="text-align: left !important;float: left;width: 50% !important" >
        <img src="{{asset("storage/")}}/{{$school_data->logo}}" height="200" width="170" alt="">
    </div>

</div>

<div class="row" >
    <div class="col-1"></div>
    <div class="col-10" >
        <form style="margin-bottom: 300px" >


            <div class="form-group student_option " id="mediumModal">
              <label for="exampleInputEmail1">  الطالب :</label>
              <label for="" class="for_show" id="name_id" style="display: none"></label>
              <div class="for_hide">
                  <select name="student_id" id="student_id" class="form-control " style="width: 50% !important;" >

                  </select>
              </div>
            </div>



            <div class="form-group for_hide" >
              <label for="exampleInputEmail1">  المادة </label>
              <select name="room" id="lesson_id" class="form-control " >

              </select>
            </div>

            <div class="form-group for_show" style="display: none" >
              <label for="exampleInputEmail1">  المادة :</label>
              <label for="" id="lesson_name" ></label>
            </div>


            <div>
                <canvas id="myChart"></canvas>
              </div>

              <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

              <script>
                const ctx = document.getElementById('myChart');

               chart = new Chart(ctx, {
                  type: 'line',
                  data: {
                    // borderWidth : 20,
                    labels: ['شفهي ف1', 'وظائف ف1', 'نشاطات ف1', 'مذاكرة ف1', 'امتحان ف1','شفهي ف2', 'وظائف ف2', 'نشاطات ف2', 'مذاكرة ف2', 'امتحان ف2',],
                    datasets: []
                  },
                  options: {
                    scales: {
                        y: {
                            max: 100,
                            min: 0,
                            ticks: {
                                font: {
                                    size: 20,
                                }
                            }

                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 20,
                                }
                            }

                        },
                    },
                    plugins: {
                        legend: {
                            labels: {
                                // This more specific font property overrides the global property
                                font: {
                                    size: 20
                                }
                            }
                        }
                    }
                  }
                });


              </script>


              <div>
                <canvas id="myChart"></canvas>
              </div>



            <a  id="export"  class="btn btn-success for_hide"> تصدير <a>

          </form>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$(document).ready(function () {


    $(document).on('click','#export', function () {
        $('.header').hide();
        $('.footer').hide();
        $('.for_hide').hide();
        $('.for_show').show();
        window.print();
        $('.for_hide').show();
        $('.for_show').hide();
        $('.header').show();
        $('.footer').show();
    })


    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }

        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title' data-id data-access></div>" +
            "</div>" +
            "</div>" +
            "</div>"
        );
        console.log(repo);
        $container.find(".select2-result-repository__title").text(repo.first_name+" "+repo.last_name);
        $container.find(".select2-result-repository__title").data('id',repo.id);

        return $container;
    }

    function formatRepoSelection(repo) {
        // console.log(repo);
        $("#student_id").find(":selected").text(repo.first_name+" "+repo.last_name);
        $("#student_id").find(":selected").data('id', repo.id)
            return repo.first_name+" "+repo.last_name;
    }

    var customer_access;

    $("#student_id").select2({
        dropdownParent: $("#mediumModal"),
        ajax: {
            url: function () {
                var url = `{{ URL::to('SMT/admin/getstudent/select2/') }}`;
                return url;
            },
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                console.log(data);
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;
                // var result_data = $.map(data.results, function(item) {
                //     if (item.name.includes(params.term) || params.term === "") return item;
                // });
                return {
                    results: data.results,
                    pagination: {
                        more: data.pagination.more
                    }
                };
            },
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection

    });


    $(document).on('change','#lesson_id', function () {
        $('#lesson_name').text( $(this).find(":selected").text() );
        console.log(idd);
        idd = $("#student_id").find(":selected").data('id');
        lesson_id = $(this).val();
        if (idd != '') {
            $.ajax({
                type: "get",
                url: "{{ route('get_data_chart') }}",
                data: {
                    'id':idd,
                    'lesson_id' : lesson_id
                },
                contentType: 'application/json',
                success: function (data) {
                    console.log(data);
                    chart.data.datasets = [];
                    xx= 0;

                    $.each(data, function (index, value) {
                    backgroundColor= ["#E14ECA","#007954","#0084F8", "#7F70F4","#0088D5","#FF55A3","#FF777C","#FFA460","#FFD058","#F9F871","#52424E","#B8A6B3","#D76F00","#993D00","#640058","#789222","#447898"],
                    borderColor= ["#E14ECA","#007954","#0084F8", "#7F70F4","#0088D5","#FF55A3","#FF777C","#FFA460","#FFD058","#F9F871","#52424E","#B8A6B3","#D76F00","#993D00","#640058","#789222","#447898"],

                        chart.data.datasets.push({
                            backgroundColor : backgroundColor[xx],
                            borderColor : borderColor[xx++],
                            label: index,
                            data: [value.oral,value.homework,value.activities,value.quize,value.exam,
                            value.oral2,value.homework2,value.activities2,value.quize2,value.exam2],
                            borderWidth: 3,
                        });
                    });
                    // .forEach(dataset => {
                    //     dataset.data = Utils.numbers({count: chart.data.labels.length, min: -100, max: 100});
                    // });

                    chart.update();
                }
            });
        }

    })



    $(document).on('change','#student_id', function () {

        chart.data.datasets = [];
        chart.update();

        console.log($('#student_id').find(":selected").text());
        $('#name_id').text($("#student_id").find(":selected").text());
       idd = $("#student_id").find(":selected").data('id');
       $('#lesson_id').empty();
        if (idd != '') {
            $.ajax({
                type: "get",
                url: "{{ route('get_info_class_bystudent') }}",
                data: {
                    'id':idd
                },
                contentType: 'application/json',
                success: function (data) {
                    $('#lesson_id').append(` <option value="" > اختر مادة </option> `);
                    $('#lesson_id').append(` <option value="0" > كل المواد </option> `);
                    $.each(data.lesson, function (index, value) {
                        $('#lesson_id').append(` <option value="${value.id}" > ${value.name} </option> `);
                    });
                }
            });
        }

    })

    // $(document).on('change','#option_id', function () {
    //     if( $(this).val() == "s" ){
    //         $('.student_option').show();
    //         $('.class_option').hide();
    //     }else{
    //         $('.student_option').hide();
    //         $('.class_option').show();
    //     }
    // })




    // $(document).on('change','#class_id', function () {
    //     $('#room_id').empty();
    //     $('#lesson_id').empty();
    //     if ($(this).val() != '') {
    //         $.ajax({
    //             type: "get",
    //             url: "{{ route('get_info_class') }}",
    //             data: {
    //                 'id':$('#class_id').val()
    //             },
    //             contentType: 'application/json',
    //             success: function (data) {
    //                 console.log(data);
    //                 $('#room_id').append(` <option value="0" > كل الشعب </option> `);
    //                 $.each(data.room, function (index, value) {
    //                     $('#room_id').append(` <option value="${value.id}" > ${value.name} </option> `);
    //                 });
    //                 // $('#lesson_id').append(` <option value="0" > كل المواد </option> `);
    //                 $.each(data.lesson, function (index, value) {
    //                     $('#lesson_id').append(` <option value="${value.id}" > ${value.name} </option> `);
    //                 });
    //             }
    //         });
    //     }
    // });

});

</script>
@endsection

