@extends('events.layout.app')
@section('title', 'Events')
@section('content')
    <div class="container mx-auto p-25">
        <h1 class="text-2xl font-bold mb-4">Events</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
            @foreach ($events as $event)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                    <img src="{{ asset($event->image) }}" alt="{{ $event->title }}"
                        class="w-full h-48 object-cover rounded-t-lg mb-4">
                    <h2 class="text-xl font-semibold">{{ $event->title }}</h2>
                    <p class="text-gray-600 dark:text-gray-400">{{ $event->event_date }}</p>
                    <p class="mt-2">{{ $event->venue->name }}</p>
                    <a href="{{ route('events.show', $event->id) }}"
                        class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">View
                        Details</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Any additional JavaScript for the events page can go here
        });
    </script>
@endsection
