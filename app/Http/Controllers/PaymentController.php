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
            'customer_name.required' => 'Ad alanı zorunludur.',
            'customer_name.string' => 'Ad geçerli bir metin olmalıdır.',
            'customer_name.max' => 'Ad 255 karakterden uzun olamaz.',
            'customer_surname.required' => 'Soyad alanı zorunludur.',
            'customer_surname.string' => 'Soyad geçerli bir metin olmalıdır.',
            'customer_surname.max' => 'Soyad 255 karakterden uzun olamaz.',
            'customer_email.required' => 'E-posta alanı zorunludur.',
            'customer_email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'customer_email.max' => 'E-posta 255 karakterden uzun olamaz.',
            'customer_phone.required' => 'Telefon numarası zorunludur.',
            'customer_phone.string' => 'Telefon numarası geçerli bir metin olmalıdır.',
            'customer_phone.max' => 'Telefon numarası 20 karakterden uzun olamaz.',
            'card_number.required' => 'Kart numarası zorunludur.',
            'card_number.string' => 'Kart numarası geçerli bir metin olmalıdır.',
            'card_number.max' => 'Kart numarası en fazla 20 karakter olabilir.',
            'exp_month.required' => 'Son kullanma ayı zorunludur.',
            'exp_month.integer' => 'Son kullanma ayı geçerli bir sayı olmalıdır.',
            'exp_month.between' => 'Son kullanma ayı 1 ile 12 arasında olmalıdır.',
            'exp_year.required' => 'Son kullanma yılı zorunludur.',
            'exp_year.integer' => 'Son kullanma yılı geçerli bir sayı olmalıdır.',
            'exp_year.digits' => 'Son kullanma yılı 4 haneli bir sayı olmalıdır.',
            'cvv.required' => 'CVV alanı zorunludur.',
            'cvv.string' => 'CVV geçerli bir metin olmalıdır.',
            'cvv.max' => 'CVV en fazla 4 karakter olabilir.',
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

        // Optionally, you can redirect to a success page or show a success message
        return json_encode([
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
