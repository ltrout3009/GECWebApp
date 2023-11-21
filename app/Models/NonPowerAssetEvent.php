<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NonPowerAssetEvent extends Model
{
    use CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'non_power_asset_id',
        'event_type_id',
        'event_status_id',
        'event_interval_id',
        'created_date',
        'due_date',
        'start_date',
        'completed_date',
        'description',
        'mileage',
        'cost',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'non_power_asset_id' => 'integer',
        'event_type_id' => 'integer',
        'event_status_id' => 'integer',
        'event_interval_id' => 'integer',
        'created_date' => 'date',
        'due_date' => 'date',
        'start_date' => 'date',
        'completed_date' => 'date',
        'cost' => 'decimal:2',
    ];

    public function nonPowerAsset(): BelongsTo
    {
        return $this->belongsTo(NonPowerAsset::class);
    }

    public function eventType(): BelongsTo
    {
        return $this->belongsTo(EventType::class);
    }

    public function eventStatusType(): BelongsTo
    {
        return $this->belongsTo(EventStatusType::class);
    }

    public function eventIntervalType(): BelongsTo
    {
        return $this->belongsTo(EventIntervalType::class);
    }

}
