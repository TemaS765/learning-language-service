<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Response\WordResponse;
use App\Domain\Entity\Word;
use App\Domain\Repository\WordRepositoryInterface;

readonly class GetWordsUseCase
{
    public function __construct(private WordRepositoryInterface $wordRepository)
    {
    }

    /**
     * @return \Iterator<WordResponse>
     */
    public function __invoke(): \Iterator
    {
        /** @var Word $word */
        foreach ($this->wordRepository->getWords() as $word) {
            yield new WordResponse(
                $word->getId()->getValue(),
                $word->getText()->getValue(),
                $word->getTranslate()->getValue()
            );
        }
    }
}
