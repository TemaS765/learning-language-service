<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Word;
use App\Domain\Exception\NotFoundException;
use App\Domain\ObjectValue\Id;
use App\Domain\ObjectValue\Text;
use App\Domain\Repository\WordRepositoryInterface;
use App\Infrastructure\Entity\Word as ORMEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Word>type
 */
class WordRepository extends ServiceEntityRepository implements WordRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ORMEntity::class);
    }

    public function addWord(Word $word): void
    {
        $entity = new ORMEntity();
        $entity->setText($word->getText()->getValue());
        $entity->setTranslate($word->getTranslate()->getValue());

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function updateWordById(Id $id, Text $text, Text $translate): void
    {
        /** @var ORMEntity $entity */
        $entity = $this->find($id->getValue());
        if (null === $entity) {
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
        $entity = new ORMEntity();
        $entity->setId($word->getId()->getValue());
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @return \Iterator<Word>
     */
    public function getWords(): \Iterator
    {
        $entities = $this->findAll();
        $words = [];
        /** @var ORMEntity $entity */
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
        /** @var ORMEntity $entity */
        $entity = $this->find($id->getValue());
        if (null === $entity) {
            throw new NotFoundException();
        }
        $word = new Word(new Text($entity->getText()), new Text($entity->getTranslate()));
        $reflectionProperty = new \ReflectionProperty(Word::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($word, new Id($entity->getId()));

        return $word;
    }

    public function deleteWordById(Id $id): void
    {
        /** @var ORMEntity $entity */
        $entity = $this->find($id->getValue());
        if (null === $entity) {
            throw new NotFoundException();
        }
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @return \Iterator<Word>
     */
    public function getWordsForExamination(int $limit): \Iterator
    {
        $db = $this->getEntityManager()->createQueryBuilder();
        $db->select('w')
            ->from(ORMEntity::class, 'w')
            ->orderBy('RANDOM()')
            ->setMaxResults($limit);

        $entities = $db->getQuery()->getResult();
        foreach ($entities as $entity) {
            $word = new Word(new Text($entity->getText()), new Text($entity->getTranslate()));
            $reflectionProperty = new \ReflectionProperty(Word::class, 'id');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($word, new Id($entity->getId()));
            yield $word;
        }
    }
}
