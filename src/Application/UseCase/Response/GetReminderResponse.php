<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

use App\Domain\Enum\ReminderChannelType;

class GetReminderResponse
{
    public function __construct(
        public int $id,
        public int $repeatPeriod,
        public ReminderChannelType $channelType,
        public string $channelId,
        public bool $isActive
    ) {
    }
}
