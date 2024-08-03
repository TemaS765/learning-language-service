<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Examination;
use App\Domain\Enum\ExaminationType;
use DateTimeInterface;

interface ExaminationRepositoryInterface
{
    public function addExamination(Examination $examination): Examination;
    public function findNotCompletedExamination(ExaminationType $type): ?Examination;
    public function updateExaminationFinishedAt(int $examinationId, DateTimeInterface $dateTime): void;
}
