<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MachineryEquipmentAssetMileage extends Model
{
    use CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mach_eqpt_asset_id',
        'mileage_date',
        'mileage',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'mach_eqpt_asset_id' => 'integer',
        'mileage_date' => 'date',
    ];

    public function machineryEquipmentAsset(): BelongsTo
    {
        return $this->belongsTo(MachineryEquipmentAsset::class);
    }

}
