<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('header-meta')
    <title>Barakad — @yield('title', 'Главная')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @stack('header-links')

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Montserrat', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#fef7ee',
                            100: '#fdedd6',
                            200: '#fad7ac',
                            300: '#f6ba77',
                            400: '#f19340',
                            500: '#ee751a',
                            600: '#df5b10',
                            700: '#b9440f',
                            800: '#933614',
                            900: '#772f14',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('header-scripts')

    @stack('header-styles')
    <style>
        [x-cloak] { display: none !important; }
        
        /* Mobile touch improvements */
        .touch-manipulation {
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
        }
        
        /* Prevent text selection on buttons */
        button, a.button {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        
        /* Better scrolling on mobile */
        @media (max-width: 640px) {
            html {
                -webkit-overflow-scrolling: touch;
            }
        }
    </style>
</head>
<body class="bg-stone-50 font-sans antialiased min-h-screen flex flex-col" x-data="cartApp()">
    @yield('header')
    @yield('content')
    @yield('footer')
    
    <!-- Footer -->
    <footer class="bg-stone-900 text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-stone-200 text-sm">
                    © <span id="hijri-year"></span> (@php echo date('Y'); @endphp) Barakad. Все права защищены.</p>
                    <script>
                        const hijriYear = new Intl.DateTimeFormat('en-u-ca-islamic-umalqura', { year: 'numeric' }).format(Date.now());
                        document.getElementById('hijri-year').textContent = Number.parseInt(hijriYear);
                    </script>
                <div class="flex flex-col md:flex-row items-center gap-2 md:gap-4 text-sm text-white">
                    <span>Адрес: г. Владикавказ, ул. Нальчикская 4</span>
                    <span class="hidden md:inline">•</span>
                    <span>ИНН: 150801082507</span>
                    <span class="hidden md:inline">•</span>
                    <span>ОГРН: 325150000046942</span>
                </div>
            </div>
        </div>
    </footer>
    
    @stack('footer-scripts')
</body>
</html>
