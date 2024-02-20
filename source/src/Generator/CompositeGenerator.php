<?php declare(strict_types=1);

namespace App\Generator;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Component\DependencyInjection\Container;

// #[TaggedIterator(tag: 'custom.generator')] private iterable $generators
class CompositeGenerator implements GeneratorInterface
{
    public function __construct(
        private iterable $generators
    ) {
    }

    public function generate(bool $flush = true)
    {
        foreach ($this->generators as $generator) {
            $generator->generate($flush);
        }
    }

    public function flush()
    {
        // TODO: Implement flush() method.
    }

    public function getGenerators(): iterable
    {
        return $this->generators;
    }
}