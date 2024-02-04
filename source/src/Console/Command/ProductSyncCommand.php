<?php declare(strict_types=1);

namespace App\Console\Command;

use App\Downloader\ProductDownloader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'product:sync')]
class ProductSyncCommand extends Command
{
    public function __construct(
        private ProductDownloader $productDownloader,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->productDownloader->download();
        $output->writeln('Products are downloaded from remote API');
        return Command::SUCCESS;
    }
}

