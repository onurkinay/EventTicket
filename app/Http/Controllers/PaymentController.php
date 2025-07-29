<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Here you can fetch payments from the database if needed
        $event = \App\Models\Event::findOrFail(Session::get('event_id'));
        $ticketCategory = \App\Models\TicketCategory::findOrFail(Session::get('ticket_category_id'));
        $selectedSeats = array_filter(explode(',', Session::get('selected_seats', '')));
        $selectedSeatsLetters = array_filter(explode(',', Session::get('selected_seats_letters', '')));

        if (empty($selectedSeats)) {
            // 403 Forbidden if no seats are selected
            abort(403, 'No seats selected for payment.');
        }

        // You can also calculate the total amount based on selected seats and ticket category
        $total = count($selectedSeats) * $ticketCategory->price; // Assuming price is a property of TicketCategory
        $taxes = $total * 0.18; // Assuming a tax rate of 18%
        $totalWithTaxes = $total + $taxes;

        return view('payments.index', compact('event', 'ticketCategory', 'selectedSeats', 'selectedSeatsLetters', 'total', 'taxes', 'totalWithTaxes'));
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
        $ticket_category_id = Session::get('ticket_category_id');
        if (! $ticket_category_id) {
            // 403 Forbidden if no ticket category is selected
            abort(403, 'No ticket category selected for payment.');
        }
        $ticketCategory = \App\Models\TicketCategory::findOrFail($ticket_category_id);

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_surname' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'card_number' => 'required|string|max:20',
            'exp_month' => 'required|integer|between:1,12',
            'exp_year' => 'required|integer|digits:4',
            'cvv' => 'required|string|max:4',
        ], [
            'customer_name.required' => 'First name is required.',
            'customer_name.string' => 'First name must be a valid text.',
            'customer_name.max' => 'First name may not be greater than 255 characters.',

            'customer_surname.required' => 'Last name is required.',
            'customer_surname.string' => 'Last name must be a valid text.',
            'customer_surname.max' => 'Last name may not be greater than 255 characters.',

            'customer_email.required' => 'Email address is required.',
            'customer_email.email' => 'Please enter a valid email address.',
            'customer_email.max' => 'Email address may not be greater than 255 characters.',

            'customer_phone.required' => 'Phone number is required.',
            'customer_phone.string' => 'Phone number must be a valid text.',
            'customer_phone.max' => 'Phone number may not be greater than 20 characters.',

            'card_number.required' => 'Card number is required.',
            'card_number.string' => 'Card number must be a valid text.',
            'card_number.max' => 'Card number may not be greater than 20 characters.',

            'exp_month.required' => 'Expiration month is required.',
            'exp_month.integer' => 'Expiration month must be a valid number.',
            'exp_month.between' => 'Expiration month must be between 1 and 12.',

            'exp_year.required' => 'Expiration year is required.',
            'exp_year.integer' => 'Expiration year must be a valid number.',
            'exp_year.digits' => 'Expiration year must be a 4-digit number.',

            'cvv.required' => 'CVV is required.',
            'cvv.string' => 'CVV must be a valid text.',
            'cvv.max' => 'CVV may not be greater than 4 characters.',
        ]);

        $selectedSeats = explode(',', substr($request->selected_seats, 1, -1)); // Assuming selected_seats is a comma-separated string
        if (empty($selectedSeats)) {
            // 403 Forbidden if no seats are selected
            abort(403, 'No seats selected for payment.');
        }
        $selectedSeatsLetters = explode(',', substr($request->selected_seats_letters, 1, -1)); // Assuming selected_seats_letters is a comma-separated string

        $total = count($selectedSeats) * $ticketCategory->price; // Assuming price is passed in the request
        $taxes = $total * 0.18; // Assuming a tax rate of 18%
        $totalWithTaxes = $total + $taxes;

        $order = Order::create([
            'customer_name' => $validated['customer_name'],
            'customer_surname' => $validated['customer_surname'],
            'customer_email' => $validated['customer_email'],
            'phone' => $validated['customer_phone'],
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'cc_number' => $validated['card_number'],
            'cc_exp_month' => $validated['exp_month'],
            'cc_exp_year' => $validated['exp_year'],
            'cc_cvv' => $validated['cvv'],
            'total_amount' => $totalWithTaxes,
        ]);

        foreach ($selectedSeats as $key => $seatIndex) {
            $seat = Seat::create([
                'seat_index' => $seatIndex,
                'seat_with_letter' => substr($selectedSeatsLetters[$key], 1, -1) ?? '', // Assuming a method to convert index to letter
            ]);

            $ticket = Ticket::create([
                'order_id' => $order->id,
                'seat_id' => $seat->id,
                'event_id' => Session::get('event_id'),
                'category_id' => Session::get('ticket_category_id'),
            ]);
        }

        // Clear the session data after payment
        Session::forget(['event_id', 'ticket_category_id', 'selected_seats', 'selected_seats_letters']);

        return response()->json([
            'status' => 'success',
            'message' => 'Payment successful!',
            'order_id' => $order->id,
            'payment_id' => $payment->id,
        ]);

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
