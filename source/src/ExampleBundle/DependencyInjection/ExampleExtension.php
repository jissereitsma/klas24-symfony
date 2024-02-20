<?php

declare(strict_types=1);

namespace App\ExampleBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class ExampleExtension extends Extension
{
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new ExampleConfiguration();
    }

    public function getAlias(): string
    {
        return 'foo';
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new ExampleConfiguration();

        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('foo.bar1.bar2', $config['bar1']['bar2']);
    }
}
