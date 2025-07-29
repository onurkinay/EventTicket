<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('events', \App\Http\Controllers\EventController::class);

Route::get('/seat-plans/{eventId}/{ticketCategoryId}', function ($eventId, $ticketCategoryId) {
    $event = \App\Models\Event::findOrFail($eventId);
    $ticketCategory = \App\Models\TicketCategory::findOrFail($ticketCategoryId);

    return view('seat-plans.index', compact('event', 'ticketCategory'));
})->name('get-ticket');

Route::resource('payments', \App\Http\Controllers\PaymentController::class);
