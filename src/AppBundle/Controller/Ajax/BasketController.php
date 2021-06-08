<?php

namespace AppBundle\Controller\Ajax;

use AdminBundle\Entity\UserOrder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class BasketController
 *
 * @Route("/basket-count")
 *
 * @package AppBundle\Controller\Ajax
 */
class BasketController extends Controller
{
    /**
     * @Route("")
     *
     * @return JsonResponse
     */
    public function getBasketCountItems(): JsonResponse
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $userOrders = $em->getRepository(UserOrder::class)->findBy([
            'user' => $user->getId(),
        ]);

        if ($user === null || $user->accessFrontendSite() === false) {
            return JsonResponse::create(['result' => false]);
        }

        return JsonResponse::create(['result' => count($userOrders)]);
    }
}