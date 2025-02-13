<?php

namespace App\Enums;

enum CustomerGenre: string
{
    case MALE = 'male';
    case FEMALE = 'female';

    public function label(): string
    {
        return match($this) {
            self::MALE => 'Homme',
            self::FEMALE => 'Femme',
        };
    }
}