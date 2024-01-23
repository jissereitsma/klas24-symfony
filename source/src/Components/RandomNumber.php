<?php
declare(strict_types=1);

namespace App\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent(name: 'randomNumber')]
class RandomNumber
{
    use DefaultActionTrait;

    #[LiveAction]
    public function getRandomNumber(): int
    {
        return rand(0, 1000);
    }
}
