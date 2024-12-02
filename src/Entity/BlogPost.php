<?php

declare(strict_types=1);
// src/Entity/BlogPost.php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Category;

/**
 * @ORM\Entity
 * @ORM\Table(name="blog_post")
 */
#[ORM\Entity]
#[ORM\Table(name: 'blog_post')]
class BlogPost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $body = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $draft = false;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'blogPosts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    /**
     * Get the ID of the blog post.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the title of the blog post.
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the title of the blog post.
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the body/content of the blog post.
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * Set the body/content of the blog post.
     */
    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Check if the blog post is a draft.
     */
    public function isDraft(): bool
    {
        return $this->draft;
    }

    /**
     * Set the draft status of the blog post.
     */
    public function setDraft(bool $draft): self
    {
        $this->draft = $draft;

        return $this;
    }

    /**
     * Get the category of the blog post.
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Set the category of the blog post.
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * String representation of the blog post.
     */
    public function __toString(): string
    {
        return $this->title ?? 'Untitled Blog Post';
    }
}