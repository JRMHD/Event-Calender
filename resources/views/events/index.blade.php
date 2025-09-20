@extends('layouts.app')

@section('title', 'Events - Unity Group Calendar')
@section('page-title', 'Events')

@section('content')
<style>
    .events-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .events-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, rgba(66, 133, 244, 0.1) 0%, rgba(52, 168, 83, 0.1) 100%);
        border-radius: 12px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .events-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }

    .events-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .add-event-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--primary-green) 0%, #2d7a3f 100%);
        color: white;
        border: none;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(52, 168, 83, 0.3);
    }

    .add-event-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(52, 168, 83, 0.4);
        color: white;
        text-decoration: none;
    }

    .view-calendar-btn {
        padding: 0.75rem 1.5rem;
        background: transparent;
        color: var(--primary-blue);
        border: 2px solid var(--primary-blue);
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .view-calendar-btn:hover {
        background: var(--primary-blue);
        color: white;
        text-decoration: none;
    }

    .events-filters {
        display: flex;
        gap: 1rem;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #5f6368;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-input {
        padding: 0.75rem 1rem;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
    }

    .filter-input:focus {
        outline: none;
        border-color: #4285F4;
        box-shadow: 0 0 0 3px rgba(66, 133, 244, 0.1);
        background: rgba(255, 255, 255, 0.95);
    }

    .filter-btn {
        padding: 0.75rem 1.5rem;
        background: var(--primary-blue);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1.5rem;
    }

    .filter-btn:hover {
        background: #1a73e8;
        transform: translateY(-2px);
    }

    .events-grid {
        display: grid;
        gap: 1rem;
    }

    .event-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
        border-left: 4px solid var(--primary-blue);
    }

    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .event-card.priority-high {
        border-left-color: var(--primary-red);
    }

    .event-card.priority-medium {
        border-left-color: var(--primary-yellow);
    }

    .event-card.priority-low {
        border-left-color: var(--dark-gray);
    }

    .event-card.status-cancelled {
        opacity: 0.6;
        border-left-color: #bbb;
    }

    .event-card.status-completed {
        border-left-color: var(--primary-green);
    }

    .event-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
    }

    .event-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 0.4rem 0;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
    }

    .event-date-time {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        text-align: right;
    }

    .event-date {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--primary-blue);
        margin-bottom: 0.25rem;
    }

    .event-time {
        font-size: 0.8rem;
        color: #5f6368;
    }

    .event-description {
        color: #5f6368;
        line-height: 1.5;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
    }

    .event-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .event-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .priority-badge.high {
        background: rgba(234, 67, 53, 0.1);
        color: var(--primary-red);
    }

    .priority-badge.medium {
        background: rgba(251, 188, 4, 0.1);
        color: #856404;
    }

    .priority-badge.low {
        background: rgba(95, 99, 104, 0.1);
        color: var(--dark-gray);
    }

    .status-badge.active {
        background: rgba(52, 168, 83, 0.1);
        color: var(--primary-green);
    }

    .status-badge.cancelled {
        background: rgba(234, 67, 53, 0.1);
        color: var(--primary-red);
    }

    .status-badge.completed {
        background: rgba(66, 133, 244, 0.1);
        color: var(--primary-blue);
    }

    .event-location {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #5f6368;
        font-size: 0.9rem;
    }

    .event-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .btn-small {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-view {
        background: rgba(66, 133, 244, 0.1);
        color: var(--primary-blue);
    }

    .btn-view:hover {
        background: var(--primary-blue);
        color: white;
    }

    .btn-edit {
        background: rgba(251, 188, 4, 0.1);
        color: #856404;
    }

    .btn-edit:hover {
        background: var(--primary-yellow);
        color: #1a1a1a;
    }

    .btn-delete {
        background: rgba(234, 67, 53, 0.1);
        color: var(--primary-red);
    }

    .btn-delete:hover {
        background: var(--primary-red);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        color: #e0e0e0;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }

    .empty-description {
        color: #5f6368;
        margin-bottom: 2rem;
        font-size: 1.1rem;
    }

    .pagination-wrapper {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    /* Custom Pagination Styling */
    .pagination-wrapper nav {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .pagination-wrapper .flex {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination-wrapper .pagination {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .pagination-wrapper .page-link,
    .pagination-wrapper .relative {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .pagination-wrapper .relative.inline-flex.items-center {
        background: rgba(66, 133, 244, 0.1);
        color: var(--primary-blue);
        border-color: rgba(66, 133, 244, 0.2);
    }

    .pagination-wrapper .relative.inline-flex.items-center:hover {
        background: var(--primary-blue);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(66, 133, 244, 0.3);
    }

    .pagination-wrapper .relative.inline-flex.items-center.cursor-default {
        background: rgba(0, 0, 0, 0.05);
        color: #9ca3af;
        cursor: not-allowed;
        border-color: rgba(0, 0, 0, 0.1);
    }

    .pagination-wrapper .relative.inline-flex.items-center.cursor-default:hover {
        transform: none;
        box-shadow: none;
    }

    /* Current page styling */
    .pagination-wrapper span[aria-current="page"] {
        background: var(--primary-blue);
        color: white;
        border-color: var(--primary-blue);
    }

    /* Previous/Next button styling */
    .pagination-wrapper .relative.inline-flex.items-center.px-2 {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }

    /* Disabled state */
    .pagination-wrapper .relative.inline-flex.items-center[aria-disabled="true"] {
        background: rgba(0, 0, 0, 0.05);
        color: #9ca3af;
        cursor: not-allowed;
        border-color: rgba(0, 0, 0, 0.1);
    }

    .pagination-wrapper .relative.inline-flex.items-center[aria-disabled="true"]:hover {
        transform: none;
        box-shadow: none;
        background: rgba(0, 0, 0, 0.05);
        color: #9ca3af;
    }

    /* Page info text */
    .pagination-wrapper .text-sm.text-gray-700 {
        color: #5f6368;
        font-weight: 500;
        font-size: 0.85rem;
        padding: 0 1rem;
    }

    @media (max-width: 768px) {
        .events-container {
            padding: 0 1rem;
        }

        .events-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .events-title {
            font-size: 1.5rem;
        }

        .events-actions {
            flex-direction: column;
            width: 100%;
            gap: 0.75rem;
        }

        .add-event-btn,
        .view-calendar-btn {
            width: 100%;
            justify-content: center;
            padding: 1rem 1.5rem;
            font-size: 1rem;
        }

        .events-filters {
            flex-direction: column;
            align-items: stretch;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .filter-group {
            width: 100%;
            margin-bottom: 1rem;
        }

        .filter-input {
            font-size: 1rem;
            padding: 1rem;
            width: 100% !important;
            min-width: 0;
            max-width: 100%;
            box-sizing: border-box;
        }

        .filter-btn {
            margin-top: 0.5rem;
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
        }

        .events-grid {
            gap: 1rem;
        }

        .event-card {
            padding: 1rem;
            margin-bottom: 0;
            margin-left: 0;
            margin-right: 0;
        }

        .event-header {
            flex-direction: column;
            gap: 0.75rem;
            align-items: flex-start;
        }

        .event-title {
            font-size: 1.1rem;
            line-height: 1.4;
        }

        .event-date-time {
            align-items: flex-start;
            text-align: left;
            width: 100%;
        }

        .event-date {
            font-size: 0.95rem;
        }

        .event-time {
            font-size: 0.85rem;
        }

        .event-meta {
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .event-badge {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }

        .event-description {
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .event-location {
            font-size: 0.85rem;
            flex-wrap: wrap;
        }

        .event-actions {
            flex-direction: column;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .btn-small {
            width: 100%;
            text-align: center;
            padding: 0.75rem;
            font-size: 0.9rem;
            justify-content: center;
        }

        .empty-state {
            padding: 2rem 1rem;
            margin: 0;
        }

        .empty-icon {
            width: 60px;
            height: 60px;
        }

        .empty-title {
            font-size: 1.25rem;
        }

        .empty-description {
            font-size: 1rem;
        }

        /* Pagination mobile styles */
        .pagination-wrapper {
            margin-left: 0;
            margin-right: 0;
        }

        .pagination-wrapper nav {
            padding: 0.75rem;
            margin: 0;
        }

        .pagination-wrapper .flex {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .pagination-wrapper .relative {
            min-width: 2.25rem;
            height: 2.25rem;
            font-size: 0.9rem;
        }

        .pagination-wrapper .text-sm.text-gray-700 {
            order: -1;
            padding: 0;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        .events-container {
            padding: 0 0.5rem;
            max-width: 100%;
        }

        .events-header {
            padding: 0.75rem;
            margin-bottom: 1rem;
            margin-left: 0;
            margin-right: 0;
        }

        .events-title {
            font-size: 1.25rem;
        }

        .events-actions {
            gap: 0.5rem;
        }

        .add-event-btn,
        .view-calendar-btn {
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
        }

        .events-filters {
            padding: 0.75rem;
            margin-left: 0;
            margin-right: 0;
            margin-bottom: 1rem;
        }

        .filter-group {
            margin-bottom: 0.75rem;
        }

        .filter-input {
            padding: 0.875rem;
            font-size: 0.95rem;
        }

        .filter-btn {
            padding: 0.875rem;
            font-size: 0.95rem;
            margin-top: 0.5rem;
        }

        .events-grid {
            gap: 0.75rem;
        }

        .event-card {
            padding: 0.75rem;
            margin: 0;
        }

        .event-header {
            gap: 0.5rem;
        }

        .event-title {
            font-size: 1rem;
            line-height: 1.3;
        }

        .event-date {
            font-size: 0.9rem;
        }

        .event-time {
            font-size: 0.8rem;
        }

        .event-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.375rem;
            margin-bottom: 0.5rem;
        }

        .event-badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }

        .event-description {
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .event-location {
            font-size: 0.8rem;
        }

        .event-actions {
            gap: 0.375rem;
            margin-top: 0.75rem;
        }

        .btn-small {
            padding: 0.625rem;
            font-size: 0.85rem;
        }

        .empty-state {
            padding: 1.5rem 0.75rem;
        }

        .empty-icon {
            width: 50px;
            height: 50px;
        }

        .empty-title {
            font-size: 1.1rem;
        }

        .empty-description {
            font-size: 0.9rem;
        }

        .pagination-wrapper {
            margin: 1rem 0 0 0;
        }

        .pagination-wrapper nav {
            padding: 0.5rem;
            margin: 0;
        }

        .pagination-wrapper .relative {
            min-width: 2rem;
            height: 2rem;
            font-size: 0.85rem;
            padding: 0.375rem 0.5rem;
        }

        .pagination-wrapper .text-sm.text-gray-700 {
            font-size: 0.85rem;
        }
    }

    /* Extra small phones */
    @media (max-width: 360px) {
        .events-container {
            padding: 0 0.25rem;
        }

        .events-header,
        .events-filters {
            padding: 0.5rem;
        }

        .events-title {
            font-size: 1.1rem;
        }

        .add-event-btn,
        .view-calendar-btn {
            padding: 0.75rem;
            font-size: 0.9rem;
        }

        .event-card {
            padding: 0.5rem;
        }

        .event-title {
            font-size: 0.95rem;
        }

        .btn-small {
            padding: 0.5rem;
            font-size: 0.8rem;
        }
    }
</style>

<div class="events-container">
    <div class="events-header">
        <h1 class="events-title">Events Management</h1>
        <div class="events-actions">
            <a href="{{ route('calendar.index') }}" class="view-calendar-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 0.5rem;">
                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                </svg>
                View Calendar
            </a>
            <a href="{{ route('events.create') }}" class="add-event-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
                Add New Event
            </a>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('events.index') }}" class="events-filters">
        <div class="filter-group">
            <label class="filter-label">Search Events</label>
            <input type="text" name="search" value="{{ $search }}" placeholder="Search by title, description, or location..."
                   class="filter-input" style="min-width: 300px;">
        </div>

        <div class="filter-group">
            <label class="filter-label">Status</label>
            <select name="status" class="filter-input" style="min-width: 150px;">
                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="filter-group">
            <button type="submit" class="filter-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 0.5rem;">
                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                </svg>
                Filter
            </button>
        </div>
    </form>

    <!-- Events List -->
    @if($events->count() > 0)
        <div class="events-grid">
            @foreach($events as $event)
                <div class="event-card priority-{{ $event->priority }} status-{{ $event->status }}">
                    <div class="event-header">
                        <div>
                            <h3 class="event-title">{{ $event->title }}</h3>
                            <div class="event-meta">
                                <span class="event-badge priority-badge {{ $event->priority }}">{{ ucfirst($event->priority) }} Priority</span>
                                <span class="event-badge status-badge {{ $event->status }}">{{ ucfirst($event->status) }}</span>
                            </div>
                        </div>
                        <div class="event-date-time">
                            <div class="event-date">
                                @if($event->start_date->eq($event->end_date))
                                    {{ $event->formatted_start_date }}
                                @else
                                    {{ $event->formatted_start_date }} - {{ $event->formatted_end_date }}
                                @endif
                            </div>
                            <div class="event-time">{{ $event->formatted_time_range }}</div>
                        </div>
                    </div>

                    @if($event->description)
                        <p class="event-description">{{ Str::limit($event->description, 150) }}</p>
                    @endif

                    @if($event->location)
                        <div class="event-location">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                            {{ $event->location }}
                        </div>
                    @endif

                    <div class="event-actions">
                        <a href="{{ route('events.show', $event) }}" class="btn-small btn-view">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 0.25rem;">
                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                            </svg>
                            View
                        </a>
                        <a href="{{ route('events.edit', $event) }}" class="btn-small btn-edit">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 0.25rem;">
                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                            </svg>
                            Edit
                        </a>
                        <form method="POST" action="{{ route('events.destroy', $event) }}" style="display: inline;"
                              onsubmit="return confirm('Are you sure you want to delete this event?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-small btn-delete">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 0.25rem;">
                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $events->withQueryString()->links() }}
        </div>
    @else
        <div class="empty-state">
            <svg class="empty-icon" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
            </svg>
            <h2 class="empty-title">No Events Found</h2>
            <p class="empty-description">
                @if($search || $status !== 'all')
                    No events match your current filters. Try adjusting your search criteria.
                @else
                    You haven't created any events yet. Start by adding your first event!
                @endif
            </p>
            <a href="{{ route('events.create') }}" class="add-event-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
                Add Your First Event
            </a>
        </div>
    @endif
</div>

@if(session('success'))
    <script>
        // Simple success notification
        setTimeout(() => {
            const notification = document.createElement('div');
            notification.innerHTML = '{{ session("success") }}';
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: var(--primary-green);
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                z-index: 10000;
                font-weight: 600;
                animation: slideIn 0.3s ease;
            `;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }, 100);

        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
    </script>
@endif
@endsection