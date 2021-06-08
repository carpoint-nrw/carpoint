<?php

namespace AdminBundle\Entity;

use AdminBundle\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserOrder
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\UserOrderRepository")
 *
 * @package AdminBundle\Entity
 */
class UserOrder
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\User\User", inversedBy="userOrder")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $user;

    /**
     * @var Car
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Car", inversedBy="userOrder")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $car;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return Order
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Car
     */
    public function getCar(): Car
    {
        return $this->car;
    }

    /**
     * @param Car $car
     *
     * @return Order
     */
    public function setCar(Car $car)
    {
        $this->car = $car;

        return $this;
    }
}