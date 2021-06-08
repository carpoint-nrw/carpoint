<?php

namespace AdminBundle\Entity;

use AdminBundle\Entity\User\Admin;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CarFile
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CarFileRepository")
 *
 * @package AdminBundle\Entity
 */
class CarFile
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
    private $fileName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var CarFileType
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\CarFileType", inversedBy="file")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $type;

    /**
     * @var Admin
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\User\Admin", inversedBy="file")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $admin;

    /**
     * @var Car
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Car", inversedBy="file")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $car;

    /**
     * CarFile constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
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
    public function getFileName():? string
    {
        return $this->fileName;
    }

    /**
     * @param string|null $fileName
     *
     * @return static
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return static
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return CarFileType|null
     */
    public function getType():? CarFileType
    {
        return $this->type;
    }

    /**
     * @param CarFileType $type
     *
     * @return static
     */
    public function setType(CarFileType $type)
    {
        $this->type = $type;

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
}