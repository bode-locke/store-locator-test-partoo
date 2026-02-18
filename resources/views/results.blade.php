@extends('layout')

@section('content')
<div class="max-w-6xl mx-auto mt-12 space-y-6">
    <x-back-button href="{{ route('index') }}" />

    @if($stores->isEmpty())
        <p class="text-gray-700 text-lg text-center">Aucun magasin trouvé.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($stores as $store)
                <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $store->name }}</h2>
                    <p class="text-gray-600 mb-2">{{ $store->address }}, {{ $store->zipcode }} {{ $store->city }}</p>
                    <p class="text-gray-600 mb-2">Pays : {{ $store->country_code }}</p>

                    <div class="mb-2">
                        <span class="font-semibold text-gray-700">Services :</span>
                        <ul class="list-disc list-inside text-gray-600">
                            @foreach($store->services as $service)
                                <li>{{ $service->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <a href="{{ route('store.show', $store) }}"
                       class="inline-block mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Voir le magasin
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
