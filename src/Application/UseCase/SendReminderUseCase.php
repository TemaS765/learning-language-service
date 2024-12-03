<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Service\ReminderServiceInterface;
use App\Application\Service\Request\SendReminderRequest as ServiceRequest;
use App\Application\UseCase\Request\SendReminderRequest;

readonly class SendReminderUseCase
{
    public function __construct(private ReminderServiceInterface $reminderService)
    {
    }

    public function __invoke(SendReminderRequest $request): void
    {
        $this->reminderService->sendReminder(
            $request->channelType,
            new ServiceRequest($request->channelId, $request->question)
        );
    }
}
