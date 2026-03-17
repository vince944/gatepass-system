<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryUnitCostHistory extends Model
{
    protected $table = 'inventory_unit_cost_history';

    protected $primaryKey = 'cost_history_id';

    public $timestamps = false;

    protected $fillable = [
        'inventory_id',
        'unit_cost',
    ];

    protected function casts(): array
    {
        return [
            'cost_history_id' => 'int',
            'inventory_id' => 'int',
            'unit_cost' => 'decimal:2',
        ];
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
}
