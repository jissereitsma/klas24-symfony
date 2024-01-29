<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
        private CategoryRepository $categoryRepository,
    ) {
    }

    #[Route(path: '/product/{id}')]
    public function __invoke(Request $request): Response
    {
        $productId = (int)$request->get('id');
        $product = $this->productRepository->find($productId);

        $categories = $this->categoryRepository->findAll();

        return $this->render('product.html.twig', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }
}
