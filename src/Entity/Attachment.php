<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AttachmentRepository;

// #[ORM\Entity(repositoryClass: AttachmentRepository::class)]
#[ORM\Entity]
#[ORM\Table(name: 'attachment')]
class Attachment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $filename;

    #[ORM\ManyToOne(targetEntity: BlogPost::class, inversedBy: 'attachments')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?BlogPost $blogPost = null;

    public function __toString(): string
    {
        return $this->filename ?? '';
    }
    // Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getBlogPost(): ?BlogPost
    {
        return $this->blogPost;
    }

    public function setBlogPost(?BlogPost $blogPost): self
    {
        $this->blogPost = $blogPost;

        return $this;
    }
}