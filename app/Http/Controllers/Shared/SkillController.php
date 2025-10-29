<?php


namespace App\Http\Controllers\Shared;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skill;


class SkillController extends Controller
{

    public function search(Request $request)
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
}
