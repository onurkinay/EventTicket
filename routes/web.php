<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('events.index');
});

Route::resource('events', \App\Http\Controllers\EventController::class);

Route::get('/seat-plans/{eventId}/{ticketCategoryId}', function ($eventId, $ticketCategoryId) {
    // önceden alınan koltuklar alınmasın
    $occupiedSeatsIds = \App\Models\Ticket::where('event_id', $eventId)
        ->where('category_id', $ticketCategoryId)
        ->pluck('seat_id')
        ->toArray();

    $occupiedSeats = \App\Models\Seat::whereIn('id', $occupiedSeatsIds)
        ->pluck('seat_index')
        ->toArray();

    $event = \App\Models\Event::findOrFail($eventId);
    $ticketCategory = \App\Models\TicketCategory::findOrFail($ticketCategoryId);

    return view('seat-plans.index', compact('event', 'ticketCategory', 'occupiedSeats'));
})->name('get-ticket');

Route::resource('payments', \App\Http\Controllers\PaymentController::class);
