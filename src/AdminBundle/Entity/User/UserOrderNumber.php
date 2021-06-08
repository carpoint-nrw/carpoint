<?php

namespace AdminBundle\Entity\User;

use AdminBundle\Entity\Car;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserOrderNumber
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\UserOrderNumberRepository")
 *
 * @package AdminBundle\Entity\User
 */
class UserOrderNumber
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $number;

    /**
     * @var Car
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Car", inversedBy="userOrderNumber")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $car;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\User\User", inversedBy="userOrderNumber")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $user;

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
    public function getNumber():? string
    {
        return $this->number;
    }

    /**
     * @param string|null $number
     *
     * @return static
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Car|null
     */
    public function getCar():? Car
    {
        return $this->car;
    }

    /**
     * @param Car|null $car
     *
     * @return static
     */
    public function setCar($car)
    {
        $this->car = $car;

        return $this;
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
}