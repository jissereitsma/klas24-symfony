<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Product;
use App\PageLoader\GenericPageLoader;
use App\PageLoader\GenericPageLoaderInterface;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Criteria;
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
        #[Autowire(service: GenericPageLoader::class)] private GenericPageLoaderInterface $genericPageLoader,
        #[Autowire(service: 'monolog.logger.custom')] private LoggerInterface $customLogger
    ) {
    }

    #[Route(path: '/', methods: ['GET'])]
    public function homepage(): Response
    {
        $criteria = new Criteria();
        $criteria->setMaxResults(8);
        $products = $this->productRepository->matching($criteria);

        $parameters = $this->genericPageLoader->mergeParameters([
            'products' => $products,
        ]);

        $this->customLogger->notice('Homepage');

        return $this->render('page/homepage.html.twig', $parameters);
    }
}