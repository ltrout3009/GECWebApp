<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Generator extends Model
{
    use CrudTrait;
    use HasFactory;

    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }

}
