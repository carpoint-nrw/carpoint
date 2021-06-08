<?php

namespace AppBundle\Controller\Ajax;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class CookieController
 *
 * @Route("/cookie")
 *
 * @package AppBundle\Controller\Ajax
 */
class CookieController extends Controller
{

    /**
     * @Route("")
     *
     * @param Request $request
     */
    public function setCheckCookie(Request $request)
    {
        $session = $request->getSession();
        $session->set('cookie-popup', true);
    }
}