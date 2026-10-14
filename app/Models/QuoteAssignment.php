<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteAssignment extends Model
{
    protected $fillable = [
       'quote_id',
        'team_id',
        'assigned_at',
        'status',
    ];

     protected $casts = [
        'assigned_at' => 'datetime',
    ];


    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function schedules()
    {
        return $this->hasMany(RouteSchedule::class, 'assignment_id');
    }

    public function latestSchedule()
    {
        return $this->hasOne(RouteSchedule::class, 'assignment_id')
                    ->latestOfMany('service_date');
    }
}