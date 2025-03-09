<?php

namespace App\Enums;

enum PlaceTypeEnum: string
{
    case ROAD = 'road';
    case CORNER = 'corner';
    case SQUARE = 'square';
    case PARK = 'park';
    case TOURIST = 'tourist';
    case BUILDING = 'building';
    case MONUMENT = 'monument';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::ROAD => 'Rua',
            self::CORNER => 'Esquina',
            self::SQUARE => 'Praça',
            self::PARK => 'Parque',
            self::TOURIST => 'Ponto turístico',
            self::BUILDING => 'Construção pública',
            self::MONUMENT => 'Monumento',
            self::OTHER => 'Outro',
        };
    }
}
