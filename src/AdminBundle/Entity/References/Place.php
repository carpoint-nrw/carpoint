<?php

namespace AdminBundle\Entity\References;

use AdminBundle\Entity\Car;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Place
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\References\PlaceRepository")
 *
 * @package AdminBundle\Entity\References
 */
class Place extends AbstractReferences
{
    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\Car",
     *     mappedBy="place",
     *     cascade={ "persist" }
     * )
     */
    private $car;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\References\Vendor",
     *     mappedBy="place",
     *     cascade={ "persist" }
     * )
     */
    private $vendor;

    /**
     * Place constructor.
     */
    public function __construct()
    {
        $this->car    = new ArrayCollection();
        $this->vendor = new ArrayCollection();
    }

    /**
     * Add Car
     *
     * @param Car $car A new associations with Car entity instance.
     *
     * @return Place
     */
    public function addCar(Car $car): Place
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
     * Add Vendor
     *
     * @param Vendor $vendor A new associations with Vendor entity instance.
     *
     * @return Place
     */
    public function addVendor(Vendor $vendor): Place
    {
        $this->vendor[] = $vendor;

        return $this;
    }

    /**
     * Remove Vendor
     *
     * @param Vendor $vendor A removed association with Vendor entity instance.
     */
    public function removeVendor(Vendor $vendor): void
    {
        $this->vendor->removeElement($vendor);
    }

    /**
     * Get Vendors
     *
     * @return Collection
     */
    public function getVendors(): Collection
    {
        return $this->vendor;
    }
}