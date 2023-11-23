<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Generator extends Model
{
    use CrudTrait;
    use HasFactory;
    use Notifiable;

    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }

    public function getFullGeneratorAttribute($value) 
    {
        return $this->id . ' - ' . $this->name;
    } 

}
