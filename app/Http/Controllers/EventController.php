<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EventController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status', 'all');

        // Update past events to completed status
        $this->updatePastEvents();

        $events = Event::where('user_id', auth()->id())
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
            })
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->orderBy('start_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(15);

        return view('events.index', compact('events', 'search', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $date = $request->get('date', now()->format('Y-m-d'));
        return view('events.create', compact('date'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'all_day' => 'boolean',
            'color' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
            'priority' => 'required|in:low,medium,high',
            'location' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        $data['user_id'] = auth()->id();
        $data['all_day'] = $request->has('all_day');

        // If all day event, clear times
        if ($data['all_day']) {
            $data['start_time'] = null;
            $data['end_time'] = null;
        }

        Event::create($data);

        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        // $this->authorize('view', $event);
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        // $this->authorize('update', $event);
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        // $this->authorize('update', $event);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'all_day' => 'boolean',
            'color' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:active,cancelled,completed',
            'location' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        $data['all_day'] = $request->has('all_day');

        // If all day event, clear times
        if ($data['all_day']) {
            $data['start_time'] = null;
            $data['end_time'] = null;
        }

        $event->update($data);

        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // $this->authorize('delete', $event);

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }

    /**
     * Store event via AJAX for calendar
     */
    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'all_day' => 'boolean',
            'color' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
            'priority' => 'required|in:low,medium,high',
            'location' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['user_id'] = auth()->id();
        $data['all_day'] = $request->has('all_day') || $request->input('all_day') === true;

        // If all day event, clear times
        if ($data['all_day']) {
            $data['start_time'] = null;
            $data['end_time'] = null;
        }

        $event = Event::create($data);

        return response()->json([
            'message' => 'Event created successfully!',
            'event' => [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date->format('Y-m-d'),
                'end' => $event->end_date->addDay()->format('Y-m-d'),
                'color' => $event->color,
                'allDay' => $event->all_day,
            ]
        ]);
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
