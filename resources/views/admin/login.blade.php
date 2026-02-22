<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barakad — Вход в панель</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] } } }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen flex items-center justify-center font-sans p-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <img src="{{ asset('storage/images/logo.png') }}" alt="Barakad" class="h-16 w-auto mx-auto mb-4">
            <h1 class="text-2xl font-bold text-white">Barakad</h1>
            <p class="text-slate-400 mt-1">Панель управления</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10 shadow-2xl">
            <h2 class="text-xl font-semibold text-white mb-6">Вход</h2>
            
            @if($errors->any())
            <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4 mb-6">
                <p class="text-red-400 text-sm">{{ $errors->first() }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all"
                               placeholder="admin@barakad.local">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Пароль</label>
                        <input type="password" id="password" name="password" required
                               class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all"
                               placeholder="••••••••">
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                               class="w-4 h-4 bg-white/5 border-white/20 rounded text-amber-500 focus:ring-amber-500/20">
                        <label for="remember" class="ml-2 text-sm text-slate-400">Запомнить меня</label>
                    </div>
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white py-3 rounded-xl font-semibold transition-all hover:shadow-lg hover:shadow-orange-500/25 active:scale-[0.98]">
                        Войти
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

