@extends('admin.master')

@section('breadcrumbs')
    <nav class="breadcrumbs">
        <a href="{{ route('dashboard.index') }}" class="breadcrumbs__item">الرئيسية</a>
        <a href="{{ route('admin.gradebook.index') }}" class="breadcrumbs__item">دفتر العلامات</a>
        <a href="{{ route('admin.gradebook.settings') }}" class="breadcrumbs__item">إعدادات التوزيع</a>
        <a class="breadcrumbs__item is-active">الشعب الصفية</a>
    </nav>
@endsection

@section('content')
<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header bg-white border-bottom">
            <h4 class="mb-0 text-primary"><i class="fas fa-door-open"></i> اختر الشعبة</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped text-center">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>الشعبة (Room)</th>
                        <th>عدد الطلاب</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td>{{ $room->id }}</td>
                            <td class="font-weight-bold">{{ $room->name }}</td>
                            <td>{{ optional($room->student)->count() ?? 0 }}</td>
                            <td>
                                <a href="{{ route('admin.gradebook.settings.subjects', $room->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-book"></i> ضبط المواد
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $rooms->links() }}
        </div>
    </div>
</div>
@endsection
