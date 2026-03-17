<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryPropNoHistory extends Model
{
    protected $table = 'inventory_propno_history';

    protected $fillable = [
        'inventory_id',
        'prop_no',
        'is_current',
        'changed_at',
    ];

    protected function casts(): array
    {
        return [
            'inventory_id' => 'int',
            'is_current' => 'boolean',
            'changed_at' => 'datetime',
        ];
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
}
