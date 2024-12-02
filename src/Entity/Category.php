<?php

declare(strict_types=1);
// src/Entity/Category.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
#[ORM\Entity]
#[ORM\Table(name: 'category')]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: BlogPost::class, mappedBy: 'category', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $blogPosts;

    public function __construct()
    {
        $this->blogPosts = new ArrayCollection();
    }

    /**
     * Get the ID of the category.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the name of the category.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the name of the category.
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the blog posts associated with this category.
     *
     * @return Collection<int, BlogPost>
     */
    public function getBlogPosts(): Collection
    {
        return $this->blogPosts;
    }

    /**
     * Add a blog post to this category.
     */
    public function addBlogPost(BlogPost $blogPost): self
    {
        if (!$this->blogPosts->contains($blogPost)) {
            $this->blogPosts[] = $blogPost;
            $blogPost->setCategory($this);
        }

        return $this;
    }

    /**
     * Remove a blog post from this category.
     */
    public function removeBlogPost(BlogPost $blogPost): self
    {
        if ($this->blogPosts->removeElement($blogPost)) {
            // Set the owning side to null (unless already changed)
            if ($blogPost->getCategory() === $this) {
                $blogPost->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * String representation of the category.
     */
    public function __toString(): string
    {
        return $this->name ?? 'Unnamed Category';
    }
}