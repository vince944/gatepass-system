<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProperty extends Model
{
    use HasFactory;

    protected $table = 'master_property';

    protected $primaryKey = 'propno';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'propno',
        'rca_acctcode',
        'propcode',
        'o_mrrno',
        'floor',
        'status',
        'property_mode',
        'disposal_mode',
        'ii_date',
        'floor_price',
        'appraise_value',
        'disposal_date',
        'orno',
        'or_date',
        'or_amount',
        'idno',
        'unit',
        'unitcost',
        'description',
        'specs',
        'serialno',
        'acq_mode',
        'area',
        'old_code',
        'revdate',
        'userid',
        'propdateissue',
        'o_status',
        'o_disposal_mode',
        'mrrno',
        'propno_old',
        'propno_new',
        'est_use_life',
        'acctcode',
        'subcode',
        'venue_tag',
        'jevno',
        'found_date',
        'found_supplier',
        'accountable_employee_id',
    ];

    public function accountableEmployee()
    {
        return $this->belongsTo(Employee::class, 'accountable_employee_id', 'employee_id');
    }
}
