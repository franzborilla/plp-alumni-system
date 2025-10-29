<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\User;

class AlumniManagementController extends Controller
{
    public function index(Request $request)
    {
        // Start query — only alumni users
        $query = User::where('role', 'alumni')
            ->with([
                'basicDetails',
                'education.course',
                'currentEmployment.industry',
                'firstEmployment.industry'
            ]);


        if ($request->filled('search')) {
            $search = $request->search;


            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%$search%")
                    ->orWhere('middle_name', 'LIKE', "%$search%")
                    ->orWhere('last_name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            })
                ->orWhereHas('basicDetails', function ($q) use ($search) {
                    $q->where('employment_status', 'LIKE', "%$search%");
                })
                ->orWhereHas('firstEmployment.industry', function ($q) use ($search) {
                    $q->where('industry_name', 'LIKE', "%$search%");
                });
        }

        // 🎓 DEGREE FILTER
        if ($request->filled('degree')) {
            $degree = strtoupper($request->degree); // e.g. BSIT, BSBA
            $query->whereHas('education.course', function ($q) use ($degree) {
                $q->where('course_code', $degree);
            });
        }

        // 🗓️ YEAR GRADUATED FILTER
        if ($request->filled('year_graduated')) {
            $year = $request->year_graduated;
            $query->whereHas('education', function ($q) use ($year) {
                $q->where('year_graduated', $year);
            });
        }

        // 🚀 FETCH & PAGINATE
        $alumni = $query->orderBy('last_name')->paginate(10);


        // Pass current filters to view for keeping selected state
        return view('admin.portal.alumni.alumni-management', [
            'alumni' => $alumni,
            'search' => $request->search,
            'degree' => $request->degree,
            'year_graduated' => $request->year_graduated,
        ]);
    }


    public function destroy($id)
    {
        // Find the alumni user by ID
        $user = User::findOrFail($id);

        // ✅ Soft delete the user (sets deleted_at)
        $user->delete();

        // ✅ Soft delete related records if they exist
        $user->basicDetails?->delete();
        $user->education?->delete();
        $user->firstEmployment?->delete();


        // ✅ Redirect back
        return redirect()
            ->route('alumni.management')
            ->with('success', 'Alumni has been deleted successfully.');
    }


    public function show($id)
    {
        $alumni = User::with([
            'basicDetails',
            'education.course',
            'educationMasteral',
            'educationDoctoral',
            'firstEmployment.industry',
            'currentEmployment.industry',
            'pastEmployment.industry',
            'skills'
        ])->where('role', 'alumni')->findOrFail($id);


        return view('admin.portal.alumni.alumni-view', compact('alumni'));
    }


    public function exportCSV()
    {
        $filename = 'alumni_records_' . now()->format('Y-m-d_His') . '.csv';


        $alumni = User::with([
            'basicDetails',
            'education.course.college',
            'educationMasteral',
            'educationDoctoral',
            'firstEmployment.industry',
            'employment.industry',
            'pastEmployment.industry',
            'skills'
        ])->where('role', 'alumni')->get();


        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];


        $columns = [
            'ID',
            'Full Name',
            'Email',
            'Student Number',
            'Sex',
            'Age',
            'Birthdate',
            'Civil Status',
            'Mobile Number',
            'Address',
            'Employment Status',
            'College Department',
            'Degree',
            'Year Graduated',
            'Masteral Degree',
            'Masteral School',
            'Masteral Years',
            'Doctoral Degree',
            'Doctoral School',
            'Doctoral Years',
            'First Job Company',
            'First Job Position',
            'First Job Industry',
            'First Job Type',
            'Current Employment Company',
            'Current Employment Position',
            'Current Employment Industry',
            'Current Job Type',
            'Skills',
        ];


        $callback = function () use ($alumni, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);


            foreach ($alumni as $a) {
                $skills = $a->skills->pluck('skill_name')->implode(', ');


                fputcsv($file, [
                    $a->id,
                    trim("{$a->first_name} {$a->middle_name} {$a->last_name} {$a->suffix}"),
                    $a->email,
                    $a->student_number ?? 'N/A',
                    $a->basicDetails->sex ?? 'N/A',
                    $a->basicDetails->age ?? 'N/A',
                    $a->basicDetails->birthdate ?? 'N/A',
                    $a->basicDetails->civil_status ?? 'N/A',
                    $a->basicDetails->mobile_number ?? 'N/A',
                    $a->basicDetails->address ?? 'N/A',
                    $a->basicDetails->employment_status ?? 'N/A',
                    $a->education->course->college->college_name ?? 'N/A',
                    $a->education->course->course_name ?? 'N/A',
                    $a->education->year_graduated ?? 'N/A',
                    $a->educationMasteral->degree_title ?? 'N/A',
                    $a->educationMasteral->school ?? 'N/A',
                    $a->educationMasteral->inclusive_years ?? 'N/A',
                    $a->educationDoctoral->degree_title ?? 'N/A',
                    $a->educationDoctoral->school ?? 'N/A',
                    $a->educationDoctoral->inclusive_years ?? 'N/A',
                    $a->firstEmployment->company_name ?? 'N/A',
                    $a->firstEmployment->position_title ?? 'N/A',
                    $a->firstEmployment->industry->industry_name ?? 'N/A',
                    $a->firstEmployment->job_type ?? 'N/A',
                    $a->employment->company_name ?? 'N/A',
                    $a->employment->position_title ?? 'N/A',
                    $a->employment->industry->industry_name ?? 'N/A',
                    $a->employment->job_type ?? 'N/A',
                    $skills ?: 'N/A',
                ]);
            }


            fclose($file);
        };


        return Response::stream($callback, 200, $headers);
    }
}
