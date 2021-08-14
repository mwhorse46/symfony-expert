<?php
declare(strict_types=1);

namespace App\Database\Entity;

use App\Database\Contract\EntityInterface;
use App\Database\Repository\UserRepository;
use App\Database\Trait\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "`user`")]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface, EntityInterface
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255, unique: true)]
    private string|null $email;

    #[ORM\Column(type: "string", length: 255, unique: true)]
    private string|null $username;

    #[ORM\Column(type: "string", length: 255)]
    private string|null $name;

    #[ORM\Column(type: "string", length: 255)]
    private string|null $password;

    #[ORM\OneToOne(targetEntity: Media::class, cascade: ["persist", "remove"])]
    private Media|null $media;

    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: "users")]
    private Role|null $role;

    //Id
    public function getId(): ?int
    {
        return $this->id;
    }

    //Email
    public function getEmail(): string|null
    {
        return $this->email;
    }

    public function setEmail(string|null $email): self
    {
        if ($email) {
            $this->email = $email;
        }

        return $this;
    }

    //Username
    public function getUsername(): string|null
    {
        return $this->username;
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->username;
    }

    public function setUsername(string|null $username): self
    {
        if ($username) {
            $this->username = $username;
        }

        return $this;
    }

    //Name
    public function getName(): string|null
    {
        return $this->name;
    }

    public function setName(string|null $name): self
    {
        if ($name) {
            $this->name = $name;
        }

        return $this;
    }

    //Password
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string|null $password): self
    {
        if ($password) {
            $this->password = $password;
        }

        return $this;
    }

    //MediaId
    public function getMedia(): Media|null
    {
        return $this->media;
    }

    public function setMedia(Media|null $media): self
    {
        if ($media) {
            $this->media = $media;
        }

        return $this;
    }

    //Role
    public function getRole(): Role|null
    {
        return $this->role;
    }

    public function setRole(Role|null $role): self
    {
        if ($role) {
            $this->role = $role;
        }

        return $this;
    }

    public function getRoles()
    {
        return [$this->role];
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
