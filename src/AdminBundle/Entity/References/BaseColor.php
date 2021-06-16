<?php

namespace AdminBundle\Entity\References;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * BaseColor
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\References\BaseColorRepository")
 */
class BaseColor
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="german", type="string", length=255, nullable=true, unique=true)
     */
    private $german;

    /**
     * @var string|null
     *
     * @ORM\Column(name="polish", type="string", length=255, nullable=true, unique=true)
     */
    private $polish;

    /**
     * @ORM\OneToMany(targetEntity="Color", mappedBy="baseColor")
     */
    private $extends;
    
    /**
     * Color constructor.
     */
    public function __construct()
    {
        $this->extends = new ArrayCollection();
    }
    
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set german.
     *
     * @param string|null $german
     *
     * @return BaseColor
     */
    public function setGerman($german = null)
    {
        $this->german = $german;

        return $this;
    }

    /**
     * Get german.
     *
     * @return string|null
     */
    public function getGerman()
    {
        return $this->german;
    }

    /**
     * Set polish.
     *
     * @param string|null $polish
     *
     * @return BaseColor
     */
    public function setPolish($polish = null)
    {
        $this->polish = $polish;

        return $this;
    }

    /**
     * Get polish.
     *
     * @return string|null
     */
    public function getPolish()
    {
        return $this->polish;
    }
    
    public function getTitle()
    {
        return $this->polish . ' / ' . $this->german;
    }

    /**
     * Set extends.
     *
     * @param array|null $extends
     *
     * @return BaseColor
     */
    public function setExtends($extends = null)
    {
        $this->extends = $extends;

        return $this;
    }

    /**
     * Get extends.
     *
     * @return array|null
     */
    public function getExtends()
    {
        return $this->extends;
    }
    
        
    /**
     * Add Color extends
     *
     * @param Color $color new associations with Color entity instance.
     *
     * @return Color
     */
    public function addExtends(Color $color): self
    {
        $this->extends[] = $color;

        return $this;
    }

    /**
     * Remove Car
     *
     * @param Car $car A removed association with Car entity instance.
     */
    public function removeExtends(Color $color): void
    {
        $this->extends->removeElement($color);
    }

}
