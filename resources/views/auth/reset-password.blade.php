<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — Gate Pass Management</title>
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
                <h1 class="text-xl font-bold text-blue-900 sm:text-2xl">Reset Password</h1>
                <p class="mt-2 text-sm leading-relaxed text-gray-600">
                    Choose a new password for your account.
                </p>
            </div>

            @if ($errors->any())
                <div class="mt-5 rounded-lg border border-red-300 bg-red-100 px-3 py-2.5 text-sm text-red-700 sm:px-4 sm:py-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="mt-6 space-y-4">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ old('email', $email) }}">

                <div>
                    <label for="password" class="mb-1.5 block text-sm font-semibold text-gray-900">
                        New Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-xl border border-gray-200 bg-gray-100 px-3 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-700 sm:px-4 sm:py-3 sm:text-base @error('password') border-red-400 @enderror"
                    >
                    @error('password')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-sm font-semibold text-gray-900">
                        Confirm Password
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-xl border border-gray-200 bg-gray-100 px-3 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-700 sm:px-4 sm:py-3 sm:text-base"
                    >
                </div>

                <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center rounded-xl border border-blue-900 px-4 py-2.5 text-center text-sm font-semibold text-blue-900 transition hover:bg-blue-50 sm:min-w-[8rem]">
                        Back to Login
                    </a>
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-blue-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-950 sm:min-w-[10rem]">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
