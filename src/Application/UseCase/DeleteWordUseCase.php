<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\DeleteWordRequest;
use App\Domain\ObjectValue\Id;
use App\Domain\Repository\WordRepositoryInterface;

readonly class DeleteWordUseCase
{
    public function __construct(private WordRepositoryInterface $wordRepository)
    {
    }

    public function __invoke(DeleteWordRequest $request): void
    {
        $word = $this->wordRepository->getWordById(new Id($request->id));
        $this->wordRepository->deleteWordById($word->getId());
    }
}
