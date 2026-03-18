<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GatepassRequest extends Model
{
    use HasFactory;

    protected $table = 'gatepass_requests';

    protected $primaryKey = 'gatepass_no';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'gatepass_no',
        'request_date',
        'requester_employee_id',
        'center',
        'purpose',
        'destination',
        'remarks',
        'status',
        'noted_by_employee_id',
        'authorized_by_employee_id',
    ];

    protected $casts = [
        'request_date' => 'date',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(GatepassRequestItem::class, 'gatepass_no', 'gatepass_no');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'requester_employee_id', 'employee_id');
    }

    public static function generateGatepassNo(int $start = 260000): string
    {
        $last = static::query()
            ->selectRaw("MAX(CAST(IF(INSTR(gatepass_no, '-') > 0, SUBSTRING_INDEX(gatepass_no, '-', -1), gatepass_no) AS UNSIGNED)) as max_no")
            ->lockForUpdate()
            ->value('max_no');

        $next = (int) ($last ?: ($start - 1)) + 1;

        return (string) $next;
    }
}
