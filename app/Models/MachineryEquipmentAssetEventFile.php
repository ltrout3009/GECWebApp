<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MachineryEquipmentAssetEventFile extends Model
{
    use CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'machinery_equipment_asset_event_id',
        'file_name',
        'file_path',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'machinery_equipment_asset_event_id' => 'integer',
    ];

    public function machineryEquipmentAssetEvent(): BelongsTo
    {
        return $this->belongsTo(MachineryEquipmentAssetEvent::class);
    }
}
