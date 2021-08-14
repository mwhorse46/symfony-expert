<?php
declare(strict_types=1);

namespace App\Database\Entity;

use App\Database\Contract\EntityInterface;
use App\Database\Repository\PostRepository;
use App\Database\Trait\SoftDeletable;
use App\Database\Trait\Timestampable;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Post implements EntityInterface
{
    use Timestampable, SoftDeletable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string|null $title;

    #[ORM\Column(type: "string", length: 255)]
    private string|null $slug;

    #[ORM\Column(type: "text", nullable: true)]
    private string|null $description;

    #[ORM\Column(type: "json", nullable: true)]
    private array $content = [];

    #[ORM\Column(type: "json", nullable: true)]
    private array $meta = [];

    #[ORM\ManyToOne(targetEntity: Media::class, inversedBy: "post")]
    private Media|null $media;

    #[ORM\ManyToOne(targetEntity: PostType::class, inversedBy: "posts")]
    #[ORM\JoinColumn(nullable: false)]
    private PostType|null $post_type;

    #[ORM\Column(type: "datetime_immutable")]
    private DateTimeImmutable|null $created_at;

    #[ORM\Column(type: "datetime_immutable", nullable: true)]
    private DateTimeImmutable|null $updated_at;

    //Id
    public function getId(): int|null
    {
        return $this->id;
    }

    //Title
    public function getTitle(): string|null
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function setDescription(string|null $description): self
    {
        $this->description = $description;

        return $this;
    }

    //Content
    public function getContent(): array|null
    {
        return $this->content;
    }

    public function setContent(array|null $content): self
    {
        $this->content = $content;

        return $this;
    }

    //Meta
    public function getMeta(): array|null
    {
        return $this->meta;
    }

    public function setMeta(array|null $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    //Media
    public function getMedia(): Media|null
    {
        return $this->media;
    }

    public function setMedia(Media|null $media): self
    {
        $this->media = $media;

        return $this;
    }

    //Post Type
    public function getPostType(): PostType|null
    {
        return $this->post_type;
    }

    public function setPostType(PostType|null $postType): self
    {
        $this->post_type = $postType;

        return $this;
    }

    //CreatedAt
    public function getCreatedAt(): DateTimeImmutable|null
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->created_at = new DateTimeImmutable();

        return $this;
    }

    //UpdatedAt
    public function getUpdatedAt(): DateTimeImmutable|null
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DateTimeImmutable|null $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
