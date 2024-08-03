<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

class ExecuteExaminationResponse
{
    public function __construct(public int $exercise_id, public string $question)
    {
    }
}
