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
        $employee = Employee::query()->where('user_id', $user->id)->first();

        if (! $employee) {
            return view('auth.complete-registration', [
                'invalidLink' => true,
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
