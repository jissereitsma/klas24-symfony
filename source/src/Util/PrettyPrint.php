<?php declare(strict_types=1);

namespace App\Util;

use Symfony\Component\Console\Output\OutputInterface;

class PrettyPrint
{
    public function prettyPrint(array $data, OutputInterface $output, $indent = 0): void
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $output->writeln(str_repeat(' ', $indent) . "$key:");
                $this->prettyPrint($value, $output, $indent + 2);
                continue;
            }

            if ($this->isPrintable($value)) {
                $output->writeln(str_repeat(' ', $indent) . "$key: $value");
                continue;
            }

            throw new \RuntimeException('Dunno');

        }
    }

    private function isPrintable($value):bool
    {
        return (is_string($value) || is_bool($value) || is_integer($value));
    }
}