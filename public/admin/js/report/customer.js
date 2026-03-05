$('#customer_purchases').on('click', function () {
    $('#table_report').DataTable().destroy();
    $('#h5').empty();
    $("#tr").empty();
    $("#body_report").empty();
    $("#count").empty();
    $("#chart").empty();
    $('#chart_row').css('display', 'block');
    var url = url_customer;
    // var cust_Name1;
    // var cust_Name2;
    // var cust_Name3;
    // var cust_Name4;
    // var cust_Name5;


    $.ajax({
        url: url,
        type: "get",
        contentType: 'application/json',
        success: function (data) {


            $('#h5').append(`	<h5 class="modal-title" id="largeModalLabel">@lang('site.customer_purchases_report')</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>`)
            $("#tr").append(` <th>@lang('site.count')</th>
                    <th>@lang('site.customers')</th>
                    <th>@lang('site.company_name')</th>`)


            $.each(data.cust, function (key, val) {
                $("#body_report").append(` <tr>
                         <td>${val.count}</td>
                         <td> ${ val.name  }</td>
                         <td> ${ val.name_company  }</td>
                     </tr> `)
                $('td').css('text-align', 'center');
            })
            $('.table').removeAttr('id');
            $('.table').attr('id','table_report');
            
            $('#table_report').DataTable({"pageLength": 5} );
            var top5_array = {};
            var customer_check = [];
            $.each(data.top5, function (key, value) {
                top5_array[key] = value;
                customer_check.push(value.customer_id);
            })
            var item1 = top5_array[0];
            var item2 = top5_array[1];
            var item3 = top5_array[2];
            var item4 = top5_array[3];
            var item5 = top5_array[4];

            var count_month1 = [];
            var count_month2 = [];
            var count_month3 = [];
            var count_month4 = [];
            var count_month5 = [];

            $.each(data.datamonth, function (key_customer, value_month) {
                if (key_customer == item2.customer_id) {
                    var array = $.map(value_month, function (value, index) {
                        return [value];
                    });
                    array.sort(function (a, b) {
                        return a.month - b.month;
                    });
                    $.each(array, function (key_array, value_array) {
                        count_month2.push(value_array.count);
                    });
                }
            })


            $.each(data.datamonth, function (key_customer, value_month) {
                if (key_customer == item1.customer_id) {
                    var array = $.map(value_month, function (value, index) {
                        return [value];
                    });
                    array.sort(function (a, b) {
                        return a.month - b.month;
                    });
                    $.each(array, function (key_array, value_array) {
                        count_month1.push(value_array.count);
                    });
                }
            })

            $.each(data.datamonth, function (key_customer, value_month) {
                if (key_customer == item3.customer_id) {
                    var array = $.map(value_month, function (value, index) {
                        return [value];
                    });
                    array.sort(function (a, b) {
                        return a.month - b.month;
                    });
                    $.each(array, function (key_array, value_array) {
                        count_month3.push(value_array.count);
                    });
                }
            })
            $.each(data.datamonth, function (key_customer, value_month) {
                if (key_customer == item4.customer_id) {
                    var array = $.map(value_month, function (value, index) {
                        return [value];
                    });
                    array.sort(function (a, b) {
                        return a.month - b.month;
                    });
                    $.each(array, function (key_array, value_array) {
                        count_month4.push(value_array.count);
                    });
                }
            })
            $.each(data.datamonth, function (key_customer, value_month) {
                if (key_customer == item5.customer_id) {
                    var array = $.map(value_month, function (value, index) {
                        return [value];
                    });
                    array.sort(function (a, b) {
                        return a.month - b.month;
                    });
                    $.each(array, function (key_array, value_array) {
                        count_month5.push(value_array.count);
                    });
                }
            })

            $("#chart").append(`   
              <h3 class="title-2 m-b-40">Bar chart</h3>
              <canvas id="barChart"></canvas>
            `)

            try {
                //bar chart
                var ctx = document.getElementById("barChart");
                if (ctx) {
                    ctx.height = 100;
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        defaultFontFamily: 'Poppins',
                        data: {
                            labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                            datasets: [{

                                    label: item1.name_company,

                                    data: count_month1,

                                    borderColor: "rgba(127, 127, 119, 0.9)",
                                    borderWidth: "0",
                                    backgroundColor: "rgba(0, 123, 255, 0.5)",
                                    fontFamily: "Poppins"
                                },
                                {
                                    label: item2.name_company,
                                    data: count_month2,
                                    borderColor: "rgba(127, 127, 119, 0.9)",
                                    borderWidth: "0",
                                    backgroundColor: "#086972",
                                    fontFamily: "Poppins"
                                },
                                {
                                    label: item3.name_company,
                                    data: count_month3,
                                    borderColor: "rgba(127, 127, 119, 0.9)",
                                    borderWidth: "0",
                                    backgroundColor: "#01a9b4",
                                    fontFamily: "Poppins"
                                },
                                {
                                    label: item4.name_company,
                                    data: count_month4,
                                    borderColor: "rgba(127, 127, 119, 0.9)",
                                    borderWidth: "0",
                                    backgroundColor: "#87dfd6",
                                    fontFamily: "Poppins"
                                },
                                {
                                    label: item5.name_company,
                                    data: count_month5,
                                    borderColor: "rgba(127, 127, 119 ,0.09)",
                                    borderWidth: "0",
                                    backgroundColor: "#035aa6",
                                    fontFamily: "Poppins"
                                }
                            ]
                        },
                        options: {
                            legend: {
                                position: 'top',
                                labels: {
                                    fontFamily: 'Poppins'
                                }

                            },
                            scales: {
                                xAxes: [{
                                    ticks: {
                                        fontFamily: "Poppins"

                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        fontFamily: "Poppins"
                                    }
                                }]
                            }
                        }
                    });
                }


            } catch (error) {
                console.log(error);
            }



        },
        error: function (xhr) {
            console.log();

        }
    });
});
