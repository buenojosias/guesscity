<?php

namespace App\Enums;

enum PlaceLevelEnum: int
{
    case SUPEREASY = 1;
    case EASY = 2;
    case MEDIUM = 3;
    case HARD = 4;
    case EXPERT = 5;

    public function label(): string
    {
        return match($this) {
            self::SUPEREASY => 'Super fácil',
            self::EASY => 'Fácil',
            self::MEDIUM => 'Médio',
            self::HARD => 'Difícil',
            self::EXPERT => 'Muito difícil',
        };
    }
}
