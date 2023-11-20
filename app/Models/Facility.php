<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Facility extends Model
{
    use CrudTrait;
    use HasFactory;

    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class);
    }

    public function wastes(): HasMany
    {
        return $this->hasMany(Waste::class);
    }
}
