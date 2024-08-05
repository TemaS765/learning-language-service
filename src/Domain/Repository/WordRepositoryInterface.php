<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Word;
use App\Domain\ObjectValue\Id;
use App\Domain\ObjectValue\Text;
use Iterator;

interface WordRepositoryInterface
{
    public function addWord(Word $word): void;
    public function updateWordById(Id $id, Text $text, Text $translate): void;
    public function deleteWord(Word $word): void;
    /** @return Iterator<Word> */
    public function getWords(): Iterator;
    public function getWordById(Id $id): Word;
    public function deleteWordById(Id $id): void;
    /** @return Iterator<Word> */
    public function getWordsForExamination(int $limit): Iterator;
}
