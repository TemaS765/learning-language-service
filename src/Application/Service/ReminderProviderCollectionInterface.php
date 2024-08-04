<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Enum\ReminderChannelType;

interface ReminderProviderCollectionInterface
{
    public function addProvider(ReminderProviderInterface $provider): void;
    public function getProvider(ReminderChannelType $channelType): ReminderProviderInterface;
}
