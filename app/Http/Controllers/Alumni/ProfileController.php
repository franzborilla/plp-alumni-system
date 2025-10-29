<?php


namespace App\Http\Controllers\Alumni;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\AlumniBasicDetails;
use App\Models\AlumniEducation;




class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $details = $user->basicDetails;
        $education = $user->education;
        $skills = $user->skills;
        $allSkills = Skill::all();

        return view('alumni.portal.alumni-profile', compact('user', 'details', 'education', 'skills', 'allSkills'));
    }

    public function updateBasic(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'birthdate' => 'required|date',
            'sex' => 'required|string',
            'civil_status' => 'nullable|string',
            'mobile_number' => 'nullable|string|max:20',
            'student_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'email' => 'required|email',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handle profile image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->image_path && Storage::exists('public/' . $user->image_path)) {
                Storage::delete('public/' . $user->image_path);
            }

            // Store new image
            $path = $request->file('image')->store('profile_images', 'public');
            $user->image_path = $path;
        }

        // Update user basic info
        $user->last_name = $validated['last_name'];
        $user->first_name = $validated['first_name'];
        $user->middle_name = $validated['middle_name'] ?? null;
        $user->suffix = $validated['suffix'] ?? null;
        $user->email = $validated['email'];
        $user->save();

        // Update AlumniBasicDetails
        AlumniBasicDetails::updateOrCreate(
            ['user_id' => $user->id],
            [
                'birthdate' => $validated['birthdate'],
                'sex' => $validated['sex'],
                'civil_status' => $validated['civil_status'] ?? null,
                'mobile_number' => $validated['mobile_number'] ?? null,
                'address' => $validated['address'] ?? null,
            ]
        );

        // Update AlumniEducations
        AlumniEducation::updateOrCreate(
            ['user_id' => $user->id],
            ['student_number' => $validated['student_number'] ?? null]
        );

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updateAbout(Request $request)
    {
        $user = Auth::user();


        $validated = $request->validate([
            'about' => 'nullable|string|max:1000',
        ]);


        AlumniBasicDetails::updateOrCreate(
            ['user_id' => $user->id],
            [
                'about' => $validated['about'] ?? null,
            ]
        );


        return back()->with('success', 'About section updated successfully!');
    }


    public function searchSkills(Request $request)
    {
        $query = $request->get('q', '');
        $skills = Skill::where('name', 'like', "%{$query}%")
            ->take(10)
            ->pluck('name');


        return response()->json($skills);
    }


    public function updateAlumniSkills(Request $request)
    {
        $user = Auth::user();


        $validated = $request->validate([
            'skills' => 'array',
            'skills.*' => 'string|max:255',
        ]);


        $skillIds = [];


        foreach ($validated['skills'] ?? [] as $skillName) {
            $skill = Skill::firstOrCreate(['name' => $skillName]);
            $skillIds[] = $skill->id;
        }


        $user->skills()->sync($skillIds);


        return back()->with('success', 'Skills updated successfully!');
    }
}
