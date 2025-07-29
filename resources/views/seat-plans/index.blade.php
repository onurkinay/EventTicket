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

</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18]  items-center lg:justify-center min-h-screen flex-col">


    <div class="bg-gray-100   py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-semibold mb-4">Buy Ticket</h1>
            <div class="flex flex-col md:flex-row gap-4">
                <div class="md:w-3/4">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="text-left font-semibold">Event</th>
                                    <th class="text-left font-semibold">Price at a ticket</th>
                                    <th class="text-left font-semibold">Seats</th>
                                    <th class="text-left font-semibold">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-4">
                                        <div class="flex items-center">

                                            <span class="font-semibold">{{ $event->title }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4">$19.99</td>
                                    <td class="py-4">
                                        [5,6,7,8,9]
                                    </td>
                                    <td class="py-4">$19.99</td>
                                </tr>
                                <!-- More product rows -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="md:w-1/4">

                    <form method="POST" action="{{ route('events.store') }}">
                        @csrf
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

                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label for="exp_date"
                                            class="block text-gray-700 dark:text-white mb-1">Expiration
                                            Date</label>
                                        <input type="text" id="exp_date" name="exp_date"
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
                        <div class="bg-white rounded-lg shadow-md p-6 mt-5">
                            <h2 class="text-lg font-semibold mb-4">Summary</h2>
                            <div class="flex justify-between mb-2">
                                <span>Subtotal</span>
                                <span>$19.99</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span>Taxes</span>
                                <span>$1.99</span>
                            </div>

                            <hr class="my-2">
                            <div class="flex justify-between mb-2">
                                <span class="font-semibold">Total</span>
                                <span class="font-semibold">$21.98</span>
                            </div>
                            <button type="submit"
                                class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full">Checkout</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
