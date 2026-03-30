<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — Gate Pass Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen overflow-x-hidden bg-cover bg-center bg-no-repeat"
      style="background-image: linear-gradient(rgba(20,58,130,0.55), rgba(20,58,130,0.55)), url('/images/login_bg.png');">

    <div class="flex min-h-screen w-full items-center justify-center px-4 py-4 sm:px-6 sm:py-6 lg:px-8">
        <div class="mx-auto w-full max-w-md rounded-xl border border-blue-300 bg-white p-6 shadow-lg sm:p-7">

            <div class="flex justify-center">
                <img src="/images/dap_logo.png" alt="DAP Logo" class="h-auto w-14 sm:w-16">
            </div>

            <div class="mt-4 text-center">
                <h1 class="text-xl font-bold text-blue-900 sm:text-2xl">Forgot Password</h1>
                <p class="mt-2 text-sm leading-relaxed text-gray-600">
                    Enter your email address and we'll send you a link to reset your password.
                </p>
            </div>

            @if (session('success'))
                <div class="mt-5 rounded-lg border border-emerald-300 bg-emerald-50 px-3 py-2.5 text-sm text-emerald-800 sm:px-4 sm:py-3">
                    {{ session('success') }}
                </div>
                <div class="mt-6 flex justify-center">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center rounded-xl border border-blue-900 px-4 py-2.5 text-sm font-semibold text-blue-900 transition hover:bg-blue-50">
                        Back to Login
                    </a>
                </div>
            @else
                @if ($errors->any())
                    <div class="mt-5 rounded-lg border border-red-300 bg-red-100 px-3 py-2.5 text-sm text-red-700 sm:px-4 sm:py-3">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-semibold text-gray-900">
                            Email Address
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            placeholder="you@dap.edu.ph"
                            required
                            autocomplete="email"
                            class="w-full rounded-xl border border-gray-200 bg-gray-100 px-3 py-2.5 text-sm text-gray-700 placeholder-gray-400
                                   focus:outline-none focus:ring-2 focus:ring-blue-700 sm:px-4 sm:py-3 sm:text-base @error('email') border-red-400 @enderror"
                        >
                    </div>

                    <div class="flex flex-col-reverse gap-3 pt-1 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center rounded-xl border border-blue-900 px-4 py-2.5 text-center text-sm font-semibold text-blue-900 transition hover:bg-blue-50 sm:min-w-[8rem]">
                            Back to Login
                        </a>
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-blue-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-950 sm:min-w-[10rem]">
                            Send Reset Link
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

</body>
</html>
