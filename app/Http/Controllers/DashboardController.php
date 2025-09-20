<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $today = now();
        $startOfWeek = $today->copy()->startOfWeek();
        $endOfWeek = $today->copy()->endOfWeek();
        $startOfMonth = $today->copy()->startOfMonth();

        // Get real statistics
        $stats = [
            'upcoming_events' => Event::where('user_id', $userId)
                ->where('start_date', '>=', $today)
                ->where('status', 'active')
                ->count(),
            'this_week' => Event::where('user_id', $userId)
                ->whereBetween('start_date', [$startOfWeek, $endOfWeek])
                ->count(),
            'this_month' => Event::where('user_id', $userId)
                ->whereBetween('start_date', [$startOfMonth, $today->copy()->endOfMonth()])
                ->count(),
            'completed' => Event::where('user_id', $userId)
                ->where('status', 'completed')
                ->count(),
        ];

        // Get upcoming events
        $upcomingEvents = Event::where('user_id', $userId)
            ->where('start_date', '>=', $today)
            ->where('status', 'active')
            ->orderBy('start_date', 'asc')
            ->limit(5)
            ->get();

        // Get recent activity
        $recentActivity = Event::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get weekly breakdown
        $weeklyBreakdown = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $weeklyBreakdown[] = [
                'day' => $date->format('D'),
                'date' => $date->format('j'),
                'events' => Event::where('user_id', $userId)
                    ->whereDate('start_date', $date)
                    ->count()
            ];
        }

        return view('dashboard', compact('stats', 'upcomingEvents', 'recentActivity', 'weeklyBreakdown'));
    }
}
