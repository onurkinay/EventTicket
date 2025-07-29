<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Buy Ticket - Event Ticket System</title>
    @vite('resources/css/app.css')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        .seat {
            cursor: pointer;
            transition: fill 0.2s;
        }

        .available {
            fill: #4ade80;
        }

        .selected {
            fill: #3b82f6;
        }

        .occupied {
            fill: #9ca3af;
            cursor: not-allowed;
        }

        .label {
            font-size: 14px;
            fill: black;
            pointer-events: none;
            user-select: none;
            text-anchor: middle;
            dominant-baseline: middle;
        }
    </style>
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18]  items-center lg:justify-center min-h-screen flex-col">


    <div class="bg-gray-100   py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-semibold mb-4">Buy Ticket</h1>

            <ul class="text-red-600 display-none" id="errorList">

            </ul>


            <form id="paymentForm">
                @csrf
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="md:w-3/4">

                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-lg font-semibold mb-4">Personal Information</h2>
                            <div>
                                <div class="mt-4">
                                    <label for="customer_name"
                                        class="block text-gray-700 dark:text-white mb-1">Name</label>
                                    <input type="text" name="customer_name" id="customer_name"
                                        value="{{ old('customer_name') }}"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                                </div>

                                <div class="mt-4">
                                    <label for="customer_surname"
                                        class="block text-gray-700 dark:text-white mb-1">Surname</label>
                                    <input type="text" name="customer_surname" id="customer_surname"
                                        value="{{ old('customer_surname') }}"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                                </div>

                                <div class="mt-4">
                                    <label for="customer_email"
                                        class="block text-gray-700 dark:text-white mb-1">Email</label>
                                    <input type="email" name="customer_email" id="customer_email"
                                        value="{{ old('customer_email') }}"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                                </div>

                                <div class="mt-4">
                                    <label for="phone" class="block text-gray-700 dark:text-white mb-1">Phone</label>
                                    <input type="text" name="customer_phone" id="phone"
                                        value="{{ old('customer_phone') }}"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                                </div>

                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow-md p-6 mt-5">
                            <h2 class="text-lg font-semibold mb-4">Payment Information</h2>
                            <div>
                                <div class="mt-4">
                                    <label for="card_number" class="block text-gray-700 dark:text-white mb-1">Card
                                        Number</label>
                                    <input type="text" id="card_number" name="card_number"
                                        class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                                </div>

                                <div class="grid grid-cols-3 gap-4 mt-4">
                                    <div>
                                        <label for="exp_month"
                                            class="block text-gray-700 dark:text-white mb-1">Expiration
                                            Month</label>
                                        <input type="text" id="exp_month" name="exp_month"
                                            class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                                    </div>
                                    <div>
                                        <label for="exp_year"
                                            class="block text-gray-700 dark:text-white mb-1">Expiration
                                            Year</label>
                                        <input type="text" id="exp_year" name="exp_year"
                                            class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                                    </div>
                                    <div>
                                        <label for="cvv"
                                            class="block text-gray-700 dark:text-white mb-1">CVV</label>
                                        <input type="text" id="cvv" name="cvv"
                                            class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="md:w-1/4">

                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-lg font-semibold mb-4">Event</h2>
                            <div class="flex justify-between mb-4">
                                <img src="{{ $event->image }}" alt="{{ $event->title }}"
                                    class="  rounded-lg object-cover">
                            </div>
                            <div class="flex justify-between mb-2">
                                <span>{{ $event->title }}</span>
                                <span><span id="subtotalAmount">{{ count($selectedSeats) }} SEATS</span></span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span>Ticket</span>
                                <span><span id="taxesAmount">{{ $ticketCategory->category }}</span></span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span>Date</span>
                                <span><span id="taxesAmount">{{ $event->event_date }}</span></span>
                            </div>

                            <div class="flex justify-between mb-2">
                                <span>Venue</span>
                                <span><span id="taxesAmount">{{ $event->venue->name }}</span></span>

                            </div>

                        </div>

                        <div class="bg-white rounded-lg shadow-md p-6 mt-5">
                            <h2 class="text-lg font-semibold mb-4">Summary</h2>
                            <div class="flex justify-between mb-2">
                                <span>Subtotal</span>
                                <span><span id="subtotalAmount">${{ number_format($total, 2) }}</span></span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span>Taxes</span>
                                <span><span id="taxesAmount">${{ number_format($taxes, 2) }}</span></span>
                            </div>

                            <hr class="my-2">
                            <div class="flex justify-between mb-2">
                                <span class="font-semibold">Total</span>
                                <span class="font-semibold"
                                    id="totalAmountSummary">${{ number_format($totalWithTaxes, 2) }}</span>
                            </div>
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <input type="hidden" name="ticket_category_id" value="{{ $ticketCategory->id }}">
                            <input type="hidden" name="selected_seats" id="selectedSeatsInput"
                                value="{{ implode(',', $selectedSeats) }}">
                            <input type="hidden" name="selected_seats_letters" id="selectedSeatsLettersInput"
                                value="{{ implode(',', $selectedSeatsLetters) }}">
                            <button id="checkoutButton" type="submit"
                                class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full cursor-pointer">Pay
                                Now!</button>
                        </div>

                    </div>
                </div>

            </form>

            <div id="myModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-xl w-96 relative">
                    <h2 class="text-xl font-bold mb-4">Payment Confirmation</h2>
                    <p class="mb-4 text-gray-700">Your payment has been successfully processed. Your event details are
                        as follows:</p>
                    <div class="mb-4">
                        <strong>Event:</strong> {{ $event->title }}<br>
                        <strong>Date:</strong> {{ $event->event_date }}<br>
                        <strong>Venue:</strong> {{ $event->venue->name }}<br>
                        <strong>Seats:</strong> {{ implode(', ', $selectedSeatsLetters) }}<br>
                        <strong>Total Amount:</strong> ${{ number_format($totalWithTaxes, 2) }}
                    </div>
                    <p class="text-green-600 font-semibold">Thank you for your purchase!</p>
                    <p class="text-sm text-gray-500 mt-2">You will receive a confirmation email shortly.</p>
                    <button onclick="closeModal()"
                        class="absolute top-2 right-2 text-gray-500 hover:text-black text-2xl leading-none">&times;</button>
                    <button onclick="closeModal()"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function closeModal() {
            window.location.href = '/events'; // Ana sayfaya yönlendir
        }
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Formun sayfayı yenilemesini engelle
            document.getElementById('checkoutButton').disabled = true; // Butonu devre dışı bırak
            document.getElementById('checkoutButton').innerText = 'Processing...'; // Buton metnini değiştir
            document.getElementById('checkoutButton').classList.add('opacity-50',
                'cursor-not-allowed'); // Buton stilini değiştir

            document.getElementById('errorList').classList.add('display-none'); // Hata listesini gizle
            const form = e.target;
            const formData = new FormData(form);

            fetch('/payments', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Başarılı:', data);
                    if (data.errors) {
                        const errorList = document.getElementById('errorList');
                        errorList.classList.remove('display-none');
                        errorList.innerHTML = ''; // Önceki hataları temizle

                        // Hataları işleyin
                        console.error('Hatalar:', data.errors);
                        document.getElementById('checkoutButton').disabled = false; // Butonu tekrar etkinleştir
                        document.getElementById('checkoutButton').innerText =
                            'Pay Now!'; // Buton metnini geri al
                        document.getElementById('checkoutButton').classList.remove('opacity-50',
                            'cursor-not-allowed'); // Buton stilini geri al
                        if (data.errors && typeof data.errors === 'object') {
                            for (const field in data.errors) {
                                if (Array.isArray(data.errors[field])) {
                                    data.errors[field].forEach((message) => {
                                        const li = document.createElement('li');
                                        li.textContent = message;
                                        errorList.appendChild(li);
                                    });
                                }
                            }
                        }
                        //yuukarıya at
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                        return;
                    }
                    document.getElementById('checkoutButton').innerText =
                        'Payment Successful!'; // Başarılı mesajı
                    document.getElementById('checkoutButton').classList.remove('bg-blue-500',
                        'text-white'); // Buton stilini kaldır
                    document.getElementById('checkoutButton').classList.add('bg-green-500',
                        'text-white'); // Başarılı stil
                    document.getElementById('checkoutButton').disabled = true; // Butonu devre dışı bırak

                    document.getElementById('myModal').classList.remove('hidden');
                    document.getElementById('myModal').classList.add('flex');

                })
                .catch(error => {
                    console.error('Hata:', error);
                });
        });
    </script>
</body>

</html>
