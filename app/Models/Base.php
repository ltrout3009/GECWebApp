<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Base extends Model
{
    use CrudTrait;
    use HasFactory;

    public function pricings(): HasMany 
    {
        return $this->hasMany(Pricing::class, 'basis_id', 'id');
    }

    public function wastes(): HasMany
    {
        return $this->hasMany(Waste::class, 'basis_id', 'id');
    }
}
