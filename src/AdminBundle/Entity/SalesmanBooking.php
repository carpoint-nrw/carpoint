<?php

namespace AdminBundle\Entity;

use AdminBundle\Entity\User\Admin;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SalesmanBooking
 *
 * @ORM\Entity
 *
 * @package AdminBundle\Entity
 */
class SalesmanBooking
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $bookTime;

    /**
     * @var Car
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Car", inversedBy="salesmanBooking")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $car;

    /**
     * @var Admin
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\User\Admin", inversedBy="salesmanBooking")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $admin;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime|null
     */
    public function getBookTime():? \DateTime
    {
        return $this->bookTime;
    }

    /**
     * @param \DateTime $bookTime
     *
     * @return static
     */
    public function setBookTime(\DateTime $bookTime)
    {
        $this->bookTime = $bookTime;

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
     * @param Car $car
     *
     * @return static
     */
    public function setCar(Car $car)
    {
        $this->car = $car;

        return $this;
    }

    /**
     * @return Admin|null
     */
    public function getAdmin():? Admin
    {
        return $this->admin;
    }

    /**
     * @param Admin $admin
     *
     * @return static
     */
    public function setAdmin(Admin $admin)
    {
        $this->admin = $admin;

        return $this;
    }
}