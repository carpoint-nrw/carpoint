<?php

namespace AdminBundle\Entity\References;

use AdminBundle\Entity\Car;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Version
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\References\VersionRepository")
 *
 * @package AdminBundle\Entity\References
 */
class Version
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $german;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $polish;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default" : 0})
     */
    private $isVisible = false;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true, options={"default" : 1})
     */
    private $sort;

    /**
     * @var StandartComplectation
     *
     * @ORM\OneToOne(
     *     targetEntity="AdminBundle\Entity\References\StandartComplectation",
     *     mappedBy="version",
     *     cascade={ "all" }
     * )
     */
    private $standardComplectation;

    /**
     * @var Model
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\Model", inversedBy="version")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $model;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\Car",
     *     mappedBy="versionGerman",
     *     cascade={ "persist" }
     * )
     */
    private $carGerman;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\Car",
     *     mappedBy="versionPolish",
     *     cascade={ "persist" }
     * )
     */
    private $carPolish;

    /**
     * @var Brand
     */
    private $brand;

    /**
     * Version constructor.
     */
    public function __construct()
    {
        $this->carGerman = new ArrayCollection();
        $this->carPolish = new ArrayCollection();
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
     * @return Version
     */
    public function addCarGerman(Car $car): Version
    {
        $this->carGerman[] = $car;

        return $this;
    }

    /**
     * Remove Car
     *
     * @param Car $car A removed association with Car entity instance.
     */
    public function removeCarGerman(Car $car): void
    {
        $this->carGerman->removeElement($car);
    }

    /**
     * Get Cars
     *
     * @return Collection
     */
    public function getCarsGerman(): Collection
    {
        return $this->carGerman;
    }

    /**
     * Add Car
     *
     * @param Car $car A new associations with Car entity instance.
     *
     * @return Version
     */
    public function addCarPolish(Car $car): Version
    {
        $this->carPolish[] = $car;

        return $this;
    }

    /**
     * Remove Car
     *
     * @param Car $car A removed association with Car entity instance.
     */
    public function removeCarPolish(Car $car): void
    {
        $this->carPolish->removeElement($car);
    }

    /**
     * Get Cars
     *
     * @return Collection
     */
    public function getCarsPolish(): Collection
    {
        return $this->carPolish;
    }

    /**
     * @return Model|null
     */
    public function getModel():? Model
    {
        return $this->model;
    }

    /**
     * @param Model $model
     *
     * @return static
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return StandartComplectation|null
     */
    public function getStandardComplectation():? StandartComplectation
    {
        return $this->standardComplectation;
    }

    /**
     * @param StandartComplectation $standardComplectation
     *
     * @return static
     */
    public function setStandardComplectation(StandartComplectation $standardComplectation)
    {
        $this->standardComplectation = $standardComplectation;

        return $this;
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
     * @return string|null
     */
    public function getGerman():? string
    {
        return $this->german;
    }

    /**
     * @param string|null $german
     *
     * @return static
     */
    public function setGerman($german)
    {
        $this->german = $german;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPolish():? string
    {
        return $this->polish;
    }

    /**
     * @param string|null $polish
     *
     * @return static
     */
    public function setPolish($polish)
    {
        $this->polish = $polish;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isVisible():? bool
    {
        return $this->isVisible;
    }

    /**
     * @param bool|null $isVisible
     *
     * @return static
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * @return int
     */
    public function getSort():? int
    {
        return $this->sort;
    }

    /**
     * @param int|null $sort
     *
     * @return static
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->german === null ? '' : $this->german;
    }
}