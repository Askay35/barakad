@extends('layouts.guest')

@section('title', 'Корзина')

@section('header')
<header class="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-stone-200">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">
        <div class="flex items-center justify-between h-14 sm:h-16 gap-2">
            <!-- Logo -->
            <a href="{{ route('menu') }}" class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Barakad" class="h-10 sm:h-16 w-auto">
            </a>
            
            <!-- Back to menu -->
            <a href="{{ route('menu') }}" 
               class="flex items-center gap-1 sm:gap-2 text-stone-600 hover:text-brand-600 active:text-brand-700 font-medium transition-colors text-sm sm:text-base touch-manipulation min-h-[44px] sm:min-h-0 px-2 sm:px-0">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="hidden sm:inline">Вернуться в меню</span>
                <span class="sm:hidden">Назад</span>
            </a>
        </div>
    </div>
</header>
@endsection

@section('content')
<main class="flex-1 max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-8 w-full">
    
    <!-- Page Title -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-stone-900">
            Корзина
            <span class="text-stone-400 font-normal text-lg sm:text-xl ml-2" x-show="cart.length > 0" x-text="'(' + cartCount + ' шт.)'"></span>
        </h1>
        <span x-show="tableNumber" x-cloak class="px-2 sm:px-3 py-1 sm:py-1.5 bg-brand-50 text-brand-700 rounded-full text-xs sm:text-sm font-semibold flex items-center gap-1 sm:gap-1.5 self-start sm:self-auto">
            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
            <span class="hidden sm:inline">Стол</span> <span x-text="tableNumber"></span>
        </span>
    </div>

    <!-- Empty Cart State -->
    <div x-show="cart.length === 0" x-cloak class="text-center py-16">
        <div class="w-32 h-32 bg-stone-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-16 h-16 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-stone-900 mb-3">Корзина пуста</h2>
        <p class="text-stone-500 mb-8">Добавьте что-нибудь вкусное из нашего меню</p>
        <a href="{{ route('menu') }}" 
           class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 text-white px-6 py-3 rounded-xl font-semibold transition-all hover:scale-105">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
            Перейти в меню
        </a>
    </div>

    <!-- Cart Content -->
    <div x-show="cart.length > 0" x-cloak class="flex flex-col lg:grid lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
        
        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-3 sm:space-y-4 order-2 lg:order-1">
            <template x-for="(item, index) in cart" :key="item.product_id">
                <div class="bg-white rounded-xl sm:rounded-2xl p-3 sm:p-4 lg:p-6 shadow-sm flex flex-col sm:flex-row gap-3 sm:gap-4 lg:gap-6">
                    <div class="flex gap-3 sm:gap-4 lg:gap-6 flex-1 min-w-0">
                        <img :src="item.image" 
                             :alt="item.name"
                             class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 rounded-xl object-cover flex-shrink-0">
                        
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-base sm:text-lg text-stone-900 truncate" x-text="item.name"></h3>
                            <p class="text-brand-600 font-semibold mt-1 text-sm sm:text-base" x-text="formatPrice(item.price)"></p>
                            <!-- Item Total on mobile -->
                            <div class="sm:hidden mt-2">
                                <span class="text-base font-bold text-stone-900" x-text="formatPrice(item.price * item.quantity)"></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quantity Controls -->
                    <div class="flex items-center justify-between sm:justify-end gap-3">
                        <div class="flex items-center gap-1 sm:gap-2 bg-stone-100 rounded-xl p-1">
                            <button @click="decrementQuantity(index)"
                                    class="w-10 h-10 sm:w-9 sm:h-9 flex items-center justify-center rounded-lg bg-white hover:bg-brand-50 active:bg-brand-100 text-brand-600 transition-colors shadow-sm touch-manipulation min-w-[44px] min-h-[44px] sm:min-w-[36px] sm:min-h-[36px]">
                                <svg class="w-5 h-5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </button>
                            <span class="w-10 sm:w-8 text-center font-bold text-stone-900 text-base sm:text-sm" x-text="item.quantity"></span>
                            <button @click="incrementQuantity(index)"
                                    class="w-10 h-10 sm:w-9 sm:h-9 flex items-center justify-center rounded-lg bg-white hover:bg-brand-50 active:bg-brand-100 text-brand-600 transition-colors shadow-sm touch-manipulation min-w-[44px] min-h-[44px] sm:min-w-[36px] sm:min-h-[36px]">
                                <svg class="w-5 h-5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </button>
                        </div>
                        
                        <button @click="removeItem(index)"
                                class="w-10 h-10 sm:w-9 sm:h-9 flex items-center justify-center rounded-lg text-stone-400 hover:text-red-500 active:text-red-600 hover:bg-red-50 active:bg-red-100 transition-colors touch-manipulation min-w-[44px] min-h-[44px] sm:min-w-[36px] sm:min-h-[36px]">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Item Total -->
                    <div class="hidden sm:block lg:text-right lg:min-w-[100px]">
                        <span class="text-base lg:text-lg font-bold text-stone-900" x-text="formatPrice(item.price * item.quantity)"></span>
                    </div>
                </div>
            </template>
            
            <!-- Clear Cart Button -->
            <button @click="clearCart()"
                    class="flex items-center gap-2 text-stone-500 hover:text-red-500 font-medium transition-colors mt-4">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Очистить корзину
            </button>
        </div>

        <!-- Order Form -->
        <div class="lg:col-span-1 order-1 lg:order-2">
            <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-sm lg:sticky lg:top-24">
                <h2 class="text-lg sm:text-xl font-bold text-stone-900 mb-4 sm:mb-6">Оформление заказа</h2>
                
                <!-- Payment Type -->
                <div class="mb-4 sm:mb-6">
                    <label class="block text-xs sm:text-sm font-semibold text-stone-700 mb-2 sm:mb-3">Способ оплаты</label>
                    <div class="grid grid-cols-2 gap-2 sm:gap-3">
                        @foreach($paymentTypes as $paymentType)
                        <label class="relative cursor-pointer">
                            <input type="radio" 
                                   name="payment_type" 
                                   value="{{ $paymentType->id }}"
                                   x-model="paymentTypeId"
                                   class="sr-only peer">
                            <div class="flex items-center justify-center gap-1 sm:gap-2 p-3 sm:p-4 rounded-xl border-2 border-stone-200 
                                        peer-checked:border-brand-500 peer-checked:bg-brand-50 transition-all touch-manipulation min-h-[44px] sm:min-h-0">
                                @if($paymentType->name === 'Наличные')
                                <svg class="w-5 h-5 text-stone-600 peer-checked:text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                @else
                                <svg class="w-5 h-5 text-stone-600 peer-checked:text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                @endif
                                <span class="font-medium text-stone-700 text-xs sm:text-sm">{{ $paymentType->name }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Comment -->
                <div class="mb-4 sm:mb-6">
                    <label for="comment" class="block text-xs sm:text-sm font-semibold text-stone-700 mb-2">Комментарий к заказу</label>
                    <textarea id="comment"
                              x-model="comment"
                              rows="3"
                              placeholder="Особые пожелания, аллергии, адрес доставки..."
                              class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-xl border border-stone-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all resize-none text-stone-900 placeholder-stone-400 text-sm sm:text-base"></textarea>
                </div>
                
                <!-- Totals -->
                <div class="border-t border-stone-200 pt-3 sm:pt-4 mb-4 sm:mb-6 space-y-2 sm:space-y-3">
                    <div class="flex justify-between text-stone-600 text-sm sm:text-base">
                        <span>Товары (<span x-text="cartCount"></span> шт.)</span>
                        <span x-text="formatPrice(cartTotal)"></span>
                    </div>
                    <div class="flex justify-between text-stone-600 text-sm sm:text-base">
                        <span>Доставка</span>
                        <span class="text-green-600 font-medium">Бесплатно</span>
                    </div>
                    <div class="flex justify-between text-lg sm:text-xl font-bold text-stone-900 pt-2 sm:pt-3 border-t border-stone-200">
                        <span>Итого</span>
                        <span class="text-brand-600" x-text="formatPrice(cartTotal)"></span>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <button @click="submitOrder()"
                        :disabled="isSubmitting || !paymentTypeId"
                        :class="isSubmitting || !paymentTypeId ? 'bg-stone-300 cursor-not-allowed' : 'bg-brand-500 hover:bg-brand-600 active:bg-brand-700 hover:scale-[1.02] active:scale-[0.98]'"
                        class="w-full text-white py-3 sm:py-4 rounded-xl font-bold text-base sm:text-lg transition-all flex items-center justify-center gap-2 touch-manipulation min-h-[44px] sm:min-h-0">
                    <template x-if="!isSubmitting">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Оформить заказ
                        </span>
                    </template>
                    <template x-if="isSubmitting">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Оформляем...
                        </span>
                    </template>
                </button>
            </div>
        </div>
    </div>
</main>

<!-- Success Modal -->
<div x-show="showSuccess" x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div class="bg-white rounded-2xl sm:rounded-3xl p-6 sm:p-8 max-w-md w-full text-center shadow-2xl mx-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h2 class="text-xl sm:text-2xl font-bold text-stone-900 mb-2">Заказ оформлен!</h2>
        <p class="text-stone-500 mb-2 text-sm sm:text-base">Номер вашего заказа:</p>
        <p class="text-2xl sm:text-3xl font-bold text-brand-600 mb-4 sm:mb-6" x-text="'#' + orderId"></p>
        <p class="text-stone-500 mb-6 sm:mb-8 text-sm sm:text-base">Мы начали готовить ваш заказ. Скоро он будет у вас!</p>
        <a href="{{ route('menu') }}" 
           class="inline-flex items-center gap-2 bg-brand-500 hover:bg-brand-600 active:bg-brand-700 text-white px-5 sm:px-6 py-3 rounded-xl font-semibold transition-all touch-manipulation min-h-[44px]">
            Вернуться в меню
        </a>
    </div>
</div>

<!-- Error Toast -->
<div x-show="showError" x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-4"
     class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 bg-red-600 text-white px-4 py-3 sm:px-6 sm:py-4 rounded-2xl shadow-2xl flex items-center gap-2 sm:gap-3 z-50 max-w-[calc(100vw-2rem)] sm:max-w-md">
    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </div>
    <span x-text="errorMessage" class="font-medium"></span>
</div>
@endsection

@push('footer-scripts')
<script>
function cartApp() {
    return {
        cart: JSON.parse(localStorage.getItem('barakad_cart') || '[]'),
        tableNumber: localStorage.getItem('barakad_table'),
        paymentTypeId: null,
        comment: '',
        isSubmitting: false,
        showSuccess: false,
        showError: false,
        errorMessage: '',
        orderId: null,
        
        get cartTotal() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },
        
        get cartCount() {
            return this.cart.reduce((sum, item) => sum + item.quantity, 0);
        },
        
        incrementQuantity(index) {
            this.cart[index].quantity++;
            this.saveCart();
        },
        
        decrementQuantity(index) {
            if (this.cart[index].quantity > 1) {
                this.cart[index].quantity--;
            } else {
                this.cart.splice(index, 1);
            }
            this.saveCart();
        },
        
        removeItem(index) {
            this.cart.splice(index, 1);
            this.saveCart();
        },
        
        clearCart() {
            if (confirm('Вы уверены, что хотите очистить корзину?')) {
                this.cart = [];
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
        
        async submitOrder() {
            if (!this.paymentTypeId) {
                this.showErrorMessage('Выберите способ оплаты');
                return;
            }
            
            if (this.cart.length === 0) {
                this.showErrorMessage('Корзина пуста');
                return;
            }
            
            this.isSubmitting = true;
            
            try {
                const response = await fetch('{{ route("order.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        items: this.cart,
                        payment_type_id: this.paymentTypeId,
                        comment: this.comment,
                        table: this.tableNumber ? parseInt(this.tableNumber) : null,
                    }),
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.orderId = data.order_id;
                    this.showSuccess = true;
                    this.cart = [];
                    this.saveCart();
                    this.comment = '';
                    this.paymentTypeId = null;
                } else {
                    this.showErrorMessage(data.message || 'Произошла ошибка при оформлении заказа');
                }
            } catch (error) {
                console.error('Order error:', error);
                this.showErrorMessage('Не удалось оформить заказ. Попробуйте позже.');
            } finally {
                this.isSubmitting = false;
            }
        },
        
        showErrorMessage(message) {
            this.errorMessage = message;
            this.showError = true;
            setTimeout(() => {
                this.showError = false;
            }, 4000);
        }
    }
}
</script>
@endpush
