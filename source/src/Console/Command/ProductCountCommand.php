<?php declare(strict_types=1);

namespace App\Console\Command;

use App\Repository\ProductRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'product:count')]
class ProductCountCommand extends Command
{
    public function __construct(
        private ProductRepository $productRepository,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln($this->productRepository->countAll(). ' products');

        return Command::SUCCESS;
    }
}