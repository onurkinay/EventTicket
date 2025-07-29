@extends('events.layout.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">{{ $event->name }}</h1>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <img src="{{ asset($event->image) }}" alt="{{ $event->name }}" class="w-full h-48 object-cover rounded-t-lg mb-4">
            <p class="text-gray-600 dark:text-gray-400">{{ $event->event_date }}</p>
            <p class="mt-2">{{ $event->venue->name }}</p>
            <p class="mt-4">{{ $event->description }}</p>
            <a href="{{ route('events.index') }}"
                class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Back to
                Events</a>
        </div>
    </div>
@endsection
