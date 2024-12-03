<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\SendReminderRequest;
use App\Domain\Entity\Reminder;
use App\Domain\Entity\ReminderExercise;
use App\Domain\Entity\Word;
use App\Domain\Repository\ReminderExerciseRepositoryInterface;
use App\Domain\Repository\ReminderRepositoryInterface;
use App\Domain\Repository\WordRepositoryInterface;

readonly class ExecuteRemindersUseCase
{
    public function __construct(
        private ReminderRepositoryInterface $reminderRepository,
        private ReminderExerciseRepositoryInterface $reminderExerciseRepository,
        private WordRepositoryInterface $wordRepository,
        private SendReminderUseCase $sendReminderUseCase,
    ) {
    }

    public function __invoke(): void
    {
        $dateTime = new \DateTime();
        /** @var Reminder $reminder */
        foreach ($this->reminderRepository->getAllActiveReminders() as $reminder) {
            if (
                empty($reminder->getChannelId())
                || (
                    $reminder->getLastReminderAt()
                    && $reminder->getLastReminderAt()->diff($dateTime)->i < $reminder->getRepeatPeriod()
                )
            ) {
                continue;
            }

            $exercise = $this->reminderExerciseRepository->findLastReminderNotCompletedExercise($reminder->getId());
            if ($exercise) {
                continue;
            }

            /** @var Word|null $word */
            $word = $this->wordRepository->getWordsForExamination(1)->current();
            if (empty($word)) {
                continue;
            }

            if (rand(0, 10) > 5) {
                $question = $word->getText()->getValue();
                $answer = $word->getTranslate()->getValue();
            } else {
                $question = $word->getTranslate()->getValue();
                $answer = $word->getText()->getValue();
            }

            $exercise = new ReminderExercise(
                $reminder->getId(),
                $question,
                '',
                $answer,
                false,
                false
            );

            $exercise = $this->reminderExerciseRepository->addReminderExercise($exercise);

            $sendRequest = new SendReminderRequest(
                $reminder->getChannelType(),
                $reminder->getChannelId(),
                $exercise->getQuestion()
            );
            ($this->sendReminderUseCase)($sendRequest);
        }
    }
}
