<?php

namespace AdminBundle\Entity;

use AdminBundle\Entity\User\Admin;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CarFileType
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CarFileTypeRepository")
 *
 * @package AdminBundle\Entity
 */
class CarFileType
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
     * @ORM\Column
     */
    private $type;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\CarFile",
     *     mappedBy="type",
     *     cascade={ "persist" }
     * )
     */
    private $file;

    /**
     * @ORM\ManyToMany(targetEntity="AdminBundle\Entity\User\Admin", inversedBy="carFileType")
     * @ORM\JoinTable(
     *  name="car_file_permission",
     *  joinColumns={
     *      @ORM\JoinColumn(name="car_file_type_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="admin_id", referencedColumnName="id")
     *  }
     * )
     */
    protected $carFilePermission;

    /**
     * CarFileType constructor.
     */
    public function __construct()
    {
        $this->file              = new ArrayCollection();
        $this->carFilePermission = new ArrayCollection();
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
    public function getType():? string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return static
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Add File
     *
     * @param CarFile $file A new associations with CarFile entity instance.
     *
     * @return CarFileType
     */
    public function addFile(CarFile $file): CarFileType
    {
        $this->file[] = $file;

        return $this;
    }

    /**
     * Remove CarFile
     *
     * @param CarFile $file A removed association with CarFile entity instance.
     */
    public function removeFile(CarFile $file): void
    {
        $this->file->removeElement($file);
    }

    /**
     * Get CarFiles
     *
     * @return Collection
     */
    public function getFiles(): Collection
    {
        return $this->file;
    }

    /**
     * Add Admin
     *
     * @param Admin $carFilePermission A new associations with Admin entity instance.
     *
     * @return CarFileType
     */
    public function addCarFilePermission(Admin $carFilePermission): CarFileType
    {
        $this->carFilePermission[] = $carFilePermission;

        return $this;
    }

    /**
     * Remove CarFile
     *
     * @param Admin $carFilePermission A removed association with Admin entity instance.
     */
    public function removCarFilePermission(Admin $carFilePermission): void
    {
        $this->carFilePermission->removeElement($carFilePermission);
    }

    /**
     * Get Admins
     *
     * @return Collection
     */
    public function getCarFilePermission(): Collection
    {
        return $this->carFilePermission;
    }
}