<?php


namespace App\Http\Controllers\Alumni;


use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\EventDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = EventDetail::with('eventType')
            ->where('status', '!=', 'done');

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('event_title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere(DB::raw("DATE_FORMAT(event_date, '%M %d, %Y')"), 'like', "%{$search}%")
                    ->orWhere('event_date', 'like', "%{$search}%");
            });
        }


        if ($request->filled('type_filter')) {
            $query->whereHas('eventType', function ($q) use ($request) {
                $q->where('event_type_name', $request->type_filter);
            });
        }

        $events = $query->orderBy('event_date', 'asc')->get()->map(function ($event) {
            $event->formatted_date = Carbon::parse($event->event_date)->format('F d, Y');


            $start = $event->event_time ? Carbon::parse($event->event_time)->format('g:i A') : null;
            $end = $event->event_end_time ? Carbon::parse($event->event_end_time)->format('g:i A') : null;
            $event->formatted_time = $start && $end ? "{$start} - {$end}" : ($start ?? 'TBA');


            return $event;
        });

        if ($request->ajax()) {
            return view('alumni.portal.events.event-page', compact('events'))->render();
        }


        return view('alumni.portal.events.event-page', compact('events'));
    }


    public function show($id)
    {
        $event = EventDetail::with('eventType')->where('event_id', $id)->firstOrFail();
        $event->formatted_date = Carbon::parse($event->event_date)->format('F d, Y');
        $start = $event->event_time ? Carbon::parse($event->event_time)->format('g:i A') : null;
        $end = $event->event_end_time ? Carbon::parse($event->event_end_time)->format('g:i A') : null;
        $event->formatted_time = $start && $end ? "{$start} - {$end}" : ($start ?? 'TBA');
        $userId = Auth::id();
        $existingRSVP = DB::table('event_attendees')
            ->where('user_id', $userId)
            ->where('event_id', $event->event_id)
            ->value('rsvp_status');


        return view('alumni.portal.events.event-view', compact('event', 'existingRSVP'));
    }


    public function submitRSVP(Request $request, $id)
    {
        $request->validate([
            'rsvp_status' => 'required|in:going,maybe,not going'
        ]);

        $userId = Auth::id();

        DB::table('event_attendees')->updateOrInsert(
            ['user_id' => $userId, 'event_id' => $id],
            [
                'rsvp_status' => $request->rsvp_status,
                'updated_at' => now(),
                'created_at' => now()
            ]
        );


        return back()->with('success', 'Your RSVP response has been recorded.');
    }
}
