<?php

namespace AdminBundle\Entity\User;

use AdminBundle\Entity\Car;
use AdminBundle\Entity\Order;
use AdminBundle\Entity\References\TargetUnload;
use AdminBundle\Entity\UserOrder;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\UserRepository")
 *
 * @package AdminBundle\Entity\User
 */
class User extends AbstractUser
{
    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $firmNumber;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $ustIdNr;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $street;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $placeIndex;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $country;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $mobileNumber;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $fax;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $abbreviation;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $gender;

    /**
     * @var TargetUnload
     *
     * @ORM\OneToOne(targetEntity="AdminBundle\Entity\References\TargetUnload", inversedBy="user")
     */
    private $targetUnload;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\Car",
     *     mappedBy="user",
     *     cascade={ "persist" }
     * )
     */
    private $car;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\UserOrder",
     *     mappedBy="user",
     *     cascade={ "all" }
     * )
     */
    private $userOrder;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\User\UserOrderNumber",
     *     mappedBy="user",
     *     cascade={ "persist" }
     * )
     */
    private $userOrderNumber;

    /**
     * @var bool
     */
    private $agb;

    /**
     * @var bool
     */
    private $daten;

    /**
     * @var string
     */
    protected $plainPassword;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->car             = new ArrayCollection();
        $this->userOrder       = new ArrayCollection();
        $this->userOrderNumber = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getFirmNumber():? string
    {
        return $this->firmNumber;
    }

    /**
     * @param string $firmNumber
     *
     * @return static
     */
    public function setFirmNumber(string $firmNumber)
    {
        $this->firmNumber = $firmNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet():? string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     *
     * @return static
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlaceIndex():? string
    {
        return $this->placeIndex;
    }

    /**
     * @param string|null $placeIndex
     *
     * @return static
     */
    public function setPlaceIndex($placeIndex)
    {
        $this->placeIndex = $placeIndex;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity():? string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     *
     * @return static
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMobileNumber():? string
    {
        return $this->mobileNumber;
    }

    /**
     * @param string|null $mobileNumber
     *
     * @return static
     */
    public function setMobileNumber($mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFax():? string
    {
        return $this->fax;
    }

    /**
     * @param string|null $fax
     *
     * @return static
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAbbreviation():? string
    {
        return $this->abbreviation;
    }

    /**
     * @param string|null $abbreviation
     *
     * @return static
     */
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGender():? string
    {
        return $this->gender;
    }

    /**
     * @param string|null $gender
     *
     * @return static
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUstIdNr():? string
    {
        return $this->ustIdNr;
    }

    /**
     * @param string|null $ustIdNr
     *
     * @return static
     */
    public function setUstIdNr($ustIdNr)
    {
        $this->ustIdNr = $ustIdNr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry():? string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     *
     * @return static
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return TargetUnload|null
     */
    public function getTargetUnload():? TargetUnload
    {
        return $this->targetUnload;
    }

    /**
     * @param TargetUnload|null $targetUnload
     *
     * @return static
     */
    public function setTargetUnload($targetUnload)
    {
        $this->targetUnload = $targetUnload;

        return $this;
    }

    /**
     * Add Car
     *
     * @param Car $car A new associations with Car entity instance.
     *
     * @return User
     */
    public function addCar(Car $car): User
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
     * Add UserOrder
     *
     * @param UserOrder $userOrder A new associations with UserOrder entity instance.
     *
     * @return User
     */
    public function addUserOrder(UserOrder $userOrder): User
    {
        $this->userOrder[] = $userOrder;

        return $this;
    }

    /**
     * Remove UserOrder
     *
     * @param UserOrder $userOrder A removed association with UserOrder entity instance.
     */
    public function removeUserOrder(UserOrder $userOrder): void
    {
        $this->userOrder->removeElement($userOrder);
    }

    /**
     * Get UserOrders
     *
     * @return Collection
     */
    public function getUserOrders(): Collection
    {
        return $this->userOrder;
    }

    /**
     * @return bool
     */
    public function isAgb():? bool
    {
        return $this->agb;
    }

    /**
     * @param bool $agb
     */
    public function setAgb($agb)
    {
        $this->agb = $agb;
    }

    /**
     * @return bool
     */
    public function isDaten():? bool
    {
        return $this->daten;
    }

    /**
     * @param bool $daten
     *
     * @return User
     */
    public function setDaten($daten)
    {
        $this->daten = $daten;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword():? string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     *
     * @return User
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return bool
     */
    public function accessFrontendSite(): bool
    {
        return true;
    }

    /**
     * Add UserOrderNumber
     *
     * @param UserOrderNumber $userOrderNumber A new associations with UserOrderNumber entity instance.
     *
     * @return Car
     */
    public function addUserOrderNumber(UserOrderNumber $userOrderNumber): User
    {
        $this->userOrderNumber[] = $userOrderNumber;

        return $this;
    }

    /**
     * Remove UserOrderNumber
     *
     * @param UserOrderNumber $userOrderNumber A removed association with UserOrderNumber entity instance.
     */
    public function removeUserOrderNumber(UserOrderNumber $userOrderNumber): void
    {
        $this->userOrderNumber->removeElement($userOrderNumber);
    }

    /**
     * Get UserOrderNumber
     *
     * @return Collection
     */
    public function getUserOrderNumber(): Collection
    {
        return $this->userOrderNumber;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getAbbreviation() ?? $this->getFirmNumber();
    }
}