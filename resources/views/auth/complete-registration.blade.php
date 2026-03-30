<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Registration</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen overflow-x-hidden bg-cover bg-center bg-no-repeat"
      style="background-image: linear-gradient(rgba(20,58,130,0.55), rgba(20,58,130,0.55)), url('/images/login_bg.png');">

    <div class="flex min-h-screen w-full items-center justify-center px-4 py-4 sm:px-6 sm:py-6 lg:px-8">
    <div class="w-full max-w-2xl">
        <div class="overflow-hidden rounded-2xl bg-white shadow-2xl">
            <div class="bg-[#173A6B] px-6 py-5 text-white">
                <h1 class="text-2xl font-bold">Complete Registration</h1>
                <p class="mt-1 text-sm text-blue-100">
                    Set up your password to activate your account.
                </p>
            </div>

            <div class="p-6 sm:p-8">
                @if ($invalidLink)
                    <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                        <h2 class="text-base font-semibold">Invalid or Expired Link</h2>
                        <p class="mt-1 text-sm">
                            This registration link is invalid or has expired.
                        </p>

                        <a href="{{ route('login') }}"
                           class="mt-4 inline-flex rounded-lg bg-[#F6BF1E] px-4 py-2 font-semibold text-[#173A6B] transition hover:opacity-90">
                            Back to Login
                        </a>
                    </div>
                @else
                    <div class="mb-6 rounded-xl border border-blue-100 bg-blue-50 p-5">
                        <h2 class="mb-4 text-lg font-semibold text-[#173A6B]">Account Information</h2>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-500">Full Name / Username</label>
                                <div class="rounded-lg border border-gray-200 bg-white px-4 py-3 text-gray-800">
                                    {{ $employee->employee_name }}
                                </div>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-500">Email</label>
                                <div class="rounded-lg border border-gray-200 bg-white px-4 py-3 text-gray-800">
                                    {{ $user->email }}
                                </div>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-500">Department</label>
                                <div class="rounded-lg border border-gray-200 bg-white px-4 py-3 text-gray-800">
                                    {{ $employee->center }}
                                </div>
                            </div>

                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-500">Role</label>
                                <div class="rounded-lg border border-gray-200 bg-white px-4 py-3 text-gray-800 capitalize">
                                    {{ $user->role }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (session('error'))
                        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ request()->fullUrl() }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label for="password" class="mb-2 block text-sm font-semibold text-[#173A6B]">
                                New Password
                            </label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-[#173A6B] focus:ring-2 focus:ring-[#173A6B]/20"
                                placeholder="Enter your new password"
                                required
                            >
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-[#173A6B]">
                                Confirm Password
                            </label>
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-[#173A6B] focus:ring-2 focus:ring-[#173A6B]/20 @error('password_confirmation') border-red-400 @enderror"
                                placeholder="Confirm your password"
                                required
                            >
                            @error('password_confirmation')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:justify-end">
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-5 py-3 font-semibold text-gray-700 transition hover:bg-gray-50">
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-[#F6BF1E] px-5 py-3 font-semibold text-[#173A6B] shadow-sm transition hover:opacity-90"
                            >
                                Complete Registration
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    </div>

</body>
</html>