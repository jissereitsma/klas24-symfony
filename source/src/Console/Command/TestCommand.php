<?php declare(strict_types=1);

namespace App\Console\Command;

use App\Kernel;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(name: 'test')]
class TestCommand extends Command
{
    public function __construct(
        #[Autowire(service: 'kernel')] private $kernel,
        #[Autowire(param: 'foo.bar1.bar2')] private string $foo = '',
        string $name = null)
    {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Cache directory: '.$this->kernel->getCacheDir());
        $output->writeln('Custom parameter: '.$this->foo);
        return Command::SUCCESS;
    }
}