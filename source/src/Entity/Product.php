<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null,
        #[ORM\Column(length: 255)]
        private ?string $title = null,
        #[ORM\Column]
        private ?float $price = null,
        #[ORM\Column(length: 255, nullable: true)]
        private ?string $description = null,
        #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
        private ?Category $category = null,
        #[ORM\Column(length: 255)]
        private ?string $image = null,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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

    public function getImage(): ?string
    {
        $image = $this->image;
        if (!preg_match('#^/#', $image) && !preg_match('#^(http|https)://#', $image)) {
            $image = '/images/'.$image;
        }

        return $image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
