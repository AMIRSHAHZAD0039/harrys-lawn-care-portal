<?php

namespace App\Http\Controllers;

use App\Mail\QuoteMail;
use App\Mail\QuoteVoidMail;
use App\Models\Admin;
use App\Models\EmailLog;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\QuoteItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Team;
use App\Models\Group;   // file ke top me

use Illuminate\Support\Str;


class QuoteController extends Controller
{


    public function create(Request $request)
    {
        $lead = null;

        if ($request->lead_id) {
            $lead = \App\Models\Lead::find($request->lead_id);
        }

        // Vancouver Time
        $today = Carbon::now('America/Vancouver');
        $validUntil = $today->copy()->addDays(7);

        return view('quotes.create', [
            'lead' => $lead,
            'today' => $today->format('Y-m-d'),
            'validUntil' => $validUntil->format('Y-m-d'),
        ]);
    }



// ===========================================================creating the quote

   public function store(Request $request)
{

    
    $token = Str::random(40);

    $quote = Quote::create([
        'quote_number'=>$request->quote_number,
        'date'=>$request->date,
        'valid_until'=>$request->valid_until,
        'prepared_by'=>$request->prepared_by,

        'client_name'=>$request->client_name,
        'client_address'=>$request->client_address,
        'client_phone'=>$request->client_phone,
        'client_email'=>$request->client_email,

        'lawn_size'=>$request->lawn_size,
        'service_area'=>$request->service_area,
        'terrain'=>$request->terrain,
        'access'=>$request->access,

        'condition'=>$request->condition,
        'hazards'=>$request->hazards,

        'service_type'=>$request->service_type,
        // frequency sirf Seasonal Program ke liye
       'seasonal_frequency'=> strtoupper(trim($request->service_type ?? '')) === 'SEASONAL PROGRAM'
                        ? $request->seasonal_frequency
                        : null,

        // seasonal totals
        'seasonal_subtotal'=>$request->seasonal_subtotal,
        'seasonal_discount'=>$request->seasonal_discount,
        'seasonal_gst'=>$request->seasonal_gst,
        'seasonal_total'=>$request->seasonal_total,

        // one-time totals
        'onetime_subtotal'=>$request->onetime_subtotal,
        'onetime_discount'=>$request->onetime_discount,
        'onetime_gst'=>$request->onetime_gst,
        'onetime_total'=>$request->onetime_total,

         // Old columns will filled also
        // combined totals
        'subtotal' => ($request->seasonal_subtotal ?? 0) + ($request->onetime_subtotal ?? 0),
        'discount' => ($request->seasonal_discount ?? 0) + ($request->onetime_discount ?? 0),
        'gst' => ($request->seasonal_gst ?? 0) + ($request->onetime_gst ?? 0),
        'total' => ($request->seasonal_total ?? 0) + ($request->onetime_total ?? 0),


        'notes'=>$request->notes,
        'representative'=>$request->representative,
        'client_signature'=>$request->client_signature,
        'client_name_print'=>$request->client_name_print,
        'signature_date'=>$request->signature_date,
        'token'=>$token,
    ]);

    // dono pricing sets save — user ek ya dono bhar sakta hai
    $this->saveItems($quote, 'seasonal', $request);
    $this->saveItems($quote, 'onetime', $request);

    return redirect('/all-quotes')->with('success', 'Quote created successfully!');
}

/**
 * Ek pricing set (seasonal ya onetime) ke quote items save karta hai.
 */
private function saveItems(Quote $quote, string $type, Request $request): void
{
    $descriptions = $request->input("{$type}_description", []);
    $qtys         = $request->input("{$type}_qty", []);
    $rates        = $request->input("{$type}_rate", []);
    $amounts      = $request->input("{$type}_amount", []);

    // frequency sirf seasonal ke liye
    $frequency = $type === 'seasonal' ? $request->seasonal_frequency : null;

    foreach ($descriptions as $key => $desc) {

        // poori empty row skip karo
        if (
            empty(trim((string)$desc)) &&
            empty($qtys[$key] ?? null) &&
            empty($rates[$key] ?? null)
        ) {
            continue;
        }

        QuoteItem::create([
            'quote_id'   => $quote->id,
            'type'       => $type,
            'frequency'  => $frequency,
            'description'=> $desc,
            'qty'        => $qtys[$key]    ?? 0,
            'rate'       => $rates[$key]   ?? 0,
            'amount'     => $amounts[$key] ?? 0,
        ]);
    }
}

