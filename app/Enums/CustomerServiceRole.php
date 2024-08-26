<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum CustomerServiceRole: string implements HasLabel
{
    case OWNER = 'owner';
    case MANAGER = 'manager';
    case EMPLOYEE = 'employee';

    public function getLabel(): ?string
    {
        return str(str($this->value)->replace('_', ' '))->title();
    }

    public function getColor(): string
    {
        return match ($this) {
            self::OWNER => 'blue',
            self::MANAGER => 'fuchsia',
            self::EMPLOYEE => 'lime',
        };
    }
}
