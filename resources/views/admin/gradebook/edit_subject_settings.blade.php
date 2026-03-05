@extends('admin.master')

@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
        <a href="{{ route('admin.gradebook.index') }}" class="breadcrumbs__item">دفتر العلامات</a>
        <a href="{{ route('admin.gradebook.edit_class') }}" class="breadcrumbs__item">إختيار الصف</a>
        <a href="{{ route('admin.gradebook.edit_subject', $class->id) }}" class="breadcrumbs__item">{{ $class->name }}</a>
        <a class="breadcrumbs__item is-active">{{ $subject->name }}</a>
    </nav>
@endsection

@section('content')
<div class="container-fluid mt-5">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-3 text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-white">إعدادات العلامات: {{ $subject->name }} ({{ $class->name }})</h4>
        </div>
        <div class="card-body">
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle"></i> 
                هذه صفحة نموذجية لإعداد العلامات. في المرحلة القادمة (المرحلة 2)، سيتم تفعيل إمكانية تعديل الأوزان (الشفهي، الوظائف، الامتحان، إلخ).
                <br>
                <strong>الحالة الحالية:</strong> هيكلية فقط (Phase 1A)
            </div>

            <form>
                <div class="form-row">
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">العلامة العظمى</label>
                        <input type="number" class="form-control" value="{{ $subject->max_mark }}" readonly>
                        <small class="text-muted">موروث من إعدادات المادة</small>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="font-weight-bold">العلامة الصغرى</label>
                        <input type="number" class="form-control" value="{{ $subject->min_mark }}" readonly>
                    </div>
                </div>

                <hr>
                <h5 class="mb-3 font-weight-bold display-2" style="font-size: 1.2rem;">مكونات العلامة (نموذج)</h5>
                <div class="row">
                    <div class="col-md-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkOral" checked disabled>
                            <label class="custom-control-label" for="checkOral">شفهي (Oral)</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkHW" checked disabled>
                            <label class="custom-control-label" for="checkHW">وظائف (Homework)</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkExam" checked disabled>
                            <label class="custom-control-label" for="checkExam">امتحان (Exam)</label>
                        </div>
                    </div>
                </div>

                <div class="mt-5 text-center">
                    <button type="button" class="btn btn-primary disabled"><i class="fas fa-save"></i> حفظ الإعدادات (قريباً)</button>
                    <a href="{{ route('admin.gradebook.edit_subject', $class->id) }}" class="btn btn-secondary">عودة</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
