<?php
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::post('/leads/store', [LeadController::class, 'leadsStore']);
