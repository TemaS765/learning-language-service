<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Exercise;
use App\Domain\Repository\Request\UpdateExerciseRequest;
use Iterator;

interface ExerciseRepositoryInterface
{
    /**
     * @param int $examinationId
     * @param Exercise[] $exercises
     * @return void
     */
    public function addExercises(int $examinationId, array $exercises): void;

    public function findNextExaminationExercise(int $examinationId): ?Exercise;

    /**
     * @param int $examinationId
     * @return Iterator<Exercise>
     */
    public function getExaminationExercises(int $examinationId): Iterator;

    public function getNotCompletedExerciseById(int $exerciseId): Exercise;

    public function updateExercise(int $exerciseId, UpdateExerciseRequest $request): void;
}
