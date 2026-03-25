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
        'rejection_reason',
        'incoming_inspection_remarks',
        'incoming_inspected_at',
        'incoming_inspected_by',
        'noted_by_employee_id',
        'authorized_by_employee_id',
        'qr_code_path',
    ];

    protected $casts = [
        'request_date' => 'date',
        'qr_code_generated_at' => 'datetime',
        'incoming_inspected_at' => 'datetime',
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
        // Existing records were generated as numeric values starting from `260000`.
        // We now want an alphanumeric format: `GP2601`, `GP2602`, ...
        // Mapping rule:
        // - numeric `260000` -> display `2601`
        // - numeric `260001` -> display `2602`
        // After migration, new records will store `GP{display}`.
        $displayStart = 2601;
        $offset = $start - $displayStart;

        $suffixExpr = "CASE
            WHEN INSTR(gatepass_no, '-') > 0
            THEN SUBSTRING_INDEX(gatepass_no, '-', -1)
            ELSE gatepass_no
        END";

        // Compute max "display" number regardless of whether gatepass_no is:
        // - numeric (e.g. 260015) -> convert to display (260015 - $offset)
        // - already prefixed (e.g. GP2616) -> extract numeric directly
        $lastDisplay = static::query()
            ->selectRaw(
                "MAX(CAST(
                    CASE
                        WHEN {$suffixExpr} LIKE 'GP%' THEN REPLACE({$suffixExpr}, 'GP', '')
                        ELSE CAST({$suffixExpr} AS UNSIGNED) - ?
                    END
                AS UNSIGNED)) as max_no",
                [$offset]
            )
            ->lockForUpdate()
            ->value('max_no');

        $nextDisplay = (int) ($lastDisplay ?: ($displayStart - 1)) + 1;

        return 'GP'.$nextDisplay;
    }
}
