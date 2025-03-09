<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GuessCity') }}</title>
    {{-- <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}" async defer></script>
    <style>
        .zoom-controls {
            position: absolute;
            bottom: 50px;
            left: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            display: none;
        }
        .zoom-btn {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            display: none;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased" style="background-image: url('/images/captura.png'); background-size: cover;">
    <div id="street-view" class="h-screen w-full">
        {{ $slot }}
    </div>
    @livewireScripts
</body>

</html>
