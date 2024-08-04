<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\SetTelegramChannelIdRequest;
use App\Domain\Exception\NotFoundException;
use App\Domain\Repository\ReminderRepositoryInterface;
use App\Domain\Repository\Request\UpdateReminder;

class SetTelegramChannelIdUseCase
{
    public function __construct(private readonly ReminderRepositoryInterface $reminderRepository)
    {
    }

    public function __invoke(SetTelegramChannelIdRequest $request): void
    {
        $reminder = $this->reminderRepository->findReminder();
        if (!$reminder) {
            throw new NotFoundException();
        }
        $update = new UpdateReminder();
        $update->channelId = $request->channelId;

        $this->reminderRepository->updateReminderById($reminder->getId(), $update);
    }
}
