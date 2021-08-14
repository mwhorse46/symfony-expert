<?php
declare(strict_types=1);

namespace App\Database\Trait;

use DateTimeImmutable;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

trait SoftDeletable
{
    #[ORM\Column(type: "datetime_immutable", nullable: true)]
    private DateTimeImmutable|null $deleted_at;

    //DeletedAt
    public function getDeletedAt(): DateTimeImmutable|null
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(DateTimeImmutable|null $deletedAt): self
    {
        $this->deleted_at = $deletedAt;

        return $this;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[ORM\PreFlush]
    public function updateWhenDelete(PreFlushEventArgs $event)
    {
        $em = $event->getEntityManager();

        foreach ($em->getUnitOfWork()->getScheduledEntityDeletions() as $object) {
            if (method_exists($object, "getDeletedAt")) {
                if ($object->getDeletedAt() instanceof DateTimeImmutable) {
                    continue;
                }

                $object->setDeletedAt(new DateTimeImmutable());

                $em->flush($object);
                $em->persist($object);
            }
        }
    }
}