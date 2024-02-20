<?php

namespace App\Generator;

interface GeneratorInterface
{
    public function generate(bool $flush = true);

    public function flush();
}