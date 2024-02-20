<?php declare(strict_types=1);

namespace App\Console\Command;

use App\Generator\CompositeGenerator;
use App\Generator\ProductGenerator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'product:generator:list')]
class ProductGeneratorListCommand extends Command
{
    public function __construct(
        private CompositeGenerator $productGenerator,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->productGenerator->getGenerators() as $generator) {
            $output->writeln(get_class($generator));
        }

        return Command::SUCCESS;
    }
}

