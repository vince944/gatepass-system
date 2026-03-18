<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GatepassRequestItem extends Model
{
    use HasFactory;

    protected $table = 'gatepass_items';

    protected $primaryKey = 'gatepass_item_id';

    protected $fillable = [
        'gatepass_no',
        'inventory_id',
        'item_remarks',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(GatepassRequest::class, 'gatepass_no', 'gatepass_no');
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }
}
