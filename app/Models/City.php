<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $fillable = [
        'state_id',
        'name',
        'latitude',
        'longitude',
        'neighbors'
    ];

    protected function casts(): array
    {
        return [
            'neighbors' => 'array'
        ];
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }

    public function profiles(): HasMany
    {
        return $this->hasMany(related: Profile::class);
    }
}
