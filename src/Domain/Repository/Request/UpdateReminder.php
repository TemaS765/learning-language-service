<?php

declare(strict_types=1);

namespace App\Domain\Repository\Request;

use App\Domain\Enum\ReminderChannelType;
use DateTimeInterface;

class UpdateReminder
{
    public ?int $repeatPeriod = null;
    public ?ReminderChannelType $channelType = null;
    public ?string $channelId = null;
    public ?bool $isActive = null;
    public ?DateTimeInterface $lastReminderAt = null;
}
