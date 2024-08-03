<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Exercise;
use App\Domain\Exception\NotFoundException;
use App\Domain\ObjectValue\Text;
use App\Domain\Repository\ExerciseRepositoryInterface;
use App\Domain\Repository\Request\UpdateExerciseRequest;
use App\Infrastructure\Entity\Exercise as ORMEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Iterator;

/**
 * @extends ServiceEntityRepository<ORMEntity>
 */
class ExerciseRepository extends ServiceEntityRepository implements ExerciseRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ORMEntity::class);
    }

    /**
     * @param int $examinationId
     * @param Exercise[] $exercises
     * @return void
     */
    public function addExercises(int $examinationId, array $exercises): void
    {
        foreach ($exercises as $exercise) {
            $entity = new ORMEntity();
            $entity->setExaminationId($examinationId);
            $entity->setQuestion($exercise->getQuestion()->getValue());
            $entity->setAnswer($exercise->getAnswer()->getValue());
            $entity->setCorrectAnswer($exercise->getCorrectAnswer()->getValue());
            $entity->setCompleted($exercise->isCompleted());
            $entity->setRight($exercise->isRight());
            $this->getEntityManager()->persist($entity);
        }
        $this->getEntityManager()->flush();
    }

    public function findNextExaminationExercise(int $examinationId): ?Exercise
    {
        $db = $this->getEntityManager()->createQueryBuilder();
        $db->select('e')
            ->from(ORMEntity::class, 'e')
            ->where('e.examinationId = :examinationId')
            ->setParameter('examinationId', $examinationId)
            ->andWhere('e.isCompleted = :isCompleted')
            ->setParameter('isCompleted', false)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(1);

        /** @var ORMEntity|null $entity */
        $entity = $db->getQuery()->getOneOrNullResult();
        $exercise = null;
        if ($entity) {
            $exercise = $this->makeExerciseByOrmEntity($entity);
        }
        return $exercise;
    }

    /**
     * @param int $examinationId
     * @return Iterator<Exercise>
     */
    public function getExaminationExercises(int $examinationId): Iterator
    {
        $db = $this->getEntityManager()->createQueryBuilder();
        $db->select('e')
            ->from(ORMEntity::class, 'e')
            ->where('e.examinationId = :examinationId')
            ->orderBy('e.id', 'ASC');

        /** @var ORMEntity[] $entities */
        $entities = $db->getQuery()->getResult();
        foreach ($entities as $entity) {
            yield $this->makeExerciseByOrmEntity($entity);
        }
    }

    public function getNotCompletedExerciseById(int $exerciseId): Exercise
    {
        $entity = $this->findOneBy(['id' => $exerciseId, 'isCompleted' => false]);
        if (!$entity) {
            throw new NotFoundException();
        }
        return $this->makeExerciseByOrmEntity($entity);
    }

    public function updateExercise(int $exerciseId, UpdateExerciseRequest $request): void
    {
        $entity = $this->findOneBy(['id' => $exerciseId]);
        if (!$entity) {
            throw new NotFoundException();
        }

        if ($request->answer) {
            $entity->setAnswer($request->answer->getValue());
        }
        if ($request->isCompleted) {
            $entity->setCompleted($request->isCompleted);
        }
        if ($request->isRight) {
            $entity->setRight($request->isRight);
        }

        $this->getEntityManager()->flush();
    }

    private function makeExerciseByOrmEntity(ORMEntity $entity): Exercise
    {
        $exercise = new Exercise(
            new Text($entity->getQuestion()),
            new Text($entity->getAnswer()),
            new Text($entity->getCorrectAnswer()),
            $entity->isCompleted(),
            $entity->isRight()
        );
        $reflectionProperty = new \ReflectionProperty(Exercise::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($exercise, $entity->getId());
        return $exercise;
    }
}
