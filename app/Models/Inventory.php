<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Inventory extends Model
{
    protected $table = 'inventory';

    protected $fillable = [
        'employee_id',
        'current_prop_no',
        'serial_no',
        'acct_code',
        'pn_old',
        'pn_code_old',
        'mrr_no',
        'description',
        'center',
        'status',
        'accountability',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'int',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function propNoHistory(): HasMany
    {
        return $this->hasMany(InventoryPropNoHistory::class, 'inventory_id');
    }

    public function currentPropNo(): HasOne
    {
        return $this->hasOne(InventoryPropNoHistory::class, 'inventory_id')
            ->where('is_current', true);
    }

    public function unitCostHistory(): HasMany
    {
        return $this->hasMany(InventoryUnitCostHistory::class, 'inventory_id');
    }

    public function currentUnitCost(): HasOne
    {
        return $this->hasOne(InventoryUnitCostHistory::class, 'inventory_id')->latestOfMany('cost_history_id');
    }

    public function endUserHistory(): HasMany
    {
        return $this->hasMany(InventoryEndUserHistory::class, 'inventory_id');
    }

    public function currentEndUser(): HasOne
    {
        return $this->hasOne(InventoryEndUserHistory::class, 'inventory_id')->latestOfMany('assignment_id');
    }

    public function remarksHistory(): HasMany
    {
        return $this->hasMany(InventoryRemarksHistory::class, 'inventory_id');
    }

    public function currentRemarks(): HasOne
    {
        return $this->hasOne(InventoryRemarksHistory::class, 'inventory_id')->latestOfMany('remark_id');
    }

    protected $appends = [
        'prop_no',
        'unit_cost',
        'end_user',
        'remarks',
    ];

    public function getPropNoAttribute(): ?string
    {
        return $this->currentPropNo?->prop_no;
    }

    public function getUnitCostAttribute(): ?string
    {
        return $this->currentUnitCost?->unit_cost;
    }

    public function getEndUserAttribute(): ?string
    {
        return $this->currentEndUser?->end_user;
    }

    public function getRemarksAttribute(): ?string
    {
        return $this->currentRemarks?->remark_text;
    }
}
