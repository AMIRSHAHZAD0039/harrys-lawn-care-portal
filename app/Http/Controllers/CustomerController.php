<?php
namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Group;                 // adjust if your group model is named differently
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // List ALL signed customers. The Blade splits All vs Active client-side via tabs,
    // so we send every signed quote and let the view filter by customer_status.
    public function index(Request $request)
    {
        // "Signed" matches your all-quotes badge logic exactly:
        //   signed == 1 AND status === 'accepted'
        $query = Quote::query()
            ->where('signed', 1)
            ->where('status', 'accepted')
            ->with(['billings']);       // invoices = existing billing records

        // Same optional filters as all-quotes.
        if ($request->filled('client')) {
            $query->where('client_name', 'like', '%'.$request->client.'%');
        }
        if ($request->filled('email')) {
            $query->where('client_email', 'like', '%'.$request->email.'%');
        }
        if ($request->filled('phone')) {
            $query->where('client_phone', 'like', '%'.$request->phone.'%');
        }
        if ($request->filled('address')) {
            $query->where('client_address', 'like', '%'.$request->address.'%');
        }

        // Active tab: every active customer (same filters), NOT paginated.
        // Cloned before paginate() so it carries the filters but not the page limit.
        $activeCustomers = (clone $query)
            ->where('customer_status', 'active')
            ->latest('signed_at')
            ->get();

        $quotes = $query->latest('signed_at')->paginate(20)->withQueryString();

        // For the Assign Group modal (same as all-quotes).
        $groups = Group::all();

        return view('quotes.all-customers', compact('quotes', 'activeCustomers', 'groups'));
    }

    // Address autocomplete for the filter bars (JSON list of matching addresses).
    // ?scope=customers limits suggestions to signed customers; otherwise all quotes.
    public function addressSuggest(Request $request)
    {
        $term = trim((string) $request->query('q'));
        if (mb_strlen($term) < 2) {
            return response()->json([]);
        }

        $addresses = Quote::query()
            ->when($request->query('scope') === 'customers', fn ($q) => $q->where('signed', 1)->where('status', 'accepted'))
            ->whereNotNull('client_address')
            ->where('client_address', 'like', '%'.$term.'%')
            ->distinct()
            ->orderBy('client_address')
            ->limit(10)
            ->pluck('client_address');

        return response()->json($addresses);
    }

    // Flip customer_status between 'all' and 'active'.
    public function toggleStatus(Request $request, Quote $quote)
    {
        $quote->customer_status = $quote->customer_status === 'active' ? 'all' : 'active';
        $quote->save();

        $now = $quote->customer_status === 'active' ? 'Active' : 'All';

        return back()->with('success', "Customer moved to {$now} Customers.");
    }
}