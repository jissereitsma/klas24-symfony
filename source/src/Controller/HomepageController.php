<?php declare(strict_types=1);

namespace App\Controller;

use App\PageLoader\GenericPageLoader;
use App\Repository\ProductRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\EventDispatcher\Event;

class HomepageController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
        private GenericPageLoader $genericPageLoader,
        #[Autowire(service: 'monolog.logger.custom')] private LoggerInterface $customLogger
    ) {
    }

    #[Route(path: '/', methods: ['GET'])]
    public function homepage(): Response
    {
        $products = $this->productRepository->findAll();

        $parameters = $this->genericPageLoader->mergeParameters([
            'products' => $products,
        ]);

        $this->customLogger->warning('Homeoage');

        return $this->render('page/homepage.html.twig', $parameters);
    }
}