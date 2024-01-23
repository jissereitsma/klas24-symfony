<?php declare(strict_types=1);

namespace App\Product;

class Product
{
    public function __construct(
        private int $id,
        private string $title,
        private string $description,
        private string $thumbnail,
        private int $price,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

}