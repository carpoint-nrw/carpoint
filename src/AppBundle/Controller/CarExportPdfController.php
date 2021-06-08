<?php

namespace AppBundle\Controller;

use AdminBundle\Entity\Car;
use AdminBundle\Entity\User\User;
use AdminBundle\Entity\User\UserOrderNumber;
use AdminBundle\Services\ExportPdf\CarlineDeedPdf;
use AdminBundle\Services\ExportPdf\FactoryExportPdf;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CarExportPdfController
 *
 * @Route("/export-pdf")
 *
 * @package AppBundle\Controller
 */
class CarExportPdfController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var FactoryExportPdf
     */
    private $factoryExportPdf;

    /**
     * CarExportPdfController constructor.
     *
     * @param EntityManagerInterface $em
     * @param FactoryExportPdf       $factoryExportPdf
     */
    public function __construct(EntityManagerInterface $em, FactoryExportPdf $factoryExportPdf)
    {
        $this->em               = $em;
        $this->factoryExportPdf = $factoryExportPdf;
    }

    /**
     * @Route("/deed")
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function deedExport(Request $request): RedirectResponse
    {
        $carId = $request->query->get('carId');
        $type  = $request->query->get('type');
        $car   = $this->em->getRepository(Car::class)->find($carId);

        if ($car === null) {
            return $this->redirectToRoute('app_basket_index');
        }

        $user  = $this->getUser();
        if ($user instanceof User) {
            $userOrderNumber = $this->em->getRepository(UserOrderNumber::class)
                ->findOneBy(['user' => $user, 'car' => $car]);

            if ($userOrderNumber === null) {
                $userOrderNumber = new UserOrderNumber();
                $userOrderNumber->setCar($car);
                $userOrderNumber->setUser($user);

                $maxCarNumber       = $this->em->getRepository(Car::class)->findMaxCarlinenumber();
                $maxUserOrderNumber = $this->em->getRepository(UserOrderNumber::class)->findMaxCarlinenumber();
                if ($maxCarNumber === null) {
                    $maxCarNumber = 1001;
                } else {
                    $maxCarNumber = (int) $maxCarNumber + 1;
                }
                if ($maxUserOrderNumber === null) {
                    $maxUserOrderNumber = 1001;
                } else {
                    $maxUserOrderNumber = (int) $maxUserOrderNumber + 1;
                }

                if ($maxUserOrderNumber > $maxCarNumber) {
                    $maxCarNumber = $maxUserOrderNumber;
                }

                $userOrderNumber->setNumber($maxCarNumber);

                $this->em->persist($userOrderNumber);
                $this->em->flush();
            }
        }

        $service = $this->factoryExportPdf->getExportService(CarlineDeedPdf::class);
        $service->export($car, ['em' => $this->em, 'type' => $type, 'user' => $user]);

        return $this->redirectToRoute('app_basket_index');
    }
}