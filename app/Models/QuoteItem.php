<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    protected $fillable=[
        'quote_id',
        'description',
        'rate',
        'amount',
        'qty',
       'frequency',

        'type'

    ];

     public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

}
