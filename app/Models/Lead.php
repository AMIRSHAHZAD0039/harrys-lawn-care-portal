<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'address', 'date_of_lead',
         'source', 'property_type', 'service','sub_services','message',
        'commercial_property_size', 'comments', 'status', 'frequency_selected',
        'package_selected', 'per_visit_charges', 'total_charges', 'visit_number',
        'visit_date', 'visit_time', 'visit_status', 'payment_status', 'client_status'
    ];
}
