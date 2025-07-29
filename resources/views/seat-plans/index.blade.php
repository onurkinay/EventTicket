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
            @if ($errors->any())
                <ul class="text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <div class="flex flex-col md:flex-row gap-4">
                <div class="md:w-3/4">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                        <table class="w-full  ">
                            <thead>
                                <tr>
                                    <th class="text-left font-semibold w-25 ">Event</th>
                                    <th class="text-left font-semibold w-25">Price at a ticket</th>
                                    <th class="text-left font-semibold w-25">Seats</th>
                                    <th class="text-left font-semibold w-25">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-4">
                                        <div class="flex items-center">

                                            <span class="font-semibold">{{ $event->title }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4" id="ticketPrice">${{ $ticketCategory->price }}</td>
                                    <td class="py-4" id="selectedSeatsText">
                                        No Selected
                                    </td>
                                    <td class="py-4" id="totalAmount">$0.00</td>
                                </tr>
                                <!-- More product rows -->
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                        <h2 class="text-lg font-semibold mb-4">Selected Seats</h2>
                        <div class=" p-6 rounded  ">
                            <svg id="seating" width="100%" height="350" viewBox="0 0 500 350">
                                <!-- SVG koltuklar ve etiketler burada olacak -->
                            </svg>
                            <div class="mt-4 text-sm text-green-300" id="selectedSeatsText"></div>

                        </div>

                    </div>
                </div>
                <div class="md:w-1/4">

                    <form method="POST" action="{{ route('events.store') }}">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        <input type="hidden" name="ticket_category_id" value="{{ $ticketCategory->id }}">
                        <input type="hidden" name="selected_seats" id="selectedSeatsInput" value="[]">
                        <input type="hidden" name="selected_seats_letters" id="selectedSeatsLettersInput"
                            value="[]">

                        <button id="checkoutButton" type="submit"
                            class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full">Checkout</button>
                </div>

                </form>
            </div>
        </div>
    </div>
    </div>

    <script>
        const svg = document.getElementById('seating');
        const selectedSeats = new Set();
        const selectedSeatsNoLetter = new Set();
        const rows = 5;
        const cols = 8;
        const seatSize = 40;
        const seatGap = 10;
        const startX = 50;
        const startY = 30;
        const occupiedSeats = [2, 5, 10, 17, 25]; //dolu koltukları
        const rowLetters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("");

        document.getElementById('checkoutButton').disabled = true;
        document.getElementById('checkoutButton').classList.add('opacity-50',
            'cursor-not-allowed');

        for (let row = 0; row < rows; row++) {
            for (let col = 0; col < cols; col++) {
                const index = row * cols + col;
                const x = startX + col * (seatSize + seatGap);
                const y = startY + row * (seatSize + seatGap);
                const seatNumber = `${rowLetters[row]}${col + 1}`;
                const seatNumberNoLetter = index;

                // Koltuk çizimi
                const seat = document.createElementNS("http://www.w3.org/2000/svg", "rect");
                seat.setAttribute("x", x);
                seat.setAttribute("y", y);
                seat.setAttribute("width", seatSize);
                seat.setAttribute("height", seatSize);
                seat.setAttribute("rx", 6);
                seat.setAttribute("data-id", seatNumber);
                seat.setAttribute("data-id-no-letter", seatNumberNoLetter);
                seat.classList.add("seat");

                if (occupiedSeats.includes(index)) {
                    seat.classList.add("occupied");
                } else {
                    seat.classList.add("available");
                    seat.addEventListener("click", () => {
                        seat.classList.toggle("selected");
                        if (selectedSeats.has(seatNumber)) {
                            selectedSeats.delete(seatNumber);
                        } else {
                            selectedSeats.add(seatNumber);
                            selectedSeatsNoLetter.add(seatNumberNoLetter);
                        }



                        const selectedSeatsText = Array.from(selectedSeats).join(', ');
                        const price = {{ $ticketCategory->price }};
                        const total = selectedSeats.size * price;
                        const totalText = selectedSeats.size > 0 ? `$${total.toFixed(2)}` : '$0.00';
                        const taxes = total * 0.18;
                        const totalWithTaxes = total + taxes;

                        document.querySelector('td:nth-child(4)').textContent = totalText;
                        document.querySelector('td:nth-child(3)').textContent = selectedSeatsText ||
                            'No Selected';

                        document.getElementById('totalAmount').textContent = `$${totalWithTaxes.toFixed(2)}`;
                        document.getElementById('selectedSeatsInput').value = JSON.stringify(Array.from(
                            selectedSeatsNoLetter));

                        document.getElementById('selectedSeatsLettersInput').value = JSON.stringify(Array.from(
                            selectedSeats));

                        if (selectedSeats.size === 0) {
                            document.getElementById('checkoutButton').disabled = true;
                            document.getElementById('checkoutButton').classList.add('opacity-50',
                                'cursor-not-allowed');
                        } else {
                            document.getElementById('checkoutButton').disabled = false;
                            document.getElementById('checkoutButton').classList.remove('opacity-50',
                                'cursor-not-allowed');
                        }
                    });
                }

                svg.appendChild(seat);

                // Koltuk üzerindeki numara
                const label = document.createElementNS("http://www.w3.org/2000/svg", "text");
                label.setAttribute("x", x + seatSize / 2);
                label.setAttribute("y", y + seatSize / 2);
                label.classList.add("label");
                label.textContent = col + 1;
                svg.appendChild(label);
            }

            // Satır harfleri (sol ve sağ)
            const rowY = startY + row * (seatSize + seatGap) + seatSize / 2;
            const leftLabel = document.createElementNS("http://www.w3.org/2000/svg", "text");
            const rightLabel = document.createElementNS("http://www.w3.org/2000/svg", "text");

            [leftLabel, rightLabel].forEach(label => {
                label.setAttribute("y", rowY);
                label.classList.add("label");
                label.setAttribute("dominant-baseline", "middle");
            });

            leftLabel.setAttribute("x", startX - 20);
            leftLabel.textContent = rowLetters[row];

            rightLabel.setAttribute("x", startX + cols * (seatSize + seatGap) + 15);
            rightLabel.textContent = rowLetters[row];

            svg.appendChild(leftLabel);
            svg.appendChild(rightLabel);
        }
    </script>
</body>

</html>
