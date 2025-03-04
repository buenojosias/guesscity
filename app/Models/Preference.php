<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Preference extends Model
{
    protected $fillable = [
        'user_id',
        'dark_mode',
        'default_mode',
        'neighbor_cities',
        'latitude',
        'longitude',
        'default_radius'
    ];

    protected function casts(): array
    {
        return [
            'dark_mode' => 'boolean',
            'neighbor_cities' => 'boolean'
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
