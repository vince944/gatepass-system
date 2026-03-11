<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gate Pass Management - Login</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-cover bg-center bg-no-repeat"
      style="background-image: linear-gradient(rgba(20,58,130,0.55), rgba(20,58,130,0.55)), url('/images/login_bg.png');">

    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 md:px-8 py-6">
        <div class="w-full max-w-[92%] sm:max-w-[480px] md:max-w-[540px] lg:max-w-[560px]
                    bg-white/95 rounded-[22px] sm:rounded-[26px] shadow-2xl
                    px-5 py-6 sm:px-7 sm:py-7 md:px-8 md:py-8">

            <div class="flex justify-center mb-2 sm:mb-3">
                <img src="/images/dap_logo.png" alt="DAP Logo" class="w-16 sm:w-20 md:w-24 h-auto">
            </div>

            <div class="text-center mb-5 sm:mb-6">
                <h1 class="text-[24px] sm:text-[34px] md:text-[38px] font-bold text-blue-900 leading-tight">
                    Gate Pass Management
                </h1>
                <p class="mt-2 text-gray-500 text-sm sm:text-base md:text-[18px]">
                    Sign in to access your dashboard
                </p>
            </div>

            @if(session('error'))
                <div class="mb-4 rounded-lg border border-red-300 bg-red-100 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-lg border border-red-300 bg-red-100 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="space-y-4 sm:space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-base sm:text-lg font-semibold text-black">
                        Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="user@dap.com"
                        required
                        class="w-full rounded-2xl border border-gray-200 bg-gray-100
                               px-4 py-3 sm:px-5 sm:py-3.5
                               text-sm sm:text-base text-gray-700 placeholder-gray-400
                               focus:outline-none focus:ring-2 focus:ring-blue-700"
                    >
                </div>

                <div>
                    <label for="password" class="mb-2 block text-base sm:text-lg font-semibold text-black">
                        Password
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full rounded-2xl border border-gray-200 bg-gray-100
                               px-4 py-3 sm:px-5 sm:py-3.5
                               text-sm sm:text-base text-gray-700
                               focus:outline-none focus:ring-2 focus:ring-blue-700"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full rounded-2xl bg-amber-400 py-3 sm:py-3.5
                           text-lg sm:text-2xl font-bold text-blue-900
                           transition duration-200 hover:bg-amber-500">
                    → Sign In
                </button>
            </form>

            <div class="relative my-5 sm:my-6">
                <div class="border-t border-gray-300"></div>
                <span class="absolute left-1/2 -translate-x-1/2 -top-3 bg-white px-3 text-[10px] sm:text-xs text-gray-500 uppercase whitespace-nowrap">
                    Demo Accounts
                </span>
            </div>

            <div class="rounded-2xl bg-gray-100 p-3 sm:p-4 text-xs sm:text-sm md:text-[15px] text-gray-800 space-y-2 break-words">
                <p><span class="font-bold">Employee:</span> employee@dap.com / employee123</p>
                <p><span class="font-bold">Admin:</span> admin@dap.com / admin123</p>
                <p><span class="font-bold">Guard:</span> guard@dap.com / guard123</p>
                <p><span class="font-bold">Admin Coordinator:</span> admincoordinator@dap.com / equipment123</p>
            </div>

            <p class="mt-5 sm:mt-6 text-center text-xs sm:text-sm md:text-base text-gray-500">
                Don't have an account?
                <a href="{{ url('/register') }}" class="font-semibold text-blue-900 hover:underline">
                    Sign up as Employee
                </a>
            </p>
        </div>
    </div>

</body>
</html>