<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\CheckReminderExerciseRequest;
use App\Application\UseCase\Response\CheckReminderExerciseResponse;
use App\Domain\Exception\NotFoundException;
use App\Domain\Repository\ReminderExerciseRepositoryInterface;
use App\Domain\Repository\ReminderRepositoryInterface;
use App\Domain\Repository\Request\UpdateReminder;
use App\Domain\Repository\Request\UpdateReminderExerciseRequest;

readonly class CheckReminderExerciseUseCase
{
    public function __construct(
        private ReminderExerciseRepositoryInterface $exerciseRepository,
        private ReminderRepositoryInterface $reminderRepository
    ) {
    }

    public function __invoke(CheckReminderExerciseRequest $request): CheckReminderExerciseResponse
    {
        $exercise = $this->exerciseRepository->getNotCompletedReminderExercises();
        if (!$exercise) {
            throw new NotFoundException();
        }

        $isCorrect = mb_strtolower($request->answer) === mb_strtolower($exercise->getCorrectAnswer());
        $update = new UpdateReminderExerciseRequest();
        $update->answer = $request->answer;
        $update->isCompleted = true;
        $update->isRight = $isCorrect;
        $this->exerciseRepository->updateReminderExercise($exercise->getId(), $update);

        $reminderUpdate = new UpdateReminder();
        $reminderUpdate->lastReminderAt = new \DateTime();
        $this->reminderRepository->updateReminderById($exercise->getId(), $reminderUpdate);

        return new CheckReminderExerciseResponse($isCorrect);
    }

}
