<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryEndUserHistory extends Model
{
    protected $table = 'inventory_end_user_history';

    protected $primaryKey = 'assignment_id';

    public $timestamps = false;

    protected $fillable = [
        'inventory_id',
        'end_user',
    ];

    protected function casts(): array
    {
        return [
            'assignment_id' => 'int',
            'inventory_id' => 'int',
        ];
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }
}
