<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;

class Employee extends Model
{
    protected $table = 'employees';

    protected $primaryKey = 'employee_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'employee_id',
        'employee_name',
        'center',
        'empl_status',
        'employee_type',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Resolve the employee record used for gate pass requests (dashboard, history, submit).
     * Uses `employees.user_id` first, then `employee_profiles.user_id` → `employee_id`.
     */
    public static function resolveForGatepassUser(?User $user): ?self
    {
        if ($user === null) {
            return null;
        }

        $linked = static::query()->where('user_id', $user->id)->first();

        if ($linked !== null) {
            return $linked;
        }

        if (! Schema::hasTable('employee_profiles')) {
            return null;
        }

        $profile = EmployeeProfile::query()->where('user_id', $user->id)->first();

        if ($profile === null) {
            return null;
        }

        return static::query()->where('employee_id', $profile->employee_id)->first();
    }
}
