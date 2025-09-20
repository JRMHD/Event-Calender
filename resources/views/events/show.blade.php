@extends('layouts.app')

@section('title', $event->title . ' - Unity Group Calendar')
@section('page-title', 'Event Details')

@section('content')
<style>
    .event-detail-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .event-header-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
        backdrop-filter: blur(20px);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-left: 6px solid {{ $event->color }};
    }

    .event-title-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }

    .event-main-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }

    .event-status-priority {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-end;
    }

    .status-badge, .priority-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-badge.active {
        background: rgba(52, 168, 83, 0.15);
        color: var(--primary-green);
    }

    .status-badge.completed {
        background: rgba(66, 133, 244, 0.15);
        color: var(--primary-blue);
    }

    .status-badge.cancelled {
        background: rgba(234, 67, 53, 0.15);
        color: var(--primary-red);
    }

    .priority-badge.high {
        background: rgba(234, 67, 53, 0.15);
        color: var(--primary-red);
    }

    .priority-badge.medium {
        background: rgba(251, 188, 4, 0.15);
        color: #856404;
    }

    .priority-badge.low {
        background: rgba(95, 99, 104, 0.15);
        color: var(--dark-gray);
    }

    .event-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .event-info-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-icon {
        width: 20px;
        height: 20px;
        color: {{ $event->color }};
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background: rgba({{ $event->color }}20, 0.05);
        border-radius: 12px;
        border-left: 3px solid {{ $event->color }};
    }

    .info-icon {
        width: 18px;
        height: 18px;
        color: {{ $event->color }};
        flex-shrink: 0;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #5f6368;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 500;
        color: #1a1a1a;
    }

    .description-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .description-text {
        color: #5f6368;
        line-height: 1.7;
        font-size: 1rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-edit {
        background: linear-gradient(135deg, #FBBC04 0%, #F9AB00 100%);
        color: #1a1a1a;
        box-shadow: 0 4px 12px rgba(251, 188, 4, 0.3);
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(251, 188, 4, 0.4);
        color: #1a1a1a;
        text-decoration: none;
    }

    .btn-delete {
        background: linear-gradient(135deg, #EA4335 0%, #d33 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(234, 67, 53, 0.3);
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(234, 67, 53, 0.4);
        color: white;
    }

    .btn-back {
        background: transparent;
        color: var(--primary-blue);
        border: 2px solid var(--primary-blue);
    }

    .btn-back:hover {
        background: var(--primary-blue);
        color: white;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .event-details-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .event-title-section {
            flex-direction: column;
            gap: 1rem;
        }

        .event-status-priority {
            align-items: flex-start;
            flex-direction: row;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="event-detail-container">
    <!-- Event Header -->
    <div class="event-header-card">
        <div class="event-title-section">
            <h1 class="event-main-title">{{ $event->title }}</h1>
            <div class="event-status-priority">
                <span class="status-badge {{ $event->status }}">{{ ucfirst($event->status) }}</span>
                <span class="priority-badge {{ $event->priority }}">{{ ucfirst($event->priority) }} Priority</span>
            </div>
        </div>
    </div>

    <!-- Event Details Grid -->
    <div class="event-details-grid">
        <!-- Date & Time Info -->
        <div class="event-info-card">
            <h3 class="card-title">
                <svg class="card-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                </svg>
                Date & Time
            </h3>

            <div class="info-item">
                <svg class="info-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                <div class="info-content">
                    <div class="info-label">Start Date</div>
                    <div class="info-value">{{ $event->formatted_start_date }}</div>
                </div>
            </div>

            @if(!$event->start_date->eq($event->end_date))
                <div class="info-item">
                    <svg class="info-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <div class="info-content">
                        <div class="info-label">End Date</div>
                        <div class="info-value">{{ $event->formatted_end_date }}</div>
                    </div>
                </div>
            @endif

            <div class="info-item">
                <svg class="info-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
                    <path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                </svg>
                <div class="info-content">
                    <div class="info-label">Time</div>
                    <div class="info-value">{{ $event->formatted_time_range ?? 'All Day' }}</div>
                </div>
            </div>

            <div class="info-item">
                <svg class="info-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                </svg>
                <div class="info-content">
                    <div class="info-label">Duration</div>
                    <div class="info-value">{{ $event->duration_in_days }} {{ $event->duration_in_days === 1 ? 'day' : 'days' }}</div>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="event-info-card">
            <h3 class="card-title">
                <svg class="card-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                Event Details
            </h3>

            @if($event->location)
                <div class="info-item">
                    <svg class="info-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    <div class="info-content">
                        <div class="info-label">Location</div>
                        <div class="info-value">{{ $event->location }}</div>
                    </div>
                </div>
            @endif

            <div class="info-item">
                <svg class="info-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
                <div class="info-content">
                    <div class="info-label">Created By</div>
                    <div class="info-value">{{ $event->user->name }}</div>
                </div>
            </div>

            <div class="info-item">
                <svg class="info-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <div class="info-content">
                    <div class="info-label">Priority Level</div>
                    <div class="info-value">{{ ucfirst($event->priority) }}</div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon" style="width: 18px; height: 18px; background: {{ $event->color }}; border-radius: 50%;"></div>
                <div class="info-content">
                    <div class="info-label">Event Color</div>
                    <div class="info-value">{{ $event->color }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    @if($event->description)
        <div class="description-card">
            <h3 class="card-title">
                <svg class="card-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                </svg>
                Description
            </h3>
            <p class="description-text">{{ $event->description }}</p>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('events.index') }}" class="btn-action btn-back">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
            </svg>
            Back to Events
        </a>

        <a href="{{ route('events.edit', $event) }}" class="btn-action btn-edit">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
            </svg>
            Edit Event
        </a>

        <form method="POST" action="{{ route('events.destroy', $event) }}" style="display: inline;"
              onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-action btn-delete">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                </svg>
                Delete Event
            </button>
        </form>
    </div>
</div>
@endsection