<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompleteRegistrationRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CompleteRegistrationController extends Controller
{
    public function show(User $user)
    {
        // Prevent reuse of the signed "complete registration" link.
        // Note: this app may create users with a placeholder password before completion,
        // so we use `email_verified_at` (set in `store()`) as the completion marker.
        if ($user->password !== null && $user->email_verified_at !== null) {
            return view('auth.complete-registration', [
                'invalidLink' => true,
                'linkAlreadyUsed' => true,
                'user' => null,
                'employee' => null,
            ]);
        }

        $employee = Employee::query()->where('user_id', $user->id)->first();

        if (! $employee) {
            return view('auth.complete-registration', [
                'invalidLink' => true,
                'linkAlreadyUsed' => false,
                'user' => null,
                'employee' => null,
            ]);
        }

        return view('auth.complete-registration', [
            'invalidLink' => false,
            'user' => $user,
            'employee' => $employee,
        ]);
    }

    public function store(CompleteRegistrationRequest $request, User $user)
    {
        // If the user already completed registration, block any further submissions.
        if ($user->password !== null && $user->email_verified_at !== null) {
            return view('auth.complete-registration', [
                'invalidLink' => true,
                'linkAlreadyUsed' => true,
                'user' => null,
                'employee' => null,
            ]);
        }

        $employee = Employee::query()->where('user_id', $user->id)->first();

        if (! $employee) {
            return redirect()->route('login')->with('error', 'Employee record not found.');
        }

        $validated = $request->validated();

        $user->password = Hash::make($validated['password']);
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('login')->with('success', 'Your account has been completed successfully. You can now sign in.');
    }
}
