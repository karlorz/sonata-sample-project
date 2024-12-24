<?php

declare(strict_types=1);
// src/Entity/BlogPost.php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'blog_post')]
class BlogPost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank(message: "The title should not be blank.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "The title cannot exceed {{ limit }} characters."
    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "The content should not be blank.")]
    #[Assert\Length(
        min: 10,
        minMessage: "The content must be at least {{ limit }} characters long."
    )]
    private ?string $body = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $draft = false;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'blogPosts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "The category must be selected.")]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'blogPost', targetEntity: Attachment::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $attachments;

    // ... (Constructor, Getters, Setters, __toString)
    
    public function __construct()
    {
        // Initialize collections if any
        $this->attachments = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->title ?? 'Untitled Blog Post';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function isDraft(): bool
    {
        return $this->draft;
    }

    public function setDraft(bool $draft): self
    {
        $this->draft = $draft;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Attachment>
     */
    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function addAttachment(Attachment $attachment): self
    {
        if (!$this->attachments->contains($attachment)) {
            $this->attachments[] = $attachment;
            $attachment->setBlogPost($this);
        }

        return $this;
    }

    public function removeAttachment(Attachment $attachment): self
    {
        if ($this->attachments->removeElement($attachment)) {
            // set the owning side to null (unless already changed)
            if ($attachment->getBlogPost() === $this) {
                $attachment->setBlogPost(null);
            }
        }

        return $this;
    }
}