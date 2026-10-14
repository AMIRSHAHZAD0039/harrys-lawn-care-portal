<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    /**
     * Show the form to create a new lead
     */
    public function create()
    {
        return view('quotes.cms.create-leads');
    }

    /**
     * Store the lead in database
     */


    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_lead' => 'nullable|date',
        ]);

        try {

            $lead = Lead::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'date_of_lead' => $request->date_of_lead,

                'source' => $request->source ?: null,
                'property_type' => $request->property ?: null,
                'message' => $request->message ?: null,
                'commercial_property_size' => $request->commercial_property_size ?: null,
                'comments' => $request->comments ?: null,
                'status' => $request->status ?: null,
                'frequency_selected' => $request->frequency_selected ?: null,
                'package_selected' => $request->package_selected ?: null,
                'per_visit_charges' => $request->per_visit_charges ?: null,
                'total_charges' => $request->total_charges ?: null,
                'visit_number' => $request->visit_number ?: null,
                'visit_date' => $request->visit_date ?: null,
                'visit_time' => $request->visit_time ?: null,
                'visit_status' => $request->visit_status ?: null,
                'payment_status' => $request->payment_status ?: null,
                'client_status' => $request->client_status ?: null,
            ]);

            return redirect()->route('leads.index')
                ->with('success', 'Lead added successfully!');

        } catch (\Exception $e) {

            // ✅ 1. LOG ERROR (IMPORTANT)
            Log::error('Lead Insert Error:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            // ✅ 2. SHOW EXACT ERROR ON SCREEN
            return back()->with('error', $e->getMessage());
        }
    }
//    ------------showing leads on all leads page and filtering them

    public function index(Request $request)
    {
        $query = Lead::query();



        // Filter by Name
        if ($request->filled('client')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->client . '%')
                    ->orWhere('last_name', 'like', '%' . $request->client . '%');
            });
        }

        //  Filter by Email
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        //  Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        //  Filter by Payment
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        //  Filter by Date
        if ($request->filled('date')) {
            $query->whereDate('date_of_lead', $request->date);
        }

        // Latest first
        // Latest first + paginate 10 per page
        $leads = $query->latest()->paginate(20);

        return view('quotes.cms.all-leads', compact('leads'));
    }

//    -----preview model customization
    public function show($id)
    {
        $lead = Lead::findOrFail($id);
        return response()->json($lead); // for preview modal
    }

//    ------edit page show
    public function edit($id)
    {
        $lead = Lead::findOrFail($id);
        return view('quotes.cms.edit-lead', compact('lead'));
    }

//    ----updating the leads
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_lead' => 'nullable|date',
        ]);

        try {
            $lead = \App\Models\Lead::findOrFail($id);

            $lead->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'date_of_lead' => $request->date_of_lead,

                'source' => $request->source ?: null,
                'property_type' => $request->property ?: null,
                'message' => $request->message ?: null,
                'commercial_property_size' => $request->commercial_property_size ?: null,
                'comments' => $request->comments ?: null,
                'status' => $request->status ?: null,
                'frequency_selected' => $request->frequency_selected ?: null,
                'package_selected' => $request->package_selected ?: null,
                'per_visit_charges' => $request->per_visit_charges ?: null,
                'total_charges' => $request->total_charges ?: null,
                'visit_number' => $request->visit_number ?: null,
                'visit_date' => $request->visit_date ?: null,
                'visit_time' => $request->visit_time ?: null,
                'visit_status' => $request->visit_status ?: null,
                'payment_status' => $request->payment_status ?: null,
                'client_status' => $request->client_status ?: null,
            ]);

            return redirect()->route('leads.index')->with('success', 'Lead updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }


//    -------------deleting the leads
    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();

        return redirect()->back()->with('success', 'Lead deleted!');
    }


//    ---------------------------------------------integarting api with harryslawn care
    // public function leadsStore(Request $request)
    // {
    //     try {

    //         //  Validate incoming JSON
    //         $validated = $request->validate([
    //             'first_name' => 'nullable|string|max:255',
    //             'last_name' => 'nullable|string|max:255',
    //             'email' => 'required|email|max:255',
    //             'phone' => 'nullable|string|max:20',
    //             'address' => 'nullable|string',
    //             'property_type' => 'nullable|string',
    //             'commercial_property_size' => 'nullable|string',
    //             'frequency_selected' => 'nullable|string',
    //             'message' => 'nullable|string',

    //             //  NEW FIELDS
    //             'package_selected' => 'nullable|string',
    //             'per_visit_charges' => 'nullable|string',
    //         ]);

    //         //  Ensure address NOT NULL (DB fix)
    //         $validated['address'] = $validated['address'] ?? 'N/A';

    //         //  Extra fields
    //         $validated['date_of_lead'] = now()->toDateString();

    //         //  Store lead
    //         $lead = Lead::create($validated);

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Lead stored successfully',
    //             'data' => $lead
    //         ], 201);

    //     } catch (\Exception $e) {

    //         \Log::error('Lead Insert Error:', [
    //             'message' => $e->getMessage(),
    //             'data' => $request->all(), //
    //             'line' => $e->getLine(),
    //             'file' => $e->getFile(),
    //         ]);

    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    public function leadsStore(Request $request)
{
    try {

        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',

            'property_type' => 'nullable|string',
            'commercial_property_size' => 'nullable|string',
            'frequency_selected' => 'nullable|string',
            'message' => 'nullable|string',

            'package_selected' => 'nullable|string',
            'per_visit_charges' => 'nullable|string',

            // NEW FIELDS
            'service' => 'nullable|string',
            'sub_services' => 'nullable|string',
        ]);

        $validated['address'] = $validated['address'] ?? 'N/A';
        $validated['date_of_lead'] = now()->toDateString();

        // ensure comma format clean
        if (!empty($validated['service'])) {
            $validated['service'] = trim($validated['service']);
        }

        if (!empty($validated['sub_services'])) {
            $validated['sub_services'] = trim($validated['sub_services']);
        }

        $lead = Lead::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Lead stored successfully',
            'data' => $lead
        ], 201);

    } catch (\Exception $e) {

        \Log::error('Lead Insert Error:', [
            'message' => $e->getMessage(),
            'data' => $request->all(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ]);

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}
}
