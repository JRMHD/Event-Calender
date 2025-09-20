<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'all_day',
        'color',
        'status',
        'priority',
        'location',
        'user_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'all_day' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedStartDateAttribute(): string
    {
        return $this->start_date->format('M d, Y');
    }

    public function getFormattedEndDateAttribute(): string
    {
        return $this->end_date->format('M d, Y');
    }

    public function getFormattedTimeRangeAttribute(): ?string
    {
        if ($this->all_day) {
            return 'All Day';
        }

        if ($this->start_time && $this->end_time) {
            return Carbon::parse($this->start_time)->format('g:i A') . ' - ' . Carbon::parse($this->end_time)->format('g:i A');
        }

        return null;
    }

    public function getDurationInDaysAttribute(): int
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    public function scopeForMonth($query, $year, $month)
    {
        return $query->where(function ($q) use ($year, $month) {
            $q->whereYear('start_date', $year)->whereMonth('start_date', $month)
              ->orWhere(function ($q2) use ($year, $month) {
                  $q2->whereYear('end_date', $year)->whereMonth('end_date', $month);
              })
              ->orWhere(function ($q3) use ($year, $month) {
                  $firstDay = Carbon::create($year, $month, 1);
                  $lastDay = $firstDay->copy()->endOfMonth();
                  $q3->where('start_date', '<=', $firstDay)
                     ->where('end_date', '>=', $lastDay);
              });
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
