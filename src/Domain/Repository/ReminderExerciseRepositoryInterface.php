<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\ReminderExercise;
use App\Domain\Repository\Request\UpdateReminderExerciseRequest;

interface ReminderExerciseRepositoryInterface
{
    public function findLastReminderNotCompletedExercise(int $reminderId): ?ReminderExercise;
    public function addReminderExercise(ReminderExercise $exercise): ReminderExercise;
    public function getNotCompletedReminderExercises(): ?ReminderExercise;
    public function updateReminderExercise(int $exerciseId, UpdateReminderExerciseRequest $request): void;
}
