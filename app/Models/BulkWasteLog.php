<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BulkWasteLog extends Model
{
    use CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rental_asset_event_id',
        'bulk_waste_container_type_id',
        'amount',
        'material',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'rental_asset_event_id' => 'integer',
        'bulk_waste_container_type_id' => 'integer',
        'amount' => 'double',
    ];

    public function bulkWasteContainerType(): BelongsTo
    {
        return $this->belongsTo(BulkWasteContainerType::class);
    }

    public function amount(): BelongsTo
    {
        return $this->belongsTo(Amount::class);
    }

    public function rentalAssetEvent(): BelongsTo
    {
        return $this->belongsTo(RentalAssetEvent::class);
    }
}
