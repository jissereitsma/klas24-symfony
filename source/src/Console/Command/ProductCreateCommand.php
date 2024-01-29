<?php declare(strict_types=1);

namespace App\Console\Command;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'product:create')]
class ProductCreateCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $product = new Product();
        $product->setTitle('Keyboard');
        $product->setCategory('fppbar');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');
        $product->setImage('Ergonomic and stylish!');

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}