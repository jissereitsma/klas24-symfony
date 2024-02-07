<?php declare(strict_types=1);

namespace App\Controller;

use App\PageLoader\GenericPageLoader;
use App\PageLoader\GenericPageLoaderInterface;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
        private CategoryRepository $categoryRepository,
        #[Autowire(service: GenericPageLoader::class)] private GenericPageLoaderInterface $genericPageLoader
    ) {
    }

    #[Route(name: 'category', path: '/category/{id}', methods: ['GET', 'HEAD'])]
    public function __invoke(Request $request): Response
    {
        $categoryId = (int)$request->get('id');

        try {
            $category = $this->categoryRepository->find($categoryId);
        } catch (NotFoundHttpException $exception) {
            return $this->render('page/notfound.html.twig', $this->genericPageLoader->mergeParameters([
            ]));
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