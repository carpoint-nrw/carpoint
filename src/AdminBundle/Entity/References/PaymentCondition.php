<?php

namespace AdminBundle\Entity\References;

use AdminBundle\Entity\Car;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PaymentCondition
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\References\PaymentConditionRepository")
 *
 * @package AdminBundle\Entity\References
 */
class PaymentCondition extends AbstractReferences
{
    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\Car",
     *     mappedBy="paymentCondition",
     *     cascade={ "persist" }
     * )
     */
    private $car;

    /**
     * PaymentCondition constructor.
     */
    public function __construct()
    {
        $this->car = new ArrayCollection();
    }

    /**
     * Add Car
     *
     * @param Car $car A new associations with Car entity instance.
     *
     * @return PaymentCondition
     */
    public function addCar(Car $car): PaymentCondition
    {
        $this->car[] = $car;

        return $this;
    }

    /**
     * Remove Car
     *
     * @param Car $car A removed association with Car entity instance.
     */
    public function removeCar(Car $car): void
    {
        $this->car->removeElement($car);
    }

    /**
     * Get Cars
     *
     * @return Collection
     */
    public function getCars(): Collection
    {
        return $this->car;
    }
}