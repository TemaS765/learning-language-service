<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\EditWordRequest;
use App\Domain\ObjectValue\Id;
use App\Domain\ObjectValue\Text;
use App\Domain\Repository\WordRepositoryInterface;

readonly class EditWordsUseCase
{
    public function __construct(private WordRepositoryInterface $wordRepository)
    {
    }

    public function __invoke(EditWordRequest $request): void
    {
        $word = $this->wordRepository->getWordById(new Id($request->id));
        $this->wordRepository->updateWordById($word->getId(), new Text($request->text), new Text($request->translate));
    }
}
