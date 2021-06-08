<?php

namespace AdminBundle\Entity\References;

use AdminBundle\Entity\Car;
use AdminBundle\Entity\User\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TargetUnload
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\References\TargetUnloadRepository")
 *
 * @package AdminBundle\Entity\References
 */
class TargetUnload extends AbstractReferences
{
    /**
     * @var User
     *
     * @ORM\OneToOne(
     *     targetEntity="AdminBundle\Entity\User\User",
     *     mappedBy="targetUnload",
     *     cascade={ "all" }
     * )
     */
    private $user;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\Car",
     *     mappedBy="targetUnload",
     *     cascade={ "persist" }
     * )
     */
    private $car;

    /**
     * TargetUnload constructor.
     */
    public function __construct()
    {
        $this->car = new ArrayCollection();
    }

    /**
     * @return User|null
     */
    public function getUser():? User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     *
     * @return static
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Add Car
     *
     * @param Car $car A new associations with Car entity instance.
     *
     * @return TargetUnload
     */
    public function addCar(Car $car): TargetUnload
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