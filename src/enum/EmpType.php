<?php
declare(strict_types=1);

namespace App\enum;

enum EmpType: string
{
    case admin = 'admin';
    case manager = 'manager';

    public function getLabel(): string
    {
        return match ($this) {
            self::admin => 'Administrateur',
            self::manager => 'Gestionnaire',
        };
    }
}