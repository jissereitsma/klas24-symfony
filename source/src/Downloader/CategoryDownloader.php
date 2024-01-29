<?php declare(strict_types=1);

namespace App\Downloader;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CategoryDownloader
{
    const URL = 'https://fakestoreapi.com/products/categories';

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
        $connection->executeQuery('TRUNCATE category');

        $data = json_decode($content, true);
        foreach ($data as $categoryName) {
            $category = new Category();
            $category->setTitle($categoryName);

            $this->entityManager->persist($category);
            $this->entityManager->flush();
        }
    }
}