    // -===========================================================-showing quotes to all quotes

    public function allQuotes(Request $request)
    {

    $sort = $request->get('sort');
    $order = $request->get('order', 'desc');


        $query = Quote::query();

        if($request->quote_number){
            $query->where('quote_number','like','%'.$request->quote_number.'%');
        }

        if($request->client){
            $query->where('client_name','like','%'.$request->client.'%');
        }

        if($request->email){
            $query->where('client_email','like','%'.$request->email.'%');
        }
        if($request->phone){
        $query->where('client_phone','like','%'.$request->phone.'%');
        }
        if($request->address){
            $query->where('client_address','like','%'.$request->address.'%');
        }

        // ---------------------- filters for status

if($request->status == 'declined'){
    $query->where('status','declined');

}elseif($request->status == 'signed'){
    $query->where('signed',1);

}elseif($request->status == 'sent'){
    $query->whereHas('emailLogs', function($q){
        $q->where('type','quote_sent');
    });

}elseif($request->status == 'pending'){
    $query->where('signed',0)
          ->whereDoesntHave('emailLogs', function($q){
              $q->where('type','quote_sent');
          })
          ->where(function($q){
              $q->whereNull('status')
                ->orWhere('status','!=','declined');
          });
}
// ----------status end filtering
// -----sorting start
if($sort === 'email_logs') {

    $query->withCount(['emailLogs as sent_count' => function($q){
        $q->where('type','quote_sent');
    }]);

    $query->orderBy('sent_count', $order);
}
if($sort === 'signed_at') {
    $query->orderBy('signed_at', $order);
}
if(!$sort){
    $query->orderBy('id','desc');
}
// -----sorting end
        // ---------------------- filters for status end


       
            $quotes = $query->with('emailLogs')
            ->paginate(15)
            ->withQueryString();

    $teams = Team::where('status',1)->get();
    $groups = Group::where('status','Active')->orderBy('name')->get();

    $weeks = Quote::whereNotNull('associated_week')
    ->distinct()
    ->orderBy('associated_week')
    ->pluck('associated_week');

        return view('quotes.all-quotes',compact('quotes','teams','groups','weeks'));
    }


    // ===========================================================delete quote

    public function deleteQuote($id)
    {
        $quote = Quote::findOrFail($id);
        $quote->delete();

        return redirect('/all-quotes')->with('success', 'Quote deleted successfully!');
    }

    // -===========================================================send quote

    public function sendQuote($id)
    {
        $quote = Quote::findOrFail($id);

        $link = url('/quote-sign/'.$quote->token);

//        Reset void status when resending
        $quote->update([
            'is_void' => false,
            'void_reason' => null
        ]);

        //  Pehle log create karo
        $log = EmailLog::create([
            'quote_id' => $quote->id,
            'email' => $quote->client_email,
            'type' => 'quote_sent',
            'subject' => 'Quote Sent',
            'sent_at' => now('America/Toronto'),
        ]);

        // Phir email bhejo + log pass karo
        Mail::to($quote->client_email)
            ->send(new QuoteMail($quote, $link, $log));

        return redirect()->back()->with('success','Quote Sent Successfully');
    }

//    -===========================================================-void quote

// ------voide quote
    public function voidQuote(Request $request, $id)
    {
        $quote = Quote::findOrFail($id);

        $quote->update([
            'is_void' => true,
            'void_reason' => $request->reason,
            'status' => 'Voided'
        ]);

        Mail::to($quote->client_email)->send(new QuoteVoidMail($quote));

        return redirect()->back()->with('success', 'Quote voided successfully!');
    }


//    -===========================================================track email opened/not
    public function trackOpen($id)
    {
        // Log the attempt to access the pixel
        Log::info('Pixel accessed', ['email_log_id' => $id, 'timestamp' => now()]);

        $log = EmailLog::find($id);

        if ($log) {
            if (!$log->opened) {
                $log->update([
                    'opened' => true,
                    'opened_at' => now('America/Toronto')
                ]);

                Log::info('Email marked as opened', [
                    'email_log_id' => $id,
                    'client_name' => $log->client_name ?? null,
                    'opened_at' => $log->opened_at
                ]);
            } else {
                Log::info('Email already opened', [
                    'email_log_id' => $id,
                    'client_name' => $log->client_name ?? null,
                    'opened_at' => $log->opened_at
                ]);
            }
        } else {
            Log::warning('Email log not found', ['email_log_id' => $id]);
        }

        $path = public_path('images/pixel.png');

        return response()->file($path)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }


