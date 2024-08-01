<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\AddWordRequest;
use App\Domain\Entity\Word;
use App\Domain\ObjectValue\Text;
use App\Domain\Repository\WordRepositoryInterface;

readonly class AddWordUseCase
{
    public function __construct(private WordRepositoryInterface $wordRepository)
    {
    }

    public function __invoke(AddWordRequest $request): void
    {
        $word = new Word(new Text(mb_strtolower($request->text)), new Text(mb_strtolower($request->translate)));
        $this->wordRepository->addWord($word);
    }
}
