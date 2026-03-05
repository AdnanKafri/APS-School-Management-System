@extends('admin.master')

@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
        <a href="{{ route('admin.gradebook.index') }}" class="breadcrumbs__item">دفتر العلامات</a>
        <a class="breadcrumbs__item is-active">خيارات العرض</a>
    </nav>
@endsection

@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-info text-white text-center">
                    <h3 class="mb-0"><i class="fas fa-list"></i> خيارات العرض</h3>
                </div>
                <div class="card-body p-5">
                    <div class="row">
                        <!-- View by Subject -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-primary h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-book-open fa-4x text-primary mb-3"></i>
                                    <h4 class="card-title">عرض حسب المادة</h4>
                                    <p class="card-text text-muted">عرض علامات جميع الطلاب في مادة معينة</p>
                                    <a href="{{ route('admin.gradebook.view_classes_subject') }}" class="btn btn-primary btn-lg mt-3">
                                        <i class="fas fa-arrow-left"></i> اختيار المادة
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- View by Student -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-warning h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-user-graduate fa-4x text-warning mb-3"></i>
                                    <h4 class="card-title">عرض حسب الطالب</h4>
                                    <p class="card-text text-muted">عرض جميع علامات طالب معين</p>
                                    <a href="{{ route('admin.gradebook.view_classes_student') }}" class="btn btn-warning btn-lg mt-3">
                                        <i class="fas fa-arrow-left"></i> اختيار الطالب
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
