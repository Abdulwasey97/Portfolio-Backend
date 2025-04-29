<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script>
        Livewire.on('errorOccurred', () => {
            alert('Login failed. Please check your credentials.');
            // You can replace this with a SweetAlert or custom toast.
        });
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - My Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom-login.css') }}">
    @livewireStyles
</head>
<body>
    <livewire:login-form />
    @livewireScripts
</body>
</html>
