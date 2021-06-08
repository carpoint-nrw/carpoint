<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ShowDuplicateController
 *
 * @Route("/show-duplicates")
 *
 * @package AdminBundle\Controller
 */
class ShowDuplicateController extends Controller
{
    /**
     * @Route("")
     * @Template
     *
     * @return Response|array
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $duplicates = $em->getRepository(Car::class)->getDuplicates();

        return ['duplicates' => $duplicates];
    }
}