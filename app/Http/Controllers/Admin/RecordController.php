<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AuditLogs;


class RecordController extends Controller
{
    public function auditLogs()
    {
        $auditLogs = AuditLogs::with('user')
            ->orderByDesc('action_time')
            ->paginate(10);

        return view('admin.portal.settings.audit-logs', compact('auditLogs'));
    }

    public function records()
    {
        return view('admin.portal.settings.add-records');
    }

    public function downloadTemplate()
    {
        $filePath = public_path('templates/alumni_records_template.csv');

        if (!file_exists($filePath)) {
            return abort(404, 'Template file not found.');
        }

        return response()->download($filePath, 'alumni_records_template.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function importCSV(Request $request)
    {
        if (!$request->hasFile('file')) {
            return back()->with('error', 'Please upload a CSV file.');
        }

        $file = $request->file('file');

        if ($file->getClientOriginalExtension() !== 'csv') {
            return back()->with('error', 'Only CSV files are allowed.');
        }

        $data = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_shift($data);
        $count = 0;
        $skipped = 0;

        foreach ($data as $row) {
            if (count($row) < 7) continue;

            $row = array_map(fn($v) => ($v = trim($v)) === '' ? null : $v, $row);

            $birthdate = $row[6] ?? null;
            if ($birthdate && preg_match('/\d{2}\/\d{2}\/\d{4}/', $birthdate)) {
                $parts = explode('/', $birthdate);
                $birthdate = "{$parts[2]}-{$parts[1]}-{$parts[0]}";
            }

            $courseCode = strtoupper(trim($row[5] ?? ''));
            $course = DB::table('courses')->where('course_code', $courseCode)->first();

            if (!$course) {
                $skipped++;
                continue;
            }

            $courseId = $course->course_id;

            $exists = DB::table('alumni_information')
                ->where('first_name', $row[1])
                ->where('last_name', $row[0])
                ->where('birthdate', $birthdate)
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            DB::table('alumni_information')->insert([
                'last_name'   => $row[0],
                'first_name'  => $row[1],
                'middle_name' => $row[2],
                'suffix'      => $row[3],
                'sex'         => $row[4],
                'course_id'   => $courseId,
                'birthdate'   => $birthdate,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            $count++;
        }

        return back()->with(
            'success',
            "$count record(s) imported successfully! ($skipped skipped — invalid course or duplicate)"
        );
    }
}
