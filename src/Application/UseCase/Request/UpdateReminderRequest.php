<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

use App\Domain\Enum\ReminderChannelType;

class UpdateReminderRequest
{
    public function __construct(
        public int $id,
        public int $repeatPeriod,
        public ReminderChannelType $channelType,
        public string $channelId,
        public bool $isActive,
    ) {
    }
}
