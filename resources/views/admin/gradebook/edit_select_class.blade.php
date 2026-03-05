@extends('admin.master')

@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
        <a href="{{ route('admin.gradebook.index') }}" class="breadcrumbs__item">دفتر العلامات</a>
        <a class="breadcrumbs__item is-active">إختيار الصف</a>
    </nav>
@endsection

@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-4">اختر الصف لإعداد دفتر العلامات</h4>
        </div>
    </div>
    <div class="row">
        @foreach($classes as $class)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
            <a href="{{ route('admin.gradebook.edit_subject', $class->id) }}" class="text-decoration-none">
                <div class="card shadow-sm text-center p-3 h-100 gradient-4 custom-hover">
                    <div class="card-body">
                        <h4 class="text-white font-weight-bold">{{ $class->name }}</h4>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<style>
    .custom-hover:hover {
        transform: translateY(-5px);
        transition: transform 0.3s;
    }
</style>
@endsection
