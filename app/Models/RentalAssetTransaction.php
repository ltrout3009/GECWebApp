<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
//use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RentalAssetTransaction extends Model
{
    use CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rental_asset_id',
        'generator_id',
        'on_rent_date',
        'off_rent_date',
        'release_date',
        'delivery_order_num',
        'pickup_order_num',
        'on_rent_notes',
        'off_rent_notes',
        'is_rental_complete',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'rental_asset_id' => 'integer',
        'generator_id' => 'integer',
        'on_rent_date' => 'date',
        'off_rent_date' => 'date',
        'release_date' => 'date',
    ];

    public function rentalAsset(): BelongsTo
    {
        return $this->belongsTo(RentalAsset::class);
    }

    public function generator(): BelongsTo
    {
        return $this->belongsTo(Generator::class);
    }

    public function transaction_events(): HasMany
    {
        return $this->hasMany(RentalAssetEvent::class);
    }

}
