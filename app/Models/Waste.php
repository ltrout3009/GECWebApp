<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Waste extends Model
{
    use CrudTrait;
    use HasFactory;

    public function pricings(): HasMany
    {
        return $this->hasMany(Pricing::class);
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }

    public function base(): BelongsTo
    {
        return $this->belongsTo(Base::class, 'basis_id', 'id');
    }

    public function container(): BelongsTo
    {
        return $this->belongsTo(Container::class);
    }

    public function wpc(): BelongsTo
    {
        return $this->belongsTo(Wpc::class);
    }
}
