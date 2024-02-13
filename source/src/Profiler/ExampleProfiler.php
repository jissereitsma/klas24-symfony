<?php
declare(strict_types=1);

namespace App\Profiler;

use Symfony\Bundle\FrameworkBundle\DataCollector\AbstractDataCollector;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExampleProfiler extends AbstractDataCollector
{
    public function collect(Request $request, Response $response, \Throwable $exception = null)
    {
        $this->data = [
            'example1' => 'foobar',
        ];
    }

    public static function getTemplate(): ?string
    {
        return 'example.html.twig';
    }

    public function getExample1(): string
    {
        return $this->data['example1'];
    }
}
