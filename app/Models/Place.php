<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Place extends Model
{
    protected $fillable = [
        'city_id',
        'name',
        'latitude',
        'longitude',
        'panoid',
        'pov',
        'type',
        'level',
        'hints',
        'created_by',
        'active',
        'has_image'
    ];

    protected function casts(): array
    {
        return [
            'pov' => 'array',
            'hints' => 'array',
            'active' => 'boolean',
            'has_image' => 'boolean'
        ];
    }

    public function metric(): HasOne
    {
        return $this->hasOne(PlaceMetric::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function plays(): HasMany
    {
        return $this->hasMany(Play::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
