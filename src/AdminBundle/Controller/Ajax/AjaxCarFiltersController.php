<?php

namespace AdminBundle\Controller\Ajax;

use AdminBundle\Entity\Car;
use AdminBundle\Enum\CarStatusEnum;
use AdminBundle\Enum\UserRoleEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class AjaxCarFiltersController
 *
 * @Route("/car-filter-ajax")
 *
 * @package AdminBundle\Controller\Ajax
 */
class AjaxCarFiltersController extends Controller
{
    private const REFERENCES = ['vendor', 'place', 'customer', 'brand', 'model', 'targetUnload', 'forwarder', 'location', 'uploader', 'paymentType'];
    private const VERSION = ['versionPolish', 'versionGerman'];
    private const COLOR = ['colorPolish', 'colorGerman'];
    private const DATE = [
        'completed', 'paymentDate', 'downloadDate', 'invoiceDate', 'date', 'data1', 'createdAt',
        'datum', 'carlineDate', 'ankauf', 'datumPayFour', 'zahldatum', 'dataFv2', 'carInvoiceDate', 'proformaDate',
    ];
    private const BOOLEAN = ['paid', 'taxReturned', 'pay', 'paidSuccess', 'pay4'];

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * AjaxCarFiltersController constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function getCarFilterData(Request $request): JsonResponse
    {
        $filterName     = $request->request->get('filter');
        $filters        = $request->request->get('filters', []);
        $columnSearch   = $request->request->get('columnSearch', []);
        $searchValue    = $request->request->get('searchValue');
        $carStatus      = $request->request->get('carStatus', CarStatusEnum::SALE);

        $user           = $this->getUser();
        $selectAllCheck = false;
        if (isset($filters[$filterName])) {
            $filterValues   = $filters[$filterName];
            $selectAllCheck = in_array('selectAll', $filterValues);
            unset($filters[$filterName]);
        }

        $cars = $this->em->getRepository(Car::class)
            ->getCarsForFilters($searchValue, $user, $filters, $columnSearch, $carStatus);

        if (in_array($filterName, self::REFERENCES)) {
            $getter = $filterName === 'uploader' ? 'getFirstName' : 'getTitle';
            $data   = $this->getReferences($cars, $filterName, $getter);
        } elseif (in_array($filterName, self::VERSION)) {
            $data = $this->getVersion($cars, $filterName);
        } elseif (in_array($filterName, self::COLOR)) {
            $data = $this->getColor($cars, $filterName);
        } elseif (in_array($filterName, self::DATE)) {
            $data = $this->getDate($cars, $filterName);
        } elseif (in_array($filterName, self::BOOLEAN)) {
            $data = $this->getBoolean($cars, $filterName);
        } elseif ($filterName === 'carCondition') {
            $data = $this->getСarCondition($cars, $filterName);
        } elseif ($filterName === 'user') {
            $data = $this->getReferences($cars, $filterName, 'getAbbreviation');
        } elseif ($filterName === 'seller') {
            $data = $this->getReferences($cars, $filterName, 'getFullName');
        } elseif ($filterName === 'placeOfIssue') {
            $data = $this->getReferences($cars, 'location', 'getTitle');
        } else {
            $data = $this->getTextField($cars, $filterName);
        }

        if (!in_array($filterName, self::DATE)) {
            sort($data);
        }

        if ($selectAllCheck) {
            $data[] = 'selectAll';
        }

        return JsonResponse::create($data);
    }

