<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\QuoteAssignmentController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\GroupController;

use App\Http\Controllers\TeamAuthController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;



Route::get('/quote-sign/{token}',[QuoteController::class,'signPage'])
    ->name('quote.sign');

Route::post('/quote-submit-sign',[QuoteController::class,'submitSign'])
    ->name('quote.submitSign');
Route::get('/thank-you', [\App\Http\Controllers\QuoteController::class, 'thankYou'])
    ->name('quotes.thankyou');

//------------------------------dashbaord:

// Login page
Route::get('/', [AdminAuthController::class, 'showLogin'])->name('login');
// Login POST
Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');

//-------tracking
Route::get('/email/open/{id}', [QuoteController::class, 'trackOpen']);
//---------------------------------------------------------------------------- Dashboard (protected)
Route::middleware('auth:admin')->group(function(){
    Route::get('/dashboard',[QuoteController::class,'dashboard'])
        ->name('admin.dashboard');

//    --------------settings
    Route::get('/settings',[AdminAuthController::class,'settings'])->name('admin.settings');
    Route::post('/settings/update',[AdminAuthController::class,'updateProfile'])->name('admin.updateProfile');

    // Register page
    Route::get('/register', [AdminAuthController::class,'showRegister'])->name('admin.register');
    Route::post('/register', [AdminAuthController::class,'register'])->name('admin.register.post');

// Logout
    Route::post('/logout', [AdminAuthController::class,'logout'])->name('admin.logout');

    //    ---------------all quotes and send
    Route::get('/all-quotes',[QuoteController::class,'allQuotes'])->name('quotes.all');
    Route::get('/quote-send/{id}',[QuoteController::class,'sendQuote'])->name('quote.send');
    Route::delete('/quote/{id}/delete', [QuoteController::class, 'deleteQuote'])->name('quote.delete');

    Route::get('/quote/send-calendly/{id}', [QuoteController::class, 'sendCalendly'])
        ->name('quote.sendCalendly');
    //edit quote
    Route::get('/quote/{id}/edit', [QuoteController::class, 'edit'])->name('quote.edit');
    Route::put('/quote/{id}/update', [QuoteController::class, 'update'])->name('quote.update');
    Route::post('/quotes/update-status', [QuoteController::class, 'updateStatus'])
    ->name('quotes.updateStatus');
//    ---------------other routes
    Route::get('/quote-create',[QuoteController::class,'create']);

    Route::post('/quote-store',[QuoteController::class,'store'])
        ->name('quote.store');

    Route::get('/quote-view/{id}',[QuoteController::class,'view'])
        ->name('quote.view');

    Route::get('/quote-pdf/{id}',[QuoteController::class,'pdf']);
    Route::get('/quote/{id}/download', [QuoteController::class, 'download'])->name('quote.download');
    Route::post('/quote/void/{id}', [QuoteController::class, 'voidQuote'])->name('quote.void');


    Route::get('/quotes-export',[QuoteController::class,'export'])->name('quotes.export');

//=========================================new portal system with integrations with website
    Route::get('/create-leads', [LeadController::class, 'create']);
    Route::post('/create-leads', [LeadController::class, 'store'])->name('leads.store');

    Route::get('/all-leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/{id}', [LeadController::class, 'show'])->name('leads.show'); // preview
    Route::get('/leads/{id}/edit', [LeadController::class, 'edit'])->name('leads.edit');
    Route::put('/leads/{id}', [LeadController::class, 'update'])->name('leads.update');
    Route::delete('/leads/{id}', [LeadController::class, 'destroy'])->name('leads.delete');

//    ================================================================teams routes 

Route::get('/quotes/create-teams',[TeamController::class,'index'])->name('teams.index');

Route::post('/teams/store',[TeamController::class,'store'])->name('teams.store');

Route::put('/teams/{team}',[TeamController::class,'update'])->name('teams.update');

Route::delete('/teams/{team}',[TeamController::class,'destroy'])->name('teams.destroy');


// ==================================================================route assignemnt by admin

Route::get('/route-optimization', function (Request $request) {

    $quoteIds = explode(',', $request->quote_ids);

    $quotes = \App\Models\Quote::whereIn('id', $quoteIds)->get();

    return view('route-optimization', compact('quotes', 'quoteIds'));
});

Route::post('/quote-assign/store', [QuoteAssignmentController::class, 'store'])
    ->name('quote.assign.store');

    // ------------------------------------/
// Dashboard "Assign Route" → inserts optimized stops (store). View already calls routes.generate, so leave the view alone.
Route::post('/optimize-route', [QuoteAssignmentController::class, 'store'])->name('routes.generate');

// Assigned-clients "Generate This Week's Routes" → frequency engine (NEW NAME)
Route::post('/generate-weekly-routes', [QuoteAssignmentController::class, 'generateWeeklyRoutes'])->name('routes.weekly');

// Assign-only (bulk on all-quotes) + single-stop delete
Route::post('/assign-clients', [QuoteAssignmentController::class, 'assign'])->name('clients.assign');
Route::delete('/route-schedule/{id}', [QuoteAssignmentController::class, 'destroySchedule'])->name('schedule.destroy');


Route::get('/weekly-routes', [QuoteAssignmentController::class, 'weeklyRoutes'])->name('routes.board');
Route::post('/route-schedule/{id}/status', [QuoteAssignmentController::class, 'updateScheduleStatus'])->name('schedule.status');

Route::get('/job-history', [QuoteAssignmentController::class, 'jobHistory'])->name('jobs.history');
Route::get('/client-history/{assignmentId}', [QuoteAssignmentController::class, 'clientHistory'])->name('client.history');


// -------------------showing assigned clients to the admin
Route::get('/assigned-clients', [QuoteAssignmentController::class, 'assignedClients']);
Route::put('/assignment/{id}', [QuoteAssignmentController::class, 'updateAssignment'])->name('assignment.update');
Route::delete('/assignment/{id}', [QuoteAssignmentController::class, 'destroyAssignment'])->name('assignment.destroy');




// --------------------billing routes ,clients billed history 
Route::post('/quotes/{quote}/billing', [BillingController::class, 'store'])->name('billing.store');
Route::put('/billing/{billing}', [BillingController::class, 'update'])->name('billing.update');
Route::get('/customers/{quote}/invoices', [BillingController::class, 'invoices'])
     ->name('billing.invoices');

     Route::delete('/billing/{billing}/delete', [BillingController::class, 'destroy'])
     ->name('billing.destroy');

// dashboard revenue drill-down: collected / pending / booked (optional ?month=YYYY-MM)
Route::get('/revenue/{type}', [BillingController::class, 'revenue'])
     ->whereIn('type', ['collected', 'pending', 'booked'])
     ->name('revenue.details');

// ----------------------------------------------------creating the groups-------
Route::get('/create-group', [GroupController::class, 'index'])->name('groups.index');
Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
Route::put('/groups/{group}', [GroupController::class, 'update'])->name('groups.update');
Route::delete('/groups/{group}', [GroupController::class, 'delete'])->name('groups.delete');


Route::post('/quotes/assign-group', [QuoteController::class, 'assignGroup'])->name('quotes.assignGroup');



// -----------------------------------------------------------------------------all customers
Route::get('/all-customers', [CustomerController::class, 'index'])->name('customers.all');
Route::post('/customers/{quote}/status', [CustomerController::class, 'toggleStatus'])->name('customers.toggleStatus');
Route::get('/address-suggest', [CustomerController::class, 'addressSuggest'])->name('address.suggest');


});


