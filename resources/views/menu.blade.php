<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Barakad — Меню</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
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
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-stone-50 font-sans antialiased" x-data="cartApp()">
    
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-stone-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="{{ route('menu') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-brand-500 to-brand-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-stone-900">Barakad</span>
                </a>
                
                <!-- Table Badge -->
                <span x-show="tableNumber" x-cloak class="px-3 py-1.5 bg-brand-50 text-brand-700 rounded-full text-sm font-semibold flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Стол <span x-text="tableNumber"></span>
                </span>

                <!-- Cart Button -->
                <a href="{{ route('cart') }}" 
                   class="relative flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-full transition-all duration-200 hover:scale-105 shadow-lg shadow-brand-500/25">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="font-semibold" x-text="formatPrice(cartTotal)"></span>
                    <span x-show="cartCount > 0" x-cloak
                          class="absolute -top-2 -right-2 w-6 h-6 bg-white text-brand-600 text-xs font-bold rounded-full flex items-center justify-center shadow"
                          x-text="cartCount"></span>
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Hero Section -->
        <section class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-stone-900 mb-4">
                Вкусная еда <span class="text-brand-500">доставка</span>
            </h1>
            <p class="text-lg text-stone-600 max-w-2xl mx-auto">
                Выберите любимые блюда из нашего меню и закажите их на стол или на вынос
            </p>
        </section>

        <!-- Categories Grid -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold text-stone-900 mb-6">Категории</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <!-- All categories link -->
                <a href="{{ route('menu', ['sort' => $currentSort]) }}"
                   class="group relative aspect-square rounded-2xl overflow-hidden bg-gradient-to-br from-stone-800 to-stone-900 transition-all duration-300 hover:scale-105 hover:shadow-xl {{ !$selectedCategoryId ? 'ring-2 ring-brand-500 ring-offset-2' : '' }}">
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-4">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </div>
                        <span class="text-white font-semibold text-sm text-center">Все</span>
                    </div>
                </a>
                
                @foreach($categories as $category)
                <a href="{{ route('menu', ['category_id' => $category->id, 'sort' => $currentSort]) }}"
                   class="group relative aspect-square rounded-2xl overflow-hidden transition-all duration-300 hover:scale-105 hover:shadow-xl {{ $selectedCategoryId == $category->id ? 'ring-2 ring-brand-500 ring-offset-2' : '' }}">
                    <img src="{{ $category->image }}" 
                         alt="{{ $category->name }}"
                         class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    <div class="absolute inset-0 flex items-end p-4">
                        <span class="text-white font-semibold text-sm">{{ $category->name }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </section>

        <!-- Filters & Sorting -->
        <section class="flex flex-wrap items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-2">
                <span class="text-stone-600 text-sm">Найдено:</span>
                <span class="font-bold text-stone-900">{{ $products->total() }} блюд</span>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="text-stone-600 text-sm hidden sm:inline">Сортировка:</span>
                <div class="flex bg-white rounded-lg border border-stone-200 p-1">
                    <a href="{{ route('menu', ['category_id' => $selectedCategoryId]) }}"
                       class="px-3 py-1.5 rounded-md text-sm font-medium transition-colors {{ !$currentSort ? 'bg-brand-500 text-white' : 'text-stone-600 hover:bg-stone-100' }}">
                        Без сортировки
                    </a>
                    <a href="{{ route('menu', ['category_id' => $selectedCategoryId, 'sort' => 'asc']) }}"
                       class="px-3 py-1.5 rounded-md text-sm font-medium transition-colors flex items-center gap-1 {{ $currentSort === 'asc' ? 'bg-brand-500 text-white' : 'text-stone-600 hover:bg-stone-100' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                        </svg>
                        Дешевле
                    </a>
                    <a href="{{ route('menu', ['category_id' => $selectedCategoryId, 'sort' => 'desc']) }}"
                       class="px-3 py-1.5 rounded-md text-sm font-medium transition-colors flex items-center gap-1 {{ $currentSort === 'desc' ? 'bg-brand-500 text-white' : 'text-stone-600 hover:bg-stone-100' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
                        </svg>
                        Дороже
                    </a>
                </div>
            </div>
        </section>

        <!-- Products Grid -->
        @if($products->count() > 0)
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
            <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group"
                     x-data="{ productId: {{ $product->id }} }">
                <div class="relative aspect-[4/3] overflow-hidden">
                    <img src="{{ $product->image }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute top-3 left-3">
                        <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-semibold text-stone-700">
                            {{ $product->category->name }}
                        </span>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-stone-900 mb-2">{{ $product->name }}</h3>
                    <p class="text-stone-500 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-brand-600">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
                        
                        <!-- Add to cart controls -->
                        <div x-show="!getCartItem(productId)" x-cloak>
                            <button @click="addToCart({ id: {{ $product->id }}, name: '{{ $product->name }}', price: {{ $product->price }}, image: '{{ $product->image }}' })"
                                    class="bg-brand-500 hover:bg-brand-600 text-white px-4 py-2 rounded-xl font-semibold transition-all hover:scale-105 active:scale-95 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                В корзину
                            </button>
                        </div>
                        
                        <div x-show="getCartItem(productId)" x-cloak
                             class="flex items-center gap-2 bg-stone-100 rounded-xl p-1">
                            <button @click="decrementQuantity(productId)"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-white hover:bg-brand-50 text-brand-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </button>
                            <span class="w-8 text-center font-bold text-stone-900" 
                                  x-text="getCartItem(productId)?.quantity || 0"></span>
                            <button @click="incrementQuantity(productId)"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-white hover:bg-brand-50 text-brand-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </section>

        <!-- Pagination -->
        @if($products->hasPages())
        <nav class="mt-12 flex justify-center">
            <div class="flex items-center gap-2">
                {{-- Previous Page Link --}}
                @if($products->onFirstPage())
                    <span class="px-4 py-2 rounded-lg bg-stone-100 text-stone-400 cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </span>
                @else
                    <a href="{{ $products->previousPageUrl() }}" class="px-4 py-2 rounded-lg bg-white border border-stone-200 text-stone-700 hover:bg-stone-50 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @if($page == $products->currentPage())
                        <span class="px-4 py-2 rounded-lg bg-brand-500 text-white font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-4 py-2 rounded-lg bg-white border border-stone-200 text-stone-700 hover:bg-stone-50 transition-colors font-medium">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="px-4 py-2 rounded-lg bg-white border border-stone-200 text-stone-700 hover:bg-stone-50 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <span class="px-4 py-2 rounded-lg bg-stone-100 text-stone-400 cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                @endif
            </div>
        </nav>
        @endif

        @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-stone-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-stone-900 mb-2">Ничего не найдено</h3>
            <p class="text-stone-500">В этой категории пока нет блюд</p>
        </div>
        @endif

    </main>

    <!-- Footer -->
    <footer class="bg-stone-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold">Barakad</span>
                </div>
                <p class="text-stone-400 text-sm">© 2026 Barakad. Все права защищены.</p>
            </div>
        </div>
    </footer>

    <!-- Toast Notification -->
    <div x-show="showToast" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed bottom-6 right-6 bg-stone-900 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 z-50">
        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <span x-text="toastMessage" class="font-medium"></span>
    </div>

<script>
// Save table number from QR code URL
(function() {
    const params = new URLSearchParams(window.location.search);
    if (params.has('table')) {
        localStorage.setItem('barakad_table', params.get('table'));
    }
})();

function cartApp() {
    return {
        cart: JSON.parse(localStorage.getItem('barakad_cart') || '[]'),
        tableNumber: localStorage.getItem('barakad_table'),
        showToast: false,
        toastMessage: '',
        
        get cartTotal() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },
        
        get cartCount() {
            return this.cart.reduce((sum, item) => sum + item.quantity, 0);
        },
        
        getCartItem(productId) {
            return this.cart.find(item => item.product_id === productId);
        },
        
        addToCart(product) {
            const existing = this.getCartItem(product.id);
            if (existing) {
                existing.quantity++;
            } else {
                this.cart.push({
                    product_id: product.id,
                    name: product.name,
                    price: product.price,
                    image: product.image,
                    quantity: 1
                });
            }
            this.saveCart();
            this.showNotification('Добавлено в корзину');
        },
        
        incrementQuantity(productId) {
            const item = this.getCartItem(productId);
            if (item) {
                item.quantity++;
                this.saveCart();
            }
        },
        
        decrementQuantity(productId) {
            const item = this.getCartItem(productId);
            if (item) {
                if (item.quantity > 1) {
                    item.quantity--;
                } else {
                    this.cart = this.cart.filter(i => i.product_id !== productId);
                }
                this.saveCart();
            }
        },
        
        saveCart() {
            localStorage.setItem('barakad_cart', JSON.stringify(this.cart));
        },
        
        formatPrice(price) {
            return new Intl.NumberFormat('ru-RU', {
                style: 'currency',
                currency: 'RUB',
                minimumFractionDigits: 0
            }).format(price);
        },
        
        showNotification(message) {
            this.toastMessage = message;
            this.showToast = true;
            setTimeout(() => {
                this.showToast = false;
            }, 2000);
        }
    }
}
</script>
</body>
</html>
