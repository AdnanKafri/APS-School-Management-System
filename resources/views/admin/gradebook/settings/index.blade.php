@extends('admin.master')

@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
        <a href="{{ route('admin.gradebook.index') }}" class="breadcrumbs__item">دفتر العلامات</a>
        <a class="breadcrumbs__item is-active">إعدادات التوزيع</a>
    </nav>
@endsection

@section('content')
<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header bg-white border-bottom">
            <h4 class="mb-0 text-primary"><i class="fas fa-cogs"></i> إعدادات توزيع العلامات - اختر الصف</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped text-center">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>الصف (Class)</th>
                        <th>عدد الشعب</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classes as $class)
                        <tr>
                            <td>{{ $class->id }}</td>
                            <td class="font-weight-bold">{{ $class->name }}</td>
                            <td>{{ $class->room_count ?? optional($class->room)->count() ?? 0 }}</td>
                            <td>
                                <a href="{{ route('admin.gradebook.settings.rooms', $class->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-door-open"></i> استعراض الشعب
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $classes->links() }}
        </div>
    </div>
</div>
@endsection
