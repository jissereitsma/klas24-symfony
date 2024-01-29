<?php declare(strict_types=1);

namespace App\Console\Command;

use App\Repository\ProductRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'product:list')]
class ProductListCommand extends Command
{
    public function __construct(
        private ProductRepository $productRepository,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $products = $this->productRepository->findAll();

        $table = new Table($output);
        $table->setHeaders(['ID', 'Title', 'Description']);

        foreach ($products as $product) {
            $table->addRow([
                $product->getId(),
                $product->getTitle(),
                substr($product->getDescription(), 0, 10) . '...'
            ]);
        }

        $table->render();

        return Command::SUCCESS;
    }
}