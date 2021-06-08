<?php

namespace AdminBundle\Entity\References;

use AdminBundle\Entity\Car;
use AdminBundle\Traits\UploadFileTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Model
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\References\ModelRepository")
 *
 * @package AdminBundle\Entity\References
 */
class Model extends AbstractReferences
{
    use UploadFileTrait;

    /**
     * @var Brand
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\Brand", inversedBy="model")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $brand;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\Car",
     *     mappedBy="model",
     *     cascade={ "persist" }
     * )
     */
    private $car;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\References\Version",
     *     mappedBy="model",
     *     cascade={ "persist" }
     * )
     */
    private $version;

    /**
     * Buyer constructor.
     */
    public function __construct()
    {
        $this->car     = new ArrayCollection();
        $this->version = new ArrayCollection();
    }

    /**
     * @return Brand|null
     */
    public function getBrand():? Brand
    {
        return $this->brand;
    }

    /**
     * @param Brand $brand
     *
     * @return static
     */
    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Add Car
     *
     * @param Car $car A new associations with Car entity instance.
     *
     * @return Model
     */
    public function addCar(Car $car): Model
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
     * Add Version
     *
     * @param Version $version A new associations with Version entity instance.
     *
     * @return Model
     */
    public function addVersion(Version $version): Model
    {
        $this->version[] = $version;

        return $this;
    }

    /**
     * Remove Version
     *
     * @param Version $version A removed association with Version entity instance.
     */
    public function removeVersion(Version $version): void
    {
        $this->version->removeElement($version);
    }

    /**
     * Get Versions
     *
     * @return Collection
     */
    public function getVersions(): Collection
    {
        return $this->version;
    }
}