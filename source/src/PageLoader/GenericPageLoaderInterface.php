<?php declare(strict_types=1);

namespace App\PageLoader;

interface GenericPageLoaderInterface
{
    public function mergeParameters(array $parameters): array;
}
