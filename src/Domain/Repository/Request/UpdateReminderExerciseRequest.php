<?php

declare(strict_types=1);

namespace App\Domain\Repository\Request;

use App\Domain\ObjectValue\Text;

class UpdateReminderExerciseRequest
{
    public ?string $answer;
    public ?bool $isCompleted;
    public ?bool $isRight;
}
