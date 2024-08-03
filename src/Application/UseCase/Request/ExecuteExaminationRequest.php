<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

use App\Domain\Enum\ExaminationType;

class ExecuteExaminationRequest
{
    public function __construct(public ExaminationType $examinationType)
    {
    }
}
