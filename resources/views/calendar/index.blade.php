@extends('layouts.app')

@section('title', 'Calendar - Unity Group Calendar')
@section('page-title', 'Calendar')

@section('content')
<style>
    .calendar-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 1.5rem 2rem;
        background: linear-gradient(135deg, rgba(66, 133, 244, 0.1) 0%, rgba(52, 168, 83, 0.1) 100%);
        border-radius: 16px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .calendar-nav {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .nav-btn {
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        color: var(--primary-blue);
    }

    .nav-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(66, 133, 244, 0.3);
        background: rgba(255, 255, 255, 1);
    }

    .current-month {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 2rem;
        min-width: 200px;
        text-align: center;
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

    .calendar-grid {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .calendar-weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        background: linear-gradient(135deg, var(--primary-blue) 0%, #1a73e8 100%);
        color: white;
    }

    .weekday {
        padding: 1rem;
        text-align: center;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .calendar-day {
        min-height: 100px;
        max-height: 140px;
        padding: 0.5rem;
        border-right: 1px solid rgba(0, 0, 0, 0.1);
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.5);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .calendar-day:hover {
        background: rgba(66, 133, 244, 0.1);
    }

    .calendar-day.other-month {
        color: #bbb;
        background: rgba(240, 240, 240, 0.3);
    }

    .calendar-day.today {
        background: linear-gradient(135deg, rgba(251, 188, 4, 0.2) 0%, rgba(251, 188, 4, 0.1) 100%);
        border: 2px solid var(--primary-yellow);
    }

    .calendar-day.today .day-number {
        color: #856404;
        font-weight: 700;
    }

    .calendar-day.has-events {
        background: linear-gradient(135deg, rgba(52, 168, 83, 0.1) 0%, rgba(52, 168, 83, 0.05) 100%);
    }

    .day-number {
        font-size: 1rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 0.25rem;
        flex-shrink: 0;
    }

    .calendar-day.other-month .day-number {
        color: #bbb;
    }

    .day-events {
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
        flex: 1;
        overflow: hidden;
    }

    .event-item {
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        font-size: 0.65rem;
        font-weight: 500;
        color: white;
        background: var(--primary-blue);
        border-left: 2px solid rgba(255, 255, 255, 0.3);
        cursor: pointer;
        transition: all 0.2s ease;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        line-height: 1.2;
        flex-shrink: 0;
    }

    .event-item:hover {
        transform: scale(1.02);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .event-item.priority-high {
        background: var(--primary-red);
    }

    .event-item.priority-medium {
        background: var(--primary-yellow);
        color: #1a1a1a;
    }

    .event-item.priority-low {
        background: var(--dark-gray);
    }

    .month-nav-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .quick-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .view-events-btn {
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

    .view-events-btn:hover {
        background: var(--primary-blue);
        color: white;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .calendar-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .calendar-nav {
            order: 2;
        }

        .quick-actions {
            order: 3;
            flex-direction: column;
            width: 100%;
        }

        .add-event-btn,
        .view-events-btn {
            width: 100%;
            text-align: center;
            justify-content: center;
        }

        .current-month {
            margin: 0;
            font-size: 1.5rem;
        }

        .calendar-day {
            min-height: 80px;
            padding: 0.5rem;
        }

        .day-number {
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .event-item {
            font-size: 0.7rem;
            padding: 0.2rem 0.4rem;
        }

        .weekday {
            padding: 0.75rem 0.5rem;
            font-size: 0.8rem;
        }
    }
</style>

<div class="calendar-container">
    <div class="calendar-header">
        <div class="calendar-nav">
            <div class="month-nav-buttons">
                <a href="{{ route('calendar.index', ['year' => $date->copy()->subMonth()->year, 'month' => $date->copy()->subMonth()->month]) }}"
                   class="nav-btn" title="Previous Month">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
                    </svg>
                </a>
                <a href="{{ route('calendar.index', ['year' => now()->year, 'month' => now()->month]) }}"
                   class="nav-btn" title="Today">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
                    </svg>
                </a>
                <a href="{{ route('calendar.index', ['year' => $date->copy()->addMonth()->year, 'month' => $date->copy()->addMonth()->month]) }}"
                   class="nav-btn" title="Next Month">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
                    </svg>
                </a>
            </div>
        </div>

        <h1 class="current-month">{{ $date->format('F Y') }}</h1>

        <div class="quick-actions">
            <a href="{{ route('events.index') }}" class="view-events-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 0.5rem;">
                    <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.1 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
                </svg>
                View All Events
            </a>
            <button onclick="openEventModal()" class="add-event-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
                Add Event
            </button>
        </div>
    </div>

    <div class="calendar-grid">
        <div class="calendar-weekdays">
            <div class="weekday">Sun</div>
            <div class="weekday">Mon</div>
            <div class="weekday">Tue</div>
            <div class="weekday">Wed</div>
            <div class="weekday">Thu</div>
            <div class="weekday">Fri</div>
            <div class="weekday">Sat</div>
        </div>

        <div class="calendar-days">
            @php
                $startOfCalendar = $date->copy()->startOfMonth()->startOfWeek();
                $endOfCalendar = $date->copy()->endOfMonth()->endOfWeek();
                $currentDate = $startOfCalendar->copy();
            @endphp

            @while($currentDate <= $endOfCalendar)
                @php
                    $isCurrentMonth = $currentDate->month === $date->month;
                    $isToday = $currentDate->isToday();
                    $dateString = $currentDate->format('Y-m-d');
                    $dayEvents = $eventsByDate->get($dateString, collect());
                    $hasEvents = $dayEvents->count() > 0;
                @endphp

                <div class="calendar-day
                    {{ !$isCurrentMonth ? 'other-month' : '' }}
                    {{ $isToday ? 'today' : '' }}
                    {{ $hasEvents ? 'has-events' : '' }}"
                    onclick="{{ $hasEvents ? 'showDayEvents' : 'openEventModal' }}('{{ $dateString }}', {{ $hasEvents ? json_encode($dayEvents->values()) : 'null' }})">

                    <div class="day-number">{{ $currentDate->day }}</div>

                    @if($hasEvents)
                        <div class="day-events">
                            @foreach($dayEvents->take(4) as $event)
                                <div class="event-item priority-{{ $event->priority }}"
                                     style="background-color: {{ $event->color }}"
                                     title="{{ $event->title }} - {{ $event->formatted_time_range ?? 'All Day' }}"
                                     onclick="event.stopPropagation(); showEventDetails({{ $event->id }})">
                                    {{ Str::limit($event->title, 20) }}
                                </div>
                            @endforeach

                            @if($dayEvents->count() > 4)
                                <div class="event-item" style="background: #666; font-size: 0.6rem; padding: 0.1rem 0.4rem;">
                                    +{{ $dayEvents->count() - 4 }} more
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                @php $currentDate->addDay(); @endphp
            @endwhile
        </div>
    </div>
</div>

<!-- Day Events Modal -->
<div id="dayEventsModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h2 class="modal-title" id="dayEventsTitle">Events for Today</h2>
            <button onclick="closeDayEventsModal()" class="modal-close-btn" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>

        <div id="dayEventsList" class="day-events-list">
            <!-- Events will be populated by JavaScript -->
        </div>

        <div class="modal-footer" style="display: flex; gap: 1rem; justify-content: space-between; margin-top: 2rem; padding-top: 1rem; border-top: 1px solid rgba(0,0,0,0.1);">
            <button onclick="closeDayEventsModal()" class="btn-cancel">Close</button>
            <button onclick="closeDayEventsModal(); openEventModal(currentSelectedDate);" class="btn-primary">Add New Event</button>
        </div>
    </div>
</div>

<!-- Event Modal -->
<div id="eventModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h2 class="modal-title">Add New Event</h2>
            <button onclick="closeEventModal()" class="modal-close-btn" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>

        <form id="eventForm" onsubmit="submitEvent(event)">
            @csrf
            <input type="hidden" id="eventDate" name="start_date">

            <div class="form-group" style="margin-bottom: 1rem;">
                <label for="eventTitle" class="form-label">Event Title</label>
                <input type="text" id="eventTitle" name="title" class="form-input" required
                       style="width: 100%; padding: 0.75rem; border: 2px solid #e0e0e0; border-radius: 8px;">
            </div>

            <div class="form-group" style="margin-bottom: 1rem;">
                <label for="eventDescription" class="form-label">Description</label>
                <textarea id="eventDescription" name="description" class="form-input" rows="3"
                         style="width: 100%; padding: 0.75rem; border: 2px solid #e0e0e0; border-radius: 8px; resize: vertical;"></textarea>
            </div>

            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group">
                    <label for="eventStartDate" class="form-label">Start Date</label>
                    <input type="date" id="eventStartDate" name="start_date" class="form-input" required
                           style="width: 100%; padding: 0.75rem; border: 2px solid #e0e0e0; border-radius: 8px;">
                </div>

                <div class="form-group">
                    <label for="eventEndDate" class="form-label">End Date</label>
                    <input type="date" id="eventEndDate" name="end_date" class="form-input" required
                           style="width: 100%; padding: 0.75rem; border: 2px solid #e0e0e0; border-radius: 8px;">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label">
                    <input type="checkbox" id="allDayEvent" name="all_day" onchange="toggleTimeFields()"> All Day Event
                </label>
            </div>

            <div id="timeFields" class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group">
                    <label for="eventStartTime" class="form-label">Start Time</label>
                    <input type="time" id="eventStartTime" name="start_time" class="form-input"
                           style="width: 100%; padding: 0.75rem; border: 2px solid #e0e0e0; border-radius: 8px;">
                </div>

                <div class="form-group">
                    <label for="eventEndTime" class="form-label">End Time</label>
                    <input type="time" id="eventEndTime" name="end_time" class="form-input"
                           style="width: 100%; padding: 0.75rem; border: 2px solid #e0e0e0; border-radius: 8px;">
                </div>
            </div>

            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group">
                    <label for="eventColor" class="form-label">Color</label>
                    <input type="color" id="eventColor" name="color" value="#4285F4" class="form-input"
                           style="width: 100%; height: 45px; padding: 0.25rem; border: 2px solid #e0e0e0; border-radius: 8px;">
                </div>

                <div class="form-group">
                    <label for="eventPriority" class="form-label">Priority</label>
                    <select id="eventPriority" name="priority" class="form-input"
                            style="width: 100%; padding: 0.75rem; border: 2px solid #e0e0e0; border-radius: 8px;">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="eventLocation" class="form-label">Location</label>
                    <input type="text" id="eventLocation" name="location" class="form-input"
                           style="width: 100%; padding: 0.75rem; border: 2px solid #e0e0e0; border-radius: 8px;">
                </div>
            </div>

            <div class="modal-buttons" style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                <button type="button" onclick="closeEventModal()" class="btn-cancel">Cancel</button>
                <button type="submit" class="btn-primary">Create Event</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEventModal(date = null) {
    const modal = document.getElementById('eventModal');
    const form = document.getElementById('eventForm');

    // Reset form
    form.reset();

    // Set date
    const selectedDate = date || '{{ now()->format("Y-m-d") }}';
    document.getElementById('eventDate').value = selectedDate;
    document.getElementById('eventStartDate').value = selectedDate;
    document.getElementById('eventEndDate').value = selectedDate;

    modal.style.display = 'flex';
    document.getElementById('eventTitle').focus();
}

function showDayEvents(date, events) {
    currentSelectedDate = date;
    const modal = document.getElementById('dayEventsModal');
    const eventsList = document.getElementById('dayEventsList');
    const dayTitle = document.getElementById('dayEventsTitle');

    // Format date for display
    const dateObj = new Date(date);
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    dayTitle.textContent = dateObj.toLocaleDateString('en-US', options);

    // Clear previous events
    eventsList.innerHTML = '';

    // Add events to list
    if (events && events.length > 0) {
        events.forEach(event => {
            const eventDiv = document.createElement('div');
            eventDiv.className = 'day-event-detail';
            eventDiv.innerHTML = `
                <div class="event-detail-header">
                    <div class="event-detail-color" style="background-color: ${event.color}"></div>
                    <h4 class="event-detail-title">${event.title}</h4>
                    <span class="event-detail-priority priority-${event.priority}">${event.priority.charAt(0).toUpperCase() + event.priority.slice(1)}</span>
                </div>
                <div class="event-detail-time">${event.formatted_time_range || 'All Day'}</div>
                ${event.description ? `<div class="event-detail-description">${event.description}</div>` : ''}
                ${event.location ? `<div class="event-detail-location">📍 ${event.location}</div>` : ''}
                <div class="event-detail-actions">
                    <a href="/events/${event.id}" class="btn-detail-view">View</a>
                    <a href="/events/${event.id}/edit" class="btn-detail-edit">Edit</a>
                </div>
            `;
            eventsList.appendChild(eventDiv);
        });
    }

    modal.style.display = 'flex';
}

function showEventDetails(eventId) {
    window.location.href = `/events/${eventId}`;
}

let currentSelectedDate = null;

function closeDayEventsModal() {
    document.getElementById('dayEventsModal').style.display = 'none';
}

function closeEventModal() {
    document.getElementById('eventModal').style.display = 'none';
}

function toggleTimeFields() {
    const allDay = document.getElementById('allDayEvent').checked;
    const timeFields = document.getElementById('timeFields');

    if (allDay) {
        timeFields.style.display = 'none';
        document.getElementById('eventStartTime').value = '';
        document.getElementById('eventEndTime').value = '';
    } else {
        timeFields.style.display = 'grid';
    }
}

function submitEvent(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());

    // Add CSRF token
    data._token = '{{ csrf_token() }}';

    fetch('{{ route("events.store.ajax") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.message) {
            closeEventModal();
            // Reload page to show new event
            window.location.reload();
        } else if (result.errors) {
            // Handle validation errors
            alert('Please check your input and try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}

// Close modal when clicking outside
document.getElementById('eventModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEventModal();
    }
});

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEventModal();
    }
});
</script>

<style>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.modal-content {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    padding: 2rem;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.btn-cancel {
    padding: 0.75rem 1.5rem;
    background: transparent;
    color: #5f6368;
    border: 2px solid #5f6368;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: #5f6368;
    color: white;
}

.btn-primary {
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, var(--primary-green) 0%, #2d7a3f 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(52, 168, 83, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(52, 168, 83, 0.4);
}

.day-events-list {
    max-height: 400px;
    overflow-y: auto;
}

.day-event-detail {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
    border-left: 4px solid var(--primary-blue);
    transition: all 0.3s ease;
}

.day-event-detail:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.event-detail-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.5rem;
}

.event-detail-color {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
}

.event-detail-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1a1a1a;
    margin: 0;
    flex: 1;
}

.event-detail-priority {
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
}

.event-detail-priority.priority-high {
    background: rgba(234, 67, 53, 0.1);
    color: var(--primary-red);
}

.event-detail-priority.priority-medium {
    background: rgba(251, 188, 4, 0.1);
    color: #856404;
}

.event-detail-priority.priority-low {
    background: rgba(95, 99, 104, 0.1);
    color: var(--dark-gray);
}

.event-detail-time {
    font-size: 0.9rem;
    color: var(--primary-blue);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.event-detail-description {
    color: #5f6368;
    line-height: 1.5;
    margin-bottom: 0.5rem;
}

.event-detail-location {
    color: #5f6368;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.event-detail-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-detail-view, .btn-detail-edit {
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-detail-view {
    background: rgba(66, 133, 244, 0.1);
    color: var(--primary-blue);
}

.btn-detail-view:hover {
    background: var(--primary-blue);
    color: white;
}

.btn-detail-edit {
    background: rgba(251, 188, 4, 0.1);
    color: #856404;
}

.btn-detail-edit:hover {
    background: var(--primary-yellow);
    color: #1a1a1a;
}
</style>
@endsection