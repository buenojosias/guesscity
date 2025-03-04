<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceMetric extends Model
{
    protected $fillable = [
        'place_id',
        'total_plays',
        'avg_time',
        'avg_distance_error',
        'accuracy_percentage',
        'popularity'
    ];

    protected function casts(): array
    {
        return [
            'total_plays' => 'integer',
            'avg_time' => 'float',
            'avg_distance_error' => 'float',
            'accuracy_percentage' => 'float',
            'popularity' => 'float'
        ];
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
