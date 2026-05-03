@extends('admin.layouts.v2')

@section('page_title', 'تقارير مستوى الطلاب')
@section('page_subtitle', 'تحليل الأداء الأكاديمي عبر الرسوم البيانية')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .chart-v2 { direction: rtl; }
    .chart-breadcrumbs { display:inline-flex; align-items:center; gap:.45rem; font-size:.88rem; }
    .chart-breadcrumbs__link { color:#8a869a; text-decoration:none; font-weight:700; }
    .chart-breadcrumbs__link:hover { color:#5b4b8a; text-decoration:none; }
    .chart-breadcrumbs__sep { color:#b8b2c6; font-weight:700; }
    .chart-breadcrumbs__current { color:#2f2b3a; font-weight:800; }

    .chart-print-head { display:none; }
    .chart-filter { display:grid; gap:.9rem; grid-template-columns:repeat(12,minmax(0,1fr)); align-items:end; margin-bottom:1rem; }
    .chart-filter__item { grid-column:span 6; }
    .chart-filter label { display:block; margin-bottom:.35rem; color:#4d4762; font-size:.88rem; font-weight:800; text-align:right; }

    .chart-v2 .form-control,
    .chart-v2 .select2-container .select2-selection--single {
        min-height:44px;
        height:44px;
        border-radius:12px !important;
        border:1px solid #dcd6eb !important;
    }

    .chart-box { border:1px solid #ece9f4; border-radius:18px; padding:1rem; background:#fff; }
    .chart-canvas-wrap { position:relative; width:100%; height:460px; }
    #myChart { width:100% !important; height:100% !important; }
    .chart-actions { margin-top:1rem; }

    @media (max-width: 991px) {
        .chart-filter__item { grid-column:span 12; }
        .chart-canvas-wrap { height:360px; }
    }

    @media print {
        .for_hide, .header, .footer { display:none !important; }
        .chart-print-head { display:flex !important; justify-content:space-between; align-items:flex-start; margin-bottom:12mm; }
        .chart-canvas-wrap { height:320mm; }
    }
</style>
@endsection

@section('breadcrumbs')
<nav class="chart-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('dashboard.index') }}" class="chart-breadcrumbs__link">لوحة التحكم</a>
    <span class="chart-breadcrumbs__sep">/</span>
    <a href="{{ route('reports') }}" class="chart-breadcrumbs__link">قسم التقارير</a>
    <span class="chart-breadcrumbs__sep">/</span>
    <span class="chart-breadcrumbs__current">تقارير مستوى الطلاب</span>
</nav>
@endsection

@section('content')
@php
    $school_data = \App\School_data::first();
@endphp

<div class="chart-v2">
    <div class="v2-card" style="padding:1.2rem;">
        <div class="chart-print-head for_show">
            <div style="text-align:right;">
                <h4 style="margin:0 0 .35rem;">الجمهورية العربية السورية</h4>
                <h4 style="margin:0 0 .35rem;">{{ $school_data->name ?? '' }}</h4>
                <h5 style="margin:0 0 .35rem;">تقرير الطلاب</h5>
                <h5 style="margin:0;">{{ $year_name ?? '' }}</h5>
            </div>
            <div>
                @if(!empty($school_data->logo))
                    <img src="{{ asset('storage/'.$school_data->logo) }}" alt="logo" style="max-height:90px;">
                @endif
            </div>
        </div>

        <div class="chart-filter for_hide">
            <div class="chart-filter__item student_option" id="mediumModal">
                <label for="student_id">الطالب</label>
                <select name="student_id" id="student_id" class="form-control"></select>
                <label id="name_id" class="for_show" style="display:none;"></label>
            </div>

            <div class="chart-filter__item">
                <label for="lesson_id">المادة</label>
                <select name="room" id="lesson_id" class="form-control"></select>
                <label class="for_show" style="display:none;">المادة: <span id="lesson_name"></span></label>
            </div>
        </div>

        <div class="chart-box">
            <div class="chart-canvas-wrap">
                <canvas id="myChart"></canvas>
            </div>
        </div>

        <div class="chart-actions for_hide">
            <a id="export" class="btn btn-primary">تصدير</a>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function () {
    let idd = '';
    let lesson_id = '';

    const ctx = document.getElementById('myChart');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['شفهي ف1', 'وظائف ف1', 'نشاطات ف1', 'مذاكرة ف1', 'امتحان ف1', 'شفهي ف2', 'وظائف ف2', 'نشاطات ف2', 'مذاكرة ف2', 'امتحان ف2'],
            datasets: []
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { max: 100, min: 0, ticks: { font: { size: 14 } } },
                x: { ticks: { font: { size: 12 } } }
            },
            plugins: { legend: { labels: { font: { size: 12 } } } }
        }
    });

    $(document).on('click', '#export', function () {
        $('.for_hide').hide();
        $('.for_show').show();
        window.print();
        $('.for_hide').show();
        $('.for_show').hide();
    });

    function formatRepo(repo) {
        if (repo.loading) return repo.text;
        const $container = $("<div class='select2-result-repository clearfix'><div class='select2-result-repository__meta'><div class='select2-result-repository__title'></div></div></div>");
        $container.find('.select2-result-repository__title').text(repo.first_name + ' ' + repo.last_name);
        return $container;
    }

    function formatRepoSelection(repo) {
        if (!repo || !repo.first_name) return repo.text || '';
        $('#student_id').find(':selected').data('id', repo.id);
        return repo.first_name + ' ' + repo.last_name;
    }

    $('#student_id').select2({
        dropdownParent: $('#mediumModal'),
        ajax: {
            url: function () { return `{{ URL::to('SMT/admin/getstudent/select2/') }}`; },
            dataType: 'json',
            delay: 250,
            data: function (params) { return { q: params.term, page: params.page }; },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return { results: data.results, pagination: { more: data.pagination.more } };
            }
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    $(document).on('change', '#lesson_id', function () {
        $('#lesson_name').text($(this).find(':selected').text());
        idd = $('#student_id').find(':selected').data('id');
        lesson_id = $(this).val();

        if (idd !== '') {
            $.ajax({
                type: 'get',
                url: "{{ route('get_data_chart') }}",
                data: { id: idd, lesson_id: lesson_id },
                contentType: 'application/json',
                success: function (data) {
                    chart.data.datasets = [];
                    let xx = 0;
                    const palette = ['#E14ECA','#007954','#0084F8','#7F70F4','#0088D5','#FF55A3','#FF777C','#FFA460','#FFD058','#F9F871','#52424E','#B8A6B3','#D76F00','#993D00','#640058','#789222','#447898'];
                    $.each(data, function (index, value) {
                        chart.data.datasets.push({
                            backgroundColor: palette[xx % palette.length],
                            borderColor: palette[xx % palette.length],
                            label: index,
                            data: [value.oral, value.homework, value.activities, value.quize, value.exam, value.oral2, value.homework2, value.activities2, value.quize2, value.exam2],
                            borderWidth: 3
                        });
                        xx++;
                    });
                    chart.update();
                }
            });
        }
    });

    $(document).on('change', '#student_id', function () {
        chart.data.datasets = [];
        chart.update();

        $('#name_id').text($('#student_id').find(':selected').text());
        idd = $('#student_id').find(':selected').data('id');
        $('#lesson_id').empty();

        if (idd !== '') {
            $.ajax({
                type: 'get',
                url: "{{ route('get_info_class_bystudent') }}",
                data: { id: idd },
                contentType: 'application/json',
                success: function (data) {
                    $('#lesson_id').append('<option value="">اختر مادة</option>');
                    $('#lesson_id').append('<option value="0">كل المواد</option>');
                    $.each(data.lesson, function (index, value) {
                        $('#lesson_id').append(`<option value="${value.id}">${value.name}</option>`);
                    });
                }
            });
        }
    });
});
</script>
@endsection
