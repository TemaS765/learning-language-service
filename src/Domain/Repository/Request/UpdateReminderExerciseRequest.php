<?php

declare(strict_types=1);

namespace App\Domain\Repository\Request;

class UpdateReminderExerciseRequest
{
    public ?string $answer;
    public ?bool $isCompleted;
    public ?bool $isRight;
}
