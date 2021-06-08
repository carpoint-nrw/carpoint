<?php

namespace AdminBundle\Entity\References;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class StandartComplectation
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\References\StandartComplectationRepository")
 *
 * @package AdminBundle\Entity\References
 */
class StandartComplectation
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
    private $polish;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $german;

    /**
     * @var Version
     *
     * @ORM\OneToOne(targetEntity="AdminBundle\Entity\References\Version", inversedBy="standardComplectation")
     */
    private $version;

    /**
     * @var Brand
     */
    private $brand;

    /**
     * @var Model
     */
    private $model;

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
     * @return Version|null
     */
    public function getVersion():? Version
    {
        return $this->version;
    }

    /**
     * @param Version $version
     *
     * @return static
     */
    public function setVersion(Version $version)
    {
        $this->version = $version;

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
}