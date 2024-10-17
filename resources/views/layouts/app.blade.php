<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DMS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Styles -->
    <style>
        /* Your existing styles */
        .alert-container {
            position: relative;
            z-index: 1000;
            margin-bottom: 1rem; /* Space below alert */
            width: auto; /* Allow alert to adjust width automatically */
            max-width: 800px; /* Increased maximum width */
            margin-left: auto; /* Center horizontally */
            margin-right: auto; /* Center horizontally */
        }
        .fade-out {
            opacity: 0;
            transition: opacity 1s ease-out;
        }
        .alert {
            display: flex; /* Align items horizontally */
            align-items: center; /* Center vertically */
            justify-content: space-between; /* Space between text and close button */
            padding: 0.75rem 1.25rem; /* Adjust padding for a clean look */
            border-radius: 0.5rem; /* More rounded corners for a stylish look */
            font-size: 1rem; /* Slightly larger font size */
        }
        .alert-success {
            background-color: #d4edda; /* Light green */
            color: #155724; /* Dark green text for contrast */
        }
        .alert-info {
            background-color: #cce5ff; /* Light blue */
            color: #004085; /* Dark blue text for contrast */
        }
        .alert-warning {
            background-color: #fff3cd; /* Light yellow */
            color: #856404; /* Dark yellow text for contrast */
        }
        .alert-danger {
            background-color: #f8d7da; /* Light red */
            color: #721c24; /* Dark red text for contrast */
        }
        .close {
            color: #155724; /* Dark green color for close button */
            opacity: 0.8; /* Slightly transparent */
        }
        .close:hover {
            opacity: 1; /* Fully opaque on hover */
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation Bar -->
        @include('layouts.navigation')

        <!-- Success Message -->
        @if(session('success'))
            <div id="success-message" class="alert alert-success alert-dismissible fade show alert-container" role="alert">
                <div>
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            </div>

            <script>
                // Set a timeout to hide the message after 3 seconds
                setTimeout(function() {
                    const successMessage = document.getElementById('success-message');
                    successMessage.classList.add('fade-out');

                    // Remove the message from the DOM after fading out
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 1000); // Matches the CSS transition duration
                }, 3000);
            </script>
        @endif

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-xl font-bold text-gray-900 dark:text-gray-200">{{ $header }}</h1>
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-grow container mx-auto">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="text-center py-4">
            <p class="text-sm">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
