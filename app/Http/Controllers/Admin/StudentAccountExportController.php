<?php

namespace App\Http\Controllers\Admin;

use App\Classe;
use App\Http\Controllers\Controller;
use App\Room;
use App\Student;
use App\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class StudentAccountExportController extends Controller
{
    public function sections(Request $request, $classId)
    {
        $user = $request->user();
        abort_unless($user && Gate::forUser($user)->allows('Account_Information_student'), 403);

        $class = Classe::findOrFail($classId);
        $year = Year::where('current_year', 1)->first();

        if (! $year) {
            return response()->json([
                'message' => 'لا يوجد عام دراسي حالي لتحميل الشعب.',
                'sections' => [],
            ], 422);
        }

        $sections = Room::where('class_id', $class->id)
            ->where('year_id', $year->id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json([
            'sections' => $sections,
        ]);
    }

    public function export(Request $request)
    {
        $user = $request->user();
        abort_unless($user && Gate::forUser($user)->allows('Account_Information_student'), 403);

        $validated = $request->validate([
            'class_id' => 'required|integer|exists:classes,id',
            'room_id' => 'required|integer|exists:rooms,id',
        ]);

        $year = Year::where('current_year', 1)->first();
        if (! $year) {
            return redirect()->back()->with('error', 'لا يوجد عام دراسي حالي لتصدير الحسابات.');
        }

        $class = Classe::findOrFail($validated['class_id']);
        $room = Room::whereKey($validated['room_id'])
            ->where('class_id', $class->id)
            ->where('year_id', $year->id)
            ->first();

        if (! $room) {
            return redirect()->back()->withErrors([
                'room_id' => 'الشعبة المحددة لا تتبع الصف المختار في العام الدراسي الحالي.',
            ]);
        }

        $studentIds = DB::table('room_student')
            ->where('year_id', $year->id)
            ->where('room_id', $room->id)
            ->distinct()
            ->pluck('student_id');

        $students = Student::with('user')
            ->whereIn('id', $studentIds)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $filename = $this->safeFilename(
            'حسابات-الطلاب-' . $year->name . '-' . $class->name . '-' . $room->name . '.xlsx'
        );
        $workbookPath = $this->buildWorkbook($students);

        return response()->download($workbookPath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
        ])->deleteFileAfterSend(true);
    }

    private function buildWorkbook($students)
    {
        $path = tempnam(sys_get_temp_dir(), 'student-accounts-');
        if ($path === false) {
            throw new \RuntimeException('Unable to create the temporary workbook.');
        }

        $zip = new \ZipArchive();
        if ($zip->open($path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            @unlink($path);
            throw new \RuntimeException('Unable to create the Excel workbook.');
        }

        try {
            $zip->addFromString('[Content_Types].xml', $this->contentTypesXml());
            $zip->addFromString('_rels/.rels', $this->rootRelationshipsXml());
            $zip->addFromString('xl/workbook.xml', $this->workbookXml());
            $zip->addFromString('xl/_rels/workbook.xml.rels', $this->workbookRelationshipsXml());
            $zip->addFromString('xl/styles.xml', $this->stylesXml());
            $zip->addFromString('xl/worksheets/sheet1.xml', $this->worksheetXml($students));

            if (! $zip->close()) {
                throw new \RuntimeException('Unable to finalize the Excel workbook.');
            }
        } catch (\Throwable $exception) {
            $zip->close();
            @unlink($path);
            throw $exception;
        }

        return $path;
    }

    private function worksheetXml($students)
    {
        $rows = [];
        $rows[] = $this->worksheetRow(1, ['اسم الطالب', 'البريد الإلكتروني', 'كلمة المرور'], 1);

        foreach ($students as $index => $student) {
            $account = $student->user;
            $rows[] = $this->worksheetRow($index + 2, [
                $this->safeCell(trim($student->first_name . ' ' . $student->last_name)),
                $this->safeCell($account && $account->email ? $account->email : 'غير متوفر'),
                $this->safeCell($account && $account->view_password ? $account->view_password : 'غير متوفر'),
            ]);
        }

        $lastRow = max(1, count($students) + 1);

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<sheetViews><sheetView workbookViewId="0" rightToLeft="1">'
            . '<pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/>'
            . '</sheetView></sheetViews>'
            . '<sheetFormatPr defaultRowHeight="20"/>'
            . '<cols><col min="1" max="1" width="30" customWidth="1"/>'
            . '<col min="2" max="2" width="34" customWidth="1"/>'
            . '<col min="3" max="3" width="28" customWidth="1"/></cols>'
            . '<sheetData>' . implode('', $rows) . '</sheetData>'
            . '<autoFilter ref="A1:C' . $lastRow . '"/>'
            . '</worksheet>';
    }

    private function worksheetRow($rowNumber, array $values, $style = 0)
    {
        $columns = ['A', 'B', 'C'];
        $cells = '';

        foreach ($values as $index => $value) {
            $cells .= '<c r="' . $columns[$index] . $rowNumber . '" t="inlineStr" s="' . $style . '">'
                . '<is><t xml:space="preserve">' . $this->xmlText($value) . '</t></is></c>';
        }

        return '<row r="' . $rowNumber . '" ht="22" customHeight="1">' . $cells . '</row>';
    }

    private function contentTypesXml()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . '</Types>';
    }

    private function rootRelationshipsXml()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>';
    }

    private function workbookXml()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" '
            . 'xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<bookViews><workbookView/></bookViews>'
            . '<sheets><sheet name="حسابات الطلاب" sheetId="1" r:id="rId1"/></sheets>'
            . '</workbook>';
    }

    private function workbookRelationshipsXml()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '</Relationships>';
    }

    private function stylesXml()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<fonts count="2"><font><sz val="11"/><name val="Arial"/></font>'
            . '<font><b/><sz val="11"/><name val="Arial"/></font></fonts>'
            . '<fills count="2"><fill><patternFill patternType="none"/></fill>'
            . '<fill><patternFill patternType="gray125"/></fill></fills>'
            . '<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="2"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0" applyAlignment="1">'
            . '<alignment horizontal="right" vertical="center"/></xf>'
            . '<xf numFmtId="0" fontId="1" fillId="0" borderId="0" xfId="0" applyFont="1" applyAlignment="1">'
            . '<alignment horizontal="right" vertical="center"/></xf></cellXfs>'
            . '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'
            . '</styleSheet>';
    }

    private function xmlText($value)
    {
        $value = preg_replace('/[^\P{C}\t\r\n]/u', '', (string) $value);

        return htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }

    private function safeCell($value)
    {
        $value = (string) $value;

        return preg_match('/^\s*[=+\-@]/u', $value) ? "'" . $value : $value;
    }

    private function safeFilename($filename)
    {
        return preg_replace('/[\\\\\/:*?"<>|]+/u', '-', $filename);
    }
}
