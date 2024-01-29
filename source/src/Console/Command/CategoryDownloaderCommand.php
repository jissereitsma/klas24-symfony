<?php declare(strict_types=1);

namespace App\Console\Command;

use App\Downloader\CategoryDownloader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'category:download')]
class CategoryDownloaderCommand extends Command
{
    public function __construct(
        private CategoryDownloader $categoryDownloader,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->categoryDownloader->download();
        $output->writeln('Categories are downloaded from remote API');
        return Command::SUCCESS;
    }
}

