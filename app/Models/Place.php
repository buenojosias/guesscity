<?php

namespace App\Models;

use App\Enums\PlaceLevelEnum;
use App\Enums\PlaceTypeEnum;
use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Place extends Model
{
    protected $fillable = [
        'city_id',
        'name',
        'neighborhood',
        'latitude',
        'longitude',
        'panoid',
        'pov',
        'type',
        'level',
        'hints',
        'created_by',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'pov' => 'array',
            'hints' => 'array',
            'active' => 'boolean',
            'type' => PlaceTypeEnum::class,
            'level' => PlaceLevelEnum::class,
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
