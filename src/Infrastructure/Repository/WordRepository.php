<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Word;
use App\Domain\Exception\NotFoundException;
use App\Domain\ObjectValue\Id;
use App\Domain\Repository\WordRepositoryInterface;
use App\Infrastructure\Entity\Word as WordEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function deleteWord(Word $word): void
    {
        $word = $this->getWordById($word->getId());
        $entity = new WordEntity();
        $entity->setId($word->getId()->getValue());
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    public function getWords(): array
    {
        $entities = $this->findAll();
        $words = [];
        foreach ($entities as $entity) {
            $word = new Word($entity->getText(), $entity->getTranslate());
            $reflectionProperty = new \ReflectionProperty(Word::class, 'id');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($word, $entity->getId());
            $words[] = $word;
        }
        return $words;
    }

    public function getWordById(Id $id): Word
    {
        $entity = $this->find($id->getValue());
        if ($entity === null) {
            throw new NotFoundException();
        }
        $word = new Word($entity->getText(), $entity->getTranslate());
        $reflectionProperty = new \ReflectionProperty(Word::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($word, $entity->getId());
        return $word;
    }
}
