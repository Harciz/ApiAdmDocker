<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\ManyToOne;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity]
#[ApiResource(
    normalizationContext: ['groups' => ['book:read']],
    denormalizationContext: ['groups' => ['book:write']],
    paginationItemsPerPage: 10,
    formats: ['jsonld', 'json', 'html']
)]
#[ApiFilter(SearchFilter::class, properties: [
    'title' => 'partial',
    'author' => 'partial',
    'category.name' => 'partial'
])]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['book:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['book:read', 'book:write'])]
    private string $title;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['book:read', 'book:write'])]
    private string $author;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: true)] 
    #[Groups(['book:read', 'book:write'])]
    private ?Category $category = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['book:read', 'book:write'])]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotNull]
    #[Groups(['book:read', 'book:write'])]
    private \DateTimeInterface $publishedAt;

    #[ApiProperty(description: "The cover image of the book", readable: true, writable: true)]
    #[Groups(['book:read', 'book:write'])]
    private ?string $coverImage = null;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['book:read', 'book:write'])]
    private bool $published = false;

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): static
    {
        $this->coverImage = $coverImage;
        return $this;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): static
    {
        $this->published = $published;
        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): static
    {
        $this->category = $category;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;
        return $this;
    }

    public function getPublishedAt(): \DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): static
    {
        $this->publishedAt = $publishedAt;
        return $this;
    }
}