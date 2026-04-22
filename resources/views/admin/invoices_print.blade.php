<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طباعة الفاتورة</title>
    <style>
        :root {
            --ink: #1f2937;
            --muted: #6b7280;
            --line: #dbe2ea;
            --surface: #ffffff;
            --brand: #3b82f6;
            --bg: #f5f7fb;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Cairo', sans-serif;
            background: var(--bg);
            color: var(--ink);
            direction: rtl;
        }

        .print-toolbar {
            max-width: 960px;
            margin: 1.5rem auto 0;
            padding: 0 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .print-toolbar__title {
            font-size: 1.1rem;
            font-weight: 800;
        }

        .print-toolbar__actions {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .btn {
            min-height: 44px;
            border-radius: 12px;
            border: 0;
            padding: .65rem 1rem;
            font-weight: 800;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .45rem;
        }

        .btn-primary {
            background: var(--brand);
            color: #fff;
        }

        .btn-light {
            background: #eef2f7;
            color: var(--ink);
        }

        .print-sheet {
            width: min(190mm, calc(100vw - 2rem));
            max-width: 190mm;
            margin: 1rem auto 2rem;
            background: var(--surface);
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.12);
            padding: 10mm;
        }

        .invoice-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--line);
        }

        .invoice-head__title {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 900;
        }

        .invoice-head__meta {
            color: var(--muted);
            font-size: .95rem;
            margin-top: .45rem;
        }

        .invoice-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .invoice-box {
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 1rem;
            background: #fbfcfe;
        }

        .invoice-box__label {
            display: block;
            color: var(--muted);
            font-size: .84rem;
            font-weight: 700;
            margin-bottom: .4rem;
        }

        .invoice-box__value {
            font-size: 1.02rem;
            font-weight: 800;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid var(--line);
            padding: .9rem .75rem;
            text-align: center;
            vertical-align: middle;
        }

        .invoice-table th {
            background: #f8fafc;
            font-size: .86rem;
            font-weight: 800;
            color: #475569;
        }

        .invoice-table td {
            font-size: .95rem;
            font-weight: 700;
        }

        .invoice-foot {
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid var(--line);
            color: var(--muted);
            font-size: .88rem;
            text-align: center;
        }

        @page {
            size: A4;
            margin: 10mm;
        }

        @media print {
            * {
                box-sizing: border-box !important;
            }
            html, body {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                height: auto !important;
                overflow: visible !important;
            }
            body {
                background: #fff;
                direction: rtl;
                text-align: right;
            }

            .print-toolbar {
                display: none !important;
            }

            .print-sheet {
                width: 190mm !important;
                max-width: 190mm !important;
                min-height: auto !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                box-shadow: none;
                padding: 0 !important;
                overflow: visible !important;
                border: 0 !important;
                page-break-after: avoid !important;
                break-after: avoid-page !important;
            }

            .invoice-head,
            .invoice-grid,
            .invoice-table,
            .invoice-foot {
                page-break-inside: avoid;
                break-inside: avoid-page;
            }

            .invoice-grid {
                width: 100%;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 4mm;
                margin: 6mm 0;
            }

            .invoice-box {
                padding: 4mm;
            }

            .invoice-table {
                width: 100% !important;
                table-layout: fixed;
                margin-top: 6mm;
            }

            .invoice-table th,
            .invoice-table td {
                padding: 3mm 2.5mm;
                font-size: 9pt;
                line-height: 1.35;
                white-space: normal;
                word-break: break-word;
            }

            .invoice-head {
                padding-bottom: 4mm;
                margin-bottom: 4mm;
            }

            .invoice-foot {
                margin-top: 6mm;
                padding-top: 4mm;
            }

            table, tr, td, th {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
        }
    </style>
</head>
<body>
    <div class="print-toolbar">
        <div class="print-toolbar__title">نسخة طباعة الفاتورة</div>
        <div class="print-toolbar__actions">
            <a href="{{ route('invoices_details', $invoice->student_id) }}" class="btn btn-light">العودة للتفاصيل</a>
            <button class="btn btn-primary" type="button" onclick="window.print()">طباعة</button>
        </div>
    </div>

    <main class="print-sheet" id="dvContainer">
        <header class="invoice-head">
            <div>
                <h1 class="invoice-head__title">فاتورة مالية</h1>
                <div class="invoice-head__meta">نسخة مخصصة للطباعة وعرض بيانات الفاتورة فقط</div>
            </div>
            <div class="invoice-head__meta">رقم الفاتورة: {{ $invoice->invoice_number }}</div>
        </header>

        <section class="invoice-grid">
            <div class="invoice-box">
                <span class="invoice-box__label">المعرف</span>
                <span class="invoice-box__value">{{ $invoice->id }}</span>
            </div>
            <div class="invoice-box">
                <span class="invoice-box__label">قيمة الفاتورة</span>
                <span class="invoice-box__value">{{ $invoice->invoice_amount }}</span>
            </div>
            <div class="invoice-box">
                <span class="invoice-box__label">نوع الدفع</span>
                <span class="invoice-box__value">{{ $invoice->payment_type }}</span>
            </div>
            <div class="invoice-box">
                <span class="invoice-box__label">اسم البنك</span>
                <span class="invoice-box__value">{{ $invoice->bank_name }}</span>
            </div>
        </section>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>المعرف</th>
                    <th>رقم الفاتورة</th>
                    <th>قيمة الفاتورة</th>
                    <th>نوع الدفع</th>
                    <th>اسم البنك</th>
                    <th>التاريخ</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->invoice_amount }}</td>
                    <td>{{ $invoice->payment_type }}</td>
                    <td>{{ $invoice->bank_name }}</td>
                    <td>{{ $invoice->created_at }}</td>
                </tr>
            </tbody>
        </table>

        <footer class="invoice-foot">
            تم تجهيز هذه الصفحة للطباعة المباشرة بدون أي عناصر من لوحة التحكم.
        </footer>
    </main>
</body>
</html>
