<?php
declare(strict_types=1);

namespace App\Database\Entity;

use App\Database\Contract\EntityInterface;
use App\Database\Repository\PermissionRepository;
use App\Database\Trait\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: PermissionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Permission implements EntityInterface
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string|null $name;

    #[ORM\ManyToMany(targetEntity: Role::class, mappedBy: "permissions")]
    private Collection $roles;

    #[Pure]
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    //Id
    public function getId(): ?int
    {
        return $this->id;
    }

    //Name
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    //Roles

    /**
     * @return Collection<int, Role>
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
            $role->addPermission($this);
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->roles->removeElement($role)) {
            $role->removePermission($this);
        }

        return $this;
    }
}
