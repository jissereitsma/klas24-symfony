<?php declare(strict_types=1);

namespace App\ExampleBundle;

use App\ExampleBundle\DependencyInjection\ExampleCompilerPass;
use App\ExampleBundle\DependencyInjection\ExampleExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ExampleBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $compilerPass = new ExampleCompilerPass();
        $container->addCompilerPass($compilerPass);
    }

    public function getContainerExtension(): null|ExtensionInterface
    {
        return new ExampleExtension();
    }
}
