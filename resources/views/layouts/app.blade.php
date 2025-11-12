<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @hasSection('title')
            @yield('title') · {{ config('app.name') }}
        @else
            {{ config('app.name') }} · Cadastro de Pessoas
        @endif
    </title>

    <meta name="description" content="@yield('meta_description', 'Sistema de cadastro de pessoas em Laravel e Livewire, com busca, paginação e formulários responsivos.')">
    <meta name="robots" content="index,follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <main id="container mx-auto p-6">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
