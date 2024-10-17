<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        /* Navigation Bar Styles */
        .navbar {
            background-color: #007BFF; /* Blue color */
            padding: 15px;
            color: white;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: white;
            font-size: 1.5rem;
        }
        .navbar-brand i {
            margin-right: 10px;
        }
        .navbar-links {
            display: flex;
            justify-content: flex-end;
            flex-grow: 1;
        }
        .navbar-links a {
            color: white;
            margin-left: 15px;
            text-decoration: none;
            font-weight: 600;
            border: 2px solid transparent;
            padding: 5px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .navbar-links a:hover {
            background-color: white;
            color: #007BFF; /* Blue text on hover */
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation Bar -->
        <nav class="navbar d-flex align-items-center">
            <div class="navbar-brand">
                <!-- DMS Icon and Name -->
                <i class="fas fa-folder"></i> <!-- FontAwesome icon (change if needed) -->
                DMS
            </div>

            <div class="navbar-links">
                @if (Route::has('login'))
                    @auth
                        @if (auth()->user()->role == 1) <!-- Assuming role 1 is Admin -->
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        @elseif (auth()->user()->role == 2) <!-- Assuming role 2 is User -->
                            <a href="{{ route('user.dashboard') }}">Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow container mx-auto text-center">
            <h1 class="text-4xl font-bold my-12">Welcome to DMS</h1>
        </main>

        <!-- Footer -->
        <footer class="py-16 text-center text-sm text-black">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </footer>
    </div>
</body>
</html>