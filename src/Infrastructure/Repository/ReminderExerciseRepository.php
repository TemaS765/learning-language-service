<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\ReminderExercise;
use App\Domain\Exception\NotFoundException;
use App\Domain\Repository\ReminderExerciseRepositoryInterface;
use App\Domain\Repository\Request\UpdateExerciseRequest;
use App\Domain\Repository\Request\UpdateReminderExerciseRequest;
use App\Infrastructure\Entity\ReminderExercise AS ORMEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ORMEntity>
 */
class ReminderExerciseRepository extends ServiceEntityRepository implements ReminderExerciseRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ORMEntity::class);
    }

    public function findLastReminderNotCompletedExercise(int $reminderId): ?ReminderExercise
    {
        $db = $this->getEntityManager()->createQueryBuilder();
        $db->select('r')
            ->from(ORMEntity::class, 'r')
            ->where('r.reminderId = :reminderId')
            ->andWhere('r.isCompleted = false')
            ->setParameter('reminderId', $reminderId)
            ->orderBy('r.id', 'DESC')
            ->setMaxResults(1);

        /** @var ORMEntity $entity */
        $entity = $db->getQuery()->getOneOrNullResult();

        $exercise = null;
        if ($entity) {
            $exercise = new ReminderExercise(
                $entity->getReminderId(),
                $entity->getQuestion(),
                $entity->getAnswer(),
                $entity->getCorrectAnswer(),
                $entity->isCompleted(),
                $entity->isRight()
            );

            $reflectionProperty = new \ReflectionProperty(ReminderExercise::class, 'id');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($exercise, $entity->getId());
        }

        return $exercise;
    }

    public function addReminderExercise(ReminderExercise $exercise): ReminderExercise
    {
        $entity = new ORMEntity();
        $entity->setReminderId($exercise->getReminderId());
        $entity->setQuestion($exercise->getQuestion());
        $entity->setAnswer($exercise->getAnswer());
        $entity->setCorrectAnswer($exercise->getCorrectAnswer());
        $entity->setCompleted($exercise->isCompleted());
        $entity->setRight($exercise->isRight());

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        $reflectionProperty = new \ReflectionProperty(ReminderExercise::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($exercise, $entity->getId());

        return $exercise;
    }

    public function getNotCompletedReminderExercise(): ?ReminderExercise
    {
        $db = $this->getEntityManager()->createQueryBuilder();
        $db->select('e')
            ->from(ORMEntity::class, 'e')
            ->where('e.isCompleted = false')
            ->orderBy('e.id', 'DESC')
            ->setMaxResults(1);

        /** @var ORMEntity $entity */
        $entity = $db->getQuery()->getOneOrNullResult();

        $exercise = null;
        if ($entity) {
            $exercise = new ReminderExercise(
                $entity->getReminderId(),
                $entity->getQuestion(),
                $entity->getAnswer(),
                $entity->getCorrectAnswer(),
                $entity->isCompleted(),
                $entity->isRight()
            );

            $reflectionProperty = new \ReflectionProperty(ReminderExercise::class, 'id');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($exercise, $entity->getId());
        }

        return $exercise;
    }

    public function updateReminderExercise(int $exerciseId, UpdateReminderExerciseRequest $request): void
    {
        $entity = $this->findOneBy(['id' => $exerciseId]);
        if (!$entity) {
            throw new NotFoundException();
        }

        if ($request->answer) {
            $entity->setAnswer($request->answer);
        }
        if ($request->isCompleted) {
            $entity->setCompleted($request->isCompleted);
        }
        if ($request->isRight) {
            $entity->setRight($request->isRight);
        }

        $this->getEntityManager()->flush();
    }
}
