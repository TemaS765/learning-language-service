<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Service\ReminderServiceInterface;
use App\Application\Service\Request\SendReminderRequest;
use App\Domain\Enum\ReminderChannelType;

class ReminderService implements ReminderServiceInterface
{
    public function __construct(private ReminderProviderCollection $providerCollection)
    {
    }

    public function sendReminder(ReminderChannelType $channelType, SendReminderRequest $request): void
    {
        $this->providerCollection->getProvider($channelType)->send($request);
    }
}
