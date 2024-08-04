<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Response\GetReminderResponse;
use App\Domain\Entity\Reminder;
use App\Domain\Enum\ReminderChannelType;
use App\Domain\Repository\ReminderRepositoryInterface;

readonly class GetReminderUseCase
{
    public function __construct(private ReminderRepositoryInterface $reminderRepository)
    {
    }

    public function __invoke(): ?GetReminderResponse
    {
        $reminder = $this->reminderRepository->findReminder();
        if (!$reminder) {
            $this->reminderRepository->addReminder(
                new Reminder(
                    0,
                    ReminderChannelType::TELEGRAM,
                    '',
                    false
                )
            );
            $reminder = $this->reminderRepository->findReminder();
        }
        return new GetReminderResponse(
            $reminder->getId(),
            $reminder->getRepeatPeriod(),
            $reminder->getChannelType(),
            $reminder->getChannelId(),
            $reminder->isActive()
        );;
    }
}
