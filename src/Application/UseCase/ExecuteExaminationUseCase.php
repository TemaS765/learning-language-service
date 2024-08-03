<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\ExecuteExaminationRequest;
use App\Application\UseCase\Response\ExecuteExaminationResponse;
use App\Domain\Entity\Examination;
use App\Domain\Entity\Exercise;
use App\Domain\Entity\Word;
use App\Domain\Exception\NotFoundException;
use App\Domain\ObjectValue\Text;
use App\Domain\Repository\ExaminationRepositoryInterface;
use App\Domain\Repository\ExerciseRepositoryInterface;
use App\Domain\Repository\WordRepositoryInterface;
use DateTime;

readonly class ExecuteExaminationUseCase
{
    const MAX_NUMBER_OF_WORDS_FOR_EXAMINATION = 50;
    public function __construct(
        private ExaminationRepositoryInterface $examinationRepository,
        private ExerciseRepositoryInterface $exerciseRepository,
        private WordRepositoryInterface $wordRepository
    ){
    }

    public function __invoke(ExecuteExaminationRequest $request): ExecuteExaminationResponse
    {
        $examination = $this->examinationRepository->findNotCompletedExamination($request->examinationType);

        if (!$examination) {
            $examination = $this->createExamination($request);
        }

        $exercise = $this->exerciseRepository->findNextExaminationExercise($examination->getId());
        if (!$exercise) {
            $this->examinationRepository->updateExaminationFinishedAt($examination->getId(), new DateTime());
            throw new NotFoundException();
        }

        return new ExecuteExaminationResponse($exercise->getId(), $exercise->getQuestion()->getValue());
    }

    private function createExamination(ExecuteExaminationRequest $request): Examination
    {
        $addExamination = new Examination(
            $request->examinationType,
            new DateTime()
        );
        $examination = $this->examinationRepository->addExamination($addExamination);
        $exercises = [];
        $iterator = $this->wordRepository->getWordsForExamination(self::MAX_NUMBER_OF_WORDS_FOR_EXAMINATION);
        /** @var Word $word */
        foreach ($iterator as $word) {
            if (rand(0, 100) > 50) {
                $question = $word->getTranslate();
                $correctAnswer = $word->getText();
            } else {
                $question = $word->getText();
                $correctAnswer = $word->getTranslate();
            }
            $exercises[] = new Exercise(
                $question,
                new Text(''),
                $correctAnswer,
                false,
                false
            );
        }

        if (empty($exercises)) {
            throw new NotFoundException();
        }

        $this->exerciseRepository->addExercises($examination->getId(), $exercises);

        return $examination;
    }
}
