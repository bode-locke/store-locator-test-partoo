@props(['href'])

<a href="{{ $href ?? url()->previous() }}"
    {{ $attributes->merge(['class' => 'inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 mb-4']) }}>
    ← Retour
</a>
