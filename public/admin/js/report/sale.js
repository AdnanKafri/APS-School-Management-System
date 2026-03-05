$('#ok').on('click', function () {
    var month = $('#month').val();
    var quarter = $('#quarter').val();
    var year = $('#year').val();
    var monthArray = [];
    var yearArray = [];
    var quarterArray = [];

    $.ajax({
        url: url_sales + "/" + month + "/" + quarter + "/" + year,
        type: "get",


        contentType: 'application/json',
        success: function (data) {
            //{month
            $.each(data.month, function (key, value) {
                monthArray.push({
                    v: parseInt(value),
                    k: key
                });
            });

            monthArray.push({
                v: parseInt(data['targetmonth']),
                k: "targetmonth"
            });

            monthArray.sort(function (a, b) {
                if (a.v > b.v) {
                    return 1
                }
                if (a.v < b.v) {
                    return -1
                }
                return 0;
            });

            $.each(monthArray, function (n, v) {
                if (v.k == 'month') {
                    monthArray.splice(n, 1);
                    return false;
                }
            })

            $.each(monthArray, function (n, v) {
                if (v.k == 'totalmonth') {
                    monthArray.splice(n, 1);
                    return false;
                }

            })
            var month = data['month']['month'];
            var totalmonth = data['month']['totalmonth'];
            var maxemummonth = data['month']['maxemummonth'];
            var minemummonth = data['month']['minemummonth'];
            var avregmonth = data['month']['avregmonth'];
            var targetmonth = data['targetmonth'];
// console.log(totalmonth);
            $(function () {
                class GaugeChart {
                    constructor(element, params) {
                        this._element = element;
                        this._initialValue = params.initialValue;
                        this._higherValue = params.higherValue;
                        this._title = params.title;
                        this._subtitle = params.subtitle;
                    }

                    _buildConfig() {
                        let element = this._element;

                        return {
                            value: this._initialValue,
                            valueIndicator: {
                                color: '#fff'
                            },
                            geometry: {
                                startAngle: 180,
                                endAngle: 360
                            },
                            scale: {
                                startValue: 0,
                                endValue: this._higherValue,
                                customTicks: [0, monthArray[0].v, monthArray[1].v, monthArray[2].v, monthArray[3].v],
                                tick: {
                                    length: 0
                                },
                                label: {
                                    font: {
                                        color: '#87959f',
                                        size: 9,
                                        family: '"Open Sans", sans-serif'
                                    }
                                }
                            },
                            title: {
                                verticalAlignment: 'bottom',
                                text: this._title,
                                font: {
                                    family: '"Open Sans", sans-serif',
                                    color: 'black',
                                    size: 12
                                },
                                subtitle: {
                                    text: this._subtitle,
                                    font: {
                                        family: '"Open Sans", sans-serif',
                                        color: 'black',
                                        weight: 700,
                                        size: 30
                                    }
                                }
                            },
                            onInitialized: function () {
                                let currentGauge = $(element);
                                let circle = currentGauge.find(
                                        '.dxg-spindle-hole')
                                    .clone();
                                let border = currentGauge.find(
                                        '.dxg-spindle-border')
                                    .clone();

                                currentGauge.find(
                                        '.dxg-title text')
                                    .first()
                                    .attr('y', 48);
                                currentGauge.find(
                                        '.dxg-title text')
                                    .last()
                                    .attr('y', 90);
                                currentGauge.find(
                                        '.dxg-value-indicator')
                                    .append(border, circle);
                            }

                        }
                    }

                    init() {
                        $(this._element).dxCircularGauge(this
                            ._buildConfig());
                    }
                }
                $('.gauge1').each(function (index, item) {
                    let params;
                    params = {
                        initialValue: parseFloat(totalmonth),
                        higherValue: monthArray[monthArray.length - 1].v,
                        title: `Total: ${data.month.totalmonth} \n Min: ${data.month.minemummonth} \n Max: ${data.month.maxemummonth} \n Target: ${data.targetmonth} \n Sales Avg: ${data.month.avregmonth}`,
                        subtitle: 'Month:' + month
                    };

                    let gauge = new GaugeChart(item, params);
                    gauge.init();
                });

            });

            //endmonth
            //year

            $.each(data.year, function (key, value) {
                yearArray.push({
                    v: parseInt(value),
                    k: key
                });
            });

            yearArray.push({
                v: parseInt(data['targetyear']),
                k: "targetyear"
            });

            yearArray.sort(function (a, b) {
                if (a.v > b.v) {
                    return 1
                }
                if (a.v < b.v) {
                    return -1
                }
                return 0;
            });

            $.each(yearArray, function (n, v) {
                if (v.k == 'year') {
                    yearArray.splice(n, 1);
                    return false;
                }

            })

            $.each(yearArray, function (n, v) {
                if (v.k == 'totalyear') {
                    yearArray.splice(n, 1);
                    return false;
                }

            })

            var year = data['year']['year'];
            var totalyear = data['year']['totalyear'];
            var maxemumyear = data['year']['maxemumyear'];
            var minemumyear = data['year']['minemumyear'];
            var avregyear = data['year']['avregyear'];
            var targetyear = data['targetyear'];

            $(function () {
                class GaugeChart {
                    constructor(element, params) {
                        this._element = element;
                        this._initialValue = params.initialValue;
                        this._higherValue = params.higherValue;
                        this._title = params.title;
                        this._subtitle = params.subtitle;
                    }



                    _buildConfig() {
                        let element = this._element;

                        return {
                            value: 400,
                            valueIndicator: {
                                color: '#fff'
                            },
                            geometry: {
                                startAngle: 180,
                                endAngle: 360
                            },
                            scale: {
                                startValue: 0,
                                endValue: 840,
                                customTicks: [0, yearArray[0].v, yearArray[1].v, yearArray[2].v, yearArray[3].v],
                                tick: {
                                    length: 0
                                },
                                label: {
                                    font: {
                                        color: '#87959f',
                                        size: 9,
                                        family: '"Open Sans", sans-serif'
                                    }
                                }
                            },
                            title: {
                                verticalAlignment: 'bottom',
                                text: this._title,
                                font: {
                                    family: '"Open Sans", sans-serif',
                                    color: 'black',
                                    size: 12
                                },
                                subtitle: {
                                    text: this._subtitle,
                                    font: {
                                        family: '"Open Sans", sans-serif',
                                        color: 'black',
                                        weight: 700,
                                        size: 30
                                    }
                                }
                            },
                            onInitialized: function () {
                                let currentGauge = $(element);
                                let circle = currentGauge.find(
                                        '.dxg-spindle-hole')
                                    .clone();
                                let border = currentGauge.find(
                                        '.dxg-spindle-border')
                                    .clone();

                                currentGauge.find(
                                        '.dxg-title text')
                                    .first()
                                    .attr('y', 48);
                                currentGauge.find(
                                        '.dxg-title text')
                                    .last()
                                    .attr('y', 90);
                                currentGauge.find(
                                        '.dxg-value-indicator')
                                    .append(border, circle);
                            }

                        }
                    }

                    init() {
                        $(this._element).dxCircularGauge(this
                            ._buildConfig());
                    }
                }

                $('.gauge2').each(function (index, item) {
                    let params;
                    params = {
                        initialValue: parseFloat(totalyear),
                        higherValue: yearArray[yearArray.length - 1].v,
                        title: `Total: ${data.year.totalyear} \n Min: ${data.year.minemumyear} \n Max: ${data.year.maxemumyear} \n Target: ${data.targetyear} \n Sales Avg: ${data.year.avregyear}`,
                        subtitle: 'Year:' + year
                    };

                    let gauge = new GaugeChart(item, params);
                    gauge.init();
                });

            });
            //endyear


            //quarter

            $.each(data.quarter, function (key, value) {
                quarterArray.push({
                    v: parseInt(value),
                    k: key
                });
            });

            quarterArray.push({
                v: parseInt(data['targetquarter']),
                k: "targetquarter"
            });

            quarterArray.sort(function (a, b) {
                if (a.v > b.v) {
                    return 1
                }
                if (a.v < b.v) {
                    return -1
                }
                return 0;
            });

            $.each(quarterArray, function (n, v) {
                if (v.k == 'quarter') {
                    quarterArray.splice(n, 1);
                    return false;
                }
            })

            $.each(quarterArray, function (n, v) {
                if ( v.k == 'totalquarter') {
                    quarterArray.splice(n, 1);
                    return false;

                }
            })
            var Quart = data['quarter']['quarter'];
            var totalQuart = data['quarter']['totalquarter'];
        

            $(function () {
                class GaugeChart {
                    constructor(element, params) {
                        this._element = element;
                        this._initialValue = params.initialValue;
                        this._higherValue = params.higherValue;
                        this._title = params.title;
                        this._subtitle = params.subtitle;
                    }
                    _buildConfig() {
                        let element = this._element;
                        return {
                            value: this._initialValue,
                            valueIndicator: {
                                color: '#fff'
                            },
                            geometry: {
                                startAngle: 180,
                                endAngle: 360
                            },
                            scale: {
                                startValue: 0,
                                endValue: this._higherValue,
                                customTicks: [0, quarterArray[0].v, quarterArray[1].v, quarterArray[2].v, quarterArray[3].v],
                                tick: {
                                    length: 0
                                },
                                label: {
                                    font: {
                                        color: '#87959f',
                                        size: 9,
                                        family: '"Open Sans", sans-serif'
                                    }
                                }
                            },
                            title: {
                                verticalAlignment: 'bottom',
                                text: this._title,
                                font: {
                                    family: '"Open Sans", sans-serif',
                                    color: 'black',
                                    size: 12
                                },
                                subtitle: {
                                    text: this._subtitle,
                                    font: {
                                        family: '"Open Sans", sans-serif',
                                        color: 'black',
                                        weight: 700,
                                        size: 30
                                    }
                                }
                            },
                            onInitialized: function () {
                                let currentGauge = $(element);
                                let circle = currentGauge.find(
                                        '.dxg-spindle-hole')
                                    .clone();
                                let border = currentGauge.find(
                                        '.dxg-spindle-border')
                                    .clone();

                                currentGauge.find(
                                        '.dxg-title text')
                                    .first()
                                    .attr('y', 48);
                                currentGauge.find(
                                        '.dxg-title text')
                                    .last()
                                    .attr('y', 90);
                                currentGauge.find(
                                        '.dxg-value-indicator')
                                    .append(border, circle);
                            }

                        }
                    }

                    init() {
                        $(this._element).dxCircularGauge(this
                            ._buildConfig());
                    }
                }

                $('.gauge3').each(function (index, item) {
                    let params;
                    params = {
                        initialValue: parseFloat(totalQuart),
                        higherValue: quarterArray[quarterArray.length - 1].v,
                        title: `Total: ${data.quarter.totalquarter} \n Min: ${data.quarter.minemumquarter} \n Max: ${data.quarter.maxemumquarter} \n Target: ${data.targetquarter} \n Sales Avg: ${data.quarter.avregquarter}`,
                        subtitle: 'Quarter:' + quarter
                    };

                    let gauge = new GaugeChart(item, params);
                    gauge.init();
                });

            });

            //endquarter

        },
        error: function (xhr) {

        }
    });


})
