<?php

namespace AdminBundle\Entity;

use AdminBundle\Entity\References\BodyType;
use AdminBundle\Entity\References\Brand;
use AdminBundle\Entity\References\CarStatus;
use AdminBundle\Entity\References\ClientStatus;
use AdminBundle\Entity\References\Color;
use AdminBundle\Entity\References\Customer;
use AdminBundle\Entity\References\Forwarder;
use AdminBundle\Entity\References\Fuel;
use AdminBundle\Entity\References\Location;
use AdminBundle\Entity\References\Model;
use AdminBundle\Entity\References\Ort;
use AdminBundle\Entity\References\PaymentCondition;
use AdminBundle\Entity\References\PaymentType;
use AdminBundle\Entity\References\Place;
use AdminBundle\Entity\References\PlaceOfIssue;
use AdminBundle\Entity\References\PlaceOfIssueCar;
use AdminBundle\Entity\References\RegistrationCertificate;
use AdminBundle\Entity\References\TargetUnload;
use AdminBundle\Entity\References\TaxType;
use AdminBundle\Entity\References\Vendor;
use AdminBundle\Entity\References\Version;
use AdminBundle\Entity\User\Admin;
use AdminBundle\Entity\User\User;
use AdminBundle\Entity\User\UserOrderNumber;
use AdminBundle\Enum\CarShowPrices;
use AdminBundle\Enum\CarStatusEnum;
use AdminBundle\Traits\ClientData;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Car
 *
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CarRepository")
 *
 * @package AdminBundle\Entity
 */
