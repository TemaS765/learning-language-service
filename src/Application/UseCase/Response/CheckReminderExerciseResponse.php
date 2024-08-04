<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

class CheckReminderExerciseResponse
{
    public function __construct(public bool $isCorrect)
    {
    }
}
