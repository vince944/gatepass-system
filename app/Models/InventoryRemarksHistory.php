<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryRemarksHistory extends Model
{
    protected $table = 'inventory_remarks_history';

    protected $primaryKey = 'remark_id';

    public $timestamps = false;

    protected $fillable = [
        'inventory_id',
        'remark_text',
    ];

    protected function casts(): array
    {
        return [
            'remark_id' => 'int',
            'inventory_id' => 'int',
        ];
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
}
