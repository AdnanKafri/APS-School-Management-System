@extends('students.layouts.app4')

@section('title', 'التقرير الأكاديمي')

@section('content')
    <div class="container-fluid py-4" dir="rtl">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">
                    <div>
                        <h2 class="mb-2">التقرير الأكاديمي</h2>
                        <p class="text-muted mb-0">
                            لا يوجد تصميم تقرير مرحلي مخصص لهذا الصف حالياً.
                        </p>
                    </div>
                    <span class="badge badge-info">{{ $year->name }}</span>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3 h-100">
                            <small class="text-muted d-block">الطالب</small>
                            <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3 h-100">
                            <small class="text-muted d-block">الصف</small>
                            <strong>{{ $class->name }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="border rounded p-3 h-100">
                            <small class="text-muted d-block">الشعبة</small>
                            <strong>{{ $room->name }}</strong>
                        </div>
                    </div>
                </div>

                <div class="alert alert-light border mb-0">
                    العلامات والنتائج الأكاديمية محفوظة ويمكن عرضها من السجل الأكاديمي.
                    لم يتم تطبيق قالب درجات خاص بالصف على هذا التقرير.
                </div>
            </div>
        </div>
    </div>
@endsection
