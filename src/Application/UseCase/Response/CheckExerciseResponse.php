<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

use App\Domain\Entity\Exercise;

class CheckExerciseResponse
{
    public function __construct(public bool $isCorrect, public Exercise $exercise)
    {
    }
}
