<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class CalendarController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index(Request $request)
    {
        // Update past events to completed status
        $this->updatePastEvents();

        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        // Ensure valid month and year
        $month = max(1, min(12, $month));
        $year = max(1900, min(2100, $year));

        $date = Carbon::create($year, $month, 1);
        $startOfCalendar = $date->copy()->startOfMonth()->startOfWeek();
        $endOfCalendar = $date->copy()->endOfMonth()->endOfWeek();

        // Get events for the current month view
        $events = Event::where('user_id', auth()->id())
            ->where(function ($query) use ($startOfCalendar, $endOfCalendar) {
                $query->whereBetween('start_date', [$startOfCalendar, $endOfCalendar])
                      ->orWhereBetween('end_date', [$startOfCalendar, $endOfCalendar])
                      ->orWhere(function ($q) use ($startOfCalendar, $endOfCalendar) {
                          $q->where('start_date', '<=', $startOfCalendar)
                            ->where('end_date', '>=', $endOfCalendar);
                      });
            })
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get();

        // Group events by date
        $eventsByDate = $events->groupBy(function ($event) {
            return $event->start_date->format('Y-m-d');
        });

        return view('calendar.index', compact('date', 'events', 'eventsByDate', 'year', 'month'));
    }

    public function getEvents(Request $request)
    {
        // Update past events to completed status
        $this->updatePastEvents();

        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $events = Event::where('user_id', auth()->id())
            ->forMonth($year, $month)
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start_date->format('Y-m-d'),
                    'end' => $event->end_date->addDay()->format('Y-m-d'), // FullCalendar expects exclusive end date
                    'color' => $event->color,
                    'allDay' => $event->all_day,
                    'time' => $event->formatted_time_range,
                    'description' => $event->description,
                    'location' => $event->location,
                    'priority' => $event->priority,
                    'status' => $event->status,
                ];
            });

        return response()->json($events);
    }

    /**
     * Update past events to completed status
     */
    private function updatePastEvents()
    {
        $today = now()->startOfDay();

        Event::where('user_id', auth()->id())
            ->where('status', 'active')
            ->where('end_date', '<', $today)
            ->update(['status' => 'completed']);
    }
}
