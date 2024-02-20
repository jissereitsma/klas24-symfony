<?php declare(strict_types=1);

namespace App\Event\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class Example2Subscriber implements EventSubscriberInterface
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController'
        ];
    }

    public function onKernelController(ControllerEvent $event)
    {
        $request = $event->getRequest();
        $controller = $event->getControllerReflector();
        $controllerName = $controller->getName();

        $this->logger->notice('onKernelController: ' . $request->getRequestUri(). ' = '.$controllerName);
    }


}
