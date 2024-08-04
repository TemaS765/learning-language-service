<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\UpdateReminderRequest;
use App\Domain\Repository\ReminderRepositoryInterface;
use App\Domain\Repository\Request\UpdateReminder;

readonly class UpdateReminderUseCase
{
    public function __construct(private ReminderRepositoryInterface $reminderRepository)
    {
    }

    public function __invoke(UpdateReminderRequest $request): void
    {
        $update = new UpdateReminder();
        $update->channelId = $request->channelId;
        $update->channelType = $request->channelType;
        $update->repeatPeriod = $request->repeatPeriod;
        $update->isActive = $request->isActive;

        $this->reminderRepository->updateReminderById($request->id, $update);
    }
}
