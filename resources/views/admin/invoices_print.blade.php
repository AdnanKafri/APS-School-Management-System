@php
    $school = \App\School_data::first();
    $student = optional($invoice)->student;
    $className = optional(optional($invoice)->classes)->name;
    $printedAt = now();
    $amount = (float) ($invoice->invoice_amount ?? 0);
    $paid = $amount;
    $remaining = 0.0;
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة مالية {{ $invoice->invoice_number }}</title>
    <style>
        :root {
            --ink: #111827;
            --muted: #6b7280;
            --line: #374151;
            --line-soft: #d1d5db;
            --paper: #ffffff;
            --screen: #f3f4f6;
        }

        * { box-sizing: border-box; }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        body {
            background: var(--screen);
            color: var(--ink);
            font-family: "Tahoma", "Arial", sans-serif;
            direction: rtl;
        }

        .tools {
            max-width: 210mm;
            margin: 14px auto 0;
            padding: 0 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .tools__actions {
            display: flex;
            gap: 8px;
        }

        .btn {
            border: 1px solid #9ca3af;
            background: #fff;
            color: #111827;
            padding: 8px 12px;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover { background: #f9fafb; }

        .sheet {
            width: 210mm;
            min-height: 297mm;
            margin: 10px auto 20px;
            background: var(--paper);
            padding: 12mm;
        }

        .doc-title {
            text-align: center;
            margin: 0 0 4mm;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: .2px;
        }

        .doc-subtitle {
            text-align: center;
            margin: 0 0 6mm;
            font-size: 12px;
            color: var(--muted);
        }

        .rule {
            border-top: 1px solid var(--line);
            margin: 0 0 6mm;
        }

        .head-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5mm;
        }

        .head-grid td {
            width: 50%;
            vertical-align: top;
            padding: 0;
        }

        .meta-table,
        .student-table,
        .summary-table,
        .lines-table {
            width: 100%;
            border-collapse: collapse;
        }

        .meta-table td,
        .student-table td,
        .summary-table td {
            border: 1px solid var(--line-soft);
            padding: 7px 8px;
            font-size: 13px;
        }

        .label {
            color: var(--muted);
            width: 34%;
            white-space: nowrap;
        }

        .value {
            font-weight: 700;
        }

        .section-title {
            margin: 5mm 0 2mm;
            font-size: 14px;
            font-weight: 700;
        }

        .lines-table th,
        .lines-table td {
            border: 1px solid var(--line);
            padding: 8px 7px;
            text-align: center;
            font-size: 13px;
            white-space: normal;
            word-break: break-word;
        }

        .lines-table th {
            background: #f9fafb;
            font-weight: 700;
        }

        .summary-wrap {
            margin-top: 4mm;
            width: 44%;
            margin-inline-start: auto;
        }

        .summary-table .label {
            width: 45%;
            font-size: 12px;
        }

        .summary-table .value {
            font-size: 13px;
        }

        .summary-table tr:last-child td {
            font-weight: 700;
            border-color: var(--line);
        }

        .footer {
            margin-top: 12mm;
        }

        .sign-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .sign-grid td {
            width: 50%;
            vertical-align: top;
            padding-top: 8mm;
            font-size: 13px;
        }

        .sign-line {
            border-top: 1px solid var(--line);
            margin-top: 12mm;
            padding-top: 3px;
            width: 80%;
        }

        .note {
            margin-top: 8mm;
            font-size: 11px;
            color: var(--muted);
            text-align: center;
        }

        @page {
            size: A4;
            margin: 8mm;
        }

        @media print {
            html, body {
                background: #fff !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .tools {
                display: none !important;
            }

            .sheet {
                width: 100% !important;
                min-height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                page-break-after: avoid !important;
                break-after: avoid-page !important;
            }

            .section-title,
            .lines-table,
            .summary-wrap,
            .footer {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
        }
    </style>
</head>
<body>
    <div class="tools">
        <div>نسخة جاهزة للطباعة</div>
        <div class="tools__actions">
            <a href="{{ route('invoices_details', $invoice->student_id) }}" class="btn">العودة للتفاصيل</a>
            <button class="btn" type="button" onclick="window.print()">طباعة</button>
        </div>
    </div>

    <main class="sheet">
        <div style="text-align:center;font-size:28px;font-weight:700;border:2px solid #111;padding:8px;margin-bottom:8px;">
            THIS IS THE NEW PRINT PAGE
        </div>
        <h1 class="doc-title">{{ $school->name_ar ?? $school->name_en ?? config('app.name') }}</h1>
        <p class="doc-subtitle">وثيقة فاتورة مالية رسمية</p>
        <div class="rule"></div>

        <table class="head-grid">
            <tr>
                <td>
                    <table class="meta-table">
                        <tr>
                            <td class="label">رقم الفاتورة</td>
                            <td class="value">{{ $invoice->invoice_number ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">تاريخ الفاتورة</td>
                            <td class="value">{{ optional($invoice->created_at)->format('Y-m-d H:i') ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
                <td style="padding-right: 4mm;">
                    <table class="meta-table">
                        <tr>
                            <td class="label">تاريخ الطباعة</td>
                            <td class="value">{{ $printedAt->format('Y-m-d H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="label">رقم المرجع</td>
                            <td class="value">INV-{{ $invoice->id ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <h2 class="section-title">بيانات الطالب</h2>
        <table class="student-table">
            <tr>
                <td class="label">اسم الطالب</td>
                <td class="value">{{ trim(($student->first_name ?? '').' '.($student->last_name ?? '')) ?: '-' }}</td>
                <td class="label">الصف / الشعبة</td>
                <td class="value">{{ $className ?: '-' }}</td>
            </tr>
        </table>

        <h2 class="section-title">تفاصيل الفاتورة</h2>
        <table class="lines-table">
            <thead>
                <tr>
                    <th style="width: 8%;">#</th>
                    <th style="width: 34%;">الوصف</th>
                    <th style="width: 18%;">المبلغ</th>
                    <th style="width: 20%;">طريقة الدفع</th>
                    <th style="width: 20%;">التاريخ</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>قسط دراسي - فاتورة طالب</td>
                    <td>{{ $invoice->invoice_amount ?? 0 }}</td>
                    <td>{{ $invoice->payment_type ?? '-' }}</td>
                    <td>{{ optional($invoice->created_at)->format('Y-m-d') ?? '-' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="summary-wrap">
            <table class="summary-table">
                <tr>
                    <td class="label">الإجمالي</td>
                    <td class="value">{{ $amount }}</td>
                </tr>
                <tr>
                    <td class="label">المدفوع</td>
                    <td class="value">{{ $paid }}</td>
                </tr>
                <tr>
                    <td class="label">المتبقي</td>
                    <td class="value">{{ $remaining }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <table class="sign-grid">
                <tr>
                    <td>
                        <div>توقيع المحاسب</div>
                        <div class="sign-line"></div>
                    </td>
                    <td>
                        <div>توقيع ولي الأمر / المستلم</div>
                        <div class="sign-line"></div>
                    </td>
                </tr>
            </table>
            <div class="note">هذه الوثيقة صادرة من النظام المالي للمدرسة وتستخدم لأغراض التوثيق والتحصيل.</div>
        </div>
    </main>
</body>
</html>
