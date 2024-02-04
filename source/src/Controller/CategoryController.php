<?php declare(strict_types=1);

namespace App\Controller;

use App\PageLoader\GenericPageLoader;
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
        private GenericPageLoader $genericPageLoader
    ) {
    }

    #[Route(path: '/category/{id}')]
    public function __invoke(Request $request): Response
    {
        $categoryId = (int)$request->get('id');
        $category = $this->categoryRepository->find($categoryId);
        if (!$category) {
            return $this->render('page/notfound.html.twig', $this->genericPageLoader->mergeParameters([]));
        }

        $products = $this->productRepository->findBy([
            'category' => $category
        ]);

        return $this->render('page/category.html.twig', $this->genericPageLoader->mergeParameters([
            'category' => $category,
            'products' => $products,
        ]));
    }
}