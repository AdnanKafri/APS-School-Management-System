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
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow border-0">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary font-weight-bold">
                        <i class="fas fa-sliders-h mr-2"></i>توزيع علامات: {{ $subject->name }}
                    </h5>
                    <span class="badge badge-primary px-3 py-2">العلامة الكلية: {{ $subject->max_mark }}</span>
                </div>
                
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success fade show">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.gradebook.settings.update', $subject->id) }}" method="POST" id="configForm" autocomplete="off">
                        @csrf
                        
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered text-center" id="componentsTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 60px">#</th>
                                        <th class="text-right">اسم القسم (النشاط)</th>
                                        <th style="width: 200px">النسبة المئوية (%)</th>
                                        <th style="width: 100px">حذف</th>
                                    </tr>
                                </thead>
                                <tbody id="componentsBody">
                                    @forelse($components as $index => $comp)
                                    <tr class="component-row">
                                        <input type="hidden" name="components[{{ $loop->index }}][id]" value="{{ $comp->id ?? '' }}">
                                        {{-- Hidden Source Mapping --}}
                                        <input type="hidden" name="components[{{ $loop->index }}][data_source]" value="{{ $comp->data_source ?? 'LEGACY_HOMEWORK' }}">

                                        <td class="align-middle index-cell font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                        <td>
                                            <input type="text" name="components[{{ $loop->index }}][name]" 
                                                   class="form-control form-control-lg border-0 bg-light" 
                                                   value="{{ $comp->name }}" required 
                                                   placeholder="اسم النشاط (مثال: وظائف، امتحان..)">
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" name="components[{{ $loop->index }}][weight]" 
                                                       class="form-control form-control-lg text-center font-weight-bold weight-input" 
                                                       value="{{ $comp->weight ?? $comp->max_mark ?? 0 }}" 
                                                       min="0" max="100" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text font-weight-bold">%</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-outline-danger btn-sm shadow-sm delete-row" 
                                                    title="حذف القسم">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    {{-- Empty state if needed --}}
                                    @endforelse
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <td colspan="2" class="text-left font-weight-bold align-middle pl-4 text-dark">
                                            المجموع الكلي للنسب:
                                        </td>
                                        <td class="align-middle">
                                            <div class="progress" style="height: 25px; background-color: #e9ecef;">
                                                <div id="totalProgressBar" class="progress-bar font-weight-bold" role="progressbar" style="width: 0%;">0%</div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <button type="button" class="btn btn-primary shadow-sm px-4 py-2" id="addRowBtn">
                                <i class="fas fa-plus mr-1"></i> إضافة قسم جديد
                            </button>
                            
                            <div>
                                <a href="{{ route('admin.gradebook.settings') }}" class="btn btn-secondary px-4 py-2 mr-2">إلغاء</a>
                                <button type="submit" class="btn btn-success shadow px-5 py-2 font-weight-bold" id="saveBtn">
                                    <i class="fas fa-save mr-2"></i> حفظ التعديلات
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- State ---
        let rowIndex = {{ $components->count() }};
        const tbody = document.getElementById('componentsBody');
        const progressBar = document.getElementById('totalProgressBar');
        const saveBtn = document.getElementById('saveBtn');

        // --- Functions ---
        
        function calculateTotal() {
            let total = 0;
            const inputs = document.querySelectorAll('.weight-input');
            
            inputs.forEach(input => {
                let val = parseFloat(input.value);
                if(isNaN(val)) val = 0;
                total += val;
            });

            // Update UI
            progressBar.style.width = total + '%';
            progressBar.innerText = total + '%';

            // Validation Styling
            if (total === 100) {
                progressBar.classList.remove('bg-danger', 'bg-warning');
                progressBar.classList.add('bg-success');
                saveBtn.disabled = false;
            } else if (total > 100) {
                progressBar.classList.remove('bg-success', 'bg-warning');
                progressBar.classList.add('bg-danger');
                // Optional: disable save if strict
            } else {
                progressBar.classList.remove('bg-success', 'bg-danger');
                progressBar.classList.add('bg-warning');
            }
        }

        // Attach listeners to new or existing inputs
        function attachListeners() {
            // Remove old listeners to avoid duplicates if using generic bind? 
            // Better: just delegate or bind to all current inputs
            document.querySelectorAll('.weight-input').forEach(input => {
                input.oninput = calculateTotal;
            });

            document.querySelectorAll('.delete-row').forEach(btn => {
                btn.onclick = function() {
                    const row = this.closest('tr');
                    // Prevent deleting the last row if desired, or allow empty
                    if(document.querySelectorAll('.component-row').length <= 1) {
                         alert('يجب أن يحتوي التوزيع على قسم واحد على الأقل.');
                         return;
                    }
                    row.remove();
                    reindexRows();
                    calculateTotal();
                }
            });
        }

        function reindexRows() {
            document.querySelectorAll('.component-row').forEach((row, idx) => {
                // Update Badge #
                row.querySelector('.index-cell').innerText = idx + 1;
            });
        }

        function addNewRow() {
            const tr = document.createElement('tr');
            tr.className = 'component-row';
            
            // Using a unique index for array keys to avoid conflicts? 
            // PHP accepts sequential keys, so we can just use rowIndex counter.
            
            tr.innerHTML = `
                <input type="hidden" name="components[${rowIndex}][id]" value="">
                <input type="hidden" name="components[${rowIndex}][data_source]" value="">

                <td class="align-middle index-cell font-weight-bold text-muted">-</td>
                <td>
                    <input type="text" name="components[${rowIndex}][name]" 
                           class="form-control form-control-lg border-0 bg-light" 
                           required 
                           placeholder="اسم القسم الجديد">
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" name="components[${rowIndex}][weight]" 
                               class="form-control form-control-lg text-center font-weight-bold weight-input" 
                               value="0" min="0" max="100" required>
                        <div class="input-group-append">
                            <span class="input-group-text font-weight-bold">%</span>
                        </div>
                    </div>
                </td>
                <td class="align-middle">
                    <button type="button" class="btn btn-outline-danger btn-sm shadow-sm delete-row" 
                            title="حذف القسم">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;

            tbody.appendChild(tr);
            rowIndex++; // Increment global counter
            
            attachListeners();
            reindexRows();
            calculateTotal();
        }

        // --- Initialization ---
        document.getElementById('addRowBtn').addEventListener('click', addNewRow);
        
        // Initial Bind
        attachListeners();
        calculateTotal();
    });
</script>
@endsection
