@extends('layouts.app')

@section('title', 'Create Event - Unity Group Calendar')
@section('page-title', 'Create New Event')

@section('content')
<style>
    .create-event-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .create-event-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 100%);
        backdrop-filter: blur(20px);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .form-header {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .form-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }

    .form-subtitle {
        color: #5f6368;
        font-size: 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }

    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
    }

    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: #4285F4;
        box-shadow: 0 0 0 3px rgba(66, 133, 244, 0.1);
        background: rgba(255, 255, 255, 0.95);
    }

    .form-input:hover, .form-select:hover, .form-textarea:hover {
        border-color: rgba(66, 133, 244, 0.3);
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .checkbox-input {
        width: 18px;
        height: 18px;
        accent-color: #4285F4;
    }

    .checkbox-label {
        font-size: 0.9rem;
        font-weight: 500;
        color: #1a1a1a;
        cursor: pointer;
    }

    .color-input {
        width: 100%;
        height: 50px;
        padding: 0.5rem;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .color-input:hover {
        border-color: rgba(66, 133, 244, 0.3);
    }

    .error-message {
        color: #EA4335;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        font-weight: 500;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
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

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-green) 0%, #2d7a3f 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(52, 168, 83, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(52, 168, 83, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background: transparent;
        color: #5f6368;
        border: 2px solid #5f6368;
    }

    .btn-secondary:hover {
        background: #5f6368;
        color: white;
        text-decoration: none;
    }

    .time-fields {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    @media (max-width: 768px) {
        .form-row, .time-fields {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }

        .create-event-card {
            padding: 1.5rem;
            margin: 1rem;
        }
    }
</style>

<div class="create-event-container">
    <div class="create-event-card">
        <div class="form-header">
            <h1 class="form-title">Create New Event</h1>
            <p class="form-subtitle">Add a new event to your calendar</p>
        </div>

        <form method="POST" action="{{ route('events.store') }}" id="createEventForm">
            @csrf

            <!-- Event Title -->
            <div class="form-group">
                <label for="title" class="form-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: inline; margin-right: 0.5rem;">
                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                    </svg>
                    Event Title *
                </label>
                <input type="text" id="title" name="title" class="form-input"
                       value="{{ old('title') }}" required
                       placeholder="Enter event title...">
                @error('title')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Event Description -->
            <div class="form-group">
                <label for="description" class="form-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: inline; margin-right: 0.5rem;">
                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                    </svg>
                    Description
                </label>
                <textarea id="description" name="description" class="form-textarea"
                          placeholder="Describe your event...">{{ old('description') }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Date Range -->
            <div class="form-row">
                <div class="form-group">
                    <label for="start_date" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: inline; margin-right: 0.5rem;">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                        </svg>
                        Start Date *
                    </label>
                    <input type="date" id="start_date" name="start_date" class="form-input"
                           value="{{ old('start_date', $date ?? '') }}" required>
                    @error('start_date')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="end_date" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: inline; margin-right: 0.5rem;">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                        </svg>
                        End Date *
                    </label>
                    <input type="date" id="end_date" name="end_date" class="form-input"
                           value="{{ old('end_date', $date ?? '') }}" required>
                    @error('end_date')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- All Day Toggle -->
            <div class="checkbox-group">
                <input type="checkbox" id="all_day" name="all_day" class="checkbox-input"
                       {{ old('all_day') ? 'checked' : '' }} onchange="toggleTimeFields()">
                <label for="all_day" class="checkbox-label">All Day Event</label>
            </div>

            <!-- Time Fields -->
            <div id="timeFields" class="time-fields" style="{{ old('all_day') ? 'display: none;' : '' }}">
                <div class="form-group">
                    <label for="start_time" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: inline; margin-right: 0.5rem;">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        Start Time
                    </label>
                    <input type="time" id="start_time" name="start_time" class="form-input"
                           value="{{ old('start_time') }}">
                    @error('start_time')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="end_time" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: inline; margin-right: 0.5rem;">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        End Time
                    </label>
                    <input type="time" id="end_time" name="end_time" class="form-input"
                           value="{{ old('end_time') }}">
                    @error('end_time')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Event Settings -->
            <div class="form-row">
                <div class="form-group">
                    <label for="color" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: inline; margin-right: 0.5rem;">
                            <path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9c.83 0 1.5-.67 1.5-1.5 0-.39-.15-.74-.39-1.01-.23-.26-.38-.61-.38-.99 0-.83.67-1.5 1.5-1.5H16c2.76 0 5-2.24 5-5 0-4.42-4.03-8-9-8z"/>
                        </svg>
                        Event Color *
                    </label>
                    <input type="color" id="color" name="color" class="color-input"
                           value="{{ old('color', '#4285F4') }}" required>
                    @error('color')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="priority" class="form-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: inline; margin-right: 0.5rem;">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        Priority *
                    </label>
                    <select id="priority" name="priority" class="form-select" required>
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low Priority</option>
                        <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium Priority</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High Priority</option>
                    </select>
                    @error('priority')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Location -->
            <div class="form-group">
                <label for="location" class="form-label">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: inline; margin-right: 0.5rem;">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    Location
                </label>
                <input type="text" id="location" name="location" class="form-input"
                       value="{{ old('location') }}"
                       placeholder="Where will this event take place?">
                @error('location')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('events.index') }}" class="btn-action btn-secondary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                    </svg>
                    Cancel
                </a>

                <button type="submit" class="btn-action btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    Create Event
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleTimeFields() {
    const allDay = document.getElementById('all_day').checked;
    const timeFields = document.getElementById('timeFields');

    if (allDay) {
        timeFields.style.display = 'none';
        document.getElementById('start_time').value = '';
        document.getElementById('end_time').value = '';
    } else {
        timeFields.style.display = 'grid';
    }
}

// Auto-set end date when start date changes
document.getElementById('start_date').addEventListener('change', function() {
    const endDate = document.getElementById('end_date');
    if (!endDate.value || endDate.value < this.value) {
        endDate.value = this.value;
    }
});

// Form validation
document.getElementById('createEventForm').addEventListener('submit', function(e) {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const startTime = document.getElementById('start_time').value;
    const endTime = document.getElementById('end_time').value;
    const allDay = document.getElementById('all_day').checked;

    if (endDate < startDate) {
        e.preventDefault();
        alert('End date cannot be before start date.');
        return false;
    }

    if (!allDay && startTime && endTime && startDate === endDate && endTime <= startTime) {
        e.preventDefault();
        alert('End time must be after start time for same-day events.');
        return false;
    }
});
</script>
@endsection