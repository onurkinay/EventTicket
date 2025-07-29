@extends('events.layout.app')

@section('content')
    <section class="bg-white lg:grid lg:min-h-screen lg:place-content-center dark:bg-gray-900">
        <div
            class="mx-auto w-screen max-w-screen-xl px-4 py-16 sm:px-6 sm:py-20 md:grid md:grid-cols-2 md:items-center md:gap-4 lg:px-5 lg:py-10">
            <div class="max-w-prose text-left">
                <h1 class="text-4xl font-bold text-gray-900 sm:text-5xl dark:text-white">
                    {{ $event->title }}
                </h1>
                <h4 class="text-2xl font-bold text-gray-400   dark:text-white"> {{ $event->venue->name }}</h4>

                <p class="mt-4 text-base text-pretty text-gray-700 sm:text-lg/relaxed dark:text-gray-200">
                    {{ $event->description }}
                </p>

                <div class="mt-4 flex gap-4 sm:mt-6">
                    <a class="inline-block rounded border border-indigo-600 bg-indigo-600 px-5 py-3 font-medium text-white shadow-sm transition-colors hover:bg-indigo-700"
                        href="#">
                        Get Ticket
                    </a>

                    <a class="inline-block rounded border border-gray-200 px-5 py-3 font-medium text-gray-700 shadow-sm transition-colors hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800 dark:hover:text-white"
                        href="#">
                        Learn More
                    </a>
                </div>
            </div>

            <!-- Responsive Image -->
            <div class="mt-6 md:mt-0 sm:p-10">
                <img class="w-full h-auto max-w-full rounded-lg object-cover md:h-[400px] lg:h-[500px]"
                    src="  {{ $event->image }}" alt="Any Image Here" />
            </div>
        </div>
    </section>
@endsection
