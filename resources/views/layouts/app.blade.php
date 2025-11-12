<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>
<body class="bg-zinc-100 text-zinc-800">
  <main class="container mx-auto p-6">
    {{ $slot }}  {{-- <- ESSENCIAL para Livewire v3 --}}
  </main>

  @livewireScripts
</body>
</html>
