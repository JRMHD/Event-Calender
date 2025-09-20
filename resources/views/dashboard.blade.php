@extends('layouts.app')

@section('title', 'User Dashboard - Unity Group Calendar')
@section('page-title', 'Dashboard')

@section('content')
<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .dashboard-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.6) 100%);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .card-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        font-weight: 600;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1a1a1a;
    }

    .card-content {
        color: #5f6368;
        line-height: 1.6;
    }

    .welcome-section {
        text-align: center;
        margin-bottom: 3rem;
        padding: 2rem;
        background: linear-gradient(135deg, rgba(66, 133, 244, 0.1) 0%, rgba(52, 168, 83, 0.1) 100%);
        border-radius: 16px;
    }

    .welcome-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }

    .welcome-subtitle {
        font-size: 1.1rem;
        color: #5f6368;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 2rem;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: linear-gradient(135deg, #4285F4 0%, #1a73e8 100%);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(66, 133, 244, 0.3);
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(66, 133, 244, 0.4);
        color: white;
    }

    .action-btn:nth-child(2) {
        background: linear-gradient(135deg, #34A853 0%, #2d7a3f 100%);
        box-shadow: 0 4px 12px rgba(52, 168, 83, 0.3);
    }

    .action-btn:nth-child(2):hover {
        box-shadow: 0 8px 20px rgba(52, 168, 83, 0.4);
    }

    .action-btn:nth-child(3) {
        background: linear-gradient(135deg, #FBBC04 0%, #f9ab00 100%);
        box-shadow: 0 4px 12px rgba(251, 188, 4, 0.3);
        color: #1a1a1a;
    }

    .action-btn:nth-child(3):hover {
        box-shadow: 0 8px 20px rgba(251, 188, 4, 0.4);
        color: #1a1a1a;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 12px;
        backdrop-filter: blur(5px);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #4285F4;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #5f6368;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .welcome-title {
            font-size: 1.5rem;
        }

        .welcome-section {
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .quick-actions {
            grid-template-columns: 1fr;
        }

        .stats-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .stat-item {
            padding: 0.75rem;
        }

        .stat-number {
            font-size: 1.5rem;
        }

        .dashboard-card {
            padding: 1rem;
        }

        .card-header {
            gap: 0.75rem;
        }

        .card-icon {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }

        .card-title {
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .stats-row {
            grid-template-columns: 1fr;
        }

        .welcome-section {
            padding: 1rem;
        }

        .dashboard-card {
            padding: 0.75rem;
        }
    }
</style>

<div class="welcome-section">
    <h1 class="welcome-title">Welcome back, {{ auth()->user()->name }}!</h1>
    <p class="welcome-subtitle">Here's what's happening with your Unity Group Calendar</p>
</div>

<div class="stats-row">
    <div class="stat-item">
        <div class="stat-number">{{ $stats['upcoming_events'] }}</div>
        <div class="stat-label">Upcoming Events</div>
    </div>
    <div class="stat-item">
        <div class="stat-number">{{ $stats['this_week'] }}</div>
        <div class="stat-label">This Week</div>
    </div>
    <div class="stat-item">
        <div class="stat-number">{{ $stats['this_month'] }}</div>
        <div class="stat-label">This Month</div>
    </div>
    <div class="stat-item">
        <div class="stat-number">{{ $stats['completed'] }}</div>
        <div class="stat-label">Completed</div>
    </div>
</div>

<div class="dashboard-grid">
    <div class="dashboard-card">
        <div class="card-header">
            <div class="card-icon" style="background: #4285F4;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                </svg>
            </div>
            <h3 class="card-title">Recent Events</h3>
        </div>
        <div class="card-content">
            @if($upcomingEvents->count() > 0)
                @foreach($upcomingEvents as $event)
                    <div style="border-bottom: 1px solid #eee; padding: 0.5rem 0; margin-bottom: 0.5rem;">
                        <strong>{{ $event->title }}</strong><br>
                        <small style="color: #666;">{{ $event->start_date->format('M j, Y g:i A') }}</small>
                    </div>
                @endforeach
            @else
                <p>No upcoming events scheduled.</p>
            @endif
            <div class="quick-actions" style="margin-top: 1rem;">
                <a href="{{ route('events.create') }}" class="action-btn" style="font-size: 0.85rem; padding: 0.75rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Add Event
                </a>
            </div>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header">
            <div class="card-icon" style="background: #34A853;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16 13c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 1c-1.33 0-4 .67-4 2v2h8v-2c0-1.33-2.67-2-4-2zM8 13c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 1c-1.33 0-4 .67-4 2v2h8v-2c0-1.33-2.67-2-4-2z"/>
                </svg>
            </div>
            <h3 class="card-title">Team Activity</h3>
        </div>
        <div class="card-content">
            @if($recentActivity->count() > 0)
                <p style="margin-bottom: 1rem;">Recent activity in your calendar:</p>
                @foreach($recentActivity as $activity)
                    <div style="border-bottom: 1px solid #eee; padding: 0.5rem 0; margin-bottom: 0.5rem;">
                        <strong>{{ $activity->title }}</strong><br>
                        <small style="color: #666;">{{ $activity->created_at->diffForHumans() }} - {{ ucfirst($activity->status) }}</small>
                    </div>
                @endforeach
            @else
                <p>No recent activity found.</p>
            @endif
            <div class="quick-actions" style="margin-top: 1rem;">
                <a href="{{ route('events.index') }}" class="action-btn" style="font-size: 0.85rem; padding: 0.75rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    View All Events
                </a>
            </div>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header">
            <div class="card-icon" style="background: #FBBC04; color: #1a1a1a;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M22,21H2V3H4V19H6V10H10V19H12V6H16V19H18V14H22V21Z"/>
                </svg>
            </div>
            <h3 class="card-title">Weekly Report</h3>
        </div>
        <div class="card-content">
            <p style="margin-bottom: 1rem;">Weekly breakdown:</p>
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1rem;">
                @foreach($weeklyBreakdown as $day)
                    <div style="text-align: center; min-width: 60px; padding: 0.5rem; background: rgba(66, 133, 244, 0.1); border-radius: 8px;">
                        <div style="font-weight: 600; color: #4285F4;">{{ $day['events'] }}</div>
                        <small style="color: #666;">{{ $day['day'] }} {{ $day['date'] }}</small>
                    </div>
                @endforeach
            </div>
            <div class="quick-actions" style="margin-top: 1rem;">
                <a href="{{ route('reports.index') }}" class="action-btn" style="font-size: 0.85rem; padding: 0.75rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                    </svg>
                    Full Report
                </a>
            </div>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header">
            <div class="card-icon" style="background: #EA4335;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
            </div>
            <h3 class="card-title">Achievements</h3>
        </div>
        <div class="card-content">
            @if($stats['completed'] > 0)
                <p>Great job! You've completed {{ $stats['completed'] }} events.
                @if($stats['upcoming_events'] > 0)
                    You have {{ $stats['upcoming_events'] }} upcoming events to look forward to.
                @else
                    Consider scheduling some new events for the coming days.
                @endif
                </p>
            @else
                <p>Start your journey by creating your first event! Track your progress and achievements as you build your schedule.</p>
            @endif
            <div class="quick-actions" style="margin-top: 1rem;">
                <a href="{{ route('calendar.index') }}" class="action-btn" style="font-size: 0.85rem; padding: 0.75rem; background: linear-gradient(135deg, #EA4335 0%, #d33 100%);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9 11H7v6h2v-6zm4 0h-2v6h2v-6zm4 0h-2v6h2v-6zM4 5v2h16V5H4z"/>
                    </svg>
                    View Calendar
                </a>
            </div>
        </div>
    </div>
</div>

<div class="quick-actions">
    <a href="{{ route('calendar.index') }}" class="action-btn">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
        </svg>
        View Calendar
    </a>
    <a href="{{ route('events.create') }}" class="action-btn">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
        </svg>
        Create Event
    </a>
    <a href="{{ route('reports.index') }}" class="action-btn">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
            <path d="M16 13c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 1c-1.33 0-4 .67-4 2v2h8v-2c0-1.33-2.67-2-4-2zM8 13c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 1c-1.33 0-4 .67-4 2v2h8v-2c0-1.33-2.67-2-4-2z"/>
        </svg>
        View Reports
    </a>
</div>
@endsection
