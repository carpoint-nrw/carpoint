<?php

namespace AdminBundle\DTO;

/**
 * Class ExportExcelDTO
 *
 * @package AdminBundle\DTO
 */
class ExportExcelDTO
{
    /**
     * @var bool
     */
    public $vendor;

    /**
     * @var bool
     */
    public $address1;

    /**
     * @var bool
     */
    public $customer;

    /**
     * @var bool
     */
    public $radioCode;

    /**
     * @var bool
     */
    public $carCondition;

    /**
     * @var bool
     */
    public $vinNumber;

    /**
     * @var bool
     */
    public $brand;

    /**
     * @var bool
     */
    public $model;

    /**
     * @var bool
     */
    public $versionPolish;

    /**
     * @var bool
     */
    public $versionGerman;

    /**
     * @var bool
     */
    public $colorPolish;

    /**
     * @var bool
     */
    public $colorGerman;

    /**
     * @var bool
     */
    public $standartComplectationPolish;

    /**
     * @var bool
     */
    public $standartComplectationGerman;

    /**
     * @var bool
     */
    public $complectationPolish;

    /**
     * @var bool
     */
    public $complectationGerman;

    /**
     * @var bool
     */
    public $ourDiscountPrice;

    /**
     * @var bool
     */
    public $carRegistration;

    /**
     * @var bool
     */
    public $carMileage;

    /**
     * @var bool
     */
    public $initialVatPrice;

    /**
     * @var bool
     */
    public $initialPriceWithOutVat;

    /**
     * @var bool
     */
    public $minimumSellingPrice;

    /**
     * @var bool
     */
    public $priceRoleFive;

    /**
     * @var bool
     */
    public $priceRoleSix;

    /**
     * @var bool
     */
    public $priceRoleSeven;

    /**
     * @var bool
     */
    public $preisb2b;

    /**
     * @var bool
     */
    public $completed;

    /**
     * @var bool
     */
    public $paymentDate;

    /**
     * @var bool
     */
    public $paid;

    /**
     * @var bool
     */
    public $documents;

    /**
     * @var bool
     */
    public $downloadDate;

    /**
     * @var bool
     */
    public $targetUnload;

    /**
     * @var bool
     */
    public $location;

    /**
     * @var bool
     */
    public $orderNumber;

    /**
     * @var bool
     */
    public $information;

    /**
     * @var bool
     */
    public $invoiceNumber;

    /**
     * @var string
     */
    public $ids;

    /**
     * @var string
     */
    public $language;

    /**
     * @var bool
     */
    public $user;

    /**
     * @var bool
     */
    public $discount;

    /**
     * @var bool
     */
    public $salePriceWithOutVAT;

    /**
     * @var bool
     */
    public $pay4;

    /**
     * @var bool
     */
    public $ekNetto;

    /**
     * @var bool
     */
    public $ekBrutto;

    /**
     * @var bool
     */
    public $ust;

    /**
     * @var bool
     */
    public $datum;

    /**
     * @var bool
     */
    public $seller;

    /**
     * @var bool
     */
    public $carlineDate;

    /**
     * @var bool
     */
    public $carlineNumber;

    /**
     * @var bool
     */
    public $gewinn;

    /**
     * @var bool
     */
    public $additionalWork;

    /**
     * @var bool
     */
    public $date;

    /**
     * @var bool
     */
    public $ankauf;

    /**
     * @var bool
     */
    public $zustand;

    /**
     * @var bool
     */
    public $preisTr;

    /**
     * @var bool
     */
    public $datumPayFour;

    /**
     * @var bool
     */
    public $company;

    /**
     * @var bool
     */
    public $rechnungsnr;

    /**
     * @var bool
     */
    public $reDatum;

    /**
     * @var bool
     */
    public $paymentType;

    /**
     * @var bool
     */
    public $vkNetto;

    /**
     * @var bool
     */
    public $vkBrutto;

    /**
     * @var bool
     */
    public $infoStatistic;

    /**
     * @var bool
     */
    public $zahldatum;

    /**
     * @var bool
     */
    public $standtage;

    /**
     * @var bool
     */
    public $address3;

    /**
     * @var bool
     */
    public $zysk;

    /**
     * @return bool|null
     */
    public function isCarCondition():? bool
    {
        return $this->carCondition;
    }

    /**
     * @param bool $carCondition
     */
    public function setCarCondition(bool $carCondition): void
    {
        $this->carCondition = $carCondition;
    }

