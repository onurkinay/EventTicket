<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Here you can fetch payments from the database if needed
        $event = \App\Models\Event::findOrFail(Cache::get('event_id'));
        $ticketCategory = \App\Models\TicketCategory::findOrFail(Cache::get('ticket_category_id'));
        $selectedSeats = (array) Cache::get('selected_seats', []);

        if (empty($selectedSeats)) {
            // 403 Forbidden if no seats are selected
            abort(403, 'No seats selected for payment.');
        }

        // You can also calculate the total amount based on selected seats and ticket category
        $total = count($selectedSeats) * $ticketCategory->price; // Assuming price is a property of TicketCategory
        $taxes = $total * 0.18; // Assuming a tax rate of 18%
        $totalWithTaxes = $total + $taxes;

        return view('payments.index', compact('event', 'ticketCategory', 'selectedSeats', 'total', 'taxes', 'totalWithTaxes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
