<?php

namespace AdminBundle\Entity\References;

use AdminBundle\Entity\Car;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Brand
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\References\BrandRepository")
 *
 * @package AdminBundle\Entity\References
 */
class Brand extends AbstractReferences
{
    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\Car",
     *     mappedBy="brand",
     *     cascade={ "persist" }
     * )
     */
    private $car;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\References\Model",
     *     mappedBy="brand",
     *     cascade={ "persist" }
     * )
     */
    private $model;

    /**
     * Buyer constructor.
     */
    public function __construct()
    {
        $this->car   = new ArrayCollection();
        $this->model = new ArrayCollection();
    }

    /**
     * Add Car
     *
     * @param Car $car A new associations with Car entity instance.
     *
     * @return Brand
     */
    public function addCar(Car $car): Brand
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
     * Add Model
     *
     * @param Model $model A new associations with Model entity instance.
     *
     * @return Brand
     */
    public function addModel(Model $model): Brand
    {
        $this->model[] = $model;

        return $this;
    }

    /**
     * Remove Model
     *
     * @param Model $model A removed association with Model entity instance.
     */
    public function removeModel(Model $model): void
    {
        $this->model->removeElement($model);
    }

    /**
     * Get Models
     *
     * @return Collection
     */
    public function getModels(): Collection
    {
        return $this->model;
    }
}