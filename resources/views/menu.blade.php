@extends('layouts.guest')

@section('title', 'Меню')

@section('header')
<header class="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-stone-200">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20 gap-2">
                <!-- Logo -->
                <a href="{{ route('menu') }}" class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                    <img src="{{ asset('storage/images/logo.png') }}" alt="Barakad" class="h-10 sm:h-16 w-auto">
                </a>
                
                <!-- Table Badge -->
                <span x-show="tableNumber" x-cloak class="hidden sm:flex px-2 sm:px-3 py-1 sm:py-1.5 bg-brand-50 text-brand-700 rounded-full text-xs sm:text-sm font-semibold items-center gap-1 sm:gap-1.5 flex-shrink-0">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <span class="hidden md:inline">Стол</span> <span x-text="tableNumber"></span>
                </span>

                <!-- Cart Button -->
                <a href="{{ route('cart') }}" 
                   class="relative flex items-center gap-1 sm:gap-2 bg-brand-500 hover:bg-brand-600 active:bg-brand-700 text-white px-3 sm:px-4 py-2 sm:py-2.5 rounded-full transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg shadow-brand-500/25 min-w-[44px] min-h-[44px] sm:min-w-0 sm:min-h-0">
                    <svg class="w-5 h-5 sm:w-5 sm:h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="font-semibold text-sm sm:text-base hidden sm:inline" x-text="formatPrice(cartTotal)"></span>
                    <span x-show="cartCount > 0" x-cloak
                          class="absolute -top-1 -right-1 sm:-top-2 sm:-right-2 w-5 h-5 sm:w-6 sm:h-6 bg-white text-brand-600 text-xs font-bold rounded-full flex items-center justify-center shadow text-[10px] sm:text-xs"
                          x-text="cartCount"></span>
                </a>
            </div>
        </div>
    </header>
@endsection

