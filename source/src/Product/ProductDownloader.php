<?php declare(strict_types=1);

namespace App\Product;

use App\Kernel;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProductDownloader
{
    const URL = 'https://dummyjson.com/products';

    public function __construct(
        private Kernel $kernel,
        private HttpClientInterface $httpClient,
        #[Autowire(value: '%app.product_json_dir%')] private string $jsonFolder = ''
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

        $filename = $this->kernel->getProjectDir() . '/'.$this->jsonFolder.'/products.json';
        file_put_contents($filename, $content);
    }
}
