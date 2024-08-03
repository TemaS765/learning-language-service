<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Examination;
use App\Domain\Enum\ExaminationType;
use App\Domain\Exception\NotFoundException;
use App\Domain\Repository\ExaminationRepositoryInterface;
use App\Infrastructure\Entity\Examination as ORMEntity;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Examination>
 */
class ExaminationRepository extends ServiceEntityRepository implements ExaminationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ORMEntity::class);
    }

    public function addExamination(Examination $examination): Examination
    {
        $entity = new ORMEntity();
        $entity->setType($examination->getType());
        $entity->setStartedAt($examination->getStartedAt());

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();


        $reflectionProperty = new \ReflectionProperty(Examination::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($examination, $entity->getId());
        return $examination;
    }

    public function findNotCompletedExamination(ExaminationType $type): ?Examination
    {
        $db = $this->getEntityManager()->createQueryBuilder();
        $db->select('e')
            ->from(ORMEntity::class, 'e')
            ->where('e.type = :type')
            ->setParameter('type', $type)
            ->andWhere('e.finishedAt is null')
            ->setMaxResults(1);
        /** @var ORMEntity|null $entity */
        $entity = $db->getQuery()->getOneOrNullResult();
        $examination = null;
        if ($entity) {
            $examination = $this->makeExaminationByOrmEntity($entity);
        }
        return $examination;
    }

    public function updateExaminationFinishedAt(int $examinationId, DateTimeInterface $dateTime): void
    {
        $entity = $this->findOneBy(['id' => $examinationId]);
        if (!$entity) {
            throw new NotFoundException();
        }

        $entity->setFinishedAt($dateTime);

        $this->getEntityManager()->flush();
    }

    private function makeExaminationByOrmEntity(ORMEntity $entity): Examination
    {
        $examination = new Examination(
            $entity->getType(),
            $entity->getStartedAt()
        );
        $examination->setFinishedAt($entity->getFinishedAt());
        $reflectionProperty = new \ReflectionProperty(Examination::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($examination, $entity->getId());
        return $examination;
    }
}