    // ===========================================================viewing the single quote
public function view($id)
{
    $quote = Quote::with('items')->findOrFail($id);

    $billings = $quote->billings()->latest()->paginate(15);

    return view('quotes.view', compact('quote', 'billings'));
}

    // ===========================================================downloading the pdf 
    public function pdf($id)
    {

        $quote = Quote::with('items')->findOrFail($id);

        $pdf = Pdf::loadView('quotes.view',compact('quote'));

        return $pdf->download('quote.pdf');

    }

    /* ==================================================================CLIENT SIGN PAGE */

    public function signPage($token)
    {
        $quote = Quote::where('token', $token)
            ->with('items')
            ->firstOrFail();

        // Get today's date in Vancouver / Canada timezone
        $today = now('America/Vancouver')->startOfDay();

        // Check if quote is expired

        if (
            $quote->is_void == 1 ||
            ($quote->valid_until && $today->gt(\Carbon\Carbon::parse($quote->valid_until)))
        ) {
            return view('quotes.expired', compact('quote'));
        }

        // Otherwise show the quote for signing
        return view('quotes.sign', compact('quote'));
    }

    /*================================================================== SUBMIT SIGNATURE */


    public function submitSign(Request $request)
    {
        $quote = Quote::where('token', $request->token)->firstOrFail();

        // =========================
        //  DECLINE CASE
        // =========================
        if ($request->action_type === 'decline') {

            $quote->update([
                'signed' => false,
                'status' => 'declined',
                'signed_at' => now()
            ]);

            return redirect()->route('quotes.thankyou');
        }

        // =========================
        //  ACCEPT CASE
        // =========================
        $quote->update([
            'signature' => $request->signature,
            'client_signature' => $request->signature,
            'client_name_print' => $request->client_name_print ?? $quote->client_name,
            'signature_date' => now()->format('Y-m-d'),
            'payment_method' => $request->payment_method,
            'signed' => true,
            'status' => 'accepted',
            'signed_at' => now()
        ]);

        // =========================
        // PDF GENERATION
        // =========================
        $pdf = Pdf::loadView('quotes.email-to-client', compact('quote'));

        // =========================
        // ADMIN EMAILS
        // =========================
        $admin = Admin::first();
        $adminEmails = [];

        if (!empty($admin->quote_emails)) {
            $adminEmails = array_map('trim', explode(',', $admin->quote_emails));
        }

        // =========================
        // SEND EMAIL
        // =========================
        Mail::to($quote->client_email)
            ->bcc($adminEmails)
            ->send(new \App\Mail\QuoteMailSigned($quote, $pdf->output()));

        return redirect()->route('quotes.thankyou');
    }


//    ==============================================================showing on dashboard
    
public function dashboard(Request $request)
{
    // Optional month filter for the revenue panel ('YYYY-MM'; empty = all time)
    $month = preg_match('/^\d{4}-\d{2}$/', (string) $request->query('month')) ? $request->query('month') : null;
    $availableMonths = \App\Models\Billing::availableMonths();

    /* ---- your original four (unchanged) ---- */
    $totalQuotes   = Quote::count();
    $signedQuotes  = Quote::where('signed', 1)->count();
    $pendingQuotes = Quote::where('signed', 0)->count();
    $quotes        = Quote::latest()->paginate(20);
 
    /* ---- signed CUSTOMERS: matches your all-quotes "Signed" badge + customers page ----
       (signed==1 AND status='accepted' — stricter than signedQuotes above, which is
        just signed==1; both are provided so the view can use whichever it needs) */
    $signedCount = Quote::where('signed', 1)->where('status', 'accepted')->count();
 
    $voidedCount   = Quote::where('status', 'Voided')->count();
    $declinedCount = Quote::where('status', 'declined')->count();
 
    // Pending quotes for the KPI card = not signed, not voided, not declined.
    $pendingCount = $totalQuotes - $signedCount - $voidedCount - $declinedCount;
    if ($pendingCount < 0) { $pendingCount = 0; }
 
    // Active customers (promoted on the customers page). Guard if column is fresh.
    $activeCustomers = Quote::where('signed', 1)
        ->where('status', 'accepted')
        ->where('customer_status', 'active')
        ->count();
 
    /* ---- revenue from billings ---- */
    $totalPaid    = (float) \App\Models\Billing::forMonth($month)->sum('amount_paid');
    $totalPending = (float) \App\Models\Billing::forMonth($month)->sum('pending_amount');

    $bookedValue = (float) Quote::where('signed', 1)
        ->where('status', 'accepted')
        ->when($month, fn ($q) => $q->whereRaw("DATE_FORMAT(signed_at, '%Y-%m') = ?", [$month]))
        ->sum('total');
 
    $conversionRate = $totalQuotes > 0
        ? round(($signedCount / $totalQuotes) * 100, 1)
        : 0;
 
    /* ---- chart: signed customers per month, last 6 months (uses signed_at) ---- */
    $chartLabels = [];
    $chartData   = [];
    for ($i = 5; $i >= 0; $i--) {
        $m = Carbon::now()->subMonths($i);
        $chartLabels[] = $m->format('M');
        $chartData[]   = Quote::where('signed', 1)
            ->where('status', 'accepted')
            ->whereYear('signed_at', $m->year)
            ->whereMonth('signed_at', $m->month)
            ->count();
    }
 
    /* ---- recent signed customers (latest 8) ---- */
    $recentCustomers = Quote::where('signed', 1)
        ->where('status', 'accepted')
        ->latest('signed_at')
        ->take(8)
        ->get();
 
    return view('quotes.dashboard', compact(
        // originals
        'totalQuotes', 'signedQuotes', 'pendingQuotes', 'quotes',
        // rich stats
        'signedCount', 'voidedCount', 'declinedCount', 'pendingCount', 'activeCustomers',
        'totalPaid', 'totalPending', 'bookedValue', 'conversionRate',
        'chartLabels', 'chartData', 'recentCustomers',
        // revenue month filter
        'month', 'availableMonths'
    ));
}

//----------------when client submit signature redirecting to thankyou page
    public function thankYou()
    {
        return view('quotes.thank-you');
    }



//    ===============================================================================edit quotes
    public function edit($id)
    {
        $quote = Quote::findOrFail($id);
        return view('quotes.edit-quote', compact('quote'));
    }
   public function update(Request $request, $id)
{
    $quote = Quote::findOrFail($id);



    //  Update main quote
    $quote->update([
        'quote_number'   => $request->quote_number,
        'date'           => $request->date,
        'valid_until'    => $request->valid_until,
        'prepared_by'    => $request->prepared_by,

        'client_name'    => $request->client_name,
        'client_address' => $request->client_address,
        'client_phone'   => $request->client_phone,
        'client_email'   => $request->client_email,

        'lawn_size'      => $request->lawn_size,
        'service_area'   => $request->service_area,
        'terrain'        => $request->terrain,
        'access'         => $request->access,

        'condition'      => $request->condition,
        'hazards'        => $request->hazards,

        'service_type'   => $request->service_type,
        // frequency sirf Seasonal Program ke liye
        'seasonal_frequency'=> strtoupper(trim($request->service_type ?? '')) === 'SEASONAL PROGRAM'
                                ? $request->seasonal_frequency
                                : null,

        // seasonal totals
        'seasonal_subtotal'=>$request->seasonal_subtotal,
        'seasonal_discount'=>$request->seasonal_discount,
        'seasonal_gst'=>$request->seasonal_gst,
        'seasonal_total'=>$request->seasonal_total,

        // one-time totals
        'onetime_subtotal'=>$request->onetime_subtotal,
        'onetime_discount'=>$request->onetime_discount,
        'onetime_gst'=>$request->onetime_gst,
        'onetime_total'=>$request->onetime_total,


         // Old columns bhi fill karo
 // combined totals
    'subtotal' => ($request->seasonal_subtotal ?? 0) + ($request->onetime_subtotal ?? 0),
    'discount' => ($request->seasonal_discount ?? 0) + ($request->onetime_discount ?? 0),
    'gst' => ($request->seasonal_gst ?? 0) + ($request->onetime_gst ?? 0),
    'total' => ($request->seasonal_total ?? 0) + ($request->onetime_total ?? 0),

        'notes'          => $request->notes,
        'representative' => $request->representative,
    ]);

    //  purane items delete
    QuoteItem::where('quote_id', $quote->id)->delete();

    //  dono pricing sets dobara insert (same helper as store)
    $this->saveItems($quote, 'seasonal', $request);
    $this->saveItems($quote, 'onetime', $request);

    return redirect('/all-quotes')->with('success', 'Quote updated successfully!');
}


//    -----------------------------downlaoding the pdf
    public function download($id)
    {
        $quote = Quote::with('items')->findOrFail($id);

        $pdf = Pdf::loadView('quotes.pdf', compact('quote'));

        return $pdf->download('quote-'.$quote->id.'.pdf');
    }

//==========================================calendly====

