<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteSchedule extends Model
{
   protected $fillable = [
    'assignment_id',
    'service_date',
    'stop_order',
    'route_type',
    'status',
    'before_photo',
    'started_at',
    'proof_photo',
    'completed_at',
];

protected $casts = [
    'service_date' => 'date',
    'started_at'   => 'datetime',
    'completed_at' => 'datetime',
    'before_photo' => 'array',   // JSON <-> PHP array automatically
    'proof_photo'  => 'array',   // JSON <-> PHP array automatically
];

    public function assignment()
    {
        return $this->belongsTo(QuoteAssignment::class, 'assignment_id');
    }
}