<?php declare(strict_types=1);

namespace App\Controller;

use App\PageLoader\GenericPageLoader;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
        private GenericPageLoader $genericPageLoader
    ) {
    }

    #[Route(path: '/product/{id}')]
    public function __invoke(Request $request): Response
    {
        $productId = (int)$request->get('id');
        $product = $this->productRepository->find($productId);
        if (!$product) {
            return $this->render('page/notfound.html.twig', $this->genericPageLoader->mergeParameters([]));
        }

        return $this->render('page/product.html.twig', $this->genericPageLoader->mergeParameters([
            'product' => $product,
        ]));
    }
}
