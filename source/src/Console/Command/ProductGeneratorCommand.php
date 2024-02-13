<?php declare(strict_types=1);

namespace App\Console\Command;

use App\Generator\ProductGenerator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'product:generate')]
class ProductGeneratorCommand extends Command
{
    public function __construct(
        private ProductGenerator $productGenerator,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addOption('amount', null, InputOption::VALUE_OPTIONAL, 'Amount of products to create', 1);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $amount = (int)$input->getOption('amount');
        if ($amount < 1) $amount = 1;

        $output->writeln('Generator '.$amount.' products');
        $progressBar = new ProgressBar($output, $amount);
        $progressBar->start();

        for ($i = 0; $i < $amount; $i++) {
            $progressBar->advance();
            $this->productGenerator->generate(false);

            if ($i % 10 === 0) {
                $this->productGenerator->flush();
            }
        }

        $this->productGenerator->flush();

        $progressBar->finish();
        $output->writeln('');

        return Command::SUCCESS;
    }
}

