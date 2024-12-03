<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Reminder;
use App\Domain\Exception\NotFoundException;
use App\Domain\Repository\ReminderRepositoryInterface;
use App\Domain\Repository\Request\UpdateReminder;
use App\Infrastructure\Entity\Reminder as ORMEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ORMEntity>
 */
class ReminderRepository extends ServiceEntityRepository implements ReminderRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ORMEntity::class);
    }

    public function addReminder(Reminder $reminder): Reminder
    {
        $entity = new ORMEntity();
        $entity->setRepeatPeriod($reminder->getRepeatPeriod());
        $entity->setChannelId($reminder->getChannelId());
        $entity->setChannelType($reminder->getChannelType());
        $entity->setActive($reminder->isActive());
        $entity->setCreatedAt($reminder->getCreatedAt());
        $entity->setUpdatedAt($reminder->getUpdatedAt());
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        $reflectionProperty = new \ReflectionProperty(Reminder::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($reminder, $entity->getId());

        return $reminder;
    }

    public function findReminder(): ?Reminder
    {
        $entity = $this->findOneBy([]);
        $reminder = null;
        if ($entity) {
            $reminder = $this->makeReminderByORMEntity($entity);
        }

        return $reminder;
    }

    public function updateReminderById(int $id, UpdateReminder $request): void
    {
        $entity = $this->findOneBy(['id' => $id]);
        if (!$entity) {
            throw new NotFoundException();
        }

        if (null != $request->repeatPeriod) {
            $entity->setRepeatPeriod($request->repeatPeriod);
        }
        if (null !== $request->channelId) {
            $entity->setChannelId($request->channelId);
        }
        if (null !== $request->channelType) {
            $entity->setChannelType($request->channelType);
        }
        if (null !== $request->isActive) {
            $entity->setActive($request->isActive);
        }
        if (null !== $request->lastReminderAt) {
            $entity->setLastReminderAt($request->lastReminderAt);
        }

        $entity->setUpdatedAt(new \DateTime());

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /** @return \Iterator<Reminder> */
    public function getAllActiveReminders(): \Iterator
    {
        $db = $this->getEntityManager()->createQueryBuilder();
        $db->select('r')
            ->from(ORMEntity::class, 'r')
            ->where('r.isActive = true')
            ->orderBy('r.id');

        $entities = $db->getQuery()->getResult();
        foreach ($entities as $entity) {
            $this->getEntityManager()->refresh($entity);
            yield $this->makeReminderByORMEntity($entity);
        }
    }

    private function makeReminderByORMEntity(ORMEntity $entity): Reminder
    {
        $reminder = new Reminder(
            $entity->getRepeatPeriod(),
            $entity->getChannelType(),
            $entity->getChannelId(),
            $entity->isActive()
        );

        $reflectionProperty = new \ReflectionProperty(Reminder::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($reminder, $entity->getId());

        $reflectionProperty = new \ReflectionProperty(Reminder::class, 'createdAt');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($reminder, $entity->getCreatedAt());

        $reflectionProperty = new \ReflectionProperty(Reminder::class, 'updatedAt');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($reminder, $entity->getUpdatedAt());

        $reflectionProperty = new \ReflectionProperty(Reminder::class, 'lastReminderAt');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($reminder, $entity->getLastReminderAt());

        return $reminder;
    }
}
