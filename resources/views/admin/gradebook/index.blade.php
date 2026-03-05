@extends('admin.master')

@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
        <a class="breadcrumbs__item is-active">دفتر العلامات</a>
    </nav>
@endsection

@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0"><i class="fas fa-book"></i> دفتر العلامات</h3>
                </div>
                <div class="card-body p-5">
                    <div class="row">
                        <!-- View Option -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-success h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-eye fa-4x text-success mb-3"></i>
                                    <h4 class="card-title">استعراض دفتر العلامات</h4>
                                    <p class="card-text text-muted">عرض علامات الطلاب (للقراءة فقط)</p>
                                    <a href="{{ route('admin.gradebook.view_options') }}" class="btn btn-success btn-lg mt-3">
                                        <i class="fas fa-arrow-left"></i> استعراض
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Option (Disabled for Phase 2) -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-secondary h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-edit fa-4x text-secondary mb-3"></i>
                                    <h4 class="card-title">تعديل دفتر العلامات</h4>
                                    <p class="card-text text-muted">ضبط توزيع العلامات للمواد والصفوف</p>
                                    <a href="{{ route('admin.gradebook.settings') }}" class="btn btn-secondary btn-lg mt-3">
                                        <i class="fas fa-cogs"></i> إعداد التوزيع
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
