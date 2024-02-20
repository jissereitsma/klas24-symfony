<?php declare(strict_types=1);

namespace App\Generator;

use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

//#[AutoconfigureTag(name: 'custom.generator')]
//#[Autoconfigure(tags:['custom.generator'])]
class FoobarGenerator implements GeneratorInterface
{

    public function generate(bool $flush = true)
    {
        // TODO: Implement generate() method.
    }

    public function flush()
    {
        // TODO: Implement flush() method.
    }
}