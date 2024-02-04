<?php declare(strict_types=1);

namespace App\Controller;

use App\PageLoader\GenericPageLoader;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
        private GenericPageLoader $genericPageLoader
    ) {
    }

    #[Route(path: '/search')]
    public function __invoke(Request $request): Response
    {
        $search = trim((string)$request->query->get('search'));
        $products = $this->productRepository->findBySearch($search);

        return $this->render('page/search.html.twig', $this->genericPageLoader->mergeParameters([
            'products' => $products,
        ]));
    }
}