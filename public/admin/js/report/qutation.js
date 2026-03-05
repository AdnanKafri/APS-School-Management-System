$('#quotation_incomplete_report').on('click', function () {
    $('#h5').empty();
    $('#table_report').DataTable().destroy();
    $("#tr").empty();
    $("#body_report").empty();
    $("#count").empty();
    $("#chart").empty();
    $('#chart_row').css('display', 'block');
    var x
    var y
    var orderCount
    var url = url_test;
    $.ajax({
        url: url,
        type: "get",
        contentType: 'application/json',
        success: function (data) {
            console.log(data);

            $('#h5').append(`	<h5 class="modal-title" id="largeModalLabel">@lang('site.quotation_incomplete_report')</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>`)
            $("#tr").append(`
                          <th>@lang('site.order_id')</th>
                          <th>@lang('site.customers')</th>
                          <th>@lang('site.company_name')</th>
                        
                       <!-- <th>@lang('site.quentity')</th>  -->
                          <th>@lang('site.date')</th> 
                  
                    
                           `)


            $("#chart").append(` 
                           <div class="row">

                           <div class="col-md-6">
                           <h3 class="title-2 tm-b-5">char by %</h3>
                           <div class="row no-gutters">
                               <div class="col-xl-6">
                                   <div class="chart-note-wrap">
                                       <div class="chart-note mr-0 d-block">
                                           <span class="dot dot--blue"></span>
                                           <span>Qutation</span>
                                       </div>
                                       <div class="chart-note mr-0 d-block">
                                           <span class="dot dot--red"></span>
                                           <span>Order</span>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-xl-6">
                                   <div class="percent-chart">
                                       <canvas id="percent-chart"></canvas>
                                   </div>
                               </div>
                           </div>
                           </div>
                           <div class="col-md-6">
                           <h3 class="title-2 tm-b-5">char by %</h3>
                           <div class="row no-gutters">
                               <div class="col-xl-6">
                                   <div class="chart-note-wrap">
                                       <div class="chart-note mr-0 d-block">
                                           <span class="dot dot--blue" style="    background: #f2be1a;"></span>
                                           <span>invoice</span>
                                       </div>
                                       <div class="chart-note mr-0 d-block">
                                           <span class="dot dot--red"></span>
                                           <span>Order</span>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-xl-6">
                                   <div class="percent-chart">
                                       <canvas id="chart-inv"></canvas>
                                   </div>
                               </div>
                           </div>
                           </div>
                           </div>

                     
                            `)


            $.each(data, function (key, val) {
                //  x =val.invoiceCount.countinv;
                //  y =val.qutatioCount.countqutation;

                x = val.qutatioCount;
                y = val.invoiceCount;
                orderCountx = 100 - x;
                orderCounty = 100 - y;

                $.each(val.qutation, function (key, val) {
                    $("#body_report").append(` <tr>
            <td>${val.order_id}</td>
            <td> ${ val.name  }</td>
            <td> ${ val.name_company  }</td>
            <!--   <td> ${ val.countqutation  }</td> -->
            <td> ${ val.ddd  }</td>
           
        </tr> 
        
        
        `)
                    $('td').css('text-align', 'center');
                })

                $('.table').removeAttr('id');
                $('.table').attr('id','table_report');
                
                $('#table_report').DataTable({"pageLength": 5} );
            })


            var ctx = document.getElementById("percent-chart");
            if (ctx) {
                ctx.height = 280;
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            label: "My First dataset",
                            data: [x, orderCountx],
                            backgroundColor: [
                                '#00b5e9',
                                '#fa4251'
                            ],
                            hoverBackgroundColor: [
                                '#00b5e9',
                                '#fa4251'
                            ],
                            borderWidth: [
                                0, 0
                            ],
                            hoverBorderColor: [
                                'transparent',
                                'transparent'
                            ]
                        }],
                        labels: [
                            'Qutation',
                            'Order'
                        ]
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        cutoutPercentage: 55,
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            titleFontFamily: "Poppins",
                            xPadding: 15,
                            yPadding: 10,
                            caretPadding: 0,
                            bodyFontSize: 16
                        }
                    }
                });
            }


            var ctx = document.getElementById("chart-inv");
            if (ctx) {
                ctx.height = 280;
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            label: "My First dataset",
                            data: [y, orderCounty],
                            backgroundColor: [
                                '#fcbf1e',
                                '#fa4251'
                            ],
                            hoverBackgroundColor: [
                                '#fcbf1e',
                                '#fa4251'
                            ],
                            borderWidth: [
                                0, 0
                            ],
                            hoverBorderColor: [
                                'transparent',
                                'transparent'
                            ]
                        }],
                        labels: [
                            'invoice',
                            'Order'
                        ]
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        cutoutPercentage: 55,
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            titleFontFamily: "Poppins",
                            xPadding: 15,
                            yPadding: 10,
                            caretPadding: 0,
                            bodyFontSize: 16
                        }
                    }
                });
            }
        },
        error: function (xhr) {}
    });
});
