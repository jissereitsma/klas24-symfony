<?php declare(strict_types=1);

namespace App\Console\Command;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'category:edit')]
class CategoryEditCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CategoryRepository $categoryRepository,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addOption('id', null, InputOption::VALUE_REQUIRED, 'Category ID');
        $this->addOption('name', null, InputOption::VALUE_OPTIONAL, 'Category name');
        $this->addOption('parent_id', null, InputOption::VALUE_OPTIONAL, 'Parent ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $categoryId = (int)$input->getOption('id');
        $category = $this->categoryRepository->find($categoryId);

        $name = trim((string)$input->getOption('name'));
        $parentId = $input->getOption('parent_id');

        if (!empty($name)) {
            $category->setTitle($name);
        }

        if (is_numeric($parentId)) {
            $category->setParentId((int)$parentId);
        }

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}