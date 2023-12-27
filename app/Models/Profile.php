<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Profile extends Model
{
    use CrudTrait;
    use HasFactory;

    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class);
    }

    public function pricings(): HasMany
    {
        return $this->hasMany(Pricing::class);
    }

    public function generator(): BelongsTo
    {
        return $this->belongsTo(Generator::class);
    }

    // Custom functions for columns
    public function enterprise(): HasOne
    {
        return $this->hasOne(Pricing::class)->ofMany('is_enterprise');
    }

    public function primaryFacility(): HasOne
    {
        return $this->hasOne(Approval::class)->ofMany('facility_id')->where('is_primary_facility', 1)->withDefault(function (Approval $approval) {
                $approval->facility->name = '-';
            });
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('number', 'asc');
        });
    }
}