@section('content')
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
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-8 gap-2">
                <!-- All categories link -->
                <a href="{{ route('menu', ['sort' => $currentSort]) }}"
                   class="group relative aspect-square rounded-xl overflow-hidden bg-gradient-to-br from-stone-800 to-stone-900 transition-all duration-300 hover:scale-105 hover:shadow-lg {{ !$selectedCategoryId ? 'ring-2 ring-brand-500 ring-offset-1' : '' }}">
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-2">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </div>
                        <span class="text-white font-semibold text-xs text-center">Все</span>
                    </div>
                </a>
                
                @foreach($categories as $category)
                <a href="{{ route('menu', ['category_id' => $category->id, 'sort' => $currentSort]) }}"
                   class="group relative aspect-square rounded-xl overflow-hidden transition-all duration-300 hover:scale-105 hover:shadow-lg {{ $selectedCategoryId == $category->id ? 'ring-2 ring-brand-500 ring-offset-1' : '' }}">
                    <img src="{{ $category->image }}" 
                         alt="{{ $category->name }}"
                         class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    <div class="absolute inset-0 flex items-end p-2">
                        <span class="text-white font-semibold text-xs">{{ $category->name }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </section>

        <!-- Filters & Sorting -->
        <section class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 mb-6 sm:mb-8">
            <div class="flex items-center gap-2">
                <span class="text-stone-600 text-xs sm:text-sm">Найдено:</span>
                <span class="font-bold text-stone-900 text-sm sm:text-base">{{ $products->total() }} блюд</span>
            </div>
            
            <div class="flex items-center gap-2 sm:gap-3">
                <span class="text-stone-600 text-xs sm:text-sm hidden sm:inline">Сортировка:</span>
                <div class="flex bg-white rounded-lg border border-stone-200 p-1 gap-1">
                    <a href="{{ route('menu', ['category_id' => $selectedCategoryId]) }}"
                       class="px-2 sm:px-3 py-2 sm:py-1.5 rounded-md text-xs sm:text-sm font-medium transition-colors touch-manipulation min-h-[44px] sm:min-h-0 flex items-center justify-center {{ !$currentSort ? 'bg-brand-500 text-white' : 'text-stone-600 hover:bg-stone-100 active:bg-stone-200' }}">
                        <span class="hidden sm:inline">Без сортировки</span>
                        <span class="sm:hidden">Все</span>
                    </a>
                    <a href="{{ route('menu', ['category_id' => $selectedCategoryId, 'sort' => 'asc']) }}"
                       class="px-2 sm:px-3 py-2 sm:py-1.5 rounded-md text-xs sm:text-sm font-medium transition-colors flex items-center justify-center gap-1 touch-manipulation min-h-[44px] sm:min-h-0 {{ $currentSort === 'asc' ? 'bg-brand-500 text-white' : 'text-stone-600 hover:bg-stone-100 active:bg-stone-200' }}">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                        </svg>
                        <span class="hidden sm:inline">Дешевле</span>
                        <span class="sm:hidden">↑</span>
                    </a>
                    <a href="{{ route('menu', ['category_id' => $selectedCategoryId, 'sort' => 'desc']) }}"
                       class="px-2 sm:px-3 py-2 sm:py-1.5 rounded-md text-xs sm:text-sm font-medium transition-colors flex items-center justify-center gap-1 touch-manipulation min-h-[44px] sm:min-h-0 {{ $currentSort === 'desc' ? 'bg-brand-500 text-white' : 'text-stone-600 hover:bg-stone-100 active:bg-stone-200' }}">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
                        </svg>
                        <span class="hidden sm:inline">Дороже</span>
                        <span class="sm:hidden">↓</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Products Grid -->
        @if($products->count() > 0)
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
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
                <div class="p-4 sm:p-5">
                    <h3 class="font-bold text-base sm:text-lg text-stone-900 mb-2">{{ $product->name }}</h3>
                    <p class="text-stone-500 text-xs sm:text-sm mb-3 sm:mb-4 line-clamp-2">{{ $product->description }}</p>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <span class="text-xl sm:text-2xl font-bold text-brand-600">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
                        
                        <!-- Add to cart controls -->
                        <div x-show="!getCartItem(productId)" x-cloak class="w-full sm:w-auto">
                            <button @click="addToCart({ id: {{ $product->id }}, name: '{{ $product->name }}', price: {{ $product->price }}, image: '{{ $product->image }}' })"
                                    class="w-full sm:w-auto bg-brand-500 hover:bg-brand-600 active:bg-brand-700 text-white px-4 sm:px-4 py-3 sm:py-2 rounded-xl font-semibold transition-all hover:scale-105 active:scale-95 flex items-center justify-center gap-2 min-h-[44px] touch-manipulation">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <span>В корзину</span>
                            </button>
                        </div>
                        
                        <div x-show="getCartItem(productId)" x-cloak
                             class="flex items-center justify-center sm:justify-start gap-2 bg-stone-100 rounded-xl p-1 w-full sm:w-auto">
                            <button @click="decrementQuantity(productId)"
                                    class="w-10 h-10 sm:w-8 sm:h-8 flex items-center justify-center rounded-lg bg-white hover:bg-brand-50 active:bg-brand-100 text-brand-600 transition-colors touch-manipulation min-w-[44px] min-h-[44px] sm:min-w-[32px] sm:min-h-[32px]">
                                <svg class="w-5 h-5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </button>
                            <span class="w-10 sm:w-8 text-center font-bold text-stone-900 text-base sm:text-sm" 
                                  x-text="getCartItem(productId)?.quantity || 0"></span>
                            <button @click="incrementQuantity(productId)"
                                    class="w-10 h-10 sm:w-8 sm:h-8 flex items-center justify-center rounded-lg bg-white hover:bg-brand-50 active:bg-brand-100 text-brand-600 transition-colors touch-manipulation min-w-[44px] min-h-[44px] sm:min-w-[32px] sm:min-h-[32px]">
                                <svg class="w-5 h-5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
@endsection


@section('footer')
<footer class="bg-stone-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <p class="text-stone-200 text-sm">
                    © <span id="hijri-year"></span> (@php echo date('Y'); @endphp) Barakad. Все права защищены.</p>
                    <script>
                        const hijriYear = new Intl.DateTimeFormat('en-u-ca-islamic-umalqura', { year: 'numeric' }).format(Date.now());
                        document.getElementById('hijri-year').textContent = Number.parseInt(hijriYear);
                    </script>
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
         class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 bg-stone-900 text-white px-4 py-3 sm:px-6 sm:py-4 rounded-2xl shadow-2xl flex items-center gap-2 sm:gap-3 z-50 max-w-[calc(100vw-2rem)] sm:max-w-none">
        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <span x-text="toastMessage" class="font-medium"></span>
    </div>
@endsection

@push('footer-scripts')
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
@endpush
