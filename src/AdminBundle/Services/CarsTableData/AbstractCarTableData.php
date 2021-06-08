<?php

namespace AdminBundle\Services\CarsTableData;

use AdminBundle\Entity\Buyer;
use AdminBundle\Entity\Car;
use AdminBundle\Entity\References\Forwarder;
use AdminBundle\Entity\References\Location;
use AdminBundle\Entity\References\TargetUnload;
use AdminBundle\Entity\User\Admin;
use AdminBundle\Entity\User\User;
use AdminBundle\Enum\CarConditionEnum;
use AdminBundle\Enum\UserRoleEnum;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AbstractCarTableData
 *
 * @package AdminBundle\Services\CarsTableData
 */
abstract class AbstractCarTableData implements CarsTableDataInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * AbstractCarTableData constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param bool $targetUnload
     * @param bool $forwarder
     * @param bool $location
     * @param bool $user
     *
     * @return array
     */
    protected function getSelectInputsData(
        bool $targetUnload = false,
        bool $forwarder    = false,
        bool $location     = false,
        bool $user         = false
    ): array {
        $targetUnloadResult = [];
        if ($targetUnload) {
            $targetUnloads = $this->em->getRepository(TargetUnload::class)->findAll();
            foreach ($targetUnloads as $targetUnload) {
                $targetUnloadResult[] = ['id' => $targetUnload->getId(), 'title' => $targetUnload->getTitle()];
            }
        }
        $forwarderResult = [];
        if ($forwarder) {
            $forwarders = $this->em->getRepository(Forwarder::class)->findAll();
            foreach ($forwarders as $forwarder) {
                $forwarderResult[] = ['id' => $forwarder->getId(), 'title' => $forwarder->getTitle()];
            }
        }
        $locationResult = [];
        if ($location) {
            $locations = $this->em->getRepository(Location::class)->findAll();
            foreach ($locations as $location) {
                $locationResult[] = ['id' => $location->getId(), 'title' => $location->getTitle()];
            }
        }
        $userResult = [];
        if ($user) {
            $users = $this->em->getRepository(User::class)
                ->findBy(
                    ['role' => UserRoleEnum::ROLE_USER],
                    ['abbreviation' => 'asc']
                );
            foreach ($users as $user) {
                $abbreviation = $user->getAbbreviation() !== null
                    ? $user->getAbbreviation()
                    : $user->getFirmNumber();
                $userResult[] = ['id' => $user->getId(), 'title' => $abbreviation];
            }
        }

        return [$targetUnloadResult, $forwarderResult, $locationResult, $userResult];
    }

    /**
     * @param Car   $car
     * @param Admin $admin
     *
     * @return boolean
     */
    protected function getPermissionForCarCondition(Car $car, Admin $admin): bool
    {
        $userId = $admin->getId();
        $userBookings = [];
        foreach ($car->getSalesmanBookings() as $booking) {
            if ($booking->getAdmin()->getId() === $userId) {
                $userBookings[] = $booking;
            }
        }

        $date = (new \DateTime())->modify('-1 week');
        foreach ($userBookings as $key => $booking) {
            if ($booking->getBookTime() < $date) {
                unset($userBookings[$key]);
            }
        }

        return !(\count($userBookings) >= 2);
    }

    /**
     * @param Car    $car
     * @param string $getter
     *
     * @return bool
     */
    protected function getPayColor(Car $car, string $getter): bool
    {
        $payColor = false;
        $payDate = $car->$getter();
        if ($payDate instanceof \DateTime) {
            $currentDate = new \DateTime();
            $diff = $currentDate->diff($payDate)->format("%a");
            if ((int) $diff < 2) {
                $payColor = true;
            }
        }
        return $payColor;
    }

    /**
     * @param Car   $car
     * @param Admin $admin
     *
     * @return bool
     */
    protected function getCarColor(Car $car, Admin $admin): bool
    {
        if ($admin->getLocale() !== 'de') {

            return false;
        }

        $targetUnload = $car->getTargetUnload() !== null ? mb_strtolower(trim($car->getTargetUnload()->getTitle())) : false;
        if (
            $car->isPaid() === true
            && mb_strtolower(trim($car->getDocuments())) === 'x'
            && $targetUnload === 'x'
            && $car->getCarCondition() === CarConditionEnum::SOLD
        ) {

            return true;
        }

        return false;
    }

    /**
     * @param Car $car
     *
     * @return bool
     */
    protected function getTerminColor(Car $car): bool
    {
        $currentDate = new \DateTime();
        $teminDate = $car->getCompleted();
        if ($teminDate <= $currentDate && $car->isPaid() === false) {

            return true;
        }

        return false;
    }
}