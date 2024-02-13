<?php declare(strict_types=1);

namespace App\Controller;

use App\PageLoader\GenericPageLoader;
use App\PageLoader\GenericPageLoaderInterface;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
        #[Autowire(service: GenericPageLoader::class)] private GenericPageLoaderInterface $genericPageLoader
    ) {
    }

    #[Route(path: '/search')]
    public function __invoke(Request $request): Response
    {
        $search = $this->filterSearch((string)$request->query->get('search'));
        $products = $this->productRepository->findBySearch($search);

        return $this->render('page/search.html.twig', $this->genericPageLoader->mergeParameters([
            'products' => $products,
        ]));
    }

    private function filterSearch(string $search): string
    {
        $search = trim($search);
        $search = strip_tags($search);

        return $search;
    }
}