class Car
{
    use ClientData;

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
    private $carCondition;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $fhnr;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $vinNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $complectationPolish;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $complectationGerman;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $standartComplectationPolish;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $standartComplectationGerman;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $carRegistration;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $carMileage;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $initialVatPrice;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $initialVatPriceType;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $initialPriceWithOutVat;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $initialPriceWithOutVatType;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $ourDiscountPrice;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $ourDiscountPriceType;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $discount;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $minimumSellingPrice;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $minimumSellingPriceType;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceRoleFive;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $priceRoleFiveType;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceRoleSix;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $priceRoleSixType;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceRoleSeven;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $priceRoleSevenType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $completed;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $invoiceNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $paymentDate;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $paid = false;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $documents;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $downloadDate;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $shippingCost;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $shippingCostType;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $transportInvoiceNumber;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $orderNumber;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $radioCode;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $salePriceWithOutVAT;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $salePriceWithOutVATType;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $salePriceWithVAT;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $salePriceWithVATType;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $salesInvoiceNumber;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $paidSuccess = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $invoiceDate;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $information;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $discharge;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $sellingPrice;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $additionalWork;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $declaration;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $importTax;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $taxNumber;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default" : 0})
     */
    private $taxReturned = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $editDate;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default" : 0})
     */
    private $carVisibility = false;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $status = CarStatusEnum::SALE;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateOfBooking;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datum;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $ptsNumber;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $deposit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $addedToArchive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $addedToArchiveDe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $addedToArchivePl;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default" : 0})
     */
    private $pay = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $payClick;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $paidClick;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $carCreatedAt;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true, options={"default" : 1}))
     */
    private $showPrice = CarShowPrices::PRISE_1;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $ekNetto;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $zakupBrut;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $vat;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $nrPro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dataPro;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $nrFv;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dataFv;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default" : 0})
     */
    private $pay4 = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $data1;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $rechNr;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $data2;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $preisTr;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default" : 0})
     */
    private $pay5 = false;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $nrPro2;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dataPro2;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dataFv2;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $zysk;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datum2;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $gewinn;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $restsumme;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $demo;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $info;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $ekBrutto;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default" : 0})
     */
    private $mwst = false;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $ust;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    protected $segregator;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $carlineDate;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $carlineNumber;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     */
    private $firma;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $ankauf;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datumPayFour;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $infoStatistic;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $zahldatum;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default" : 0})
     */
    private $zahldatumPay = false;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $carInvoiceNumber;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $carInvoiceNumberYear;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $carInvoiceDate;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true, unique=true)
     */
    private $proformaNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $proformaDate;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $invoiceFileName;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $registrationCertificateDescription;

    /**
     * @var BodyType
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\BodyType", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $bodyType;

    /**
     * @var CarStatus
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\CarStatus", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $carStatus;

    /**
     * @var RegistrationCertificate
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\RegistrationCertificate", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $registrationCertificate;

    /**
     * @var ClientStatus
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\ClientStatus", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $clientStatus;

    /**
     * @var Fuel
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\Fuel", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $fuel;

    /**
     * @var Ort
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\Ort", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $ort;

    /**
     * @var PaymentCondition
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\PaymentCondition", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $paymentCondition;

    /**
     * @var PaymentType
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\PaymentType", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $paymentType;

    /**
     * @var TaxType
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\TaxType", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $taxType;

    /**
     * @var Admin
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\User\Admin", inversedBy="carSalesman")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $salesman;

    /**
     * @var Admin
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\User\Admin", inversedBy="uploadCar")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $uploader;

    /**
     * @var Brand
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\Brand", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $brand;

    /**
     * @var Model
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\Model", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $model;

    /**
     * @var Version
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\Version", inversedBy="carGerman")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $versionGerman;

    /**
     * @var Version
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\Version", inversedBy="carPolish")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $versionPolish;

    /**
     * @var Color
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\Color", inversedBy="carPolish")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $colorPolish;

    /**
     * @var Color
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\Color", inversedBy="carGerman")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $colorGerman;

    /**
     * @var Admin
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\User\Admin", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $seller;

    /**
     * @var Vendor
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\Vendor", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $vendor;

    /**
     * @var Place
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\Place", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $place;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\Customer", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $customer;

    /**
     * @var TargetUnload
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\TargetUnload", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $targetUnload;

    /**
     * @var Forwarder
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\Forwarder", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $forwarder;

    /**
     * @var Location
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\Location", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $location;

    /**
     * @var PlaceOfIssue
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\References\PlaceOfIssue", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $placeOfIssue;

    /**
     * @var Buyer
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Buyer", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $buyer;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\User\User", inversedBy="car")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $user;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\UserOrder",
     *     mappedBy="car",
     *     cascade={ "all" }
     * )
     */
    private $userOrder;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\CarEditHistory",
     *     mappedBy="car",
     *     cascade={ "all" }
     * )
     */
    private $carEditHistory;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\SalesmanBooking",
     *     mappedBy="car",
     *     cascade={ "persist" }
     * )
     */
    private $salesmanBooking;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\CarFile",
     *     mappedBy="car",
     *     cascade={ "persist" }
     * )
     */
    private $file;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AdminBundle\Entity\User\UserOrderNumber",
     *     mappedBy="car",
     *     cascade={ "persist" }
     * )
     */
    private $userOrderNumber;

    /**
     * Car constructor.
     */
    public function __construct()
    {
        $this->carEditHistory  = new ArrayCollection();
        $this->userOrderNumber = new ArrayCollection();
        $this->salesmanBooking = new ArrayCollection();
        $this->userOrder       = new ArrayCollection();
        $this->file            = new ArrayCollection();
        $this->setCarCreatedAt(new \DateTime());
        $this->setCreatedAt(new \DateTime());
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
    public function getCarCondition():? string
    {
        return $this->carCondition;
    }

    /**
     * @param string|null $carCondition
     *
     * @return static
     */
    public function setCarCondition($carCondition)
    {
        $this->carCondition = $carCondition;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVinNumber():? string
    {
        return $this->vinNumber;
    }

    /**
     * @param string $vinNumber
     *
     * @return static
     */
    public function setVinNumber(string $vinNumber = null)
    {
        $this->vinNumber = $vinNumber;

        return $this;
    }

    /**
     * @return Brand|null
     */
    public function getBrand():? Brand
    {
        return $this->brand;
    }

    /**
     * @param Brand|null $brand
     *
     * @return static
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Model|null
     */
    public function getModel():? Model
    {
        return $this->model;
    }

    /**
     * @param Model|null $model
     *
     * @return static
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return Version|null
     */
    public function getVersionGerman():? Version
    {
        return $this->versionGerman;
    }

    /**
     * @param Version|null $versionGerman
     *
     * @return static
     */
    public function setVersionGerman($versionGerman)
    {
        $this->versionGerman = $versionGerman;

        return $this;
    }

    /**
     * @return Version|null
     */
    public function getVersionPolish():? Version
    {
        return $this->versionPolish;
    }

    /**
     * @param Version|null $versionPolish
     *
     * @return static
     */
    public function setVersionPolish($versionPolish)
    {
        $this->versionPolish = $versionPolish;

        return $this;
    }

    /**
     * @return Color|null
     */
    public function getColorPolish():? Color
    {
        return $this->colorPolish;
    }

    /**
     * @param Color|null $colorPolish
     *
     * @return static
     */
    public function setColorPolish($colorPolish)
    {
        $this->colorPolish = $colorPolish;

        return $this;
    }

    /**
     * @return Color|null
     */
    public function getColorGerman():? Color
    {
        return $this->colorGerman;
    }

    /**
     * @param Color|null $colorGerman
     *
     * @return static
     */
    public function setColorGerman($colorGerman)
    {
        $this->colorGerman = $colorGerman;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStandartComplectationPolish():? string
    {
        return $this->standartComplectationPolish;
    }

    /**
     * @param string|null $standartComplectationPolish
     *
     * @return static
     */
    public function setStandartComplectationPolish($standartComplectationPolish)
    {
        $this->standartComplectationPolish = $standartComplectationPolish;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStandartComplectationGerman():? string
    {
        return $this->standartComplectationGerman;
    }

    /**
     * @param string|null $standartComplectationGerman
     *
     * @return static
     */
    public function setStandartComplectationGerman($standartComplectationGerman)
    {
        $this->standartComplectationGerman = $standartComplectationGerman;

        return $this;
    }

    /**
     * @return Admin|null
     */
    public function getSeller():? Admin
    {
        return $this->seller;
    }

    /**
     * @param Admin|null $seller
     *
     * @return static
     */
    public function setSeller($seller)
    {
        $this->seller = $seller;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getComplectationPolish():? string
    {
        return $this->complectationPolish;
    }

    /**
     * @param string $complectationPolish
     *
     * @return static
     */
    public function setComplectationPolish(string $complectationPolish = null)
    {
        $this->complectationPolish = $complectationPolish;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getComplectationGerman():? string
    {
        return $this->complectationGerman;
    }

    /**
     * @param string $complectationGerman
     *
     * @return static
     */
    public function setComplectationGerman(string $complectationGerman = null)
    {
        $this->complectationGerman = $complectationGerman;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCarRegistration():? \DateTime
    {
        return $this->carRegistration;
    }

    /**
     * @param \DateTime|null $carRegistration
     *
     * @return static
     */
    public function setCarRegistration($carRegistration = null)
    {
        $this->carRegistration = $carRegistration;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCarMileage():? string
    {
        return $this->carMileage;
    }

    /**
     * @param string $carMileage
     *
     * @return static
     */
    public function setCarMileage(string $carMileage = null)
    {
        $this->carMileage = $carMileage;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getInitialVatPrice():? float
    {
        return $this->initialVatPrice;
    }

    /**
     * @param float $initialVatPrice
     *
     * @return static
     */
    public function setInitialVatPrice(float $initialVatPrice = null)
    {
        $this->initialVatPrice = $initialVatPrice;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInitialVatPriceType():? string
    {
        return $this->initialVatPriceType;
    }

    /**
     * @param string $initialVatPriceType
     *
     * @return static
     */
    public function setInitialVatPriceType(string $initialVatPriceType)
    {
        $this->initialVatPriceType = $initialVatPriceType;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getInitialPriceWithOutVat():? float
    {
        return $this->initialPriceWithOutVat;
    }

    /**
     * @param float $initialPriceWithOutVat
     *
     * @return static
     */
    public function setInitialPriceWithOutVat(float $initialPriceWithOutVat = null)
    {
        $this->initialPriceWithOutVat = $initialPriceWithOutVat;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInitialPriceWithOutVatType():? string
    {
        return $this->initialPriceWithOutVatType;
    }

    /**
     * @param string $initialPriceWithOutVatType
     *
     * @return static
     */
    public function setInitialPriceWithOutVatType(string $initialPriceWithOutVatType)
    {
        $this->initialPriceWithOutVatType = $initialPriceWithOutVatType;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getOurDiscountPrice():? float
    {
        return $this->ourDiscountPrice;
    }

    /**
     * @param float|null $ourDiscountPrice
     *
     * @return static
     */
    public function setOurDiscountPrice($ourDiscountPrice)
    {
        $this->ourDiscountPrice = $ourDiscountPrice;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOurDiscountPriceType():? string
    {
        return $this->ourDiscountPriceType;
    }

    /**
     * @param string $ourDiscountPriceType
     *
     * @return static
     */
    public function setOurDiscountPriceType(string $ourDiscountPriceType)
    {
        $this->ourDiscountPriceType = $ourDiscountPriceType;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getDiscount():? float
    {
        return $this->discount;
    }

    /**
     * @param float $discount
     *
     * @return static
     */
    public function setDiscount(float $discount = null)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMinimumSellingPrice():? float
    {
        return $this->minimumSellingPrice;
    }

    /**
     * @param float $minimumSellingPrice
     *
     * @return static
     */
    public function setMinimumSellingPrice(float $minimumSellingPrice = null)
    {
        $this->minimumSellingPrice = $minimumSellingPrice;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMinimumSellingPriceType():? string
    {
        return $this->minimumSellingPriceType;
    }

    /**
     * @param string $minimumSellingPriceType
     *
     * @return static
     */
    public function setMinimumSellingPriceType(string $minimumSellingPriceType)
    {
        $this->minimumSellingPriceType = $minimumSellingPriceType;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPriceRoleFive():? float
    {
        return $this->priceRoleFive;
    }

    /**
     * @param float|null $priceRoleFive
     *
     * @return static
     */
    public function setPriceRoleFive($priceRoleFive)
    {
        $this->priceRoleFive = $priceRoleFive;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPriceRoleFiveType():? string
    {
        return $this->priceRoleFiveType;
    }

    /**
     * @param string $priceRoleFiveType
     *
     * @return static
     */
    public function setPriceRoleFiveType(string $priceRoleFiveType)
    {
        $this->priceRoleFiveType = $priceRoleFiveType;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPriceRoleSix():? float
    {
        return $this->priceRoleSix;
    }

    /**
     * @param float|null $priceRoleSix
     *
     * @return static
     */
    public function setPriceRoleSix($priceRoleSix)
    {
        $this->priceRoleSix = $priceRoleSix;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPriceRoleSixType():? string
    {
        return $this->priceRoleSixType;
    }

    /**
     * @param string $priceRoleSixType
     *
     * @return static
     */
    public function setPriceRoleSixType(string $priceRoleSixType)
    {
        $this->priceRoleSixType = $priceRoleSixType;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPriceRoleSeven():? float
    {
        return $this->priceRoleSeven;
    }

    /**
     * @param float|null $priceRoleSeven
     *
     * @return static
     */
    public function setPriceRoleSeven($priceRoleSeven)
    {
        $this->priceRoleSeven = $priceRoleSeven;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPriceRoleSevenType():? string
    {
        return $this->priceRoleSevenType;
    }

    /**
     * @param string $priceRoleSevenType
     *
     * @return static
     */
    public function setPriceRoleSevenType(string $priceRoleSevenType)
    {
        $this->priceRoleSevenType = $priceRoleSevenType;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCompleted():? \DateTime
    {
        return $this->completed;
    }

    /**
     * @param \DateTime|null $completed
     *
     * @return static
     */
    public function setCompleted($completed = null)
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInvoiceNumber():? string
    {
        return $this->invoiceNumber;
    }

    /**
     * @param string $invoiceNumber
     *
     * @return static
     */
    public function setInvoiceNumber(string $invoiceNumber = null)
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPaymentDate():? \DateTime
    {
        return $this->paymentDate;
    }

    /**
     * @param \DateTime|null $paymentDate
     *
     * @return static
     */
    public function setPaymentDate($paymentDate = null)
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isPaid():? bool
    {
        return $this->paid;
    }

    /**
     * @param bool $paid
     *
     * @return static
     */
    public function setPaid(bool $paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDocuments():? string
    {
        return $this->documents;
    }

    /**
     * @param string $documents
     *
     * @return static
     */
    public function setDocuments(string $documents = null)
    {
        $this->documents = $documents;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDownloadDate():? \DateTime
    {
        return $this->downloadDate;
    }

    /**
     * @param \DateTime|null $downloadDate
     *
     * @return static
     */
    public function setDownloadDate($downloadDate = null)
    {
        $this->downloadDate = $downloadDate;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getShippingCost():? float
    {
        return $this->shippingCost;
    }

    /**
     * @param float|null $shippingCost
     *
     * @return static
     */
    public function setShippingCost($shippingCost)
    {
        $this->shippingCost = $shippingCost;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShippingCostType():? string
    {
        return $this->shippingCostType;
    }

    /**
     * @param string $shippingCostType
     *
     * @return static
     */
    public function setShippingCostType(string $shippingCostType)
    {
        $this->shippingCostType = $shippingCostType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTransportInvoiceNumber():? string
    {
        return $this->transportInvoiceNumber;
    }

    /**
     * @param string $transportInvoiceNumber
     *
     * @return static
     */
    public function setTransportInvoiceNumber(string $transportInvoiceNumber = null)
    {
        $this->transportInvoiceNumber = $transportInvoiceNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrderNumber():? string
    {
        return $this->orderNumber;
    }

    /**
     * @param string $orderNumber
     *
     * @return static
     */
    public function setOrderNumber(string $orderNumber = null)
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRadioCode():? string
    {
        return $this->radioCode;
    }

    /**
     * @param string $radioCode
     *
     * @return static
     */
    public function setRadioCode(string $radioCode = null)
    {
        $this->radioCode = $radioCode;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getSalePriceWithOutVAT():? float
    {
        return $this->salePriceWithOutVAT;
    }

    /**
     * @param float|null $salePriceWithOutVAT
     *
     * @return static
     */
    public function setSalePriceWithOutVAT($salePriceWithOutVAT)
    {
        $this->salePriceWithOutVAT = $salePriceWithOutVAT;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSalePriceWithOutVATType():? string
    {
        return $this->salePriceWithOutVATType;
    }

    /**
     * @param string $salePriceWithOutVATType
     *
     * @return static
     */
    public function setSalePriceWithOutVATType(string $salePriceWithOutVATType)
    {
        $this->salePriceWithOutVATType = $salePriceWithOutVATType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSalesInvoiceNumber():? string
    {
        return $this->salesInvoiceNumber;
    }

    /**
     * @param string $salesInvoiceNumber
     *
     * @return static
     */
    public function setSalesInvoiceNumber(string $salesInvoiceNumber = null)
    {
        $this->salesInvoiceNumber = $salesInvoiceNumber;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getInvoiceDate():? \DateTime
    {
        return $this->invoiceDate;
    }

    /**
     * @param \DateTime|null $invoiceDate
     *
     * @return static
     */
    public function setInvoiceDate($invoiceDate)
    {
        $this->invoiceDate = $invoiceDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInformation():? string
    {
        return $this->information;
    }

    /**
     * @param string $information
     *
     * @return static
     */
    public function setInformation(string $information = null)
    {
        $this->information = $information;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDischarge():? string
    {
        return $this->discharge;
    }

    /**
     * @param string $discharge
     *
     * @return static
     */
    public function setDischarge(string $discharge = null)
    {
        $this->discharge = $discharge;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getSellingPrice():? float
    {
        return $this->sellingPrice;
    }

    /**
     * @param float|null $sellingPrice
     *
     * @return static
     */
    public function setSellingPrice($sellingPrice)
    {
        $this->sellingPrice = $sellingPrice;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdditionalWork():? string
    {
        return $this->additionalWork;
    }

    /**
     * @param string|null $additionalWork
     *
     * @return static
     */
    public function setAdditionalWork($additionalWork)
    {
        $this->additionalWork = $additionalWork;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNotes():? string
    {
        return $this->notes;
    }

    /**
     * @param string|null $notes
     *
     * @return static
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

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
     * @param \DateTime|null $date
     *
     * @return static
     */
    public function setDate($date = null)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeclaration():? string
    {
        return $this->declaration;
    }

    /**
     * @param string $declaration
     *
     * @return static
     */
    public function setDeclaration(string $declaration = null)
    {
        $this->declaration = $declaration;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getImportTax():? float
    {
        return $this->importTax;
    }

    /**
     * @param float $importTax
     *
     * @return static
     */
    public function setImportTax(float $importTax = null)
    {
        $this->importTax = $importTax;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTaxNumber():? string
    {
        return $this->taxNumber;
    }

    /**
     * @param string $taxNumber
     *
     * @return static
     */
    public function setTaxNumber(string $taxNumber = null)
    {
        $this->taxNumber = $taxNumber;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isTaxReturned():? bool
    {
        return $this->taxReturned;
    }

    /**
     * @param bool $taxReturned
     *
     * @return static
     */
    public function setTaxReturned(bool $taxReturned)
    {
        $this->taxReturned = $taxReturned;

        return $this;
    }

    /**
     * @return Vendor|null
     */
    public function getVendor():? Vendor
    {
        return $this->vendor;
    }

    /**
     * @param Vendor|null $vendor
     *
     * @return static
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * @return Place|null
     */
    public function getPlace():? Place
    {
        return $this->place;
    }

    /**
     * @param Place|null $place
     *
     * @return static
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return Customer|null
     */
    public function getCustomer():? Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer|null $customer
     *
     * @return static
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

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
     * @return Forwarder|null
     */
    public function getForwarder():? Forwarder
    {
        return $this->forwarder;
    }

    /**
     * @param Forwarder|null $forwarder
     *
     * @return static
     */
    public function setForwarder($forwarder)
    {
        $this->forwarder = $forwarder;

        return $this;
    }

    /**
     * @return Location|null
     */
    public function getLocation():? Location
    {
        return $this->location;
    }

    /**
     * @param Location|null $location
     *
     * @return static
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return PlaceOfIssue|null
     */
    public function getPlaceOfIssue():? PlaceOfIssue
    {
        return $this->placeOfIssue;
    }

    /**
     * @param PlaceOfIssue|null $placeOfIssue
     *
     * @return static
     */
    public function setPlaceOfIssue($placeOfIssue)
    {
        $this->placeOfIssue = $placeOfIssue;

        return $this;
    }

    /**
     * @return Buyer|null
     */
    public function getBuyer():? Buyer
    {
        return $this->buyer;
    }

    /**
     * @param Buyer|null $buyer
     *
     * @return static
     */
    public function setBuyer($buyer)
    {
        $this->buyer = $buyer;

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
     * Add UserOrder
     *
     * @param UserOrder $userOrder A new associations with UserOrder entity instance.
     *
     * @return Car
     */
    public function addOrder(UserOrder $userOrder): Car
    {
        $this->userOrder[] = $userOrder;

        return $this;
    }

    /**
     * Remove UserOrder
     *
     * @param UserOrder $userOrder A removed association with UserOrder entity instance.
     */
    public function removeOrder(UserOrder $userOrder): void
    {
        $this->userOrder->removeElement($userOrder);
    }

    /**
     * Get UserOrders
     *
     * @return Collection
     */
    public function getOrders(): Collection
    {
        return $this->userOrder;
    }

    /**
     * Add CarEditHistory
     *
     * @param CarEditHistory $carEditHistory A new associations with CarEditHistory entity instance.
     *
     * @return Car
     */
    public function addCarEditHistory(CarEditHistory $carEditHistory): Car
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
     * Add UserOrderNumber
     *
     * @param UserOrderNumber $userOrderNumber A new associations with UserOrderNumber entity instance.
     *
     * @return Car
     */
    public function addUserOrderNumber(UserOrderNumber $userOrderNumber): Car
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
     * Add SalesmanBooking
     *
     * @param SalesmanBooking $salesmanBooking A new associations with SalesmanBooking entity instance.
     *
     * @return Car
     */
    public function addSalesmanBooking(SalesmanBooking $salesmanBooking): Car
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
     * Add File
     *
     * @param CarFile $file A new associations with CarFile entity instance.
     *
     * @return Car
     */
    public function addFile(CarFile $file): Car
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
     * @return bool
     */
    public function isCarVisibility(): bool
    {
        return $this->carVisibility;
    }

    /**
     * @param bool $carVisibility
     *
     * @return static
     */
    public function setCarVisibility(bool $carVisibility)
    {
        $this->carVisibility = $carVisibility;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus():? string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     *
     * @return static
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Admin|null
     */
    public function getSalesman():? Admin
    {
        return $this->salesman;
    }

    /**
     * @param Admin|null $salesman
     *
     * @return static
     */
    public function setSalesman($salesman)
    {
        $this->salesman = $salesman;

        return $this;
    }

    /**
     * @return Admin|null
     */
    public function getUploader():? Admin
    {
        return $this->uploader;
    }

    /**
     * @param Admin|null $uploader
     *
     * @return static
     */
    public function setUploader($uploader)
    {
        $this->uploader = $uploader;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateOfBooking():? \DateTime
    {
        return $this->dateOfBooking;
    }

    /**
     * @param \DateTime|null $dateOfBooking
     *
     * @return static
     */
    public function setDateOfBooking($dateOfBooking)
    {
        $this->dateOfBooking = $dateOfBooking;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDatum():? \DateTime
    {
        return $this->datum;
    }

    /**
     * @param \DateTime|null $datum
     *
     * @return static
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPtsNumber():? string
    {
        return $this->ptsNumber;
    }

    /**
     * @param string|null $ptsNumber
     *
     * @return static
     */
    public function setPtsNumber($ptsNumber)
    {
        $this->ptsNumber = $ptsNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeposit():? string
    {
        return $this->deposit;
    }

    /**
     * @param string|null $deposit
     *
     * @return static
     */
    public function setDeposit($deposit)
    {
        $this->deposit = $deposit;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRegistrationCertificateDescription():? string
    {
        return $this->registrationCertificateDescription;
    }

    /**
     * @param string|null $registrationCertificateDescription
     *
     * @return static
     */
    public function setRegistrationCertificateDescription($registrationCertificateDescription)
    {
        $this->registrationCertificateDescription = $registrationCertificateDescription;

        return $this;
    }

    /**
     * @return BodyType|null
     */
    public function getBodyType():? BodyType
    {
        return $this->bodyType;
    }

    /**
     * @param BodyType|null $bodyType
     *
     * @return static
     */
    public function setBodyType($bodyType)
    {
        $this->bodyType = $bodyType;

        return $this;
    }

    /**
     * @return CarStatus|null
     */
    public function getCarStatus():? CarStatus
    {
        return $this->carStatus;
    }

    /**
     * @param CarStatus|null $carStatus
     *
     * @return static
     */
    public function setCarStatus($carStatus)
    {
        $this->carStatus = $carStatus;

        return $this;
    }

    /**
     * @return RegistrationCertificate|null
     */
    public function getRegistrationCertificate():? RegistrationCertificate
    {
        return $this->registrationCertificate;
    }

    /**
     * @param RegistrationCertificate|null $registrationCertificate
     *
     * @return static
     */
    public function setRegistrationCertificate($registrationCertificate)
    {
        $this->registrationCertificate = $registrationCertificate;

        return $this;
    }

    /**
     * @return ClientStatus|null
     */
    public function getClientStatus():? ClientStatus
    {
        return $this->clientStatus;
    }

    /**
     * @param ClientStatus|null $clientStatus
     *
     * @return static
     */
    public function setClientStatus($clientStatus)
    {
        $this->clientStatus = $clientStatus;

        return $this;
    }

    /**
     * @return Fuel|null
     */
    public function getFuel():? Fuel
    {
        return $this->fuel;
    }

    /**
     * @param Fuel|null $fuel
     *
     * @return static
     */
    public function setFuel($fuel)
    {
        $this->fuel = $fuel;

        return $this;
    }

    /**
     * @return Ort|null
     */
    public function getOrt():? Ort
    {
        return $this->ort;
    }

    /**
     * @param Ort|null $ort
     *
     * @return static
     */
    public function setOrt($ort)
    {
        $this->ort = $ort;

        return $this;
    }

    /**
     * @return PaymentCondition|null
     */
    public function getPaymentCondition():? PaymentCondition
    {
        return $this->paymentCondition;
    }

    /**
     * @param PaymentCondition|null $paymentCondition
     *
     * @return static
     */
    public function setPaymentCondition($paymentCondition)
    {
        $this->paymentCondition = $paymentCondition;

        return $this;
    }

    /**
     * @return PaymentType|null
     */
    public function getPaymentType():? PaymentType
    {
        return $this->paymentType;
    }

    /**
     * @param PaymentType|null $paymentType
     *
     * @return static
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * @return TaxType|null
     */
    public function getTaxType():? TaxType
    {
        return $this->taxType;
    }

    /**
     * @param TaxType|null $taxType
     *
     * @return static
     */
    public function setTaxType($taxType)
    {
        $this->taxType = $taxType;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getSalePriceWithVAT():? float
    {
        return $this->salePriceWithVAT;
    }

    /**
     * @param float|null $salePriceWithVAT
     *
     * @return static
     */
    public function setSalePriceWithVAT($salePriceWithVAT)
    {
        $this->salePriceWithVAT = $salePriceWithVAT;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSalePriceWithVATType():? string
    {
        return $this->salePriceWithVATType;
    }

    /**
     * @param string $salePriceWithVATType
     *
     * @return static
     */
    public function setSalePriceWithVATType(string $salePriceWithVATType)
    {
        $this->salePriceWithVATType = $salePriceWithVATType;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPaidSuccess(): bool
    {
        return $this->paidSuccess;
    }

    /**
     * @param bool $paidSuccess
     *
     * @return static
     */
    public function setPaidSuccess(bool $paidSuccess)
    {
        $this->paidSuccess = $paidSuccess;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFhnr():? string
    {
        return $this->fhnr;
    }

    /**
     * @param string|null $fhnr
     *
     * @return static
     */
    public function setFhnr($fhnr)
    {
        $this->fhnr = $fhnr;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getAddedToArchive():? \DateTime
    {
        return $this->addedToArchive;
    }

    /**
     * @param \DateTime|null $addedToArchive
     *
     * @return static
     */
    public function setAddedToArchive($addedToArchive)
    {
        $this->addedToArchive = $addedToArchive;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPay(): bool
    {
        return $this->pay;
    }

    /**
     * @param bool $pay
     *
     * @return static
     */
    public function setPay(bool $pay)
    {
        $this->pay = $pay;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPayClick():? \DateTime
    {
        return $this->payClick;
    }

    /**
     * @param \DateTime|null $payClick
     *
     * @return static
     */
    public function setPayClick($payClick)
    {
        $this->payClick = $payClick;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPaidClick():? \DateTime
    {
        return $this->paidClick;
    }

    /**
     * @param \DateTime|null $paidClick
     *
     * @return static
     */
    public function setPaidClick($paidClick)
    {
        $this->paidClick = $paidClick;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCarCreatedAt():? \DateTime
    {
        return $this->carCreatedAt;
    }

    /**
     * @param \DateTime|null $carCreatedAt
     *
     * @return static
     */
    public function setCarCreatedAt($carCreatedAt)
    {
        $this->carCreatedAt = $carCreatedAt;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getAddedToArchiveDe():? \DateTime
    {
        return $this->addedToArchiveDe;
    }

    /**
     * @param \DateTime|null $addedToArchiveDe
     *
     * @return static
     */
    public function setAddedToArchiveDe($addedToArchiveDe)
    {
        $this->addedToArchiveDe = $addedToArchiveDe;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getAddedToArchivePl():? \DateTime
    {
        return $this->addedToArchivePl;
    }

    /**
     * @param \DateTime|null $addedToArchivePl
     *
     * @return static
     */
    public function setAddedToArchivePl($addedToArchivePl)
    {
        $this->addedToArchivePl = $addedToArchivePl;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShowPrice():? string
    {
        return $this->showPrice;
    }

    /**
     * @param string|null $showPrice
     *
     * @return static
     */
    public function setShowPrice($showPrice)
    {
        $this->showPrice = $showPrice;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getEkNetto():? float
    {
        return $this->ekNetto;
    }

    /**
     * @param float|null $ekNetto
     *
     * @return static
     */
    public function setEkNetto($ekNetto)
    {
        $this->ekNetto = $ekNetto;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getZakupBrut():? float
    {
        return $this->zakupBrut;
    }

    /**
     * @param float|null $zakupBrut
     *
     * @return static
     */
    public function setZakupBrut($zakupBrut)
    {
        $this->zakupBrut = $zakupBrut;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getVat():? float
    {
        return $this->vat;
    }

    /**
     * @param float|null $vat
     *
     * @return static
     */
    public function setVat($vat)
    {
        $this->vat = $vat;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNrPro():? string
    {
        return $this->nrPro;
    }

    /**
     * @param string|null $nrPro
     *
     * @return static
     */
    public function setNrPro($nrPro)
    {
        $this->nrPro = $nrPro;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDataPro():? \DateTime
    {
        return $this->dataPro;
    }

    /**
     * @param \DateTime|null $dataPro
     *
     * @return static
     */
    public function setDataPro($dataPro)
    {
        $this->dataPro = $dataPro;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNrFv():? string
    {
        return $this->nrFv;
    }

    /**
     * @param string|null $nrFv
     *
     * @return static
     */
    public function setNrFv($nrFv)
    {
        $this->nrFv = $nrFv;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDataFv():? \DateTime
    {
        return $this->dataFv;
    }

    /**
     * @param \DateTime|null $dataFv
     *
     * @return static
     */
    public function setDataFv($dataFv)
    {
        $this->dataFv = $dataFv;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isPay4():? bool
    {
        return $this->pay4;
    }

    /**
     * @param bool|null $pay4
     *
     * @return static
     */
    public function setPay4($pay4)
    {
        $this->pay4 = $pay4;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getData1():? \DateTime
    {
        return $this->data1;
    }

    /**
     * @param \DateTime|null $data1
     *
     * @return static
     */
    public function setData1($data1)
    {
        $this->data1 = $data1;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getRechNr():? float
    {
        return $this->rechNr;
    }

    /**
     * @param float|null $rechNr
     *
     * @return static
     */
    public function setRechNr($rechNr)
    {
        $this->rechNr = $rechNr;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getData2():? \DateTime
    {
        return $this->data2;
    }

    /**
     * @param \DateTime|null $data2
     *
     * @return static
     */
    public function setData2($data2)
    {
        $this->data2 = $data2;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPreisTr():? float
    {
        return $this->preisTr;
    }

    /**
     * @param float|null $preisTr
     *
     * @return static
     */
    public function setPreisTr($preisTr)
    {
        $this->preisTr = $preisTr;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isPay5():? bool
    {
        return $this->pay5;
    }

    /**
     * @param bool|null $pay5
     *
     * @return static
     */
    public function setPay5($pay5)
    {
        $this->pay5 = $pay5;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNrPro2():? string
    {
        return $this->nrPro2;
    }

    /**
     * @param string|null $nrPro2
     *
     * @return static
     */
    public function setNrPro2($nrPro2)
    {
        $this->nrPro2 = $nrPro2;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDataPro2():? \DateTime
    {
        return $this->dataPro2;
    }

    /**
     * @param \DateTime|null $dataPro2
     *
     * @return static
     */
    public function setDataPro2($dataPro2)
    {
        $this->dataPro2 = $dataPro2;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDataFv2():? \DateTime
    {
        return $this->dataFv2;
    }

    /**
     * @param \DateTime|null $dataFv2
     *
     * @return static
     */
    public function setDataFv2($dataFv2)
    {
        $this->dataFv2 = $dataFv2;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getZysk():? float
    {
        return $this->zysk;
    }

    /**
     * @param float|null $zysk
     *
     * @return static
     */
    public function setZysk($zysk)
    {
        $this->zysk = $zysk;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDatum2():? \DateTime
    {
        return $this->datum2;
    }

    /**
     * @param \DateTime|null $datum2
     *
     * @return static
     */
    public function setDatum2($datum2)
    {
        $this->datum2 = $datum2;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getGewinn():? float
    {
        return $this->gewinn;
    }

    /**
     * @param float|null $gewinn
     *
     * @return static
     */
    public function setGewinn($gewinn)
    {
        $this->gewinn = $gewinn;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getRestsumme():? float
    {
        return $this->restsumme;
    }

    /**
     * @param float|null $restsumme
     *
     * @return static
     */
    public function setRestsumme($restsumme)
    {
        $this->restsumme = $restsumme;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDemo():? string
    {
        return $this->demo;
    }

    /**
     * @param string|null $demo
     *
     * @return static
     */
    public function setDemo($demo)
    {
        $this->demo = $demo;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInfo():? string
    {
        return $this->info;
    }

    /**
     * @param string|null $info
     *
     * @return static
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getEkBrutto():? float
    {
        return $this->ekBrutto;
    }

    /**
     * @param float|null $ekBrutto
     *
     * @return static
     */
    public function setEkBrutto($ekBrutto)
    {
        $this->ekBrutto = $ekBrutto;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMwst(): bool
    {
        return $this->mwst;
    }

    /**
     * @param bool|null $mwst
     *
     * @return static
     */
    public function setMwst($mwst)
    {
        $this->mwst = $mwst;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getUst():? float
    {
        return $this->ust;
    }

    /**
     * @param float|null $ust
     *
     * @return static
     */
    public function setUst($ust)
    {
        $this->ust = $ust;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSegregator():? string
    {
        return $this->segregator;
    }

    /**
     * @param string|null $segregator
     *
     * @return static
     */
    public function setSegregator($segregator)
    {
        $this->segregator = $segregator;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt():? \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|null $createdAt
     *
     * @return static
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCarlineDate():? \DateTime
    {
        return $this->carlineDate;
    }

    /**
     * @param \DateTime|null $carlineDate
     *
     * @return static
     */
    public function setCarlineDate($carlineDate)
    {
        $this->carlineDate = $carlineDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCarlineNumber():? string
    {
        return $this->carlineNumber;
    }

    /**
     * @param string|null $carlineNumber
     *
     * @return static
     */
    public function setCarlineNumber($carlineNumber)
    {
        $this->carlineNumber = $carlineNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirma():? string
    {
        return $this->firma;
    }

    /**
     * @param string|null $firma
     *
     * @return static
     */
    public function setFirma($firma)
    {
        $this->firma = $firma;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getAnkauf():? \DateTime
    {
        return $this->ankauf;
    }

    /**
     * @param \DateTime|null $ankauf
     *
     * @return static
     */
    public function setAnkauf($ankauf)
    {
        $this->ankauf = $ankauf;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDatumPayFour():? \DateTime
    {
        return $this->datumPayFour;
    }

    /**
     * @param \DateTime|null $datumPayFour
     *
     * @return static
     */
    public function setDatumPayFour($datumPayFour)
    {
        $this->datumPayFour = $datumPayFour;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInfoStatistic():? string
    {
        return $this->infoStatistic;
    }

    /**
     * @param string|null $infoStatistic
     *
     * @return static
     */
    public function setInfoStatistic($infoStatistic)
    {
        $this->infoStatistic = $infoStatistic;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getZahldatum():? \DateTime
    {
        return $this->zahldatum;
    }

    /**
     * @param \DateTime|null $zahldatum
     *
     * @return static
     */
    public function setZahldatum($zahldatum)
    {
        $this->zahldatum = $zahldatum;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isZahldatumPay():? bool
    {
        return $this->zahldatumPay;
    }

    /**
     * @param bool|null $zahldatumPay
     *
     * @return static
     */
    public function setZahldatumPay($zahldatumPay)
    {
        $this->zahldatumPay = $zahldatumPay;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCarInvoiceNumber():? int
    {
        return $this->carInvoiceNumber;
    }

    /**
     * @param int|null $carInvoiceNumber
     *
     * @return static
     */
    public function setCarInvoiceNumber($carInvoiceNumber)
    {
        $this->carInvoiceNumber = $carInvoiceNumber;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCarInvoiceNumberYear():? int
    {
        return $this->carInvoiceNumberYear;
    }

    /**
     * @param int|null $carInvoiceNumberYear
     *
     * @return static
     */
    public function setCarInvoiceNumberYear($carInvoiceNumberYear)
    {
        $this->carInvoiceNumberYear = $carInvoiceNumberYear;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCarInvoiceDate():? \DateTime
    {
        return $this->carInvoiceDate;
    }

    /**
     * @param \DateTime|null $carInvoiceDate
     *
     * @return static
     */
    public function setCarInvoiceDate($carInvoiceDate)
    {
        $this->carInvoiceDate = $carInvoiceDate;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getProformaNumber():? int
    {
        return $this->proformaNumber;
    }

    /**
     * @param int|null $proformaNumber
     *
     * @return static
     */
    public function setProformaNumber($proformaNumber)
    {
        $this->proformaNumber = $proformaNumber;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getProformaDate():? \DateTime
    {
        return $this->proformaDate;
    }

    /**
     * @param \DateTime|null $proformaDate
     *
     * @return static
     */
    public function setProformaDate($proformaDate)
    {
        $this->proformaDate = $proformaDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getInvoiceFileName():? string
    {
        return $this->invoiceFileName;
    }

    /**
     * @param string|null $invoiceFileName
     *
     * @return static
     */
    public function setInvoiceFileName($invoiceFileName)
    {
        $this->invoiceFileName = $invoiceFileName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPriceByShowPrice():? string
    {
        switch ($this->getShowPrice()) {
            case CarShowPrices::PRISE_1:
                return $this->getPriceRoleFive();
            case CarShowPrices::PRISE_2:
                return $this->getPriceRoleSix();
            case CarShowPrices::PRISE_3:
                return $this->getPriceRoleSeven();
            default:
                return null;
        }
    }
}
