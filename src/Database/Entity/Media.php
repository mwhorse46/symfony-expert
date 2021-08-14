<?php
declare(strict_types=1);

namespace App\Database\Entity;

use App\Database\Contract\EntityInterface;
use App\Database\Repository\MediaRepository;
use App\Database\Trait\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Media implements EntityInterface
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

    #[ORM\Column(type: "string", length: 255)]
    private string|null $type;

    #[ORM\Column(type: "string", length: 255)]
    private string|null $url;

    #[ORM\OneToMany(mappedBy: "media_id", targetEntity: Post::class)]
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

    //Type
    public function getType(): string|null
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    //Url
    public function getUrl(): string|null
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    //Post

    /**
     * @return Collection<int, Post>
     */
    public function getPost(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setMediaId($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getMediaId() === $this) {
                $post->setMediaId(null);
            }
        }

        return $this;
    }
}
