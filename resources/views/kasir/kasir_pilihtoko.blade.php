<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    <!-- Dynamic Favicon -->
    @php
    $appName = config('app.name', 'App');
    $initials = collect(explode(' ', $appName))
    ->map(fn($word) => strtoupper(substr($word, 0, 1)))
    ->take(3)
    ->implode('');
    @endphp
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,
        %3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E
            %3Crect width='100' height='100' rx='20' fill='%232563eb'/%3E
            %3Ctext x='50' y='50' text-anchor='middle' dy='0.35em' font-family='Arial, sans-serif' font-size='45' font-weight='bold' fill='white'%3E{{ $initials }}%3C/text%3E
        %3C/svg%3E">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- FontAwesome CDN for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        sidebar: {
                            DEFAULT: '#ffffff',
                            foreground: '#1f2937'
                        }
                    }
                }
            }
        }
    </script>

    <!-- Custom Styles -->
    <style>
        .sidebar-transition {
            transition: width 0.3s ease;
        }

        .content-transition {
            transition: margin-left 0.3s ease;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4b5563;
        }

        .dark .bg-sidebar {
            background-color: #1f2937;
        }

        .dark .text-sidebar-foreground {
            color: #f3f4f6;
        }
    </style>

    <script>
        window.setAppearance = function(appearance) {
            let setDark = () => document.documentElement.classList.add('dark')
            let setLight = () => document.documentElement.classList.remove('dark')
            let setButtons = (appearance) => {
                document.querySelectorAll('button[onclick^="setAppearance"]').forEach((button) => {
                    button.setAttribute('aria-pressed', String(appearance === button.value))
                })
            }
            if (appearance === 'system') {
                let media = window.matchMedia('(prefers-color-scheme: dark)')
                window.localStorage.removeItem('appearance')
                media.matches ? setDark() : setLight()
            } else if (appearance === 'dark') {
                window.localStorage.setItem('appearance', 'dark')
                setDark()
            } else if (appearance === 'light') {
                window.localStorage.setItem('appearance', 'light')
                setLight()
            }
            if (document.readyState === 'complete') {
                setButtons(appearance)
            } else {
                document.addEventListener("DOMContentLoaded", () => setButtons(appearance))
            }
        }
        window.setAppearance(
            "{{ auth()->user()->theme_preference ?? '' }}" ||
            window.localStorage.getItem('appearance') ||
            'system'
        )
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex flex-col">
    <main class="flex-1 flex flex-col overflow-auto bg-gray-100 dark:bg-gray-900 content-transition p-6 h-full">
        <div class="mb-6 flex items-center text-sm">
            <a href="{{ route('dashboard') }}"
                class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Dashboard') }}</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-500 dark:text-gray-400">{{ __('Cashier') }}</span>
        </div>

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Pilih Toko') }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('') }}</p>
        </div>

        <div class="container">
            <h2>Pilih Toko untuk Kasir</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($tokos as $toko)
                <div class="col-lg-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 text-gray-800 dark:text-gray-100">
                    <div class="card">
                        <div class="card-body">
                            <h5>{{ $toko->name }}</h5>
                            <p>{{ $toko->alamat }}</p>
                            <form action="{{ route('kasir.kasir_simpantoko') }}" method="POST">
                                @csrf
                                <input type="hidden" name="toko_id" value="{{ $toko->id }}">
                                <button type="submit" class=" w-100 flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                                    Pilih Toko Ini
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>

</body>