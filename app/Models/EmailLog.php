<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = [
        'quote_id',
        'email',
        'type',
        'subject',
        'sent_at',
        'opened',
        'opened_at'
    ];
}
