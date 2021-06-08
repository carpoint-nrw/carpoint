<?php

namespace AdminBundle\Entity\References;

use AdminBundle\Entity\Car;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Vendor
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\References\VendorRepository")
 *
 * @package AdminBundle\Entity\References
 */
class Vendor extends AbstractReferences
{
    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $address;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\Car",
     *     mappedBy="vendor",
     *     cascade={ "persist" }
     * )
     */
    private $car;

    /**
     * @var Place
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\Place", inversedBy="vendor")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $place;

    /**
     * Vendor constructor.
     */
    public function __construct()
    {
        $this->car = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getAddress():? string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     *
     * @return static
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Add Car
     *
     * @param Car $car A new associations with Car entity instance.
     *
     * @return Vendor
     */
    public function addCar(Car $car): Vendor
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
     * @return Place|null
     */
    public function getPlace():? Place
    {
        return $this->place;
    }

    /**
     * @param Place $place
     *
     * @return static
     */
    public function setPlace(Place $place)
    {
        $this->place = $place;

        return $this;
    }
}