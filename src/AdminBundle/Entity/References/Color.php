<?php

namespace AdminBundle\Entity\References;

use AdminBundle\Entity\Car;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Color
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\References\ColorRepository")
 *
 * @package AdminBundle\Entity\References
 */
class Color
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="BaseColor", inversedBy="extends")
     * @ORM\JoinColumn(name="base_color_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $baseColor;
    
    /**
     * @var bool
     * 
     * @ORM\Column(type="boolean", nullable=true)
     */
    
    private $metallic;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $german;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $polish;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\Car",
     *     mappedBy="colorGerman",
     *     cascade={ "persist" }
     * )
     */
    private $carGerman;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\Car",
     *     mappedBy="colorPolish",
     *     cascade={ "persist" }
     * )
     */
    private $carPolish;

    /**
     * Color constructor.
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
     * @return string|null
     */
    public function getBaseColor():?BaseColor
    {
        return $this->baseColor;
    }

    /**
     * @param string|null $polish
     *
     * @return static
     */
    public function setBaseColor($color): Color
    {
        $this->baseColor = $color;

        return $this;
    }
    
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->german . ' / ' . $this->polish ;
    }
    
    /**
     * @return string|null
     */
    public function getMetallic():? bool
    {
        return $this->metallic;
    }

    /**
     * @param string|null $metallic
     *
     * @return static
     */
    public function setMetallic($metallic): Color
    {
        $this->metallic = $metallic;

        return $this;
    }
    
    /**
     * Add Car
     *
     * @param Car $car A new associations with Car entity instance.
     *
     * @return Color
     */
    public function addCarGerman(Car $car): Color
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
     * @return Color
     */
    public function addCarPolish(Car $car): Color
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
}