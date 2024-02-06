<?php declare(strict_types=1);

namespace App\PageLoader;

use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(decorates: GenericPageLoader::class)]
class GenericPageLoaderDecorator implements GenericPageLoaderInterface
{
    public function __construct(
        private GenericPageLoader $genericPageLoader
    ) {
    }

    public function mergeParameters(array $parameters): array
    {
        $parameters['foo'] = 'bar';
        $parameters = $this->genericPageLoader->mergeParameters($parameters);
        $parameters['foo'] = 'bar';
        return $parameters;
    }
}
