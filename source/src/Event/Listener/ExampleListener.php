<?php declare(strict_types=1);

namespace App\Event\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

#[AsEventListener(event: 'kernel.controller', method: 'onKernelController')]
class ExampleListener
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function onKernelController(ControllerEvent $event)
    {
        $request = $event->getRequest();
        $controller = $event->getControllerReflector();
        $controllerName = $controller->getName();

        $this->logger->notice('onKernelController: ' . $request->getRequestUri(). ' = '.$controllerName);
    }
}
