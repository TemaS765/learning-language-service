<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Response\WordResponse;
use App\Domain\ObjectValue\Id;
use App\Domain\Repository\WordRepositoryInterface;

readonly class ShowWordsUseCase
{
    public function __construct(private WordRepositoryInterface $wordRepository)
    {
    }

    public function __invoke(int $id): WordResponse
    {
        $word = $this->wordRepository->getWordById(new Id($id));

        return new WordResponse(
            $word->getId()->getValue(),
            $word->getText()->getValue(),
            $word->getTranslate()->getValue()
        );
    }
}
