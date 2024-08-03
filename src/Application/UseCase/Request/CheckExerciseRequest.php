<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

class CheckExerciseRequest
{
    public function __construct(public int $exerciseId, public string $answer)
    {
    }
}