    /**
     * @Route("/statistics")
     *
     * @param Request $request A Request instance.
     *
     * @return JsonResponse
     */
    public function getCarStatisticFilterData(Request $request): JsonResponse
    {
        $filterName     = $request->request->get('filter');
        $filters        = $request->request->get('filters', []);
        $searchValue    = $request->request->get('searchValue');

        $selectAllCheck = false;
        if (isset($filters[$filterName])) {
            $filterValues   = $filters[$filterName];
            $selectAllCheck = in_array('selectAll', $filterValues);
            unset($filters[$filterName]);
        }

        $cars = $this->em->getRepository(Car::class)
            ->getCarsForStatisticFilters($searchValue, $filters);

        if ($filterName === 'customer') {
            $data = $this->getStatisticCustomerData($cars);
        } elseif (in_array($filterName, self::REFERENCES)) {
            $getter = $filterName === 'uploader' ? 'getFirstName' : 'getTitle';
            $data   = $this->getReferences($cars, $filterName, $getter, true);
        } elseif (in_array($filterName, self::VERSION)) {
            $data = $this->getVersion($cars, $filterName);
        } elseif (in_array($filterName, self::COLOR)) {
            $data = $this->getColor($cars, $filterName);
        } elseif (in_array($filterName, self::DATE)) {
            $data = $this->getDate($cars, $filterName, true);
        } elseif (in_array($filterName, self::BOOLEAN)) {
            $data = $this->getBoolean($cars, $filterName, true);
        } elseif ($filterName === 'carCondition') {
            $data = $this->getСarCondition($cars, $filterName);
        } elseif ($filterName === 'user') {
            $data = $this->getReferences($cars, $filterName, 'getFirmNumber');
        } elseif ($filterName === 'seller') {
            $data = $this->getReferences($cars, $filterName, 'getFullName');
        } elseif ($filterName === 'placeOfIssue') {
            $data = $this->getReferences($cars, 'location', 'getTitle');
        } elseif ($filterName === 'zustand') {
            $result[] = 'Empty';
            foreach ($cars as $car) {
                $zustand = null;
                if ($car->getCarMileage() === null || $car->getCarMileage() === '') {
                    $zustand = 'Neu';
                } else {
                    $zustand = 'Gebraucht';
                }
                $result[] = $zustand;
            }
            $result = array_unique($result);
            $result = array_values($result);
            $data = $result;
        } else {
            $data = $this->getTextField($cars, $filterName);
        }

        if (!in_array($filterName, self::DATE)) {
            sort($data);
        }

        if ($selectAllCheck) {
            $data[] = 'selectAll';
        }

        return JsonResponse::create($data);
    }

    /**
     * @param array   $cars
     * @param string  $name
     * @param string  $entityGetter
     * @param boolean $statistic
     *
     * @return array
     */
    private function getReferences(array $cars, string $name, string $entityGetter, bool $statistic = false): array
    {
        $result = [];
        if (empty($cars)) {
            return $result;
        }

        $result[] = 'Empty';
        if ($name === 'model' && $statistic === false) {
            $result[] = 'Only blue';
        }

        $getter = 'get' . ucfirst($name);
        foreach ($cars as $car) {
            $entity = $car->$getter();
            if ($entity !== null) {
                $value = $entity->$entityGetter();
                if ($entityGetter === 'getAbbreviation' && $value === null) {
                    continue;
                }
                $result[] = $value;
            }
        }

        $result = array_unique($result);
        $result = array_values($result);
        return $result;
    }

    /**
     * @param array  $cars
     * @param string $name
     *
     * @return array
     */
    private function getVersion(array $cars, string $name): array
    {
        $result = [];
        if (empty($cars)) {
            return $result;
        }

        $result[] = 'Empty';
        $getter = 'get' . ucfirst($name);
        foreach ($cars as $car) {
            $entity = $car->$getter();
            $versionGetter = $name === 'versionPolish' ? 'getPolish' : 'getGerman';
            if ($entity !== null) {
                $result[] = $entity->$versionGetter();
            }
        }

        $result = array_unique($result);
        $result = array_values($result);
        return $result;
    }

    /**
     * @param array  $cars
     * @param string $name
     *
     * @return array
     */
    private function getColor(array $cars, string $name): array
    {
        $result = [];
        if (empty($cars)) {
            return $result;
        }

        $result[] = 'Empty';
        $getter = 'get' . ucfirst($name);
        foreach ($cars as $car) {
            $entity = $car->$getter();
            $colorGetter = $name === 'colorPolish' ? 'getPolish' : 'getGerman';
            if ($entity !== null) {
                $result[] = $entity->$colorGetter();
            }
        }

        $result = array_unique($result);
        $result = array_values($result);
        return $result;
    }

