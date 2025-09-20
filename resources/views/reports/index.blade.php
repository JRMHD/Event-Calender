@extends('layouts.app')

@section('title', 'Calendar Reports - Unity Group Calendar')
@section('page-title', 'Calendar Reports')

@section('content')
<style>
    .reports-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .reports-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, rgba(66, 133, 244, 0.1) 0%, rgba(52, 168, 83, 0.1) 100%);
        border-radius: 12px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .reports-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }

    .reports-subtitle {
        color: #5f6368;
        font-size: 0.95rem;
        margin-top: 0.25rem;
    }

    .export-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .export-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--primary-blue) 0%, #1a73e8 100%);
        color: white;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(66, 133, 244, 0.3);
    }

    .export-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(66, 133, 244, 0.4);
        color: white;
        text-decoration: none;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .stat-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-icon.total { background: rgba(66, 133, 244, 0.1); color: var(--primary-blue); }
    .stat-icon.completed { background: rgba(52, 168, 83, 0.1); color: var(--primary-green); }
    .stat-icon.active { background: rgba(251, 188, 4, 0.1); color: #856404; }
    .stat-icon.cancelled { background: rgba(234, 67, 53, 0.1); color: var(--primary-red); }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }

    .stat-label {
        color: #5f6368;
        font-size: 0.9rem;
        font-weight: 500;
        margin-top: 0.5rem;
    }

    .chart-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .chart-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .chart-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
    }

    .chart-placeholder {
        height: 300px;
        background: linear-gradient(135deg, rgba(66, 133, 244, 0.05) 0%, rgba(52, 168, 83, 0.05) 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #5f6368;
        font-size: 1.1rem;
        border: 2px dashed rgba(0, 0, 0, 0.1);
    }

    .recent-activity {
        grid-column: 1 / -1;
    }

    .activity-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        background: rgba(66, 133, 244, 0.05);
        border-radius: 8px;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 0.25rem;
    }

    .activity-meta {
        color: #5f6368;
        font-size: 0.85rem;
    }

    .priority-high { border-left: 4px solid var(--primary-red); }
    .priority-medium { border-left: 4px solid var(--primary-yellow); }
    .priority-low { border-left: 4px solid var(--dark-gray); }

    .status-active { background: rgba(52, 168, 83, 0.1); }
    .status-completed { background: rgba(66, 133, 244, 0.1); }
    .status-cancelled { background: rgba(234, 67, 53, 0.1); }

    .month-selector {
        display: flex;
        gap: 1rem;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .month-input {
        padding: 0.5rem 1rem;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        font-size: 0.9rem;
        background: rgba(255, 255, 255, 0.8);
    }

    @media (max-width: 768px) {
        .reports-container {
            padding: 0 1rem;
        }

        .reports-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .reports-title {
            font-size: 1.5rem;
        }

        .reports-subtitle {
            font-size: 0.9rem;
        }

        .export-actions {
            flex-direction: column;
            width: 100%;
            gap: 0.5rem;
        }

        .export-btn {
            width: 100%;
            justify-content: center;
            padding: 1rem 1.5rem;
            font-size: 1rem;
        }

        .chart-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .stat-card {
            padding: 1rem;
        }

        .stat-header {
            margin-bottom: 0.75rem;
        }

        .stat-icon {
            width: 2.5rem;
            height: 2.5rem;
            font-size: 1.25rem;
        }

        .stat-icon svg {
            width: 20px;
            height: 20px;
        }

        .stat-value {
            font-size: 1.75rem;
        }

        .stat-label {
            font-size: 0.85rem;
        }

        .chart-card {
            padding: 1rem;
        }

        .chart-title {
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .chart-placeholder {
            height: 200px;
            font-size: 0.9rem;
        }

        .activity-item {
            padding: 0.75rem;
            flex-direction: row;
            align-items: center;
            gap: 0.75rem;
        }

        .activity-icon {
            width: 2rem;
            height: 2rem;
            font-size: 0.875rem;
        }

        .activity-icon svg {
            width: 16px;
            height: 16px;
        }

        .activity-title {
            font-size: 0.95rem;
        }

        .activity-meta {
            font-size: 0.8rem;
        }

        .month-selector {
            flex-direction: column;
            align-items: stretch;
            gap: 0.75rem;
        }

        .month-input {
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .reports-container {
            padding: 0 0.75rem;
        }

        .reports-header {
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .reports-title {
            font-size: 1.25rem;
        }

        .export-actions {
            gap: 0.5rem;
        }

        .export-btn {
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .stat-card {
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-header {
            margin-bottom: 0;
            flex-shrink: 0;
        }

        .stat-icon {
            width: 2.5rem;
            height: 2.5rem;
        }

        .stat-icon svg {
            width: 18px;
            height: 18px;
        }

        .stat-content {
            flex: 1;
        }

        .stat-value {
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.8rem;
            margin: 0;
        }

        .chart-card {
            padding: 1rem;
        }

        .chart-title {
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .activity-item {
            padding: 0.75rem;
            flex-direction: row;
            align-items: center;
            gap: 0.75rem;
        }

        .activity-icon {
            width: 2rem;
            height: 2rem;
            flex-shrink: 0;
        }

        .activity-icon svg {
            width: 14px;
            height: 14px;
        }

        .activity-content {
            flex: 1;
            min-width: 0;
        }

        .activity-title {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .activity-meta {
            font-size: 0.75rem;
            line-height: 1.4;
        }

        .month-selector {
            gap: 0.5rem;
        }

        .month-input {
            padding: 0.75rem;
            font-size: 0.95rem;
        }
    }

    /* Extra small phones */
    @media (max-width: 360px) {
        .reports-container {
            padding: 0 0.5rem;
        }

        .reports-header {
            padding: 0.75rem;
        }

        .reports-title {
            font-size: 1.1rem;
        }

        .export-btn {
            padding: 0.75rem;
            font-size: 0.9rem;
        }

        .stat-card {
            padding: 0.75rem;
        }

        .stat-value {
            font-size: 1.25rem;
        }

        .chart-card {
            padding: 0.75rem;
        }

        .activity-item {
            padding: 0.5rem;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .activity-content {
            width: 100%;
        }
    }
</style>

<div class="reports-container">
    <div class="reports-header">
        <div>
            <h1 class="reports-title">Calendar Reports</h1>
            <p class="reports-subtitle">Analytics and insights for your calendar events</p>
        </div>
        <div class="export-actions">
            <a href="{{ route('reports.export', ['format' => 'csv']) }}" class="export-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                </svg>
                Export CSV
            </a>
            <a href="{{ route('reports.export', ['format' => 'json']) }}" class="export-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M5,3H7V5H5V10A2,2 0 0,1 3,8V6A2,2 0 0,1 5,4V3M19,3V4A2,2 0 0,1 21,6V8A2,2 0 0,1 19,10V5H17V3H19M5,21V20A2,2 0 0,1 3,18V16A2,2 0 0,1 5,14V19H7V21H5M19,21H17V19H19V14A2,2 0 0,1 21,16V18A2,2 0 0,1 19,20V21Z"/>
                </svg>
                Export JSON
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon total">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22,21H2V3H4V19H6V10H10V19H12V6H16V19H18V14H22V21Z"/>
                    </svg>
                </div>
            </div>
            <div class="stat-content">
                <h2 class="stat-value">{{ $stats['total_events'] }}</h2>
                <p class="stat-label">Total Events</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon active">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12.5,7V13L16.25,15.15L15.5,16.25L11,13.5V7H12.5Z"/>
                    </svg>
                </div>
            </div>
            <div class="stat-content">
                <h2 class="stat-value">{{ $stats['active'] }}</h2>
                <p class="stat-label">Active Events</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon completed">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10,17L5,12L6.41,10.58L10,14.17L17.59,6.58L19,8M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                    </svg>
                </div>
            </div>
            <div class="stat-content">
                <h2 class="stat-value">{{ $stats['completed'] }}</h2>
                <p class="stat-label">Completed Events</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon cancelled">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12,2C17.53,2 22,6.47 22,12C22,17.53 17.53,22 12,22C6.47,22 2,17.53 2,12C2,6.47 6.47,2 12,2M15.59,7L12,10.59L8.41,7L7,8.41L10.59,12L7,15.59L8.41,17L12,13.41L15.59,17L17,15.59L13.41,12L17,8.41L15.59,7Z"/>
                    </svg>
                </div>
            </div>
            <div class="stat-content">
                <h2 class="stat-value">{{ $stats['cancelled'] }}</h2>
                <p class="stat-label">Cancelled Events</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon total">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                    </svg>
                </div>
            </div>
            <div class="stat-content">
                <h2 class="stat-value">{{ $stats['this_month'] }}</h2>
                <p class="stat-label">This Month</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon total">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9,10V12H7V10H9M13,10V12H11V10H13M17,10V12H15V10H17M19,3A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5C3.89,21 3,20.1 3,19V5A2,2 0 0,1 5,3H6V1H8V3H16V1H18V3H19M19,19V8H5V19H19M9,14V16H7V14H9M13,14V16H11V14H13M17,14V16H15V14H17Z"/>
                    </svg>
                </div>
            </div>
            <div class="stat-content">
                <h2 class="stat-value">{{ $stats['this_year'] }}</h2>
                <p class="stat-label">This Year</p>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="chart-grid">
        <div class="chart-card">
            <h3 class="chart-title">Monthly Events Overview</h3>
            <canvas id="monthlyChart" width="400" height="200"></canvas>
        </div>

        <div class="chart-card">
            <h3 class="chart-title">Current Month Breakdown</h3>
            <div class="month-selector">
                <label for="month">Month:</label>
                <select id="month" class="month-input">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $i == $month ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
                <select id="year" class="month-input">
                    @for($i = now()->year - 2; $i <= now()->year + 1; $i++)
                        <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <canvas id="breakdownChart" width="200" height="200"></canvas>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="chart-card recent-activity">
        <h3 class="chart-title">Recent Activity</h3>
        @if($recentActivity->count() > 0)
            <ul class="activity-list">
                @foreach($recentActivity as $event)
                    <li class="activity-item priority-{{ $event->priority }}">
                        <div class="activity-icon status-{{ $event->status }}">
                            @if($event->status === 'completed')
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M10,17L5,12L6.41,10.58L10,14.17L17.59,6.58L19,8M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                                </svg>
                            @elseif($event->status === 'cancelled')
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12,2C17.53,2 22,6.47 22,12C22,17.53 17.53,22 12,22C6.47,22 2,17.53 2,12C2,6.47 6.47,2 12,2M15.59,7L12,10.59L8.41,7L7,8.41L10.59,12L7,15.59L8.41,17L12,13.41L15.59,17L17,15.59L13.41,12L17,8.41L15.59,7Z"/>
                                </svg>
                            @else
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12.5,7V13L16.25,15.15L15.5,16.25L11,13.5V7H12.5Z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">{{ $event->title }}</div>
                            <div class="activity-meta">
                                {{ ucfirst($event->status) }} • {{ ucfirst($event->priority) }} Priority
                                • {{ $event->formatted_start_date }}
                                @if($event->location)
                                    • {{ $event->location }}
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="chart-placeholder">
                No recent activity found
            </div>
        @endif
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Events Chart
    const monthlyData = @json($monthlyData);
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');

    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthlyData.map(item => item.month),
            datasets: [{
                label: 'Total Events',
                data: monthlyData.map(item => item.events),
                borderColor: '#4285F4',
                backgroundColor: 'rgba(66, 133, 244, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Completed Events',
                data: monthlyData.map(item => item.completed),
                borderColor: '#34A853',
                backgroundColor: 'rgba(52, 168, 83, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Current Month Breakdown Chart
    const currentMonthData = @json($currentMonthData);
    const breakdownCtx = document.getElementById('breakdownChart').getContext('2d');

    const statusData = currentMonthData.status_breakdown.reduce((acc, item) => {
        acc[item.status] = item.count;
        return acc;
    }, {});

    new Chart(breakdownCtx, {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Completed', 'Cancelled'],
            datasets: [{
                data: [
                    statusData.active || 0,
                    statusData.completed || 0,
                    statusData.cancelled || 0
                ],
                backgroundColor: [
                    '#FBBC04',
                    '#34A853',
                    '#EA4335'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Month/Year selector change handler
    document.getElementById('month').addEventListener('change', updateCharts);
    document.getElementById('year').addEventListener('change', updateCharts);

    function updateCharts() {
        const month = document.getElementById('month').value;
        const year = document.getElementById('year').value;
        window.location.href = `{{ route('reports.index') }}?month=${month}&year=${year}`;
    }
});
</script>
@endsection