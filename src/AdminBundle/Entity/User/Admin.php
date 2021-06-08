<?php

namespace AdminBundle\Entity\User;

use AdminBundle\Entity\Car;
use AdminBundle\Entity\CarEditHistory;
use AdminBundle\Entity\CarFile;
use AdminBundle\Entity\CarFileType;
use AdminBundle\Entity\SalesmanBooking;
use AdminBundle\Enum\UserRoleEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Admin
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\AdminRepository")
 *
 * @package AdminBundle\Entity\User
 */
class Admin extends AbstractUser
{

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default" : 0})
     */
    private $sidebar = false;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default" : 0})
     */
    private $isVisible = false;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\Car",
     *     mappedBy="seller",
     *     cascade={ "persist" }
     * )
     */
    private $car;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\Car",
     *     mappedBy="salesman",
     *     cascade={ "persist" }
     * )
     */
    private $carSalesman;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\Car",
     *     mappedBy="uploader",
     *     cascade={ "persist" }
     * )
     */
    private $uploadCar;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\SalesmanBooking",
     *     mappedBy="admin",
     *     cascade={ "all" }
     * )
     */
    private $salesmanBooking;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\CarEditHistory",
     *     mappedBy="admin",
     *     cascade={ "all" }
     * )
     */
    private $carEditHistory;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\CarFile",
     *     mappedBy="admin",
     *     cascade={ "persist" }
     * )
     */
    private $file;

    /**
     * @ORM\ManyToMany(targetEntity="AdminBundle\Entity\CarFileType", mappedBy="carFilePermission")
     */
    protected $carFileType;

    /**
     * Buyer constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->car             = new ArrayCollection();
        $this->carEditHistory  = new ArrayCollection();
        $this->carSalesman     = new ArrayCollection();
        $this->salesmanBooking = new ArrayCollection();
        $this->file            = new ArrayCollection();
        $this->carFileType     = new ArrayCollection();
    }

    /**
     * Add Car
     *
     * @param Car $car A new associations with Car entity instance.
     *
     * @return Admin
     */
    public function addCar(Car $car): Admin
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

    /**
     * Add Car
     *
     * @param Car $car A new associations with Car entity instance.
     *
     * @return Admin
     */
    public function addCarSalesman(Car $car): Admin
    {
        $this->carSalesman[] = $car;

        return $this;
    }

    /**
     * Remove Car
     *
     * @param Car $car A removed association with Car entity instance.
     */
    public function removeCarSalesman(Car $car): void
    {
        $this->carSalesman->removeElement($car);
    }

    /**
     * Get Cars
     *
     * @return Collection
     */
    public function getCarSalesmans(): Collection
    {
        return $this->carSalesman;
    }

    /**
     * Add Car
     *
     * @param Car $car A new associations with Car entity instance.
     *
     * @return Admin
     */
    public function addUploadCar(Car $car): Admin
    {
        $this->uploadCar[] = $car;

        return $this;
    }

    /**
     * Remove Car
     *
     * @param Car $car A removed association with Car entity instance.
     */
    public function removeUploadCar(Car $car): void
    {
        $this->uploadCar->removeElement($car);
    }

    /**
     * Get Cars
     *
     * @return Collection
     */
    public function getUploadCars(): Collection
    {
        return $this->uploadCar;
    }

    /**
     * Add CarEditHistory
     *
     * @param CarEditHistory $carEditHistory A new associations with CarEditHistory entity instance.
     *
     * @return Admin
     */
    public function addCarEditHistory(CarEditHistory $carEditHistory): Admin
    {
        $this->carEditHistory[] = $carEditHistory;

        return $this;
    }

    /**
     * Remove CarEditHistory
     *
     * @param CarEditHistory $carEditHistory A removed association with CarEditHistory entity instance.
     */
    public function removeCarEditHistory(CarEditHistory $carEditHistory): void
    {
        $this->carEditHistory->removeElement($carEditHistory);
    }

    /**
     * Get CarEditHistory
     *
     * @return Collection
     */
    public function getCarEditHistory(): Collection
    {
        return $this->carEditHistory;
    }

    /**
     * Add SalesmanBooking
     *
     * @param SalesmanBooking $salesmanBooking A new associations with SalesmanBooking entity instance.
     *
     * @return Admin
     */
    public function addSalesmanBooking(SalesmanBooking $salesmanBooking): Admin
    {
        $this->salesmanBooking[] = $salesmanBooking;

        return $this;
    }

    /**
     * Remove SalesmanBooking
     *
     * @param SalesmanBooking $salesmanBooking A removed association with SalesmanBooking entity instance.
     */
    public function removeSalesmanBooking(SalesmanBooking $salesmanBooking): void
    {
        $this->salesmanBooking->removeElement($salesmanBooking);
    }

    /**
     * Get SalesmanBooking
     *
     * @return Collection
     */
    public function getSalesmanBookings(): Collection
    {
        return $this->salesmanBooking;
    }

    /**
     * @return bool
     */
    public function isSidebar(): bool
    {
        return $this->sidebar;
    }

    /**
     * @param bool $sidebar
     *
     * @return static
     */
    public function setSidebar(bool $sidebar)
    {
        $this->sidebar = $sidebar;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isVisible():? bool
    {
        return $this->isVisible;
    }

    /**
     * @param bool|null $isVisible
     *
     * @return static
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * Add File
     *
     * @param CarFile $file A new associations with CarFile entity instance.
     *
     * @return Admin
     */
    public function addFile(CarFile $file): Admin
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
     * Add CarFileType
     *
     * @param CarFileType $carFileType A new associations with CarFileType entity instance.
     *
     * @return Admin
     */
    public function addCarFileType(CarFileType $carFileType): Admin
    {
        $this->carFileType[] = $carFileType;

        return $this;
    }

    /**
     * Remove CarFileType
     *
     * @param CarFileType $carFileType A removed association with CarFileType entity instance.
     */
    public function removeCarFileType(CarFileType $carFileType): void
    {
        $this->carFileType->removeElement($carFileType);
    }

    /**
     * Get CarFileTypes
     *
     * @return Collection
     */
    public function getCarFileTypes(): Collection
    {
        return $this->carFileType;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function accessEditUsers(): bool
    {
        return $this->role === UserRoleEnum::ROLE_ADMIN_1 ? true : false;
    }

    /**
     * @return bool
     */
    public function accessCurrency(): bool
    {
        return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2]);
    }

    /**
     * @return bool
     */
    public function accessCarFileType(): bool
    {
        return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1]);
    }

    /**
     * @return bool
     */
    public function accessToStatistics(): bool
    {
        return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_15, UserRoleEnum::ROLE_ADMIN_11, UserRoleEnum::ROLE_ADMIN_8]);
    }

    /**
     * @return bool
     */
    public function accessToCars(): bool
    {
        return !\in_array($this->role, [UserRoleEnum::ROLE_ADMIN_15]);
    }

    /**
     * @return bool
     */
    public function accessToInvoices(): bool
    {
        return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_11, UserRoleEnum::ROLE_ADMIN_8]);
    }

    /**
     * @return bool
     */
    public function accessEditCarHistory(): bool
    {
        return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2, UserRoleEnum::ROLE_ADMIN_8]);
    }

    /**
     * @return bool
     */
    public function accessArchive(): bool
    {
        return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2, UserRoleEnum::ROLE_ADMIN_8, UserRoleEnum::ROLE_ADMIN_13, UserRoleEnum::ROLE_ADMIN_14, UserRoleEnum::ROLE_ADMIN_9, UserRoleEnum::ROLE_ADMIN_11]);
    }

    /**
     * @return bool
     */
    public function accessArchiveButton(): bool
    {
        return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2, UserRoleEnum::ROLE_ADMIN_8]);
    }

    /**
     * @return bool
     */
    public function accessDeleteButton(): bool
    {
        return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1]);
    }

    /**
     * @return bool
     */
    public function accessDump(): bool
    {
        return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1]);
    }

    /**
     * @return bool
     */
    public function accessReferences(): bool
    {
        return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2, UserRoleEnum::ROLE_ADMIN_9, UserRoleEnum::ROLE_ADMIN_13, UserRoleEnum::ROLE_ADMIN_8]);
    }

    /**
     * @return bool
     */
    public function accessUser(): bool
    {
        return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2, UserRoleEnum::ROLE_ADMIN_13, UserRoleEnum::ROLE_ADMIN_14]);
    }

    /**
     * @return bool
     */
    public function accessFrontendSite(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function accessShowDuplicates(): bool
    {
        return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1]);
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function accessReference(string $type): bool
    {
        switch ($type) {
            case 'Brand':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2, UserRoleEnum::ROLE_ADMIN_9, UserRoleEnum::ROLE_ADMIN_13, UserRoleEnum::ROLE_ADMIN_8]);
            case 'Model':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2, UserRoleEnum::ROLE_ADMIN_9, UserRoleEnum::ROLE_ADMIN_13, UserRoleEnum::ROLE_ADMIN_8]);
            case 'Version':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2, UserRoleEnum::ROLE_ADMIN_9, UserRoleEnum::ROLE_ADMIN_13, UserRoleEnum::ROLE_ADMIN_8]);
            case 'Color':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2, UserRoleEnum::ROLE_ADMIN_9, UserRoleEnum::ROLE_ADMIN_13, UserRoleEnum::ROLE_ADMIN_8]);
            case 'Standart complectation':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2, UserRoleEnum::ROLE_ADMIN_9, UserRoleEnum::ROLE_ADMIN_13, UserRoleEnum::ROLE_ADMIN_8]);
            case 'Buyers':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2]);
            case 'Customers':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2]);
            case 'Forwarders':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2]);
            case 'Locations':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2]);
            case 'Places':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2]);
            case 'Target Unload':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2]);
            case 'Vendors':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_2]);
            case 'Fahrzeugart':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1]);
            case 'Car Status':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1]);
            case 'Client Status':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1]);
            case 'Fuel':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1]);
            case 'Ort':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1]);
            case 'Payment Condition':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1]);
            case 'Payment Type':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1]);
            case 'Tax Type':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1]);
            case 'Auslieferungsort':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1]);
            case 'Registration certificate':
                return \in_array($this->role, [UserRoleEnum::ROLE_ADMIN_1, UserRoleEnum::ROLE_ADMIN_8]);
            default:
                return false;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}