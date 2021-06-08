<?php

namespace AdminBundle\Entity;

use AdminBundle\Traits\ClientData;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Buyer
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\BuyerRepository")
 *
 * @package AdminBundle\Entity
 */
class Buyer
{
    use ClientData;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\Car",
     *     mappedBy="buyer",
     *     cascade={ "persist" }
     * )
     */
    private $car;

    /**
     * Buyer constructor.
     */
    public function __construct()
    {
        $this->car = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add Car
     *
     * @param Car $car A new associations with Car entity instance.
     *
     * @return Buyer
     */
    public function addCar(Car $car): Buyer
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

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getFirmNumber();
    }
}