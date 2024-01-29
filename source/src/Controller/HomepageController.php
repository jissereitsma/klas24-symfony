<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
        private CategoryRepository $categoryRepository,

    ) {
    }

    #[Route(path: '/')]
    public function homepage(): Response
    {
        $products = $this->productRepository->findAll();
        $categories = $this->categoryRepository->findAll();

        return $this->render('homepage.html.twig', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}