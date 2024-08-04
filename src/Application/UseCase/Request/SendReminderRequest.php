<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

use App\Domain\Enum\ReminderChannelType;

class SendReminderRequest
{
    public function __construct(
        public ReminderChannelType $channelType,
        public string $channelId,
        public string $question
    ) {
    }
}
