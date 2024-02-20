<?php

declare(strict_types=1);

namespace App\ExampleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ExampleConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('foo');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('bar1')
                    ->children()
                        ->scalarNode('bar2')
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}