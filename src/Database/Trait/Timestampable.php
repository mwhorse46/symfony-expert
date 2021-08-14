<?php
declare(strict_types=1);

namespace App\Database\Trait;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait Timestampable
{
    #[ORM\Column(type: "datetime_immutable")]
    private DateTimeImmutable|null $created_at;

    #[ORM\Column(type: "datetime_immutable", nullable: true)]
    private DateTimeImmutable|null $updated_at;

    //CreatedAt
    public function getCreatedAt(): DateTimeImmutable|null
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->created_at = $createdAt;

        return $this;
    }

    //UpdatedAt
    public function getUpdatedAt(): DateTimeImmutable|null
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTimeImmutable|null $updatedAt): self
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function updateCreatedOnPersist()
    {
        if (method_exists($this, 'setCreatedAt')) {
            $this->setCreatedAt(new DateTimeImmutable());
        }
    }

    #[ORM\PreUpdate]
    public function updateUpdateOnUpdate()
    {
        if (method_exists($this, 'setUpdatedAt')) {
            $this->setUpdatedAt(new DateTimeImmutable());
        }
    }
}