    /**
     * @return bool|null
     */
    public function isVinNumber():? bool
    {
        return $this->vinNumber;
    }

    /**
     * @param bool $vinNumber
     */
    public function setVinNumber(bool $vinNumber): void
    {
        $this->vinNumber = $vinNumber;
    }

    /**
     * @return bool|null
     */
    public function isBrand():? bool
    {
        return $this->brand;
    }

    /**
     * @param bool $brand
     */
    public function setBrand(bool $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return bool|null
     */
    public function isModel():? bool
    {
        return $this->model;
    }

    /**
     * @param bool $model
     */
    public function setModel(bool $model): void
    {
        $this->model = $model;
    }

    /**
     * @return bool|null
     */
    public function isVersionPolish():? bool
    {
        return $this->versionPolish;
    }

    /**
     * @param bool $versionPolish
     */
    public function setVersionPolish(bool $versionPolish): void
    {
        $this->versionPolish = $versionPolish;
    }

    /**
     * @return bool|null
     */
    public function isVersionGerman():? bool
    {
        return $this->versionGerman;
    }

    /**
     * @param bool $versionGerman
     */
    public function setVersionGerman(bool $versionGerman): void
    {
        $this->versionGerman = $versionGerman;
    }

    /**
     * @return bool|null
     */
    public function isColorPolish():? bool
    {
        return $this->colorPolish;
    }

    /**
     * @param bool $colorPolish
     */
    public function setColorPolish(bool $colorPolish): void
    {
        $this->colorPolish = $colorPolish;
    }

    /**
     * @return bool|null
     */
    public function isColorGerman():? bool
    {
        return $this->colorGerman;
    }

    /**
     * @param bool $colorGerman
     */
    public function setColorGerman(bool $colorGerman): void
    {
        $this->colorGerman = $colorGerman;
    }

    /**
     * @return bool|null
     */
    public function isStandartComplectationPolish():? bool
    {
        return $this->standartComplectationPolish;
    }

    /**
     * @param bool $standartComplectationPolish
     */
    public function setStandartComplectationPolish(bool $standartComplectationPolish): void
    {
        $this->standartComplectationPolish = $standartComplectationPolish;
    }

    /**
     * @return bool|null
     */
    public function isStandartComplectationGerman():? bool
    {
        return $this->standartComplectationGerman;
    }

    /**
     * @param bool $standartComplectationGerman
     */
    public function setStandartComplectationGerman(bool $standartComplectationGerman): void
    {
        $this->standartComplectationGerman = $standartComplectationGerman;
    }

    /**
     * @return bool|null
     */
    public function isComplectationPolish():? bool
    {
        return $this->complectationPolish;
    }

    /**
     * @param bool $complectationPolish
     */
    public function setComplectationPolish(bool $complectationPolish): void
    {
        $this->complectationPolish = $complectationPolish;
    }

    /**
     * @return bool|null
     */
    public function isComplectationGerman():? bool
    {
        return $this->complectationGerman;
    }

    /**
     * @param bool $complectationGerman
     */
    public function setComplectationGerman(bool $complectationGerman): void
    {
        $this->complectationGerman = $complectationGerman;
    }

    /**
     * @return bool|null
     */
    public function isCarRegistration():? bool
    {
        return $this->carRegistration;
    }

    /**
     * @param bool $carRegistration
     */
    public function setCarRegistration(bool $carRegistration): void
    {
        $this->carRegistration = $carRegistration;
    }

    /**
     * @return bool|null
     */
    public function isCarMileage():? bool
    {
        return $this->carMileage;
    }

    /**
     * @param bool $carMileage
     */
    public function setCarMileage(bool $carMileage): void
    {
        $this->carMileage = $carMileage;
    }

    /**
     * @return bool|null
     */
    public function isInitialVatPrice():? bool
    {
        return $this->initialVatPrice;
    }

    /**
     * @param bool $initialVatPrice
     */
    public function setInitialVatPrice(bool $initialVatPrice): void
    {
        $this->initialVatPrice = $initialVatPrice;
    }

    /**
     * @return bool|null
     */
    public function isInitialPriceWithOutVat():? bool
    {
        return $this->initialPriceWithOutVat;
    }

    /**
     * @param bool $initialPriceWithOutVat
     */
    public function setInitialPriceWithOutVat(bool $initialPriceWithOutVat): void
    {
        $this->initialPriceWithOutVat = $initialPriceWithOutVat;
    }

    /**
     * @return bool|null
     */
    public function isMinimumSellingPrice():? bool
    {
        return $this->minimumSellingPrice;
    }

    /**
     * @param bool $minimumSellingPrice
     */
    public function setMinimumSellingPrice(bool $minimumSellingPrice): void
    {
        $this->minimumSellingPrice = $minimumSellingPrice;
    }

    /**
     * @return bool|null
     */
    public function isPriceRoleFive():? bool
    {
        return $this->priceRoleFive;
    }

    /**
     * @param bool $priceRoleFive
     */
    public function setPriceRoleFive(bool $priceRoleFive): void
    {
        $this->priceRoleFive = $priceRoleFive;
    }

    /**
     * @return bool|null
     */
    public function isPriceRoleSix():? bool
    {
        return $this->priceRoleSix;
    }

    /**
     * @param bool $priceRoleSix
     */
    public function setPriceRoleSix(bool $priceRoleSix): void
    {
        $this->priceRoleSix = $priceRoleSix;
    }

    /**
     * @return bool|null
     */
    public function isPriceRoleSeven():? bool
    {
        return $this->priceRoleSeven;
    }

    /**
     * @param bool $priceRoleSeven
     */
    public function setPriceRoleSeven(bool $priceRoleSeven): void
    {
        $this->priceRoleSeven = $priceRoleSeven;
    }

    /**
     * @return bool|null
     */
    public function isPreisb2b():? bool
    {
        return $this->preisb2b;
    }

    /**
     * @param bool $preisb2b
     */
    public function setPreisb2b(bool $preisb2b): void
    {
        $this->preisb2b = $preisb2b;
    }

    /**
     * @return bool|null
     */
    public function isCompleted():? bool
    {
        return $this->completed;
    }

    /**
     * @param bool $completed
     */
    public function setCompleted(bool $completed): void
    {
        $this->completed = $completed;
    }

    /**
     * @return bool|null
     */
    public function isPaymentDate():? bool
    {
        return $this->paymentDate;
    }

    /**
     * @param bool $paymentDate
     */
    public function setPaymentDate(bool $paymentDate): void
    {
        $this->paymentDate = $paymentDate;
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
     */
    public function setPaid(bool $paid): void
    {
        $this->paid = $paid;
    }

    /**
     * @return bool|null
     */
    public function isDocuments():? bool
    {
        return $this->documents;
    }

    /**
     * @param bool $documents
     */
    public function setDocuments(bool $documents): void
    {
        $this->documents = $documents;
    }

    /**
     * @return bool|null
     */
    public function isDownloadDate():? bool
    {
        return $this->downloadDate;
    }

    /**
     * @param bool $downloadDate
     */
    public function setDownloadDate(bool $downloadDate): void
    {
        $this->downloadDate = $downloadDate;
    }

    /**
     * @return bool|null
     */
    public function isTargetUnload():? bool
    {
        return $this->targetUnload;
    }

    /**
     * @param bool $targetUnload
     */
    public function setTargetUnload(bool $targetUnload): void
    {
        $this->targetUnload = $targetUnload;
    }

    /**
     * @return bool|null
     */
    public function isLocation():? bool
    {
        return $this->location;
    }

    /**
     * @param bool $location
     */
    public function setLocation(bool $location): void
    {
        $this->location = $location;
    }

    /**
     * @return bool|null
     */
    public function isOrderNumber():? bool
    {
        return $this->orderNumber;
    }

    /**
     * @param bool $orderNumber
     */
    public function setOrderNumber(bool $orderNumber): void
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return bool|null
     */
    public function isRadioCode():? bool
    {
        return $this->radioCode;
    }

    /**
     * @param bool $radioCode
     */
    public function setRadioCode(bool $radioCode): void
    {
        $this->radioCode = $radioCode;
    }

    /**
     * @return bool|null
     */
    public function isInformation():? bool
    {
        return $this->information;
    }

    /**
     * @param bool $information
     */
    public function setInformation(bool $information): void
    {
        $this->information = $information;
    }

    /**
     * @return string|null
     */
    public function getIds():? string
    {
        return $this->ids;
    }

    /**
     * @param string|null $ids
     */
    public function setIds($ids): void
    {
        $this->ids = $ids;
    }

    /**
     * @return string|null
     */
    public function getLanguage():? string
    {
        return $this->language;
    }

    /**
     * @param string $language
     *
     * @return static
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isVendor():? bool
    {
        return $this->vendor;
    }

    /**
     * @param bool $vendor
     */
    public function setVendor(bool $vendor): void
    {
        $this->vendor = $vendor;
    }

    /**
     * @return bool|null
     */
    public function isCustomer():? bool
    {
        return $this->customer;
    }

    /**
     * @param bool $customer
     */
    public function setCustomer(bool $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return bool|null
     */
    public function isOurDiscountPrice():? bool
    {
        return $this->ourDiscountPrice;
    }

    /**
     * @param bool $ourDiscountPrice
     */
    public function setOurDiscountPrice(bool $ourDiscountPrice): void
    {
        $this->ourDiscountPrice = $ourDiscountPrice;
    }

    /**
     * @return bool|null
     */
    public function isInvoiceNumber():? bool
    {
        return $this->invoiceNumber;
    }

    /**
     * @param bool $invoiceNumber
     */
    public function setInvoiceNumber(bool $invoiceNumber): void
    {
        $this->invoiceNumber = $invoiceNumber;
    }

    /**
     * @return bool|null
     */
    public function isAddress1():? bool
    {
        return $this->address1;
    }

    /**
     * @param bool $address1
     */
    public function setAddress1(bool $address1): void
    {
        $this->address1 = $address1;
    }

    /**
     * @return bool|null
     */
    public function isUser():? bool
    {
        return $this->user;
    }

    /**
     * @param bool $user
     */
    public function setUser(bool $user): void
    {
        $this->user = $user;
    }

    /**
     * @return bool|null
     */
    public function isDiscount():? bool
    {
        return $this->discount;
    }

    /**
     * @param bool $discount
     */
    public function setDiscount(bool $discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return bool|null
     */
    public function isSalePriceWithOutVAT():? bool
    {
        return $this->salePriceWithOutVAT;
    }

    /**
     * @param bool $salePriceWithOutVAT
     */
    public function setSalePriceWithOutVAT(bool $salePriceWithOutVAT): void
    {
        $this->salePriceWithOutVAT = $salePriceWithOutVAT;
    }

    /**
     * @return bool|null
     */
    public function isPay4():? bool
    {
        return $this->pay4;
    }

    /**
     * @param bool $pay4
     */
    public function setPay4(bool $pay4): void
    {
        $this->pay4 = $pay4;
    }

    /**
     * @return bool|null
     */
    public function isEkNetto():? bool
    {
        return $this->ekNetto;
    }

    /**
     * @param bool $ekNetto
     */
    public function setEkNetto(bool $ekNetto): void
    {
        $this->ekNetto = $ekNetto;
    }

    /**
     * @return bool|null
     */
    public function isEkBrutto():? bool
    {
        return $this->ekBrutto;
    }

    /**
     * @param bool $ekBrutto
     */
    public function setEkBrutto(bool $ekBrutto): void
    {
        $this->ekBrutto = $ekBrutto;
    }

    /**
     * @return bool|null
     */
    public function isUst():? bool
    {
        return $this->ust;
    }

    /**
     * @param bool $ust
     */
    public function setUst(bool $ust): void
    {
        $this->ust = $ust;
    }

    /**
     * @return bool|null
     */
    public function isDatum():? bool
    {
        return $this->datum;
    }

    /**
     * @param bool $datum
     */
    public function setDatum(bool $datum): void
    {
        $this->datum = $datum;
    }

    /**
     * @return bool|null
     */
    public function isSeller():? bool
    {
        return $this->seller;
    }

    /**
     * @param bool $seller
     */
    public function setSeller(bool $seller): void
    {
        $this->seller = $seller;
    }

    /**
     * @return bool|null
     */
    public function isCarlineDate():? bool
    {
        return $this->carlineDate;
    }

    /**
     * @param bool $carlineDate
     */
    public function setCarlineDate(bool $carlineDate): void
    {
        $this->carlineDate = $carlineDate;
    }

    /**
     * @return bool|null
     */
    public function isCarlineNumber():? bool
    {
        return $this->carlineNumber;
    }

    /**
     * @param bool $carlineNumber
     */
    public function setCarlineNumber(bool $carlineNumber): void
    {
        $this->carlineNumber = $carlineNumber;
    }

    /**
     * @return bool|null
     */
    public function isGewinn():? bool
    {
        return $this->gewinn;
    }

    /**
     * @param bool $gewinn
     */
    public function setGewinn(bool $gewinn): void
    {
        $this->gewinn = $gewinn;
    }

    /**
     * @return bool|null
     */
    public function isAdditionalWork():? bool
    {
        return $this->additionalWork;
    }

    /**
     * @param bool $additionalWork
     */
    public function setAdditionalWork(bool $additionalWork): void
    {
        $this->additionalWork = $additionalWork;
    }

    /**
     * @return bool|null
     */
    public function isDate():? bool
    {
        return $this->date;
    }

    /**
     * @param bool $date
     */
    public function setDate(bool $date): void
    {
        $this->date = $date;
    }

    /**
     * @return bool|null
     */
    public function isAnkauf():? bool
    {
        return $this->ankauf;
    }

    /**
     * @param bool $ankauf
     */
    public function setAnkauf(bool $ankauf): void
    {
        $this->ankauf = $ankauf;
    }

    /**
     * @return bool|null
     */
    public function isZustand():? bool
    {
        return $this->zustand;
    }

    /**
     * @param bool $zustand
     */
    public function setZustand(bool $zustand): void
    {
        $this->zustand = $zustand;
    }

    /**
     * @return bool|null
     */
    public function isPreisTr():? bool
    {
        return $this->preisTr;
    }

    /**
     * @param bool $preisTr
     */
    public function setPreisTr(bool $preisTr): void
    {
        $this->preisTr = $preisTr;
    }

    /**
     * @return bool|null
     */
    public function isDatumPayFour():? bool
    {
        return $this->datumPayFour;
    }

    /**
     * @param bool $datumPayFour
     */
    public function setDatumPayFour(bool $datumPayFour): void
    {
        $this->datumPayFour = $datumPayFour;
    }

    /**
     * @return bool|null
     */
    public function isCompany():? bool
    {
        return $this->company;
    }

    /**
     * @param bool $company
     */
    public function setCompany(bool $company): void
    {
        $this->company = $company;
    }

    /**
     * @return bool|null
     */
    public function isRechnungsnr():? bool
    {
        return $this->rechnungsnr;
    }

    /**
     * @param bool $rechnungsnr
     */
    public function setRechnungsnr(bool $rechnungsnr): void
    {
        $this->rechnungsnr = $rechnungsnr;
    }

    /**
     * @return bool|null
     */
    public function isReDatum():? bool
    {
        return $this->reDatum;
    }

    /**
     * @param bool $reDatum
     */
    public function setReDatum(bool $reDatum): void
    {
        $this->reDatum = $reDatum;
    }

    /**
     * @return bool|null
     */
    public function isPaymentType():? bool
    {
        return $this->paymentType;
    }

    /**
     * @param bool $paymentType
     */
    public function setPaymentType(bool $paymentType): void
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @return bool|null
     */
    public function isVkNetto():? bool
    {
        return $this->vkNetto;
    }

    /**
     * @param bool $vkNetto
     */
    public function setVkNetto(bool $vkNetto): void
    {
        $this->vkNetto = $vkNetto;
    }

    /**
     * @return bool|null
     */
    public function isVkBrutto():? bool
    {
        return $this->vkBrutto;
    }

    /**
     * @param bool $vkBrutto
     */
    public function setVkBrutto(bool $vkBrutto): void
    {
        $this->vkBrutto = $vkBrutto;
    }

    /**
     * @return bool|null
     */
    public function isInfoStatistic():? bool
    {
        return $this->infoStatistic;
    }

    /**
     * @param bool $infoStatistic
     */
    public function setInfoStatistic(bool $infoStatistic): void
    {
        $this->infoStatistic = $infoStatistic;
    }

    /**
     * @return bool|null
     */
    public function isZahldatum():? bool
    {
        return $this->zahldatum;
    }

    /**
     * @param bool $zahldatum
     */
    public function setZahldatum(bool $zahldatum): void
    {
        $this->zahldatum = $zahldatum;
    }

    /**
     * @return bool|null
     */
    public function isStandtage():? bool
    {
        return $this->standtage;
    }

    /**
     * @param bool $standtage
     */
    public function setStandtage(bool $standtage): void
    {
        $this->standtage = $standtage;
    }

    /**
     * @return bool|null
     */
    public function isAddress3():? bool
    {
        return $this->address3;
    }

    /**
     * @param bool $address3
     */
    public function setAddress3(bool $address3): void
    {
        $this->address3 = $address3;
    }

    /**
     * @return bool|null
     */
    public function isZysk():? bool
    {
        return $this->zysk;
    }

    /**
     * @param bool $zysk
     */
    public function setZysk(bool $zysk): void
    {
        $this->zysk = $zysk;
    }
}