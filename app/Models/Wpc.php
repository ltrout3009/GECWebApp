<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wpc extends Model
{
    use CrudTrait;
    use HasFactory;

    
    public function wastes(): HasMany
    {
        return $this->hasMany(Waste::class);
    }

    public function waste_costs(): HasMany
    {
        return $this->hasMany(Waste::class, 'wpc_id')->orderBy('facility_id', 'asc')->orderBy('container_id', 'desc');
    }
    
}
