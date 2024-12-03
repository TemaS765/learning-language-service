<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Reminder;
use App\Domain\Repository\Request\UpdateReminder;

interface ReminderRepositoryInterface
{
    public function findReminder(): ?Reminder;

    public function addReminder(Reminder $reminder): Reminder;

    public function updateReminderById(int $id, UpdateReminder $request): void;

    /** @return \Iterator<Reminder> */
    public function getAllActiveReminders(): \Iterator;
}
