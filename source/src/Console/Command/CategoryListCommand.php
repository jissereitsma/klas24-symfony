<?php declare(strict_types=1);

namespace App\Console\Command;

use App\Repository\CategoryRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'category:list')]
class CategoryListCommand extends Command
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $categories = $this->categoryRepository->findAll();

        $table = new Table($output);
        $table->setHeaders(['ID', 'Title', 'Parent ID']);

        foreach ($categories as $category) {
            $table->addRow([
                $category->getId(),
                $category->getTitle(),
                $category->getParentId()
            ]);
        }

        $table->render();

        return Command::SUCCESS;
    }
}