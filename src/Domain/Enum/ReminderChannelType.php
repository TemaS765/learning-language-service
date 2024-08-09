<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum ReminderChannelType: string {
    case TELEGRAM = 'telegram';
}
