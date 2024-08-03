<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\CheckExerciseRequest;
use App\Application\UseCase\Response\CheckExerciseResponse;
use App\Domain\Exception\NotFoundException;
use App\Domain\ObjectValue\Text;
use App\Domain\Repository\ExerciseRepositoryInterface;
use App\Domain\Repository\Request\UpdateExerciseRequest;

readonly class CheckExerciseUseCase
{
    public function __construct(
        private ExerciseRepositoryInterface $exerciseRepository
    ){
    }

    public function __invoke(CheckExerciseRequest $request): CheckExerciseResponse
    {
        $exercise = $this->exerciseRepository->getNotCompletedExerciseById($request->exerciseId);
        if (!$exercise) {
            throw new NotFoundException();
        }

        $isCorrect = mb_strtolower($request->answer) === mb_strtolower($exercise->getCorrectAnswer()->getValue());
        $update = new UpdateExerciseRequest();
        $update->answer = new Text($request->answer);
        $update->isCompleted = true;
        $update->isRight = $isCorrect;
        $this->exerciseRepository->updateExercise($exercise->getId(), $update);

        return new CheckExerciseResponse($isCorrect, $exercise);
    }

}
