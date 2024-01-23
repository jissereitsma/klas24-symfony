<?php declare(strict_types=1);

namespace App\Controller;

use App\Product\ProductLoader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private ProductLoader $productLoader
    ) {
    }

    #[Route(path: '/product/{id}')]
    public function __invoke(Request $request): Response
    {
        $productId = (int)$request->get('id');
        $product = $this->productLoader->getProductById($productId);

        return $this->render('product.html.twig', ['product' => $product]);
    }
}
