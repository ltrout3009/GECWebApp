<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NonPowerAssetNote extends Model
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
        'note',
        'note_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'non_power_asset_id' => 'integer',
        'note_date' => 'date',
    ];

    public function nonPowerAsset(): BelongsTo
    {
        return $this->belongsTo(NonPowerAsset::class);
    }

}
