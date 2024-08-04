<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Service\Request\SendReminderRequest;
use App\Domain\Enum\ReminderChannelType;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

#[Autoconfigure(tags: ['app.reminder_provider'])]
interface ReminderProviderInterface
{
    public function getType(): ReminderChannelType;

    public function send(SendReminderRequest $request): void;
}
