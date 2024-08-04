<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Service\ReminderProviderCollectionInterface;
use App\Application\Service\ReminderProviderInterface;
use App\Domain\Enum\ReminderChannelType;
use App\Domain\Exception\NotFoundException;

class ReminderProviderCollection implements ReminderProviderCollectionInterface
{
    private array $providers = [];

    public function addProvider(ReminderProviderInterface $provider): void
    {
        $this->providers[$provider->getType()->value] = $provider;
    }

    public function getProvider(ReminderChannelType $channelType): ReminderProviderInterface
    {
        if (!isset($this->providers[$channelType->value])) {
            throw new NotFoundException();
        }

        return $this->providers[$channelType->value];
    }
}
