<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEmployeeProfileRequest;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeProfileController extends Controller
{
    public function update(UpdateEmployeeProfileRequest $request): JsonResponse
    {
        $user = $request->user();

        if ($user === null) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);
        }

        /** @var Employee|null $employee */
        $employee = Employee::query()
            ->where('user_id', $user->id)
            ->first();

        if ($employee === null) {
            return response()->json([
                'message' => 'Employee record not found.',
            ], 422);
        }

        $validated = $request->validated();

        DB::transaction(function () use ($employee, $user, $validated, $request): void {
            $employee->update([
                'employee_name' => $validated['employee_name'],
                'center' => $validated['center'],
            ]);

            $user->email = $validated['email'];

            if ($request->passwordChangeRequested()) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();
        });

        $employee->refresh();
        $user->refresh();

        return response()->json([
            'message' => 'Profile updated successfully.',
            'data' => [
                'employee_name' => $employee->employee_name,
                'center' => $employee->center,
                'email' => $user->email,
            ],
        ]);
    }
}
