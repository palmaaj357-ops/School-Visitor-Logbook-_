<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'name',
        'purpose',
        'time_in',
        'time_out',
    ];

    protected $casts = [
        'time_in' => 'datetime',
        'time_out' => 'datetime',
    ];

    /**
     * Get the visitor's status (In or Out).
     */
    public function getStatusAttribute(): string
    {
        return is_null($this->time_out) ? 'In' : 'Out';
    }

    /**
     * Get the formatted visit date.
     */
    public function getVisitDateAttribute(): string
    {
        return $this->time_in->format('M d, Y');
    }
}
