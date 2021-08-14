<?php
declare(strict_types=1);

namespace App\Database\Entity;

use App\Database\Contract\EntityInterface;
use App\Database\Repository\PostTypeRepository;
use App\Database\Trait\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: PostTypeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class PostType implements EntityInterface
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string|null $name;

    #[ORM\Column(type: "string", length: 255)]
    private string|null $slug;

    #[ORM\Column(type: "text", nullable: true)]
    private string|null $description;

    #[ORM\OneToMany(mappedBy: "post_type_id", targetEntity: Post::class, orphanRemoval: true)]
    private ArrayCollection $posts;

    #[Pure]
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    //Id
    public function getId(): ?int
    {
        return $this->id;
    }

    //Name
    public function getName(): string|null
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    //Slug
    public function getSlug(): string|null
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    //Description
    public function getDescription(): string|null
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    //Posts

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setPostType($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getPostType() === $this) {
                $post->setPostType(null);
            }
        }

        return $this;
    }
}
