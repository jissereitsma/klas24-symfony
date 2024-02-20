<?php declare(strict_types=1);

namespace App\Console\Command;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;

#[AsCommand(name: 'category:create')]
class CategoryCreateCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addOption('name', null, InputOption::VALUE_REQUIRED, 'Category name');
        $this->addOption('parent_id', null, InputOption::VALUE_OPTIONAL, 'Parent ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = trim((string)$input->getOption('name'));
        $parentId = (int)$input->getOption('parent_id');
        if ($parentId < 1) {
            throw new \RuntimeException('Parent ID should be higher than 0');
        }

        $category = new Category();
        $category->setTitle($name);
        $category->setParentId($parentId);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}