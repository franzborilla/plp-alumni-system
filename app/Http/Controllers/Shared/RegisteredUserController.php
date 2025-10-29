<?php

namespace App\Http\Controllers\Shared;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\AlumniBasicDetail;
use App\Models\AlumniEducation;
use App\Models\AlumniGraduateEducation;
use App\Models\AlumniFirstEmployment;
use App\Models\AlumniInformation;
use App\Models\Course;
use App\Models\Location;

class RegisteredUserController extends Controller
{
    public function showPersonalForm()
    {
        $personal = Session::get('registration.personal', []);
        return view('/auth/registration/register', compact('personal'));
    }

    public function storePersonalInfo(Request $request)
    {
        $validated = $request->validate([
            'last_name' => 'required',
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'suffix' => 'nullable',
            'sex' => 'required',
            'birthdate' => 'required|date',
        ]);

        Session::put('registration.personal', $validated);

        return redirect()->route('register.education');
    }

    public function showEducationForm()
    {
        $courses = Course::all();
        $education = Session::get('registration.education', []);
        return view('/auth/registration/education-background', compact('courses', 'education'));
    }

    public function storeEducation(Request $request)
    {
        $validated = $request->validate([
            'student_number' => 'nullable|string',
            'course_id' => 'required|exists:courses,course_id',
            'year_graduated' => 'required|date_format:Y',
            'graduate_studies' => 'nullable|array',
            'graduate_studies.took_studies' => 'nullable|in:yes,no',
            'graduate_studies.masters_degree' => 'nullable|string',
            'graduate_studies.masters_university' => 'nullable|string',
            'graduate_studies.masters_years' => 'nullable|string',
            'graduate_studies.doctorate_degree' => 'nullable|string',
            'graduate_studies.doctorate_university' => 'nullable|string',
            'graduate_studies.doctorate_years' => 'nullable|string',
        ]);

        Session::put('registration.education', $validated);

        return redirect()->route('register.employment');
    }

    public function showCareerForm()
    {
        $locations = Location::all();
        $employment = Session::get('registration.employment', []);
        return view('auth.registration.career-history', compact('locations', 'employment'));
    }

    public function storeEmployment(Request $request)
    {
        $validated = $request->validate([
            'employment_status' => 'required|string',
            'had_first_job' => 'required_if:employment_status,Unemployed',
            'position_title' => 'required_if:employment_status,Employed|required_if:had_first_job,yes',
            'job_type' => 'required_if:employment_status,Employed|required_if:had_first_job,yes',
            'location_id' => 'required_if:employment_status,Employed|required_if:had_first_job,yes',
            'job_alignment' => 'required_if:employment_status,Employed|required_if:had_first_job,yes',
            'waiting_period' => 'required_if:employment_status,Employed|required_if:had_first_job,yes',
        ]);

        Session::put('registration.employment', $validated);

        return redirect()->route('register.credentials');
    }

    public function showCredentialsForm()
    {
        return view('auth.registration.credentials');
    }

    public function storeCredentials(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|confirmed|min:8',
            'terms' => 'accepted',
        ]);

        $personal = Session::get('registration.personal');
        $education = Session::get('registration.education');
        $employment = Session::get('registration.employment');

        $course = Course::find((int) $education['course_id']);

        $courseName = $course?->course_name; // Make sure you're using `course_name` not `name`

        $match = AlumniInformation::where('last_name', $personal['last_name'])
            ->where('first_name', $personal['first_name'])
            ->where('middle_name', $personal['middle_name'])
            ->where('sex', $personal['sex'])
            ->where('birthdate', $personal['birthdate']) // in Y-m-d format
            ->where('course', $courseName) // must exactly match the string in DB
            ->first();

        if (!$match) {
            return redirect()->back()->withErrors(['match' => 'No matching alumni record found.']);
        }

        // Create user
        $user = User::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'last_name' => $personal['last_name'],
            'first_name' => $personal['first_name'],
            'middle_name' => $personal['middle_name'],
            'suffix' => $personal['suffix'],
            'email' => $validated['email'],
        ]);

        Auth::login($user);

        AlumniBasicDetail::create([
            'user_id' => $user->id,
            'employment_status' => $employment['employment_status'],
            'birthdate' => $personal['birthdate'],
            'sex' => $personal['sex'],
        ]);

        AlumniEducation::create([
            'user_id' => $user->id,
            'student_number' => $education['student_number'],
            'course_id' => $education['course_id'],
            'year_graduated' => $education['year_graduated'],
        ]);

        if (
            isset($education['graduate_studies']['took_studies']) &&
            $education['graduate_studies']['took_studies'] === 'yes'
        ) {
            if (
                !empty($education['graduate_studies']['masters_degree']) ||
                !empty($education['graduate_studies']['masters_university']) ||
                !empty($education['graduate_studies']['masters_years'])
            ) {
                AlumniGraduateEducation::create([
                    'user_id' => $user->id,
                    'level' => 'masteral',
                    'degree_title' => $education['graduate_studies']['masters_degree'] ?? null,
                    'school' => $education['graduate_studies']['masters_university'] ?? null,
                    'inclusive_years' => $education['graduate_studies']['masters_years'] ?? null,
                ]);
            }

            if (
                !empty($education['graduate_studies']['doctorate_degree']) ||
                !empty($education['graduate_studies']['doctorate_university']) ||
                !empty($education['graduate_studies']['doctorate_years'])
            ) {
                AlumniGraduateEducation::create([
                    'user_id' => $user->id,
                    'level' => 'doctoral',
                    'degree_title' => $education['graduate_studies']['doctorate_degree'] ?? null,
                    'school' => $education['graduate_studies']['doctorate_university'] ?? null,
                    'inclusive_years' => $education['graduate_studies']['doctorate_years'] ?? null,
                ]);
            }
        }

        AlumniFirstEmployment::create([
            'user_id' => $user->id,
            'position_title' => $employment['position_title'],
            'location_id' => $employment['location_id'],
            'job_alignment' => $employment['job_alignment'],
            'job_type' => $employment['job_type'],
            'waiting_period' => $employment['waiting_period'],
        ]);

        Session::forget('registration');

        return redirect()->route('add-skills')->with([
            'registration_complete' => true,
            'success_message' => 'Account created successfully! You can now log in.',
        ]);
    }

    public function showSkillsForm()
    {
        return view('/add-skills');
    }
}
