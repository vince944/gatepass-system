<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gate Pass Management - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen overflow-x-hidden bg-cover bg-center bg-no-repeat"
      style="background-image: linear-gradient(rgba(20,58,130,0.55), rgba(20,58,130,0.55)), url('/images/login_bg.png');">

    <div class="flex min-h-screen w-full items-center justify-center px-4 py-4 sm:px-6 sm:py-6 lg:px-8">
        <div class="w-full max-w-md rounded-2xl bg-white/95 shadow-2xl sm:rounded-[22px]
                    px-4 py-5 sm:px-6 sm:py-6 lg:px-7 lg:py-7">

            <div class="flex justify-center">
                <img src="/images/dap_logo.png" alt="DAP Logo" class="h-auto w-14 sm:w-16 md:w-20">
            </div>

            <div class="mt-3 space-y-1.5 text-center sm:mt-4">
                <h1 class="text-xl font-bold leading-tight text-blue-900 sm:text-2xl">
                    Gate Pass Management
                </h1>
                <p class="text-xs text-gray-500 sm:text-sm">
                    Sign in to access your dashboard
                </p>
            </div>

            @if(session('success') || session('error') || $errors->any())
                <div class="mt-4 space-y-3 sm:mt-5">
                    @if(session('success'))
                        <div class="rounded-lg border border-emerald-300 bg-emerald-50 px-3 py-2.5 text-sm text-emerald-800 sm:px-4 sm:py-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="rounded-lg border border-red-300 bg-red-100 px-3 py-2.5 text-sm text-red-700 sm:px-4 sm:py-3">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="rounded-lg border border-red-300 bg-red-100 px-3 py-2.5 text-sm text-red-700 sm:px-4 sm:py-3">
                            {{ $errors->first() }}
                        </div>
                    @endif
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="mt-4 space-y-3.5 sm:mt-5 sm:space-y-4">
                @csrf

                <div class="space-y-1.5">
                    <label for="email" class="block text-sm font-semibold text-black sm:text-base">
                        Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="user@dap.com"
                        required
                        class="w-full rounded-xl border border-gray-200 bg-gray-100 px-3 py-2.5 text-sm text-gray-700
                               placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-700
                               sm:px-4 sm:py-3 sm:text-base"
                    >
                </div>

                <div class="space-y-1.5">
                    <label for="password" class="block text-sm font-semibold text-black sm:text-base">
                        Password
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full rounded-xl border border-gray-200 bg-gray-100 px-3 py-2.5 text-sm text-gray-700
                               focus:outline-none focus:ring-2 focus:ring-blue-700
                               sm:px-4 sm:py-3 sm:text-base"
                    >
                    <div class="text-right">
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-900 hover:underline">
                            Forgot Password?
                        </a>
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-amber-400 py-2.5 text-base font-bold text-blue-900
                           transition duration-200 hover:bg-amber-500 sm:py-3 sm:text-lg">
                    → Sign In
                </button>
            </form>

            <!--<p class="mt-4 text-center text-xs text-gray-500 sm:mt-5 sm:text-sm">
                Don't have an account?
                <a href="{{ url('/register') }}" class="font-semibold text-blue-900 hover:underline">
                    Sign up as Employee
                </a>
            </p>-->

            <div class="mt-4 rounded-lg border border-blue-200 bg-blue-100/70 p-4">
                <h2 class="text-sm font-semibold text-blue-800">
                    Instructions
                </h2>
                <p class="mt-2 text-sm leading-relaxed text-blue-700 break-words">
                    Don't have an account? Contact your administrator to request an account.
                </p>
            </div>
        </div>
    </div>

</body>
</html>
