<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

class CheckReminderExerciseRequest
{
    public function __construct(public string $answer)
    {
    }
}
