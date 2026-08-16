@extends('admin.layouts.v2')

@section('page_title', 'الترقية السنوية')
@section('page_subtitle', 'إعداد توزيع الطلاب للعام الدراسي التالي دون تعديل السجل الأكاديمي السابق')

@section('style')
<style>
    .year-end-page { direction: rtl; text-align: right; }
    .year-end-card { background: #fff; border: 1px solid #e9e5f2; border-radius: 18px; box-shadow: 0 8px 24px rgba(35, 27, 64, .06); margin-bottom: 18px; padding: 18px; }
    .year-end-toolbar { display:flex; gap:10px; align-items:center; justify-content:space-between; flex-wrap:wrap; }
    .year-end-table { min-width: 1080px; }
    .year-end-table th, .year-end-table td { vertical-align: middle; }
    .year-end-table select { min-width: 150px; }
    .year-end-filters { display:grid; grid-template-columns:minmax(220px,1.5fr) repeat(2,minmax(170px,1fr)); gap:10px; }
    .year-end-count { color:#6d6780; font-size:.9rem; }
    .year-end-hidden { display:none !important; }
    .year-end-note { color:#6d6780; font-size:.9rem; }
    @media (max-width: 768px) { .year-end-card { padding: 12px; } .year-end-table-wrap { overflow-x:auto; } }
</style>
@endsection

@section('content')
<div class="year-end-page">
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

    <div class="year-end-card">
        <div class="year-end-toolbar">
            <div>
                <h3 class="mb-1">الترقية إلى العام الدراسي التالي</h3>
                <p class="year-end-note mb-0">لا يتم تفعيل العام الجديد من هذه الصفحة، ولا يتم نسخ أي علامات أو سجلات مالية.</p>
            </div>
            <form method="POST" action="{{ route('admin.year_end.clone_rooms') }}">@csrf
                <button class="btn btn-outline-primary" type="submit" {{ !$targetYear ? 'disabled' : '' }}>تجهيز شعب العام التالي</button>
            </form>
        </div>
        <p class="year-end-note mt-2 mb-0">تجهيز الشعب ينسخ بنية الشعب وأسماءها من العام الحالي إلى العام التالي فقط، ولا ينقل طلاباً ولا علامات ولا بيانات مالية.</p>
        <form id="year-end-bulk-form" class="mt-3" method="POST" action="{{ route('admin.year_end.process_bulk') }}">
            @csrf
            <input type="hidden" name="items" id="year-end-bulk-items">
            <button class="btn btn-primary" type="submit" {{ !$targetYear ? 'disabled' : '' }}>تنفيذ الطلاب المحددين</button>
            <span class="year-end-note mr-2">يمكن تعديل أي طالب منفرداً من زر الحفظ في صفه.</span>
        </form>
        <div class="row mt-3">
            <div class="col-md-6"><strong>العام الحالي:</strong> {{ optional($sourceYear)->name ?: 'غير محدد' }}</div>
            <div class="col-md-6"><strong>العام التالي:</strong> {{ optional($configuredTargetYear)->name ?: 'غير مرتبط' }} @if($yearConfigurationError)<span class="text-danger">(غير صالح)</span>@endif</div>
        </div>
        @if($yearConfigurationError)<div class="alert alert-warning mt-3 mb-0">{{ $yearConfigurationError }}</div>@endif
    </div>

    @if($targetYear)
    <div class="year-end-card">
        @php($roomCatalog = $rooms->map(function ($room) { return ['id' => $room->id, 'name' => $room->name, 'class_id' => $room->class_id]; })->values())
        <div class="year-end-filters mb-3">
            <input type="search" class="form-control" id="year-end-search" placeholder="ابحث باسم الطالب أو رقمه">
            <select class="form-control" id="year-end-current-class"><option value="">كل الصفوف الحالية</option>@foreach($classes as $class)<option value="{{ $class->id }}">{{ $class->name }}</option>@endforeach</select>
            <select class="form-control" id="year-end-current-section"><option value="">كل الشعب الحالية</option>@foreach($enrollments->pluck('sourceRoom')->filter()->unique('id')->sortBy('name') as $room)<option value="{{ $room->id }}">{{ $room->name }}</option>@endforeach</select>
        </div>
        <div class="d-flex align-items-center justify-content-between flex-wrap mb-2">
            <label class="mb-0"><input type="checkbox" id="year-end-select-visible"> تحديد كل الظاهر</label>
            <span class="year-end-count" id="year-end-count"></span>
        </div>
        <div class="year-end-table-wrap">
            <table class="table table-hover year-end-table">
                <thead><tr><th>تحديد</th><th>الطالب</th><th>الصف / الشعبة الحالية</th><th>النتيجة</th><th>الصف المستهدف</th><th>الشعبة المستهدفة</th><th>إجراء</th></tr></thead>
                <tbody>
                @forelse($enrollments as $enrollment)
                    @php($student = $enrollment->student)
                    @if($student && $enrollment->sourceRoom)
                    <tr class="promotion-row" data-name="{{ strtolower(trim($student->first_name.' '.$student->last_name)) }}" data-student-id="{{ $student->id }}" data-current-class="{{ $enrollment->sourceRoom->class_id }}" data-current-section="{{ $enrollment->sourceRoom->id }}">
                        <td class="text-center">
                            <input type="checkbox" class="js-promotion-select" data-student-id="{{ $student->id }}" aria-label="تحديد الطالب">
                        </td>
                        <td>
                            <form id="year-end-{{ $student->id }}" method="POST" action="{{ route('admin.year_end.process') }}">@csrf
                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                            </form>
                            {{ trim($student->first_name.' '.$student->last_name) }}
                        </td>
                        <td>{{ optional($enrollment->sourceRoom->classes)->name }} / {{ $enrollment->sourceRoom->name }}</td>
                        <td><select form="year-end-{{ $student->id }}" name="outcome" class="form-control js-outcome"><option value="promote">ترقية للصف التالي</option><option value="repeat">إعادة نفس الصف</option><option value="manual">نقل استثنائي / تحديد يدوي</option></select></td>
                        <td><select form="year-end-{{ $student->id }}" name="class_id" class="form-control js-target-class" data-next-class="{{ optional($enrollment->sourceRoom->classes)->next_class }}" data-current-class="{{ $enrollment->sourceRoom->class_id }}">@foreach($classes as $class)<option value="{{ $class->id }}">{{ $class->name }}</option>@endforeach</select></td>
                        <td><select form="year-end-{{ $student->id }}" name="room_id" class="form-control js-target-room"></select></td>
                        <td><button form="year-end-{{ $student->id }}" type="submit" class="btn btn-primary">تنفيذ لهذا الطالب</button></td>
                    </tr>
                    @endif
                @empty
                    <tr><td colspan="7" class="text-center text-muted">لا يوجد طلاب مرتبطون بالعام الحالي.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

@section('script')
<script>
(function () {
    var roomCatalog = @json($roomCatalog);
    function filterRooms(row) {
        var classSelect = row.querySelector('.js-target-class');
        var roomSelect = row.querySelector('.js-target-room');
        var submitButton = row.querySelector('button[type="submit"]');
        if (!classSelect || !roomSelect) return;
        var selected = String(classSelect.value);
        roomSelect.innerHTML = '';
        var matching = roomCatalog.filter(function (room) { return String(room.class_id) === selected; });
        if (!matching.length) {
            var empty = document.createElement('option');
            empty.value = '';
            empty.textContent = 'لا توجد شعب لهذا الصف في العام التالي';
            roomSelect.appendChild(empty);
            roomSelect.disabled = true;
            if (submitButton) submitButton.disabled = true;
            return;
        }
        roomSelect.disabled = false;
        if (submitButton) submitButton.disabled = false;
        matching.forEach(function (room) {
            var option = document.createElement('option');
            option.value = room.id;
            option.textContent = room.name;
            roomSelect.appendChild(option);
        });
    }
    function visibleRows() { return Array.prototype.filter.call(document.querySelectorAll('.promotion-row'), function (row) { return !row.classList.contains('year-end-hidden'); }); }
    function updateCount() { document.getElementById('year-end-count').textContent = 'الظاهر: ' + visibleRows().length + ' | المحدد: ' + document.querySelectorAll('.js-promotion-select:checked').length; }
    function applyFilters() {
        var query = (document.getElementById('year-end-search').value || '').toLowerCase().trim();
        var currentClass = document.getElementById('year-end-current-class').value;
        var currentSection = document.getElementById('year-end-current-section').value;
        Array.prototype.forEach.call(document.querySelectorAll('.promotion-row'), function (row) {
            var matches = (!query || row.getAttribute('data-name').indexOf(query) !== -1 || row.getAttribute('data-student-id') === query)
                && (!currentClass || row.getAttribute('data-current-class') === currentClass)
                && (!currentSection || row.getAttribute('data-current-section') === currentSection);
            row.classList.toggle('year-end-hidden', !matches);
            if (!matches) row.querySelector('.js-promotion-select').checked = false;
        });
        updateCount();
    }
    Array.prototype.forEach.call(document.querySelectorAll('.year-end-table tbody tr'), function (row) {
        var classSelect = row.querySelector('.js-target-class');
        var outcomeSelect = row.querySelector('.js-outcome');
        if (classSelect) {
            if (classSelect.getAttribute('data-next-class') && classSelect.value !== classSelect.getAttribute('data-next-class')) {
                classSelect.value = classSelect.getAttribute('data-next-class');
            }
            classSelect.addEventListener('change', function () { filterRooms(row); });
            if (outcomeSelect) outcomeSelect.addEventListener('change', function () {
                var destination = this.value === 'promote' ? classSelect.getAttribute('data-next-class') : (this.value === 'repeat' ? classSelect.getAttribute('data-current-class') : classSelect.value);
                if (destination) classSelect.value = destination;
                filterRooms(row);
            });
            filterRooms(row);
        }
    });
    ['year-end-search', 'year-end-current-class', 'year-end-current-section'].forEach(function (id) {
        document.getElementById(id).addEventListener(id === 'year-end-search' ? 'input' : 'change', applyFilters);
    });
    document.getElementById('year-end-select-visible').addEventListener('change', function () {
        visibleRows().forEach(function (row) { row.querySelector('.js-promotion-select').checked = this.checked; }, this);
        updateCount();
    });
    Array.prototype.forEach.call(document.querySelectorAll('.js-promotion-select'), function (checkbox) { checkbox.addEventListener('change', updateCount); });
    applyFilters();
    var bulkForm = document.getElementById('year-end-bulk-form');
    if (bulkForm) bulkForm.addEventListener('submit', function (event) {
        var items = [];
        Array.prototype.forEach.call(document.querySelectorAll('.js-promotion-select:checked'), function (checkbox) {
            var row = checkbox.closest('tr');
            items.push({
                student_id: checkbox.getAttribute('data-student-id'),
                outcome: row.querySelector('.js-outcome').value,
                class_id: row.querySelector('.js-target-class').value,
                room_id: row.querySelector('.js-target-room').value
            });
        });
        if (!items.length) { event.preventDefault(); window.alert('يرجى تحديد طالب واحد على الأقل.'); return; }
        if (!window.confirm('سيتم إعداد الطلاب المحددين للعام الدراسي التالي. تأكد من الصفوف والشعب ثم أكد المتابعة.')) { event.preventDefault(); return; }
        document.getElementById('year-end-bulk-items').value = JSON.stringify(items);
    });
})();
</script>
@endsection
