<?php

namespace App\Enum;

enum Status
{

    use EnumRenderer;
    case DRAFT;
    case PENDING;
    case COMPLETED;

    public function description(): string
    {
        return match($this)
        {
            self::DRAFT => 'Draft',
            self::PENDING => 'Pending',
            self::COMPLETED => 'Completed',
        };
    }
}
