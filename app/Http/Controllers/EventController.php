<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();

        return view('events.index', compact('events'));
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
        /*$validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_category_id' => 'required|exists:ticket_categories,id',
            'selected_seats' => 'required|string',
            'customer_name' => 'required|string|max:255',
            'customer_surname' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'card_number' => 'required|string|max:20',
            'exp_date' => 'required|string|max:7',
            'cvv' => 'required|string|max:4',
        ], [

            'event_id.required' => 'Etkinlik seçimi zorunludur.',
            'event_id.exists' => 'Seçilen etkinlik bulunamadı.',

            'ticket_category_id.required' => 'Bilet kategorisi seçilmelidir.',
            'ticket_category_id.exists' => 'Seçilen bilet kategorisi geçersiz.',

            'selected_seats.required' => 'Lütfen en az bir koltuk seçiniz.',
            'selected_seats.array' => 'Seçilen koltuklar geçersiz biçimde gönderildi.',
            'selected_seats.*.string' => 'Her koltuk bir metin olarak gönderilmelidir.',
            'selected_seats.*.distinct' => 'Aynı koltuğu birden fazla kez seçtiniz.',

            'customer_name.required' => 'Ad alanı zorunludur.',
            'customer_name.string' => 'Ad geçerli bir metin olmalıdır.',
            'customer_name.max' => 'Ad 255 karakterden uzun olamaz.',

            'customer_surname.required' => 'Soyad alanı zorunludur.',
            'customer_surname.string' => 'Soyad geçerli bir metin olmalıdır.',
            'customer_surname.max' => 'Soyad 255 karakterden uzun olamaz.',

            'customer_email.required' => 'E-posta alanı zorunludur.',
            'customer_email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'customer_email.max' => 'E-posta 255 karakteri geçemez.',

            'customer_phone.string' => 'Telefon numarası geçerli değil.',
            'customer_phone.max' => 'Telefon numarası 20 karakteri geçemez.',

            'card_number.required' => 'Kart numarası zorunludur.',
            'card_number.string' => 'Kart numarası geçerli bir metin olmalıdır.',
            'card_number.max' => 'Kart numarası en fazla 20 karakter olabilir.',

            'exp_date.required' => 'Son kullanma tarihi zorunludur.',
            'exp_date.string' => 'Son kullanma tarihi geçerli bir biçimde olmalıdır.',
            'exp_date.max' => 'Son kullanma tarihi en fazla 7 karakter olabilir (örnek: 12/2025).',

            'cvv.required' => 'CVV alanı zorunludur.',
            'cvv.string' => 'CVV geçerli bir metin olmalıdır.',
            'cvv.max' => 'CVV en fazla 4 karakter olabilir.',
        ]);

        dd($validated);*/
        Session::put('event_id', $request->event_id);
        Session::put('ticket_category_id', $request->ticket_category_id);
        Session::put('selected_seats', $request->selected_seats);
        Session::put('selected_seats_letters', $request->selected_seats_letters);

        return redirect()->route('payments.index');
        // Store the payment and redirect to the payment index

    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
