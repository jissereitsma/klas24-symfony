<?php declare(strict_types=1);

namespace App\Controller;

use App\PageLoader\GenericPageLoader;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
        private GenericPageLoader $genericPageLoader
    ) {
    }

    #[Route(path: '/')]
    public function homepage(): Response
    {
        $products = $this->productRepository->findAll();

        $parameters = $this->genericPageLoader->mergeParameters([
            'products' => $products,
        ]);

        return $this->render('page/homepage.html.twig', $parameters);
    }
}