@extends('admin.master')

@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
        <a href="{{ route('admin.gradebook.index') }}" class="breadcrumbs__item">دفتر العلامات</a>
        <a href="{{ route('admin.gradebook.edit_class') }}" class="breadcrumbs__item">إختيار الصف</a>
        <a class="breadcrumbs__item is-active">{{ $class->name }}</a>
    </nav>
@endsection

@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-bottom">
                    <h4 class="text-primary">إعداد المواد للصف: {{ $class->name }}</h4>
                </div>
                <div class="card-body">
                    @if($subjects->isEmpty())
                        <div class="alert alert-warning text-center">لا يوجد مواد متاحة لهذا الصف.</div>
                    @else
                        <div class="list-group">
                            @foreach($subjects as $subject)
                                <a href="{{ route('admin.gradebook.edit_settings', $subject->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center mb-2 shadow-sm rounded">
                                    <div>
                                        <h5 class="mb-1 text-dark font-weight-bold">{{ $subject->name }}</h5>
                                        <small class="text-muted">{{ $subject->name_en }}</small>
                                    </div>
                                    <span class="badge badge-primary badge-pill p-2"><i class="fas fa-cog"></i> إعداد</span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
