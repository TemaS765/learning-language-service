<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Word;
use App\Domain\Exception\NotFoundException;
use App\Domain\ObjectValue\Id;
use App\Domain\ObjectValue\Text;
use App\Domain\Repository\WordRepositoryInterface;
use App\Infrastructure\Entity\Word as WordEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Iterator;

/**
 * @extends ServiceEntityRepository<Word>
 */
class WordRepository extends ServiceEntityRepository implements WordRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WordEntity::class);
    }

    public function addWord(Word $word): void
    {
        $entity = new WordEntity();
        $entity->setText($word->getText()->getValue());
        $entity->setTranslate($word->getTranslate()->getValue());

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function updateWordById(Id $id, Text $text, Text $translate): void
    {
        /** @var WordEntity $entity */
        $entity = $this->find($id->getValue());
        if ($entity === null) {
            throw new NotFoundException();
        }

        if ($entity->getText() !== $text->getValue()) {
            $entity->setText($text->getValue());
        }

        if ($entity->getTranslate() !== $translate->getValue()) {
            $entity->setTranslate($translate->getValue());
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function deleteWord(Word $word): void
    {
        $word = $this->getWordById($word->getId());
        $entity = new WordEntity();
        $entity->setId($word->getId()->getValue());
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @return Iterator<Word>
     */
    public function getWords(): Iterator
    {
        $entities = $this->findAll();
        $words = [];
        /** @var WordEntity $entity */
        foreach ($entities as $entity) {
            $word = new Word(new Text($entity->getText()), new Text($entity->getTranslate()));
            $reflectionProperty = new \ReflectionProperty(Word::class, 'id');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($word, new Id($entity->getId()));
            yield $word;
        }
        return $words;
    }

    public function getWordById(Id $id): Word
    {
        /** @var WordEntity $entity */
        $entity = $this->find($id->getValue());
        if ($entity === null) {
            throw new NotFoundException();
        }
        $word = new Word(new Text($entity->getText()), new Text($entity->getTranslate()));
        $reflectionProperty = new \ReflectionProperty(Word::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($word, new Id($entity->getId()));
        return $word;
    }
}
