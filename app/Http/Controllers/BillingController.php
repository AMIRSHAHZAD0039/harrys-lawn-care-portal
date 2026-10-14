<?php

namespace App\Http\Controllers;
use App\Models\Quote;
use Illuminate\Http\Request;
use App\Models\Billing;

class BillingController extends Controller
{

// ----------------------storing billing info
    public function store(Request $request, Quote $quote)
        {
            $quote->billings()->create($this->validatedBilling($request));

            return back()->with('success', 'Billing record added.');
        }

// ----------------------updating billing info

    public function update(Request $request, Billing $billing)
        {
            $billing->update($this->validatedBilling($request));

            return back()->with('success', 'Billing record updated.');
        }

// ----------------------shared validation + GST / paid / pending math
    private function validatedBilling(Request $request): array
    {
        $data = $request->validate([
            'service_detail' => 'required|string',
            'status'         => 'required|in:Paid,Unpaid,Partial',
            'method'         => 'nullable|string',
            'invoice_amount' => 'required|numeric|min:0',
            'amount_paid'    => 'nullable|numeric|min:0',
            'paid_date'      => 'nullable|date',
            'notes'          => 'nullable|string',
        ]);

        $gstApplied = $request->boolean('gst_applied');
        $subtotal   = round((float) $data['invoice_amount'], 2);
        $gst        = $gstApplied ? round($subtotal * Billing::GST_RATE, 2) : 0;
        $total      = round($subtotal + $gst, 2);

        // Paid -> whole total collected; Unpaid -> whole total pending;
        // Partial -> whatever was paid, remainder is pending.
        switch ($data['status']) {
            case 'Paid':
                $paid = $total;
                break;
            case 'Unpaid':
                $paid = 0;
                break;
            default:
                $paid = min(round((float) ($data['amount_paid'] ?? 0), 2), $total);
        }

        $data['gst_applied']    = $gstApplied;
        $data['gst_amount']     = $gst;
        $data['total_amount']   = $total;
        $data['amount_paid']    = $paid;
        $data['pending_amount'] = round($total - $paid, 2);

        return $data;
    }


        public function invoices(Quote $quote)
{
    // Paginated billings for the pagination block; the table/summary read $quote->billings.
    $billings = $quote->billings()->latest()->paginate(15);

    return view('quotes.customer-invoices', compact('quote', 'billings'));
}
// ----------------------dashboard revenue drill-down (collected / pending / booked)
public function revenue(Request $request, string $type)
{
    $month = preg_match('/^\d{4}-\d{2}$/', (string) $request->query('month')) ? $request->query('month') : null;
    $availableMonths = Billing::availableMonths();

    if ($type === 'booked') {
        // Signed customers; their invoices shown for context (all-time billing for that customer).
        $customers = Quote::where('signed', 1)
            ->where('status', 'accepted')
            ->when($month, fn ($q) => $q->whereRaw("DATE_FORMAT(signed_at, '%Y-%m') = ?", [$month]))
            ->with(['billings' => fn ($q) => $q->orderByDesc('paid_date')])
            ->latest('signed_at')
            ->get();

        $grandTotal = (float) $customers->sum('total');
    } else {
        $column = $type === 'collected' ? 'amount_paid' : 'pending_amount';

        // Only customers who have matching invoices, and only those invoices.
        $invoiceFilter = fn ($q) => $q->forMonth($month)->where($column, '>', 0);

        $customers = Quote::whereHas('billings', $invoiceFilter)
            ->with(['billings' => fn ($q) => $invoiceFilter($q)->orderByDesc('paid_date')])
            ->get()
            ->sortByDesc(fn ($c) => $c->billings->sum($column))
            ->values();

        $grandTotal = (float) Billing::forMonth($month)->sum($column);
    }

    return view('quotes.revenue-details', compact('type', 'month', 'availableMonths', 'customers', 'grandTotal'));
}

// ----------------------deleting billing info
public function destroy(Billing $billing)
{
    $billing->delete();

    return back()->with('success', 'Billing record deleted.');
}

}
