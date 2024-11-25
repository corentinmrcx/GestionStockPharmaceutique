<?php
declare(strict_types=1);

namespace App\enum;

enum ClientType: string
{
    case private = 'Particulier';
    case professional = 'Professionnel';

    public function getLabel(): string
    {
        return match ($this) {
            self::professional => 'Professionnel',
            self::private => 'Particulier',
        };
    }
}