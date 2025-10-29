<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobDetail;
use App\Models\Industry;
use App\Models\Skill;
use App\Models\SubmittedJob;


class JobManagementController extends Controller
{
    // 🔍 Skill search moved here
    public function searchSkills(Request $request)
    {
        $query = trim($request->input('query'));


        if (!$query) {
            return response()->json([]);
        }


        $skills = Skill::where(function ($q) use ($query) {
            $q->where('name', 'like', "{$query}%")      // starts with letter
                ->orWhere('name', 'like', "% {$query}%")  // starts after space
                ->orWhere('name', 'like', "%{$query}%");  // fallback anywhere
        })
            ->orderByRaw("
                CASE
                    WHEN name LIKE ? THEN 1
                    WHEN name LIKE ? THEN 2
                    ELSE 3
                END, name ASC
            ", ["{$query}%", "% {$query}%"])
            ->limit(10)
            ->get(['id', 'name']);


        return response()->json($skills);
    }


    // 🔽 keep your existing Job Management methods below...


    public function index(Request $request)
    {
        $query = JobDetail::with('industry');


        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('job_title', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }


        if ($request->filled('industry')) {
            $industryName = $request->input('industry');
            $query->whereHas('industry', function ($q) use ($industryName) {
                $q->where('industry_name', $industryName);
            });
        }


        if ($request->filled('job_type')) {
            $query->where('job_type', $request->input('job_type'));
        }


        // ✅ Sort newest jobs first — based on creation timestamp (date + time)
        $jobs = $query->orderByDesc('created_at')->paginate(10);


        return view('admin.portal.job.admin.official-job-listings', compact('jobs'));
    }


    public function show($id)
    {
        $job = JobDetail::with('industry')->findOrFail($id);
        $industries = Industry::orderBy('industry_name')->get();


        return view('admin.portal.job.admin.official-job-view', compact('job', 'industries'));
    }


    public function destroy($id)
    {
        JobDetail::findOrFail($id)->delete();


        return redirect()
            ->route('official.job.listings')
            ->with('success', 'Job post has been deleted successfully.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'job_title' => 'required|string|max:255',
            'industry' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string',
            'salary_range' => 'nullable|string|max:255',
            'job_description' => 'required|string',
            'application_link' => 'nullable|string|max:255',
            'skills' => 'nullable|array',
            'status' => 'required|in:active,inactive',
        ]);


        $industryId = Industry::where('industry_name', $request->industry)->value('industry_id');
        $job = JobDetail::findOrFail($id);


        $job->update([
            'job_title' => $request->job_title,
            'industry_id' => $industryId,
            'company' => $request->company,
            'location' => $request->location,
            'job_type' => strtolower($request->job_type),
            'salary_range' => $request->salary_range,
            'job_description' => $request->job_description,
            'application_link' => $request->application_link,
            'status' => strtolower($request->status),
        ]);


        if ($request->has('skills')) {
            $job->skills()->sync($request->input('skills'));
        } else {
            $job->skills()->sync([]);
        }


        return redirect()
            ->route('official.job.view', $job->job_id)
            ->with('success', 'Job details updated successfully.');
    }


    public function create()
    {
        $industries = Industry::orderBy('industry_name')->get();
        return view('admin.portal.job.admin.add-official-job', compact('industries'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'job_title' => 'required|string|max:255',
            'industry' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string',
            'salary_range' => 'nullable|string|max:255',
            'job_description' => 'required|string',
            'application_link' => 'nullable|string|max:255',
            'skills' => 'required|array|min:1',
        ], [
            'skills.required' => 'Please add at least one skill.',
            'skills.min' => 'Please add at least one skill.',
        ]);


        $industryId = Industry::where('industry_name', $request->industry)->value('industry_id');


        $job = JobDetail::create([
            'job_title' => $request->job_title,
            'industry_id' => $industryId,
            'company' => $request->company,
            'location' => $request->location,
            'job_type' => strtolower($request->job_type),
            'salary_range' => $request->salary_range,
            'job_description' => $request->job_description,
            'application_link' => $request->application_link,
            'date_posted' => now(),
        ]);


        if ($request->has('skills')) {
            $job->skills()->sync($request->input('skills'));
        }


        return redirect()
            ->route('official.job.create')
            ->with('success', 'Job post added successfully.');
    }



    public function alumniShared(Request $request)
    {
        $query = \App\Models\SubmittedJob::with('industry');


        // 🔍 Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('job_title', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }


        // 🏭 Industry filter
        if ($request->filled('industry_filter')) {
            $industryName = $request->input('industry_filter');
            $query->whereHas('industry', function ($q) use ($industryName) {
                $q->where('industry_name', $industryName);
            });
        }


        // 📋 Status filter
        if ($request->filled('status_filter')) {
            $query->where('status', $request->input('status_filter'));
        }


        // ✅ Sort newest first
        $jobs = $query->orderByDesc('created_at')->paginate(10);


        // 📂 For dropdowns
        $industries = \App\Models\Industry::pluck('industry_name', 'industry_name')->toArray();
        $statuses = ['' => 'All Status', 'pending' => 'Pending', 'approved' => 'Approved', 'denied' => 'Denied'];


        return view('admin.portal.job.alumni.alumni-shared-jobs', compact('jobs', 'industries', 'statuses'));
    }


    // 🗑️ SOFT DELETE ALUMNI-SHARED JOB
    public function deleteShared($id)
    {
        $job = \App\Models\SubmittedJob::findOrFail($id);
        $job->delete(); // Soft delete (keeps in DB with deleted_at timestamp)


        return redirect()
            ->route('alumni.shared.jobs')
            ->with('success', 'Alumni shared job deleted successfully.');
    }
    // 🧾 VIEW ALUMNI-SHARED JOB DETAILS
    public function viewShared($id)
    {
        $job = SubmittedJob::with('industry')->findOrFail($id);
        $industries = Industry::orderBy('industry_name')->get();
        return view('admin.portal.job.alumni.shared-job-view', compact('job', 'industries'));
    }




    // ✏️ UPDATE ALUMNI-SHARED JOB (STATUS ONLY)
    public function updateShared(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,denied',
        ]);


        $job = SubmittedJob::findOrFail($id);


        $job->status = $request->status;
        $job->save();


        return redirect()
            ->route('alumni.shared.jobs.view', $id)
            ->with('success', 'Job status updated successfully.');
    }
}