// ===========================================================================team portal starts from here



Route::get('/team', [TeamAuthController::class, 'showLogin'])
    ->name('team.login');

Route::post('/team/login', [TeamAuthController::class, 'login'])
    ->name('team.login.submit');

Route::post('/team/logout', [TeamAuthController::class, 'logout'])
    ->name('team.logout');

Route::middleware('team.auth')->group(function () {

Route::get('/team-dashboard', [TeamAuthController::class, 'dashboard'])->name('team.dashboard');

// TEAM PORTAL — controller-backed (replaces the bare-view closure)
Route::get('/assigned-jobs', [QuoteAssignmentController::class, 'teamPortal'])->name('team.jobs');

// LOCALHOST TESTING ONLY — resolves team by URL param. Remove/auth-gate before production (IDOR, see notes).
Route::get('/assigned-jobs/test/{teamId}', [QuoteAssignmentController::class, 'teamPortal'])->name('team.jobs.test');

Route::post('/assigned-jobs/{id}/start', [QuoteAssignmentController::class, 'startJob'])->name('team.jobs.start');
Route::post('/assigned-jobs/{id}/complete', [QuoteAssignmentController::class, 'completeJob'])->name('team.jobs.complete');
Route::post('/assigned-jobs/{id}/undo', [QuoteAssignmentController::class, 'undoJob'])->name('team.jobs.undo');
 Route::post('/team/jobs/{id}/photo/delete', [QuoteAssignmentController::class, 'deletePhoto'])->name('team.jobs.deletePhoto');
Route::post('/team/jobs/{id}/after', [QuoteAssignmentController::class, 'addAfterPhoto'])->name('team.jobs.after');

Route::get('/team-history', [QuoteAssignmentController::class, 'teamHistory'])->name('team.history');
// LOCALHOST TESTING ONLY — remove/auth-gate before production (IDOR)
Route::get('/team-history/test/{teamId}', [QuoteAssignmentController::class, 'teamHistory'])->name('team.history.test');
Route::get('/team-profile',  [TeamAuthController::class, 'profile'])->name('team.profile');
Route::post('/team-profile', [TeamAuthController::class, 'updateProfile'])->name('team.profile.update');





});





