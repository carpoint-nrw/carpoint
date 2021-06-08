<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Currency
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CurrencyRepository")
 *
 * @package AdminBundle\Entity
 */
class Currency
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $realCurrency;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $ourCurrency;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * Currency constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->setDate(new \DateTime());
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float|null
     */
    public function getRealCurrency():? float
    {
        return $this->realCurrency;
    }

    /**
     * @param float $realCurrency
     *
     * @return Currency
     */
    public function setRealCurrency(float $realCurrency)
    {
        $this->realCurrency = $realCurrency;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getOurCurrency():? float
    {
        return $this->ourCurrency;
    }

    /**
     * @param float $ourCurrency
     *
     * @return Currency
     */
    public function setOurCurrency(float $ourCurrency)
    {
        $this->ourCurrency = $ourCurrency;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate():? \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return Currency
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }
}