<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable=[
        'quote_number',
        'date',
        'valid_until',
        'prepared_by',

        'client_name',
        'client_address',
        'client_phone',
        'client_email',

        'lawn_size',
        'service_area',
        'terrain',
        'access',

        'condition',
        'hazards',

        'service_type',

        'subtotal',
        'discount',
        'gst',
        'total',

        'notes',
        'status',
        'client_signature',
        'client_name_print',
        'signature_date',
        'representative',

        'token',
        'signed',
        'signature',
        'is_void',
        'void_reason',
        'signed_at',
        'associated_group',
        'associated_week',
        'payment_method',

        'seasonal_frequency',
'seasonal_subtotal','seasonal_discount','seasonal_gst','seasonal_total',
'onetime_subtotal','onetime_discount','onetime_gst','onetime_total','sign_reason'

    ];

    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }
    public function emailLogs()
    {
        return $this->hasMany(EmailLog::class);
    }

    public function assignments()
{
    return $this->hasMany(QuoteAssignment::class);
}

public function billings()
{
    return $this->hasMany(Billing::class);
}

// method:
public function group()
{
    return $this->belongsTo(\App\Models\Group::class, 'associated_group');
}

}
