<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
     protected $fillable = [
        'quote_id','service_detail','status','method',
        'amount_paid','pending_amount','paid_date','notes',
        'invoice_amount','gst_applied','gst_amount','total_amount',
    ];

    protected $casts = [
        'gst_applied' => 'boolean',
    ];

    public const GST_RATE = 0.05;

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    // Invoice month = payment/invoice date, falling back to when the record was created.
    // $month is 'YYYY-MM'; null/'' means no filter.
    public function scopeForMonth($query, ?string $month)
    {
        if (!$month) return $query;

        return $query->whereRaw("DATE_FORMAT(COALESCE(paid_date, created_at), '%Y-%m') = ?", [$month]);
    }

    // Months that have at least one invoice, newest first: ['2026-09' => 'September 2026', ...]
    public static function availableMonths(): array
    {
        return static::selectRaw("DATE_FORMAT(COALESCE(paid_date, created_at), '%Y-%m') as ym")
            ->groupBy('ym')
            ->orderByDesc('ym')
            ->pluck('ym')
            ->mapWithKeys(fn ($ym) => [$ym => \Carbon\Carbon::createFromFormat('!Y-m', $ym)->format('F Y')])
            ->all();
    }
}
