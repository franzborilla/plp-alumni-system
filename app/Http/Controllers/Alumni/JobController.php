<?php


namespace App\Http\Controllers\Alumni;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobDetail;


class JobController extends Controller
{
    /**
     * Display recommended jobs for the logged-in alumni.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();


        // 🧠 Run ML recommender (Python script)
        $pythonPath = 'python'; // or 'python3' if you're using Linux/macOS
        $scriptPath = base_path('ml/recommend_jobs.py');
        $command    = escapeshellcmd("$pythonPath \"$scriptPath\" $userId");


        $output = shell_exec($command);
        $recommendations = json_decode($output, true) ?? [];


        // ⚠️ Handle Python or JSON errors gracefully
        if (!$recommendations || isset($recommendations['error'])) {
            $error = $recommendations['error'] ?? 'Unable to generate job recommendations.';
            return back()->with('error', $error);
        }


        // 🧹 Filter valid results only (similarity > 0.10)
        $recommendations = array_filter(
            $recommendations,
            fn($rec) =>
            isset($rec['similarity']) && $rec['similarity'] > 0.10
        );


        // 🧭 Get filter inputs
        $search   = strtolower($request->get('search', ''));
        $industry = strtolower($request->get('industry', ''));
        $jobType  = strtolower($request->get('job_type', ''));


        // 🔎 Apply filters
        $recommendations = array_filter($recommendations, function ($rec) use ($search, $industry, $jobType) {
            $title    = strtolower($rec['job_title'] ?? '');
            $company  = strtolower($rec['company'] ?? '');
            $location = strtolower($rec['location'] ?? '');
            $skills   = strtolower($rec['job_skills'] ?? '');
            $indName  = strtolower($rec['industry_name'] ?? '');
            $type     = strtolower($rec['job_type'] ?? '');


            $matchSearch   = !$search || str_contains($title, $search) || str_contains($company, $search)
                || str_contains($location, $search) || str_contains($skills, $search);
            $matchIndustry = !$industry || str_contains($indName, $industry);
            $matchType     = !$jobType || $type === $jobType;


            return $matchSearch && $matchIndustry && $matchType;
        });


        // 🔢 Sort by highest similarity score
        usort($recommendations, fn($a, $b) => $b['similarity'] <=> $a['similarity']);


        return view('alumni.portal.jobs.job-page', compact('recommendations'));
    }


    /**
     * Display a specific job’s detailed information.
     */
    public function show($id)
    {
        $job = JobDetail::with(['industry', 'skills'])
            ->where('job_id', $id)
            ->first();


        if (!$job) {
            abort(404, 'Job not found');
        }


        return view('alumni.portal.jobs.job-view', compact('job'));
    }
}
