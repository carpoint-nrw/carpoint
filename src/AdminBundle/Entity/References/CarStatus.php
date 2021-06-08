<?php

namespace AdminBundle\Entity\References;

use AdminBundle\Entity\Car;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CarStatus
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\References\CarStatusRepository")
 *
 * @package AdminBundle\Entity\References
 */
class CarStatus extends AbstractReferences
{
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\Car",
     *     mappedBy="carStatus",
     *     cascade={ "persist" }
     * )
     */
    private $car;

    /**
     * CarStatus constructor.
     */
    public function __construct()
    {
        $this->car = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getDescription():? string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return static
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Add Car
     *
     * @param Car $car A new associations with Car entity instance.
     *
     * @return CarStatus
     */
    public function addCar(Car $car): CarStatus
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