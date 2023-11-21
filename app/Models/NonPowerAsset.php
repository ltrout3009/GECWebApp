<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NonPowerAsset extends Model
{
    use CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'acumatica_asset_id',
        'asset_class_id',
        'asset_type_id',
        'property_type_id',
        'location_id',
        'assigned_branch_id',
        'assigned_person_id',
        'status_id',
        'lienholder_id',
        'owner_id',
        'is_commercial_motor_vehicle',
        'fleet_num',
        'receipt_date',
        'in_service_date',
        'retired_date',
        'useful_life',
        'quantity',
        'description',
        'carrying_capacity_lbs',
        'gvwr',
        'empty_weight_lbs',
        'color',
        'drive_tire_size',
        'steer_tire_size',
        'fuel_type',
        'transmission',
        'license_plate_num',
        'tx_tag_num',
        'voyager_card_num',
        'serial_vin_num',
        'is_insurance_needed',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'asset_class_id' => 'integer',
        'asset_type_id' => 'integer',
        'property_type_id' => 'integer',
        'location_id' => 'integer',
        'assigned_branch_id' => 'integer',
        'assigned_person_id' => 'integer',
        'status_id' => 'integer',
        'lienholder_id' => 'integer',
        'owner_id' => 'integer',
        'is_commercial_motor_vehicle' => 'boolean',
        'receipt_date' => 'date',
        'in_service_date' => 'date',
        'retired_date' => 'date',
        'is_insurance_needed' => 'boolean',
    ];

    public function assetClass(): BelongsTo
    {
        return $this->belongsTo(AssetClass::class);
    }

    public function assetType(): BelongsTo
    {
        return $this->belongsTo(AssetType::class);
    }

    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assetStatusType(): BelongsTo
    {
        return $this->belongsTo(AssetStatusType::class, 'status_id');
    }

    public function assetLienholder(): BelongsTo
    {
        return $this->belongsTo(AssetLienholder::class);
    }

    public function assetOwner(): BelongsTo
    {
        return $this->belongsTo(AssetOwner::class);
    }

}
