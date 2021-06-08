<?php

namespace AdminBundle\Entity;

use AdminBundle\Entity\User\Admin;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CarEditHistory
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CarEditHistoryRepository")
 *
 * @package AdminBundle\Entity
 */
class CarEditHistory
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
     * @ORM\Column(nullable=true)
     */
    private $columnGerman;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $columnPolish;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $oldValue;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $newValue;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $editDate;

    /**
     * @var Car
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Car", inversedBy="carEditHistory")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $car;

    /**
     * @var Admin
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\User\Admin", inversedBy="carEditHistory")
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
     * @return string|null
     */
    public function getColumnGerman():? string
    {
        return $this->columnGerman;
    }

    /**
     * @param string|null $columnGerman
     *
     * @return static
     */
    public function setColumnGerman($columnGerman)
    {
        $this->columnGerman = $columnGerman;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getColumnPolish():? string
    {
        return $this->columnPolish;
    }

    /**
     * @param string|null $columnPolish
     *
     * @return static
     */
    public function setColumnPolish($columnPolish)
    {
        $this->columnPolish = $columnPolish;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOldValue():? string
    {
        return $this->oldValue;
    }

    /**
     * @param string|null $oldValue
     *
     * @return static
     */
    public function setOldValue($oldValue)
    {
        $this->oldValue = $oldValue;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNewValue():? string
    {
        return $this->newValue;
    }

    /**
     * @param string|null $newValue
     *
     * @return static
     */
    public function setNewValue($newValue)
    {
        $this->newValue = $newValue;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getEditDate():? \DateTime
    {
        return $this->editDate;
    }

    /**
     * @param \DateTime|null $editDate
     *
     * @return static
     */
    public function setEditDate($editDate)
    {
        $this->editDate = $editDate;

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