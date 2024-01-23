<?php declare(strict_types=1);

namespace App\Product;

use App\Kernel;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ProductLoader
{
    public function __construct(
        private Kernel $kernel,
        #[Autowire(value: '%app.product_json_dir%')] private string $jsonFolder = ''
    ) {
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        $filename = $this->kernel->getProjectDir() . '/' . $this->jsonFolder . '/products.json';
        $data = file_get_contents($filename);

        $products = [];
        $data = json_decode($data, true);
        foreach ($data['products'] as $productData) {
            $products[] = $this->createProduct($productData);
        }

        usort($products, function(Product $product1, Product $product2) {
            return strcmp($product1->getTitle(), $product2->getTitle());
        });

        return $products;
    }

    public function getProductById(int $productId): Product
    {
        foreach($this->getProducts() as $product) {
            if ($product->getId() === $productId) {
                return $product;
            }
        }

        throw new \RuntimeException('Product not found');
    }

    private function createProduct(array $data):Product
    {
        return new Product(
            $data['id'],
            $data['title'],
            $data['description'],
            $data['thumbnail'],
            $data['price'],
        );
    }
}