    public function sendCalendly($id)
    {
        $quote = Quote::findOrFail($id);

        $calendlyLink = "https://calendly.com/visit-scheduling-harryslawncare/30min";

        //  1. Pehle log create karo
        $log = EmailLog::create([
            'quote_id' => $quote->id,
            'email' => $quote->client_email,
            'type' => 'calendly_sent',
            'subject' => 'Calendly Invite Sent',
            'sent_at' => now('America/Toronto'),
        ]);

        //  2. Email send karo
        Mail::send([], [], function ($message) use ($quote, $calendlyLink) {
            $message->to($quote->client_email)
                ->subject('Schedule Your Meeting')
                ->html("
                <h3>Hello {$quote->client_name},</h3>
                <p>Please schedule your meeting using the button below:</p>

                <a href='$calendlyLink'
                   style='display:inline-block;padding:10px 15px;background:#6f42c1;color:white;text-decoration:none;border-radius:5px;'>
                    Schedule Meeting
                </a>

                <br><br>
         <p>
            Thank you for choosing <span style=\"font-weight:bold;\">Harry Lawns Care</span>.<br>
            We look forward to helping your lawn look its best this season!
        </p>
            ");
        });

        return redirect()->back()->with('success', 'Calendly email sent successfully!');
    }










    // ---------------------------------------donwloading quotes
  public function export(Request $request)
{
    $query = Quote::query();

    // ---------------- filters (same as before)
    if($request->client){
        $query->where('client_name','like','%'.$request->client.'%');
    }

    if($request->email){
        $query->where('client_email','like','%'.$request->email.'%');
    }

    if($request->phone){
        $query->where('client_phone','like','%'.$request->phone.'%');
    }

    if($request->address){
        $query->where('client_address','like','%'.$request->address.'%');
    }

    if($request->status == 'declined'){
        $query->where('status','declined');

    }elseif($request->status == 'signed'){
        $query->where('signed',1);

    }elseif($request->status == 'sent'){
        $query->whereHas('emailLogs', function($q){
            $q->where('type','quote_sent');
        });

    }elseif($request->status == 'pending'){
        $query->where('signed',0)
              ->whereDoesntHave('emailLogs', function($q){
                  $q->where('type','quote_sent');
              })
              ->where(function($q){
                  $q->whereNull('status')
                    ->orWhere('status','!=','declined');
              });
    }

    $quotes = $query->get();

    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=quotes.csv",
    ];

    $callback = function() use($quotes){

        $file = fopen('php://output', 'w');

        // ✅ FULL HEADER ROW
        fputcsv($file, [
            'ID','Date','Valid Until','Prepared By',
            'Client Name','Client Address','Client Phone','Client Email',
            'Lawn Size','Service Area','Terrain','Access',
            'Condition','Hazards','Service Type',
            'Subtotal','Discount','GST','Total',
            'Notes','Representative',
            'Signature','Client Name Print','Signature Date',
            'Token','Signed','Status','Signature Data',
            'Is Void','Void Reason','Signed At'
        ]);

        foreach($quotes as $q){
            fputcsv($file, [
                $q->id,
                
                $q->date,
                $q->valid_until,
                $q->prepared_by,

                $q->client_name,
                $q->client_address,
                $q->client_phone,
                $q->client_email,

                $q->lawn_size,
                $q->service_area,
                $q->terrain,
                $q->access,

                $q->condition,
                $q->hazards,
                $q->service_type,

                $q->subtotal,
                $q->discount,
                $q->gst,
                $q->total,

                $q->notes,
                $q->representative,

                $q->client_signature,
                $q->client_name_print,
                $q->signature_date,

                $q->token,
                $q->signed,
                $q->status,
                $q->signature,

                $q->is_void,
                $q->void_reason,
                $q->signed_at
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}


// assing group
public function assignGroup(Request $request)
{
    $data = $request->validate([
        'quote_ids'        => 'required|array',
        'quote_ids.*'      => 'integer',
        'group_id'         => 'nullable',
        'associated_week'  => 'nullable|string',
    ]);

    // Blank = unassign group
    $groupName = $request->filled('group_id')
        ? optional(Group::find($request->group_id))->name
        : null;

    Quote::whereIn('id', $data['quote_ids'])
        ->update([
            'associated_group' => $groupName,
            'associated_week'  => $request->associated_week,
        ]);

    return back()->with('success', 'Group & Week assigned successfully!');
}






// ===========================================================================update status manually by admin
public function updateStatus(Request $request)
{
    // Validate: a quote must be chosen and a status picked.
    $request->validate([
        'quote_id'      => 'required|exists:quotes,id',
        'status_choice' => 'required|in:accepted,declined,Voided,pending',
    ]);

    $quote  = Quote::findOrFail($request->quote_id);
    $choice = $request->status_choice;
    $note   = $request->sign_reason; // admin's note — saved for every status

    // -------------------- ACCEPTED --------------------
    if ($choice === 'accepted') {
        $quote->update([
            'signature'         => $request->signature,
            'client_signature'  => $request->signature,
            'client_name_print' => $request->client_name_print ?? $quote->client_name,
            'signature_date'    => now()->format('Y-m-d'),
            'payment_method'    => $request->payment_method,
            'signed'            => true,
            'status'            => 'accepted',
            'signed_at'         => now(),
            'sign_reason'       => $note,
        ]);
    }

    // -------------------- DECLINED --------------------
    elseif ($choice === 'declined') {
        $quote->update([
            'signed'      => false,
            'status'      => 'declined',
            'signed_at'   => now(),
            'sign_reason' => $note,
        ]);
    }

    // -------------------- VOIDED --------------------
    elseif ($choice === 'Voided') {
        $quote->update([
            'signed'      => false,
            'status'      => 'Voided',
            'sign_reason' => $note,
        ]);
    }

    // -------------------- PENDING --------------------
    // null status = Pending (matches the "else" branch in your table).
    else {
        $quote->update([
            'signed'      => false,
            'status'      => null,
            'signed_at'   => null,
            'sign_reason' => $note,
        ]);
    }

    return redirect()->back()->with('success', 'Quote #' . $quote->id . ' status updated to ' . $choice . '.');
}

}
