<html>

    @if (!app()->environment('testing'))
        @vite(['resources/css/app.css'])
    @endif


    <head>
        <title>Storeloc Test</title>
        <style>
            .form {
                display: flex;
                gap: 12px;
            }
            .bounds, .filters {
                display: flex;
                flex-direction: column;
                gap: 12px;
                justify-content: stretch;
            }

        </style>
    </head>
    <body>
        <div class="flex flex-col h-screen justify-between">
            {{-- Header --}}
            <x-header />

            {{-- Main content --}}
            <main class="py-6">
                @yield('content')
            </main>

            {{-- Footer --}}
            <x-footer />
        </div>
    </body>
</html>
