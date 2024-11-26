<?php
declare(strict_types=1);

namespace App\enum;

enum CustomerType: string
{
    case private = 'private';
    case professional = 'professional';

    public function getLabel(): string
    {
        return match ($this) {
            self::professional => 'Professionnel',
            self::private => 'Particulier',
        };
    }
}