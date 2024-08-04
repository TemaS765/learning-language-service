<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Service\Request\SendReminderRequest;
use App\Domain\Enum\ReminderChannelType;

interface ReminderServiceInterface
{
    public function sendReminder(ReminderChannelType $channelType, SendReminderRequest $request): void;
}
