$('#button_sales_year').on('click', function () {
    $('#table_report').DataTable().destroy();
    $('#h5').empty();
    $("#tr").empty();
    $("#body_report").empty();
    $("#count").empty();
    $("#chart").empty();
    $('#chart_row').css('display', 'block');
    var x
    var y
    var orderCount
    var url = url_sale_year;
    $.ajax({
        url: url,
        type: "get",
        contentType: 'application/json',
        success: function (data) {

            $('#h5').append(`	<h5 class="modal-title" id="largeModalLabel">@lang('site.quotation_incomplete_report')</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>`)
            var year = [];
            var d = [];
            $.each(data, function (key, value) {
                year[key] = value.year;
                d[key] = value.totalmonth;
                x=value.test;
                y = value.month;
            })
            console.log(x);
            
            if (x == 0) {
                $("#chart").append(` 
    

            <h3 class="title-2 m-b-40">Yearly Sales</h3>
            <canvas id="team-chart"></canvas>
   


     `)
            } else {
                $("#chart").append(` 

            <h3 class="title-2 m-b-40">Yearly Sales for month ${y}</h3>
            <canvas id="team-chart"></canvas>



     `)
            }




            var ctx = document.getElementById("team-chart");
            if (ctx) {
                ctx.height = 150;
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: year,
                        type: 'line',
                        defaultFontFamily: 'Poppins',
                        datasets: [{
                            data: d,
                            label: "Sales",
                            backgroundColor: 'rgba(0,103,255,.15)',
                            borderColor: 'rgba(0,103,255,0.5)',
                            borderWidth: 3.5,
                            pointStyle: 'circle',
                            pointRadius: 5,
                            pointBorderColor: 'transparent',
                            pointBackgroundColor: 'rgba(0,103,255,0.5)',
                        }, ]
                    },
                    options: {
                        responsive: true,
                        tooltips: {
                            mode: 'index',
                            titleFontSize: 12,
                            titleFontColor: '#000',
                            bodyFontColor: '#000',
                            backgroundColor: '#fff',
                            titleFontFamily: 'Poppins',
                            bodyFontFamily: 'Poppins',
                            cornerRadius: 3,
                            intersect: false,
                        },
                        legend: {
                            display: false,
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                fontFamily: 'Poppins',
                            },


                        },
                        scales: {
                            xAxes: [{
                                display: true,
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                scaleLabel: {
                                    display: false,
                                    labelString: 'Month'
                                },
                                ticks: {
                                    fontFamily: "Poppins"
                                }
                            }],
                            yAxes: [{
                                display: true,
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Value',
                                    fontFamily: "Poppins"
                                },
                                ticks: {
                                    fontFamily: "Poppins"
                                }
                            }]
                        },
                        title: {
                            display: false,
                        }
                    }
                });
            }
        },
        error: function (xhr) {}
    });
});
