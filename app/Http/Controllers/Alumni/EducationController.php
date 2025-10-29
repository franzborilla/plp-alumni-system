<?php


namespace App\Http\Controllers\Alumni;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AlumniEducation;
use App\Models\AlumniGraduateEducation;

class EducationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $education = AlumniEducation::with(['course.college'])
            ->where('user_id', $user->id)
            ->first();

        $masteral = AlumniGraduateEducation::where('user_id', $user->id)
            ->where('level', 'masteral')
            ->first();

        $doctoral = AlumniGraduateEducation::where('user_id', $user->id)
            ->where('level', 'doctoral')
            ->first();

        return view('alumni.portal.education-career.education', compact('user', 'education', 'masteral', 'doctoral'));
    }


    public function store(Request $request)
    {
        $user = Auth::user();
        $graduationYear = $user->alumniDetail->graduation_year ?? null;


        $request->validate([
            'bachelor_years' => [
                'nullable',
                'regex:/^\d{4}-\d{4}$/',
                function ($attribute, $value, $fail) use ($graduationYear) {
                    [$start, $end] = explode('-', $value);


                    if ($start > $end) {
                        $fail('Bachelor inclusive years must be valid (start year before end year).');
                    }


                    if ($graduationYear && $end < $graduationYear) {
                        $fail('Bachelor years must not end before your graduation year (' . $graduationYear . ').');
                    }
                },
            ],
            'masteral_years' => [
                'nullable',
                'regex:/^\d{4}-\d{4}$/',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && $request->doctoral_years) {
                        [$mStart, $mEnd] = explode('-', $value);
                        [$dStart] = explode('-', $request->doctoral_years);


                        if ($mEnd > $dStart) {
                            $fail('Masteral years must not be later than your doctoral years.');
                        }
                    }
                },
            ],
            'doctoral_years' => [
                'nullable',
                'regex:/^\d{4}-\d{4}$/',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && $request->masteral_years) {
                        [$dStart, $dEnd] = explode('-', $value);
                        [$mEnd] = array_reverse(explode('-', $request->masteral_years));


                        if ($dStart < $mEnd) {
                            $fail('Doctoral years must start after your masteral years.');
                        }
                    }
                },
            ],
        ], [
            'bachelor_years.regex' => 'Bachelor inclusive years must be in format YYYY-YYYY (e.g., 2018-2022).',
            'masteral_years.regex' => 'Masteral inclusive years must be in format YYYY-YYYY (e.g., 2022-2024).',
            'doctoral_years.regex' => 'Doctoral inclusive years must be in format YYYY-YYYY (e.g., 2024-2028).',
        ]);


        AlumniEducation::updateOrCreate(
            ['alumni_id' => $user->id],
            [
                'bachelor_school' => $request->bachelor_school,
                'bachelor_years' => $request->bachelor_years,
                'masteral_school' => $request->masteral_school,
                'masteral_years' => $request->masteral_years,
                'doctoral_school' => $request->doctoral_school,
                'doctoral_years' => $request->doctoral_years,
            ]
        );


        return redirect()->back()->with('success', 'Education information saved successfully!');
    }
}
