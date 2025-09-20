@extends('layouts.app')

@section('title', 'Edit Event - Unity Group Calendar')
@section('page-title', 'Edit Event')

@section('content')
<style>
    .edit-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .edit-header {
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

    .edit-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }

    .edit-subtitle {
        color: #5f6368;
        font-size: 0.95rem;
        margin-top: 0.25rem;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: rgba(255, 255, 255, 0.9);
        color: #5f6368;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        background: rgba(255, 255, 255, 1);
        color: #1a1a1a;
        border-color: rgba(0, 0, 0, 0.2);
        text-decoration: none;
        transform: translateY(-2px);
    }

    .edit-form {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-input {
        padding: 0.875rem 1rem;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
    }

    .form-input:focus {
        outline: none;
        border-color: #4285F4;
        box-shadow: 0 0 0 3px rgba(66, 133, 244, 0.1);
        background: rgba(255, 255, 255, 0.95);
    }

    .form-textarea {
        min-height: 100px;
        resize: vertical;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 0;
    }

    .checkbox-input {
        width: 1.25rem;
        height: 1.25rem;
        accent-color: #4285F4;
    }

    .checkbox-label {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1a1a1a;
        margin: 0;
        text-transform: none;
        letter-spacing: normal;
    }

    .color-picker-group {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .color-picker {
        width: 3rem;
        height: 3rem;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        cursor: pointer;
        background: none;
        padding: 0;
    }

    .color-text {
        flex: 1;
        font-family: 'Courier New', monospace;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .time-fields {
        grid-column: 1 / -1;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 1rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        margin-top: 1rem;
    }

    .cancel-btn {
        padding: 0.75rem 1.5rem;
        color: #5f6368;
        background: transparent;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .cancel-btn:hover {
        color: #1a1a1a;
        background: rgba(0, 0, 0, 0.05);
    }

    .submit-btn {
        padding: 0.75rem 2rem;
        background: linear-gradient(135deg, var(--primary-blue) 0%, #1a73e8 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(66, 133, 244, 0.3);
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(66, 133, 244, 0.4);
    }

    .error-alert {
        background: rgba(234, 67, 53, 0.1);
        border: 1px solid rgba(234, 67, 53, 0.2);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .error-icon {
        color: var(--primary-red);
        width: 1.25rem;
        height: 1.25rem;
        flex-shrink: 0;
    }

    .error-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--primary-red);
        margin-bottom: 0.5rem;
    }

    .error-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .error-item {
        color: var(--primary-red);
        font-size: 0.9rem;
        padding: 0.25rem 0;
        padding-left: 1.5rem;
        position: relative;
    }

    .error-item::before {
        content: "•";
        position: absolute;
        left: 0;
        color: var(--primary-red);
        font-weight: bold;
    }

    @media (max-width: 768px) {
        .edit-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .time-fields {
            grid-template-columns: 1fr;
        }

        .color-picker-group {
            flex-direction: column;
            align-items: stretch;
        }

        .form-actions {
            flex-direction: column-reverse;
            gap: 0.75rem;
        }

        .cancel-btn,
        .submit-btn {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="edit-container">
    <div class="edit-header">
        <div>
            <h1 class="edit-title">Edit Event</h1>
            <p class="edit-subtitle">Update your event details</p>
        </div>
        <a href="{{ route('events.index') }}" class="back-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.42-1.41L7.83 13H20v-2z"/>
            </svg>
            Back to Events
        </a>
    </div>

    @if ($errors->any())
        <div class="error-alert">
            <div class="flex items-start gap-1rem">
                <svg class="error-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                <div>
                    <h3 class="error-title">Please correct the following errors:</h3>
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                            <li class="error-item">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('events.update', $event) }}" class="edit-form">
        @csrf
        @method('PATCH')

        <div class="form-grid">
            <!-- Event Title -->
            <div class="form-group full-width">
                <label for="title" class="form-label">Event Title</label>
                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title', $event->title) }}"
                       class="form-input"
                       placeholder="Enter event title"
                       required>
            </div>

            <!-- Start Date -->
            <div class="form-group">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date"
                       id="start_date"
                       name="start_date"
                       value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}"
                       class="form-input"
                       required>
            </div>

            <!-- End Date -->
            <div class="form-group">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date"
                       id="end_date"
                       name="end_date"
                       value="{{ old('end_date', $event->end_date->format('Y-m-d')) }}"
                       class="form-input"
                       required>
            </div>

            <!-- All Day Toggle -->
            <div class="form-group full-width">
                <div class="checkbox-group">
                    <input type="checkbox"
                           id="all_day"
                           name="all_day"
                           value="1"
                           {{ old('all_day', $event->all_day) ? 'checked' : '' }}
                           class="checkbox-input">
                    <label for="all_day" class="checkbox-label">All Day Event</label>
                </div>
            </div>

            <!-- Time Fields -->
            <div id="time-fields" class="time-fields" style="{{ old('all_day', $event->all_day) ? 'display: none;' : '' }}">
                <!-- Start Time -->
                <div class="form-group">
                    <label for="start_time" class="form-label">Start Time</label>
                    <input type="time"
                           id="start_time"
                           name="start_time"
                           value="{{ old('start_time', $event->start_time ? $event->start_time->format('H:i') : '') }}"
                           class="form-input">
                </div>

                <!-- End Time -->
                <div class="form-group">
                    <label for="end_time" class="form-label">End Time</label>
                    <input type="time"
                           id="end_time"
                           name="end_time"
                           value="{{ old('end_time', $event->end_time ? $event->end_time->format('H:i') : '') }}"
                           class="form-input">
                </div>
            </div>

            <!-- Event Color -->
            <div class="form-group">
                <label for="color" class="form-label">Event Color</label>
                <div class="color-picker-group">
                    <input type="color"
                           id="color"
                           name="color"
                           value="{{ old('color', $event->color) }}"
                           class="color-picker">
                    <input type="text"
                           id="color_text"
                           value="{{ old('color', $event->color) }}"
                           readonly
                           class="form-input color-text">
                </div>
            </div>

            <!-- Priority -->
            <div class="form-group">
                <label for="priority" class="form-label">Priority</label>
                <select id="priority"
                        name="priority"
                        class="form-input"
                        required>
                    <option value="low" {{ old('priority', $event->priority) == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority', $event->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ old('priority', $event->priority) == 'high' ? 'selected' : '' }}>High</option>
                </select>
            </div>

            <!-- Status -->
            <div class="form-group full-width">
                <label for="status" class="form-label">Status</label>
                <select id="status"
                        name="status"
                        class="form-input"
                        required>
                    <option value="active" {{ old('status', $event->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <!-- Location -->
            <div class="form-group full-width">
                <label for="location" class="form-label">Location</label>
                <input type="text"
                       id="location"
                       name="location"
                       value="{{ old('location', $event->location) }}"
                       class="form-input"
                       placeholder="Enter event location">
            </div>

            <!-- Description -->
            <div class="form-group full-width">
                <label for="description" class="form-label">Description</label>
                <textarea id="description"
                          name="description"
                          rows="4"
                          class="form-input form-textarea"
                          placeholder="Enter event description (optional)">{{ old('description', $event->description) }}</textarea>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <a href="{{ route('events.show', $event) }}" class="cancel-btn">
                Cancel
            </a>
            <button type="submit" class="submit-btn">
                Update Event
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const allDayCheckbox = document.getElementById('all_day');
    const timeFields = document.getElementById('time-fields');
    const colorInput = document.getElementById('color');
    const colorText = document.getElementById('color_text');

    // Toggle time fields based on all-day checkbox
    allDayCheckbox.addEventListener('change', function() {
        if (this.checked) {
            timeFields.style.display = 'none';
            document.getElementById('start_time').value = '';
            document.getElementById('end_time').value = '';
        } else {
            timeFields.style.display = 'grid';
        }
    });

    // Sync color picker with text input
    colorInput.addEventListener('input', function() {
        colorText.value = this.value.toUpperCase();
    });

    // Validate end date is after start date
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    function validateDates() {
        if (startDate.value && endDate.value) {
            if (new Date(endDate.value) < new Date(startDate.value)) {
                endDate.setCustomValidity('End date must be after start date');
            } else {
                endDate.setCustomValidity('');
            }
        }
    }

    startDate.addEventListener('change', validateDates);
    endDate.addEventListener('change', validateDates);

    // Validate end time is after start time (if same date)
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');

    function validateTimes() {
        if (startTime.value && endTime.value && startDate.value === endDate.value) {
            if (endTime.value <= startTime.value) {
                endTime.setCustomValidity('End time must be after start time');
            } else {
                endTime.setCustomValidity('');
            }
        } else {
            endTime.setCustomValidity('');
        }
    }

    startTime.addEventListener('change', validateTimes);
    endTime.addEventListener('change', validateTimes);
});
</script>
@endsection