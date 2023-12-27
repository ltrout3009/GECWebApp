<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Approval extends Model
{
    protected $casts = [
        'number' => 'integer',
    ];

    use CrudTrait;
    use HasFactory;

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class)->withDefault([
            'name' => '-',
        ]);
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

}
