<?php declare(strict_types=1);

namespace App\Downloader;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProductDownloader
{
    const URL = 'https://dummyjson.com/products';

    public function __construct(
        private HttpClientInterface $httpClient,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function download()
    {
        $response = $this->httpClient->request('GET', self::URL);
        if ($response->getStatusCode() !== 200) {
            throw new RuntimeException($response->getContent());
        }

        $content = $response->getContent();
        if (empty($content)) {
            throw new RuntimeException('Empty content');
        }

        $connection = $this->entityManager->getConnection();
        $connection->executeQuery('TRUNCATE product');

        /** @var ProductRepository $productRepository */
        /** @var CategoryRepository $categoryRepository */
        $productRepository = $this->entityManager->getRepository(Product::class);
        $categoryRepository = $this->entityManager->getRepository(Category::class);

        $data = json_decode($content, true);
        foreach ($data['products'] as $productData) {
            if ($productRepository->find($productData['id'])) {
                continue;
            }

            $product = new Product();
            $product->setTitle($productData['title']);
            $product->setDescription($productData['description']);
            $product->setImage($productData['thumbnail'] ?? '');
            $product->setPrice((float)$productData['price']);

            $category = $categoryRepository->findOneBy(['title' => $productData['category']]);
            if (empty($category)) {
                $category = new Category();
                $category->setTitle($productData['category']);
                $this->entityManager->persist($category);
                $this->entityManager->flush();
            }

            $product->setCategory($category);

            $this->entityManager->persist($product);
            $this->entityManager->flush();
        }
    }
}
