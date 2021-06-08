<?php

namespace AdminBundle\EventListeners;

use AdminBundle\Entity\Car;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class LocaleListener
 *
 * @package AdminBundle\EventListeners
 */
class LocaleListener
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var TokenStorageInterface
     */
    private $storage;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * LocaleListener constructor.
     *
     * @param ContainerInterface    $containerInterface
     * @param TokenStorageInterface $storage
     * @param RequestStack          $requestStack
     */
    public function __construct(
        ContainerInterface $containerInterface,
        TokenStorageInterface $storage,
        RequestStack $requestStack
    ) {
        $this->container = $containerInterface;
        $this->storage   = $storage;
        $this->requestStack = $requestStack;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $ref = str_replace("app_dev.php/", "", parse_url($request->headers->get('referer'),PHP_URL_PATH ));
        $lastRoute = $this->container->get('router')->match($ref)['_route'];

        $currentRoute = $request->get('_route');

        if ($lastRoute === 'admin_car_edit' && $currentRoute !== '_wdt' && !in_array($currentRoute, ['admin_ajax_ajax_getmodel', 'admin_ajax_ajax_getversion', 'admin_ajax_ajax_getstandartcomplectation'])) {
            $id = explode('/', $ref);
            $id = array_pop($id);

            $em = $this->container->get('doctrine.orm.entity_manager');
            $car = $em->getRepository(Car::class)->find($id);
            $car->setEditDate(null);
            $em->persist($car);
            $em->flush();
        }

        $token = $this->storage->getToken();
        if ($token !== null) {
            $user = $token->getUser();
            if (!is_string($user)) {
                $locale = $user->getLocale() === null ? 'en' : $user->getLocale();

                $request = $event->getRequest();
                $request->setLocale($locale);

                $translator = $this->container->get('translator');
                $translator->setLocale($locale);
            }
        }
    }
}