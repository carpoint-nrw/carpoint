<?php

namespace AdminBundle\Entity\References;

use AdminBundle\Entity\Car;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TaxType
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\References\TaxTypeRepository")
 *
 * @package AdminBundle\Entity\References
 */
class TaxType extends AbstractReferences
{
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $tax;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $withOutTaxText;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $taxValueText;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $fullPriceText;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\Car",
     *     mappedBy="taxType",
     *     cascade={ "persist" }
     * )
     */
    private $car;

    /**
     * TaxType constructor.
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
     * @return int|null
     */
    public function getTax():? int
    {
        return $this->tax;
    }

    /**
     * @param int|null $tax
     *
     * @return static
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWithOutTaxText():? string
    {
        return $this->withOutTaxText;
    }

    /**
     * @param string|null $withOutTaxText
     *
     * @return static
     */
    public function setWithOutTaxText($withOutTaxText)
    {
        $this->withOutTaxText = $withOutTaxText;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTaxValueText():? string
    {
        return $this->taxValueText;
    }

    /**
     * @param string|null $taxValueText
     *
     * @return static
     */
    public function setTaxValueText($taxValueText)
    {
        $this->taxValueText = $taxValueText;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFullPriceText():? string
    {
        return $this->fullPriceText;
    }

    /**
     * @param string|null $fullPriceText
     *
     * @return static
     */
    public function setFullPriceText($fullPriceText)
    {
        $this->fullPriceText = $fullPriceText;

        return $this;
    }

    /**
     * Add Car
     *
     * @param Car $car A new associations with Car entity instance.
     *
     * @return TaxType
     */
    public function addCar(Car $car): TaxType
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