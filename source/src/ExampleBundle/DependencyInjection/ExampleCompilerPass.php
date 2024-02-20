<?php declare(strict_types=1);

namespace App\ExampleBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ExampleCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        //$kernelDefinition = $container->getDefinition('kernel');
        //$kernelDefinition->setArgument('sdf', 'sfds');
    }
}