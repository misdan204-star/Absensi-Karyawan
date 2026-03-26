<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

        <!-- Tailwind CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- AlpineJS CDN -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <style>
            body { 
                font-family: 'Outfit', sans-serif; 
                background: #020617; 
                color: white;
                background-image: 
                    radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.15) 0px, transparent 50%),
                    radial-gradient(at 100% 100%, rgba(124, 58, 237, 0.15) 0px, transparent 50%);
            }
            .glass { 
                background: rgba(255, 255, 255, 0.02); 
                backdrop-filter: blur(20px); 
                border: 1px solid rgba(255, 255, 255, 0.05); 
            }
        </style>
    </head>
    <body class="antialiased selection:bg-indigo-500/30">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-10">
                <a href="/">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl flex items-center justify-center shadow-2xl shadow-indigo-500/20 rotate-3 transition hover:rotate-0 duration-500">
                        <span class="text-3xl">📡</span>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-10 py-12 glass shadow-2xl sm:rounded-[40px] overflow-hidden">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
