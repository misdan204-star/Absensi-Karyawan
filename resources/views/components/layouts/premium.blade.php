<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --bg-dark: #050510;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at top left, #1e1b4b, var(--bg-dark));
            min-height: 100vh;
            color: white;
            overflow-x: hidden;
        }
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased" x-data="{ sidebarOpen: false }">
    <!-- Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[110] bg-black/60 backdrop-blur-sm md:hidden" 
         @click="sidebarOpen = false"></div>

    <!-- Sidebar Component -->
    <x-sidebar />

    <!-- Main Content Wrapper -->
    <div class="md:ml-[280px] min-h-screen flex flex-col">
        <!-- Top Bar (Optional, can be hidden per page) -->
        @if(!isset($hideTopBar))
        <header class="sticky top-0 z-40 px-6 py-4 flex items-center justify-between border-b border-white/5 bg-[#050510]/40 backdrop-blur-xl md:px-10">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="md:hidden w-10 h-10 glass rounded-xl flex items-center justify-center text-indigo-400 hover:bg-indigo-500/10 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div>
                    <h2 class="text-lg font-bold text-white tracking-tight">{{ $headerTitle ?? 'Dashboard' }}</h2>
                    <p class="text-xs text-white/30 font-medium">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                @stack('top_actions')
            </div>
        </header>
        @endif

        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>

    <!-- Toast Layer -->
    <div id="toast-container" class="fixed top-6 right-6 z-[200] space-y-3 pointer-events-none"></div>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
