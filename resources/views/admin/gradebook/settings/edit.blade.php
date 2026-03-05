@extends('admin.master')

@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
        <a href="{{ route('admin.gradebook.index') }}" class="breadcrumbs__item">دفتر العلامات</a>
        <a href="{{ route('admin.gradebook.settings') }}" class="breadcrumbs__item">إعدادات التوزيع</a>
        <a class="breadcrumbs__item is-active">تعديل التوزيع</a>
    </nav>
@endsection

@section('content')
<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-edit"></i> توزيع علامات: {{ $subject->name }}</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('admin.gradebook.settings.update', $subject->id) }}" method="POST">
                        @csrf
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> يرجى تحديد الحد الأقصى (Max Mark) لكل جزء من العلامة.
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">علامة الشفهي (Oral Max)</label>
                            <div class="col-sm-8">
                                <input type="number" name="oral_max" class="form-control" value="{{ $config->oral_max }}" min="0" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">علامة الوظائف/المذاكرات (H.W/Quiz Max)</label>
                            <div class="col-sm-8">
                                <input type="number" name="homework_max" class="form-control" value="{{ $config->homework_max }}" min="0" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label font-weight-bold">علامة الامتحان (Exam Max)</label>
                            <div class="col-sm-8">
                                <input type="number" name="exam_max" class="form-control" value="{{ $config->exam_max }}" min="0" required>
                            </div>
                        </div>

                        <div class="form-group row border-top pt-3">
                            <label class="col-sm-4 col-form-label font-weight-bold text-primary">المجموع الكلي (Total)</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control-plaintext font-weight-bold text-primary" readonly value="(يتم الحساب تلقائياً: املأ الحقول وتأكد من المجموع)">
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="fas fa-save"></i> حفظ الإعدادات
                            </button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-lg ml-2">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
