@extends('layout')

@section('content')
<div class="max-w-4xl mx-auto p-8 bg-gray-50 rounded-lg mt-12 shadow-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Trouver un magasin</h1>

    {{-- Erreurs globales --}}
    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="GET" action="{{ route('results') }}" class="space-y-6">

        {{-- Coordonnées --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Latitude nord</label>
                <input type="search" name="n" value="{{ old('n') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
                @error('n') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Latitude sud</label>
                <input type="search" name="s" value="{{ old('s') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
                @error('s') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Longitude ouest</label>
                <input type="search" name="w" value="{{ old('w') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
                @error('w') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Longitude est</label>
                <input type="search" name="e" value="{{ old('e') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none" />
                @error('e') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Services --}}
        <div>
            <label class="block mb-1 font-semibold text-gray-700">Services</label>
            <select multiple name="services[]" class="w-full border border-gray-300 rounded-lg h-32 px-3 py-2 focus:ring-2 focus:ring-blue-400">
                @foreach($services as $service)
                    <option value="{{ $service->id }}"
                        {{ collect(old('services'))->contains($service->id) ? 'selected' : '' }}>
                        {{ $service->name }}
                    </option>
                @endforeach
            </select>
            @error('services') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Operator --}}
        <div>
            <label class="block mb-1 font-semibold text-gray-700">Opérateur</label>
            <select name="operator" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400">
                <option value="OR" {{ old('operator') === 'OR' ? 'selected' : '' }}>OR</option>
                <option value="AND" {{ old('operator') === 'AND' ? 'selected' : '' }}>AND</option>
            </select>
            @error('operator') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Submit --}}
        <div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition">
                Rechercher
            </button>
        </div>
    </form>
</div>
@endsection