    /**
     * @param array   $cars
     * @param string  $name
     * @param boolean $statistic
     *
     * @return array
     */
    private function getDate(array $cars, string $name, bool $statistic = false): array
    {
        $result = [];
        if (empty($cars)) {
            return $result;
        }

        $getter = 'get' . ucfirst($name);
        $tempArray = [];
        foreach ($cars as $car) {
            $targetUnload = $car->getTargetUnload() === null ? null : $car->getTargetUnload()->getTitle();
            if ($targetUnload === 'x' && $name === 'downloadDate') {
                continue;
            }
            $valueResult = $car->$getter();
            if ($valueResult !== null) {
                $tempArray[] = $valueResult;
            }
        }
        sort($tempArray);

        $monthAndYear = ['completed', 'createdAt', 'datum', 'carlineDate', 'ankauf', 'datumPayFour', 'dataFv2'];
        if ($statistic) {
            $monthAndYear[] = 'paymentDate';
            $monthAndYear[] = 'carInvoiceDate';
            $monthAndYear[] = 'zahldatum';
        }
        foreach ($tempArray as $elem) {
            if (in_array($name, $monthAndYear)) {
                $result[] = $elem->format('m.Y');
            } else {
                $result[] = $elem->format('d.m.Y');
            }
        }

        $result[] = 'Empty';
        $result = array_unique($result);
        $result = array_values($result);

        return $result;
    }

    /**
     * @param array   $cars
     * @param string  $name
     * @param boolean $statistic
     *
     * @return array
     */
    private function getBoolean(array $cars, string $name, bool $statistic = false): array
    {
        $result = [];
        if (empty($cars)) {
            return $result;
        }

        if ($name === 'paid' && $statistic === false) {
            $result[] = 'Only blue';
        }

        $getter = 'is' . ucfirst($name);
        foreach ($cars as $car) {
            $valueResult = $car->$getter();
            $result[] = $valueResult === true ? 'true' : 'false';
        }
        $result = array_unique($result);
        $result = array_values($result);
        return $result;
    }

    /**
     * @param array  $cars
     * @param string $name
     *
     * @return array
     */
    private function getСarCondition(array $cars, string $name): array
    {
        $result = [];
        if (empty($cars)) {
            return $result;
        }

        $user = $this->getUser();
        $locale = $user->getLocale();

        $result[] = 'Empty';
        $getter = 'get' . ucfirst($name);
        foreach ($cars as $car) {
            $valueResult = $car->$getter();
            if ($valueResult !== null) {
                if ($locale === 'de' && $valueResult === 'sold') {
                    $result[] = 'VK';
                } elseif ($locale === 'de' && $valueResult === 'reservation') {
                    $result[] = 'R';
                } elseif ($locale === 'pl' && $valueResult === 'sold') {
                    $result[] = 'SP';
                } elseif ($locale === 'pl' && $valueResult === 'reservation') {
                    $result[] = 'R';
                }
            }
        }
        $result = array_unique($result);
        $result = array_values($result);
        return $result;
    }

    /**
     * @param array  $cars
     * @param string $name
     *
     * @return array
     */
    private function getTextField(array $cars, string $name): array
    {
        $result = [];
        if (empty($cars)) {
            return $result;
        }

        $getter = 'get' . ucfirst($name);
        foreach ($cars as $value) {
            $valueResult = $value->$getter();
            if ($valueResult !== null) {
                $result[] = $valueResult;
            }
        }
        $result[] = 'Empty';
        $result = array_unique($result);
        $result = array_values($result);
        return $result;
    }

    /**
     * @param array $cars
     *
     * @return array
     */
    private function getStatisticCustomerData(array $cars): array
    {
        $result = [];
        if (empty($cars)) {
            return $result;
        }

        $result[] = 'Empty';
        foreach ($cars as $car) {
            $value = $car->getCustomer() !== null ? $car->getCustomer()->getTitle() : null;
            if ($value !== 'LB' && $value !== 'CL' && $value !== 'I') {
                $value = $car->getVendor() !== null ? $car->getVendor()->getTitle() : null;
            }

            if ($value !== null) {
                $result[] = $value;
            }
        }

        $result = array_unique($result);
        $result = array_values($result);

        return $result;
    }
}