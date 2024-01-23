<?php declare(strict_types=1);

namespace App\Controller;

use App\Product\ProductLoader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    public function __construct(
        private ProductLoader $productLoader
    ) {
    }

    #[Route(path: '/')]
    public function homepage(): Response
    {
        $products = $this->productLoader->getProducts();
        return $this->render('homepage.html.twig', ['products' => $products]);
    }
}