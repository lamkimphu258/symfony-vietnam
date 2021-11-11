<?php

namespace App\EventSubscriber;

use App\Controller\GeneralController;
use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AuthenticationSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private ContainerInterface $container,
        private UrlGeneratorInterface $urlGenerator
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => [
                ['checkAuthenticatedUser', 0],
                ['checkUnAuthenticatedUser', 0],
            ]
        ];
    }

    public function checkAuthenticatedUser(ControllerEvent $event)
    {
        $controller = $event->getController();
        $controllerRoute = '';

        if (is_array($controller)) {
            $controllerRoute = $controller[1];
            $controller = $controller[0];
        }

        if ($this->container->get('security.token_storage')->getToken()) {
            if (
                $controller instanceof GeneralController ||
                $controllerRoute === 'login' ||
                $controllerRoute === 'register'
            ) {
                $event->setController(function () {
                    return new RedirectResponse($this->urlGenerator->generate('app_course_index'));
                });
            }
        }
    }

    public function checkUnAuthenticatedUser(ControllerEvent $event)
    {
        $controller = $event->getController();
        $controllerRoute = '';

        if (is_array($controller)) {
            $controllerRoute = $controller[1];
            $controller = $controller[0];
        }

        if (is_null($this->container->get('security.token_storage')->getToken())) {
            if (
                !(
                    $controller instanceof GeneralController ||
                    $controllerRoute === 'login' ||
                    $controllerRoute === 'register'
                )
            ) {
                $event->setController(function () {
                    // TODO: implement unauthenticated page and redirect to that page instead
                    return new RedirectResponse($this->urlGenerator->generate('app_home'));
                });
            }
        }
    }
}
