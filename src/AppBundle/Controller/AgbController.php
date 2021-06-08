<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class AgbController
 *
 * @Route("/agb")
 *
 * @package AppBundle\Controller
 */
class AgbController extends Controller
{
    /**
     * @Route("")
     * @Template
     *
     * @return Response|array
     */
    public function indexAction()
    {
        return [];
    }
}