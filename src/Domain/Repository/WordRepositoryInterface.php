<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Word;
use App\Domain\ObjectValue\Id;

interface WordRepositoryInterface
{
    public function addWord(Word $word): void;
    public function deleteWord(Word $word): void;
    /** @return Word[] */
    public function getWords(): array;
    public function getWordById(Id $id): Word;
}
