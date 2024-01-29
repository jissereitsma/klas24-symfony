<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
        private CategoryRepository $categoryRepository,
    ) {
    }

    #[Route(path: '/category/{id}')]
    public function __invoke(Request $request): Response
    {
        $categoryId = (int)$request->get('id');
        $category = $this->categoryRepository->find($categoryId);

        $products = $this->productRepository->findBy([
            'category' => $category
        ]);

        $categories = $this->categoryRepository->findAll();

        return $this->render('category.html.twig', [
            'category' => $category,
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}