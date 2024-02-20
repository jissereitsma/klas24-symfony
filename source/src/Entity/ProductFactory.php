<?php declare(strict_types=1);

namespace App\Entity;

class ProductFactory
{
    public static function create(): Product
    {
        $product = new Product();
        $product->setPrice(42);
        return $product;
    }
}