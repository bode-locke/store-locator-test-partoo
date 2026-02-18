@extends('layout')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md mt-6">

    <h1 class="text-2xl font-bold mb-4">{{ $store->name }}</h1>

    <p class="text-gray-700 mb-2"><strong>Adresse :</strong> {{ $store->address }}, {{ $store->zipcode }} {{ $store->city }}, {{ $store->country_code }}</p>

    <p class="text-gray-700 mb-2"><strong>Ouvert actuellement :</strong>
        @if($isOpen)
            <span class="text-green-600 font-semibold">Oui</span>
        @else
            <span class="text-red-600 font-semibold">Non</span>
        @endif
    </p>

    <div class="mb-2">
        <strong>Services :</strong>
        <ul class="list-disc ml-5 mt-1">
            @forelse($store->services as $service)
                <li>{{ $service->name }}</li>
            @empty
                <li>Aucun service</li>
            @endforelse
        </ul>
    </div>

    <div class="mt-4">
        <h2 class="text-xl font-semibold mb-2">Horaires</h2>
        <ul class="list-disc ml-5">
            @foreach(json_decode($store->hours, true) as $day => $intervals)
                <li><strong>{{ $day }}:</strong> {{ implode(', ', $intervals) }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
