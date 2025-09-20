<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Display the reports dashboard
     */
    public function index(Request $request)
    {
        $userId = auth()->id();
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        // Update past events to completed status
        $this->updatePastEvents();

        // Get overview statistics
        $stats = $this->getOverviewStats($userId);

        // Get monthly data for charts
        $monthlyData = $this->getMonthlyData($userId, $year);

        // Get current month events breakdown
        $currentMonthData = $this->getCurrentMonthData($userId, $year, $month);

        // Get recent activity
        $recentActivity = $this->getRecentActivity($userId);

        return view('reports.index', compact(
            'stats',
            'monthlyData',
            'currentMonthData',
            'recentActivity',
            'year',
            'month'
        ));
    }

    /**
     * Get overview statistics
     */
    private function getOverviewStats($userId)
    {
        $today = now();
        $startOfMonth = $today->copy()->startOfMonth();
        $startOfYear = $today->copy()->startOfYear();

        return [
            'total_events' => Event::where('user_id', $userId)->count(),
            'this_month' => Event::where('user_id', $userId)
                ->whereBetween('start_date', [$startOfMonth, $today])
                ->count(),
            'completed' => Event::where('user_id', $userId)
                ->where('status', 'completed')
                ->count(),
            'active' => Event::where('user_id', $userId)
                ->where('status', 'active')
                ->count(),
            'cancelled' => Event::where('user_id', $userId)
                ->where('status', 'cancelled')
                ->count(),
            'this_year' => Event::where('user_id', $userId)
                ->whereBetween('start_date', [$startOfYear, $today])
                ->count(),
        ];
    }

    /**
     * Get monthly data for the year
     */
    private function getMonthlyData($userId, $year)
    {
        $data = [];
        for ($month = 1; $month <= 12; $month++) {
            $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
            $endOfMonth = $startOfMonth->copy()->endOfMonth();

            $data[] = [
                'month' => $startOfMonth->format('M'),
                'events' => Event::where('user_id', $userId)
                    ->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                    ->count(),
                'completed' => Event::where('user_id', $userId)
                    ->where('status', 'completed')
                    ->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                    ->count(),
            ];
        }
        return $data;
    }

    /**
     * Get current month detailed data
     */
    private function getCurrentMonthData($userId, $year, $month)
    {
        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        return [
            'priority_breakdown' => Event::where('user_id', $userId)
                ->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                ->select('priority', DB::raw('count(*) as count'))
                ->groupBy('priority')
                ->get(),
            'status_breakdown' => Event::where('user_id', $userId)
                ->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get(),
            'daily_events' => Event::where('user_id', $userId)
                ->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                ->select(DB::raw('DATE(start_date) as date'), DB::raw('count(*) as count'))
                ->groupBy(DB::raw('DATE(start_date)'))
                ->orderBy('date')
                ->get(),
        ];
    }

    /**
     * Get recent activity
     */
    private function getRecentActivity($userId)
    {
        return Event::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Export reports as PDF or Excel
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'pdf');
        $userId = auth()->id();

        $stats = $this->getOverviewStats($userId);
        $monthlyData = $this->getMonthlyData($userId, now()->year);

        if ($format === 'csv') {
            return $this->exportCsv($stats, $monthlyData);
        }

        // For now, return JSON data (can be enhanced with PDF library later)
        return response()->json([
            'stats' => $stats,
            'monthly_data' => $monthlyData,
            'generated_at' => now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Export as CSV
     */
    private function exportCsv($stats, $monthlyData)
    {
        $filename = 'calendar_report_' . now()->format('Y_m_d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($stats, $monthlyData) {
            $file = fopen('php://output', 'w');

            // Overview stats
            fputcsv($file, ['Calendar Report - ' . now()->format('Y-m-d H:i:s')]);
            fputcsv($file, []);
            fputcsv($file, ['Overview Statistics']);
            fputcsv($file, ['Total Events', $stats['total_events']]);
            fputcsv($file, ['This Month', $stats['this_month']]);
            fputcsv($file, ['This Year', $stats['this_year']]);
            fputcsv($file, ['Completed', $stats['completed']]);
            fputcsv($file, ['Active', $stats['active']]);
            fputcsv($file, ['Cancelled', $stats['cancelled']]);
            fputcsv($file, []);

            // Monthly data
            fputcsv($file, ['Monthly Breakdown']);
            fputcsv($file, ['Month', 'Total Events', 'Completed Events']);
            foreach ($monthlyData as $data) {
                fputcsv($file, [$data['month'], $data['events'], $data['completed']]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
