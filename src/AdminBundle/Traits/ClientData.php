<?php

namespace AdminBundle\Traits;

/**
 * Trait ClientData
 *
 * @package AdminBundle\Traits
 */
trait ClientData
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
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $lastName;

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
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $phoneNumber;

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
     * @return string|null
     */
    public function getFirmNumber():? string
    {
        return $this->firmNumber;
    }

    /**
     * @param string|null $firmNumber
     *
     * @return static
     */
    public function setFirmNumber($firmNumber)
    {
        $this->firmNumber = $firmNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName():? string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     *
     * @return static
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName():? string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     *
     * @return static
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

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
    public function getEmail():? string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     *
     * @return static
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber():? string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string|null $phoneNumber
     *
     * @return static
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

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
     * @return string
     */
    public function getFullName():? string
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}