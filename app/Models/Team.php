<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'team_lead',
        'email',
        'phone',
         'password',
        'status'
    ];

    public function assignments()
{
    return $this->hasMany(QuoteAssignment::class);
}
}