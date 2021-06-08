<?php

namespace AdminBundle\Repository;

use AdminBundle\Enum\CarStatusEnum;
use AdminBundle\Enum\UserRoleEnum;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class CarRepository
 *
 * @package AdminBundle\Repository
 */
class CarRepository extends EntityRepository
{
    private const JOINED_TABLE = [
        'vendor', 'place', 'customer', 'targetUnload', 'forwarder', 'location',
        'brand', 'model', 'placeOfIssue', 'buyer', 'versionPolish', 'versionGerman',
        'colorPolish', 'colorGerman', 'seller', 'user', 'uploader', 'paymentType'
    ];
    private const SEARCH_JOINED_TABLE = [
        'vendor', 'place', 'customer', 'targetUnload', 'forwarder', 'location', 'brand', 'model'
    ];

    private const TABLE_COLUMNS = [
        'carCondition', 'vinNumber',
        'complectationPolish', 'complectationGerman', 'carRegistration', 'carMileage',
        'discount', 'completed', 'invoiceNumber',
        'paymentDate', 'paid', 'pay', 'documents', 'downloadDate', 'shippingCost', 'transportInvoiceNumber', 'orderNumber',
        'radioCode', 'salesInvoiceNumber', 'information', 'discharge',
        'declaration', 'importTax', 'taxNumber','taxReturned', 'notes', 'fhnr', 'lastName'
    ];

    private const REFERENCES = ['vendor', 'place', 'customer', 'brand', 'model', 'targetUnload', 'forwarder', 'location', 'placeOfIssue', 'paymentType'];
    private const VERSION = ['versionPolish', 'versionGerman'];
    private const COLOR = ['colorPolish', 'colorGerman'];
    private const DATE = [
        'completed', 'paymentDate', 'downloadDate', 'invoiceDate', 'date', 'data1',
        'createdAt', 'datum', 'carlineDate', 'ankauf', 'datumPayFour', 'zahldatum', 'dataFv2', 'carInvoiceDate', 'proformaDate',
    ];
    private const BOOLEAN = ['paid', 'taxReturned', 'pay', 'paidSuccess', 'pay4'];

    private const STATISTICS_SEARCH_FIELDS = [
        'vinNumber', 'invoiceNumber', 'orderNumber', 'firma', 'lastName'
    ];

    /**
     * @param string      $start
     * @param string      $length
     * @param string      $columnSort
     * @param string      $sortType
     * @param string      $search
     * @param mixed       $user
     * @param string      $carStatus
     * @param array       $filters
     * @param array       $columnSearch
     * @param string|null $addedType
     *
     * @return array
     */
    public function getCars(
        string $start,
        string $length,
        string $columnSort,
        string $sortType,
        string $search,
               $user,
        string $carStatus,
        array  $filters = [],
        array  $columnSearch = [],
               $addedType = null
    ): array {
        $query = $this->createQueryBuilder('car');

        foreach (self::JOINED_TABLE as $table) {
            $query->leftJoin('car.' . $table, $table);
        }

        $userLocale = $user->getLocale();
        if ($carStatus === CarStatusEnum::SALE) {
            if ($userLocale === 'de') {
                $query->andWhere('car.addedToArchiveDe IS NULL');
            } elseif ($userLocale === 'pl') {
                $query->andWhere('car.addedToArchivePl IS NULL');
            }
        } elseif ($carStatus === CarStatusEnum::ARCHIVE) {
            if ($addedType === 'de') {
                $query
                    ->andWhere('car.addedToArchiveDe IS NOT NULL');
            } elseif ($addedType === 'pl') {
                $query
                    ->andWhere('car.addedToArchivePl IS NOT NULL');
            }
            $query->andWhere('car.addedToArchive IS NOT NULL');

            $userRole = $user->getRole();
            if ($userRole === UserRoleEnum::ROLE_ADMIN_14) {
                $query->andWhere('seller.role = :userRole14');
                $query->setParameter('userRole14', UserRoleEnum::ROLE_ADMIN_14);
            }
        }

        if ($search !== '') {
            $expr         = $this->_em->getExpressionBuilder();
            $condition    = $expr->andX();

            $main         = $expr->orX();
            $joinedTable  = $expr->orX();
            $buyer        = $expr->orX();
            $tableColumns = $expr->orX();

            foreach (self::SEARCH_JOINED_TABLE as $table) {
                $joinedTable->add($expr->like($table . '.title', ':search'));
            }
            $buyer->add($expr->like('user.firmNumber', ':search'));
            $buyer->add($expr->like('car.firma', ':search'));

            $buyer->add($expr->like('versionPolish.polish', ':search'));
            $buyer->add($expr->like('versionGerman.german', ':search'));

            $buyer->add($expr->like('colorPolish.polish', ':search'));
            $buyer->add($expr->like('colorGerman.german', ':search'));

            foreach (self::TABLE_COLUMNS as $column) {
                $tableColumns->add($expr->like('car.' . $column, ':search'));
            }
            $tableColumns->add(
                $expr->like(
                    $expr->concat(
                        'model.title',
                        $expr->concat(
                            $expr->literal(' '),
                            'versionGerman.german')
                    ),
                    ':search')
            );
            $tableColumns->add(
                $expr->like(
                    $expr->concat(
                        'model.title',
                        $expr->concat(
                            $expr->literal(' '),
                            'versionPolish.polish')
                    ),
                    ':search')
            );

            $main
                ->add($joinedTable)
                ->add($buyer)
                ->add($tableColumns);
            $condition->add($main);
            $query
                ->setParameter('search', '%' . trim($search) . '%')
                ->andWhere($condition);
        }

        // COLUMN SEARCH
        foreach ($columnSearch as $name => $data) {
            if ($data !== '') {
                $query
                    ->andWhere('car.'.$name.' LIKE :columnSearch'.$name)
                    ->setParameter('columnSearch'.$name, '%'.$data.'%');
            }
        }
        // -------------

        // FILTERS --------------------------------------------------------
        foreach ($filters as $name => $filter) {
            if ($selectAllKey = array_search('selectAll', $filter)) {
                unset($filter[$selectAllKey]);
                $filter = array_values($filter);
            }
            if (in_array($name, self::REFERENCES)) {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name . '.title'));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }
                if ($name === 'model' && in_array('Only blue', $filter)) {
                    $orX->add($expr->isNotNull('car.carCreatedAt'));
                    $emptyKey = array_search('Only blue', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in($name . '.title', ':'.$name.'Value'));
                $query->setParameter($name.'Value', $filter);

                $query->andWhere($orX);
            } elseif ($name === 'carCondition') {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                $resultArray = [];
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull('car.'.$name));
                    $emptyKey = array_search('Empty', $filter);
                    $resultArray[] = '';
                    unset($filter[$emptyKey]);
                }

                if (in_array('R', $filter)) {
                    $resultArray[] = 'reservation';
                }
                if (in_array('VK', $filter)) {
                    $resultArray[] = 'sold';
                }
                if (in_array('R', $filter)) {
                    $resultArray[] = 'reservation';
                }
                if (in_array('SP', $filter)) {
                    $resultArray[] = 'sold';
                }
                $resultArray = array_unique($resultArray);

                $orX->add($expr->in('car.carCondition', ':carCondition'));
                $query->setParameter('carCondition', $resultArray);

                $query->andWhere($orX);
            } elseif (in_array($name, self::VERSION)) {
                if ($name === 'versionPolish') {
                    $type = 'polish';
                } else {
                    $type = 'german';
                }
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name.'.'.$type));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                foreach ($filter as $key => $value) {
                    $orX->add($expr->eq($name.'.'.$type, ':'.$name.$key));
                    $query->setParameter($name.$key, $value);
                }
                $query->andWhere($orX);
            } elseif (in_array($name, self::COLOR)) {
                if ($name === 'colorPolish') {
                    $type = 'polish';
                } else {
                    $type = 'german';
                }
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name.'.'.$type));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                foreach ($filter as $key => $value) {
                    $orX->add($expr->eq($name.'.'.$type, ':'.$name.$key));
                    $query->setParameter($name.$key, $value);
                }
                $query->andWhere($orX);
            } elseif (in_array($name, self::DATE)) {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();

                if (in_array('selectAll', $filter)) {
                    $emptyKey = array_search('selectAll', $filter);
                    unset($filter[$emptyKey]);
                }

                foreach ($filter as $key => $value) {
                    try {
                        if ($value === 'Empty') {
                            $orX->add($expr->isNull('car.'.$name));
                        } else {
                            if (
                                $name === 'completed' || $name === 'createdAt' || $name === 'datum'
                                || $name === 'carlineDate' || $name === 'ankauf' || $name === 'dataFv2'
                            ) {
                                $month          = date('n', strtotime('01.'.$value));
                                $countMonthDays = date('t', mktime(0, 0, 0, $month));
                                $andX           = $expr->andX();
                                $startDate      = new \DateTime('01.'.$value);
                                $endDate        = new \DateTime($countMonthDays.'.'.$value);
                                $andX->add($expr->gte('car.'.$name, ':'.$name.'start'.$key));
                                $andX->add($expr->lte('car.'.$name, ':'.$name.'end'.$key));
                                $query->setParameter($name.'start'.$key, $startDate);
                                $query->setParameter($name.'end'.$key, $endDate);
                                $orX->add($andX);
                            } else {
                                $orX->add($expr->eq('car.'.$name, ':'.$name.$key));
                                $query->setParameter($name.$key, new \DateTime($value));
                            }
                        }
                    } catch (\Throwable $exception) {}
                }
                $query->andWhere($orX);
            } elseif (in_array($name, self::BOOLEAN)) {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                $resultArray = [];
                foreach ($filter as $value) {
                    if ($value === 'true') {
                        $resultArray[] = true;
                    } elseif ($value === 'false') {
                        $resultArray[] = false;
                    } elseif ($value === 'Only blue') {
                        $orX->add($expr->isNotNull('car.paidClick'));
                    }
                }
                $orX->add($expr->in('car.'.$name, ':'.$name.'Value'));
                $query->setParameter($name.'Value', $resultArray);
                $query->andWhere($orX);
            } elseif ($name === 'user') {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull('user.abbreviation'));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in('user.abbreviation', ':'.$name.'Value'));
                $query->setParameter($name.'Value', $filter);
                $query->andWhere($orX);
            } elseif ($name === 'seller') {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($expr->concat(
                        $name.'.firstName',
                        $expr->concat(
                            $expr->literal(' '),
                            $name.'.lastName')
                    )));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }
                foreach ($filter as $key => $value) {
                    $value = trim($value);
                    $orX->add(
                        $expr->like(
                            $expr->concat(
                                $name.'.firstName',
                                $expr->concat(
                                    $expr->literal(' '),
                                    $name.'.lastName')
                            ),
                            ':'.$name.$key)
                    );
                    $orX->add($name.'.firstName = :first'.$name.$key);
                    $orX->add($name.'.lastName = :last'.$name.$key);
                    $query->setParameter($name.$key, $value);
                    $query->setParameter('first'.$name.$key, $value);
                    $query->setParameter('last'.$name.$key, $value);
                }
                $query->andWhere($orX);
            } elseif ($name === 'uploader') {
                $expr = $this->_em->getExpressionBuilder();
                $orX  = $expr->orX();

                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name . '.firstName'));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in($name . '.firstName', ':'.$name.'Value'));
                $query->setParameter($name.'Value', $filter);

                $query->andWhere($orX);
            } else {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull('car.'.$name));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in('car.'.$name, ':'.$name.'Value'));
                $query->setParameter($name.'Value', $filter);

                $query->andWhere($orX);
            }
        }
        // END FILTERS -----------------------------------------------------

        if ($userLocale === 'pl') {
            $query->andWhere('car.carVisibility = false');
        }

        if ($columnSort === 'client') {
            $columnSort = 'lastName';
        } elseif ($columnSort === 'polishComplectation') {
            $columnSort = 'standartComplectationPolish';
        } elseif ($columnSort === 'germanComplectation') {
            $columnSort = 'standartComplectationGerman';
        }
        $query
            ->orderBy('car.' . $columnSort, $sortType)
            ->setFirstResult($start)
            ->setMaxResults($length);

        $paginator = new Paginator($query);

        return [
            $paginator->count(),
            $paginator->getQuery()->getResult(),
        ];
    }

    /**
     * @param string $search
     * @param mixed  $user
     * @param array  $filters
     * @param array  $columnSearch
     * @param string $carStatus
     *
     * @return array
     */
    public function getCarsForFilters(
        string $search,
               $user,
        array  $filters = [],
        array  $columnSearch = [],
        string $carStatus
    ): array {
        $query = $this->createQueryBuilder('car');

        foreach (self::JOINED_TABLE as $table) {
            $query->leftJoin('car.' . $table, $table);
        }

        $userLocale = $user->getLocale();
        if ($carStatus === CarStatusEnum::SALE) {
            if ($userLocale === 'de') {
                $query->andWhere('car.addedToArchiveDe IS NULL');
            } elseif ($userLocale === 'pl') {
                $query->andWhere('car.addedToArchivePl IS NULL');
            }
        } elseif ($carStatus === CarStatusEnum::ARCHIVE) {
            if ($userLocale === 'de') {
                $query
                    ->andWhere('car.addedToArchiveDe IS NOT NULL');
            } elseif ($userLocale === 'pl') {
                $query
                    ->andWhere('car.addedToArchivePl IS NOT NULL');
            }
            $query->andWhere('car.addedToArchive IS NOT NULL');

            $userRole = $user->getRole();
            if ($userRole === UserRoleEnum::ROLE_ADMIN_14) {
                $query->andWhere('seller.role = :userRole14');
                $query->setParameter('userRole14', UserRoleEnum::ROLE_ADMIN_14);
            }
        }

        if ($search !== '') {
            $expr         = $this->_em->getExpressionBuilder();
            $condition    = $expr->andX();

            $main         = $expr->orX();
            $joinedTable  = $expr->orX();
            $buyer        = $expr->orX();
            $tableColumns = $expr->orX();

            foreach (self::SEARCH_JOINED_TABLE as $table) {
                $joinedTable->add($expr->like($table . '.title', ':search'));
            }
            $buyer->add($expr->like('user.firmNumber', ':search'));
            $buyer->add($expr->like('car.firma', ':search'));

            $buyer->add($expr->like('versionPolish.polish', ':search'));
            $buyer->add($expr->like('versionGerman.german', ':search'));

            $buyer->add($expr->like('colorPolish.polish', ':search'));
            $buyer->add($expr->like('colorGerman.german', ':search'));

            foreach (self::TABLE_COLUMNS as $column) {
                $tableColumns->add($expr->like('car.' . $column, ':search'));
            }
            $tableColumns->add(
                $expr->like(
                    $expr->concat(
                        'model.title',
                        $expr->concat(
                            $expr->literal(' '),
                            'versionGerman.german')
                    ),
                    ':search')
            );
            $tableColumns->add(
                $expr->like(
                    $expr->concat(
                        'model.title',
                        $expr->concat(
                            $expr->literal(' '),
                            'versionPolish.polish')
                    ),
                    ':search')
            );

            $main
                ->add($joinedTable)
                ->add($buyer)
                ->add($tableColumns);
            $condition->add($main);
            $query
                ->setParameter('search', '%' . trim($search) . '%')
                ->andWhere($condition);
        }

        // COLUMN SEARCH
        foreach ($columnSearch as $name => $data) {
            if ($data !== '') {
                $query
                    ->andWhere('car.'.$name.' LIKE :columnSearch'.$name)
                    ->setParameter('columnSearch'.$name, '%'.$data.'%');
            }
        }
        // -------------

        // FILTERS --------------------------------------------------------
        foreach ($filters as $name => $filter) {
            if ($selectAllKey = array_search('selectAll', $filter)) {
                unset($filter[$selectAllKey]);
                $filter = array_values($filter);
            }
            if (in_array($name, self::REFERENCES)) {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name . '.title'));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }
                if ($name === 'model' && in_array('Only blue', $filter)) {
                    $orX->add($expr->isNotNull('car.carCreatedAt'));
                    $emptyKey = array_search('Only blue', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in($name . '.title', ':'.$name.'Value'));
                $query->setParameter($name.'Value', $filter);

                $query->andWhere($orX);
            } elseif ($name === 'carCondition') {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                $resultArray = [];
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull('car.'.$name));
                    $emptyKey = array_search('Empty', $filter);
                    $resultArray[] = '';
                    unset($filter[$emptyKey]);
                }

                if (in_array('R', $filter)) {
                    $resultArray[] = 'reservation';
                }
                if (in_array('VK', $filter)) {
                    $resultArray[] = 'sold';
                }
                if (in_array('R', $filter)) {
                    $resultArray[] = 'reservation';
                }
                if (in_array('SP', $filter)) {
                    $resultArray[] = 'sold';
                }
                $resultArray = array_unique($resultArray);

                $orX->add($expr->in('car.carCondition', ':carCondition'));
                $query->setParameter('carCondition', $resultArray);

                $query->andWhere($orX);
            } elseif (in_array($name, self::VERSION)) {
                if ($name === 'versionPolish') {
                    $type = 'polish';
                } else {
                    $type = 'german';
                }
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name.'.'.$type));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                foreach ($filter as $key => $value) {
                    $orX->add($expr->eq($name.'.'.$type, ':'.$name.$key));
                    $query->setParameter($name.$key, $value);
                }
                $query->andWhere($orX);
            } elseif (in_array($name, self::COLOR)) {
                if ($name === 'colorPolish') {
                    $type = 'polish';
                } else {
                    $type = 'german';
                }
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name.'.'.$type));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                foreach ($filter as $key => $value) {
                    $orX->add($expr->eq($name.'.'.$type, ':'.$name.$key));
                    $query->setParameter($name.$key, $value);
                }
                $query->andWhere($orX);
            } elseif (in_array($name, self::DATE)) {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                foreach ($filter as $key => $value) {
                    try {
                        if ($value === 'Empty') {
                            $orX->add($expr->isNull('car.'.$name));
                        } else {
                            if (
                                $name === 'completed' || $name === 'createdAt' || $name === 'datum'
                                || $name === 'carlineDate' || $name === 'ankauf' || $name === 'dataFv2'
                            ) {
                                $month          = date('n', strtotime('01.'.$value));
                                $countMonthDays = date('t', mktime(0, 0, 0, $month));
                                $andX           = $expr->andX();
                                $startDate      = new \DateTime('01.'.$value);
                                $endDate        = new \DateTime($countMonthDays.'.'.$value);
                                $andX->add($expr->gte('car.'.$name, ':'.$name.'start'.$key));
                                $andX->add($expr->lte('car.'.$name, ':'.$name.'end'.$key));
                                $query->setParameter($name.'start'.$key, $startDate);
                                $query->setParameter($name.'end'.$key, $endDate);
                                $orX->add($andX);
                            } else {
                                $orX->add($expr->eq('car.'.$name, ':'.$name.$key));
                                $query->setParameter($name.$key, new \DateTime($value));
                            }
                        }
                    } catch (\Throwable $exception) {}
                }
                $query->andWhere($orX);
            } elseif (in_array($name, self::BOOLEAN)) {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                $resultArray = [];
                foreach ($filter as $value) {
                    if ($value === 'true') {
                        $resultArray[] = true;
                    } elseif ($value === 'false') {
                        $resultArray[] = false;
                    } elseif ($value === 'Only blue') {
                        $orX->add($expr->isNotNull('car.paidClick'));
                    }
                }
                $orX->add($expr->in('car.'.$name, ':'.$name.'Value'));
                $query->setParameter($name.'Value', $resultArray);
                $query->andWhere($orX);
            } elseif ($name === 'user') {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull('user.abbreviation'));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in('user.abbreviation', ':'.$name.'Value'));
                $query->setParameter($name.'Value', $filter);
                $query->andWhere($orX);
            } elseif ($name === 'seller') {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($expr->concat(
                        $name.'.firstName',
                        $expr->concat(
                            $expr->literal(' '),
                            $name.'.lastName')
                    )));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }
                foreach ($filter as $key => $value) {
                    $value = trim($value);
                    $orX->add(
                        $expr->like(
                            $expr->concat(
                                $name.'.firstName',
                                $expr->concat(
                                    $expr->literal(' '),
                                    $name.'.lastName')
                            ),
                            ':'.$name.$key)
                    );
                    $orX->add($name.'.firstName = :first'.$name.$key);
                    $orX->add($name.'.lastName = :last'.$name.$key);
                    $query->setParameter($name.$key, $value);
                    $query->setParameter('first'.$name.$key, $value);
                    $query->setParameter('last'.$name.$key, $value);
                }
                $query->andWhere($orX);
            } elseif ($name === 'uploader') {
                $expr = $this->_em->getExpressionBuilder();
                $orX  = $expr->orX();

                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name . '.firstName'));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in($name . '.firstName', ':'.$name.'Value'));
                $query->setParameter($name.'Value', $filter);

                $query->andWhere($orX);
            } else {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull('car.'.$name));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in('car.'.$name, ':'.$name.'Value'));
                $query->setParameter($name.'Value', $filter);

                $query->andWhere($orX);
            }
        }
        // END FILTERS -----------------------------------------------------

        if ($userLocale === 'pl') {
            $query->andWhere('car.carVisibility = false');
        }

        return $query->getQuery()->getResult();
    }

    /**
     * @return array
     */
    public function getCarWithEditDate(): array
    {
        $date = (new \DateTime())->modify('-10 min');
        return $this->createQueryBuilder('car')
            ->where('car.editDate is not NULL')
            ->andWhere('car.editDate < :date')
            ->setParameter('date', $date)
            ->getQuery()->getResult();
    }

    /**
     * @param string $carId
     * @param string $vinNumber
     *
     * @return array
     */
    public function checkVinNumber(string $carId, string $vinNumber): array
    {
        return $this->createQueryBuilder('car')
            ->where('car.id != :carId')
            ->andWhere('car.vinNumber = :vinNumber')
            ->andWhere('car.addedToArchiveDe IS NULL')
            ->setParameter('carId', $carId)
            ->setParameter('vinNumber', $vinNumber)
            ->getQuery()->getResult();
    }

    /**
     * @return array
     */
    public function carsWithClickDate(): array
    {
        return $this->createQueryBuilder('car')
            ->where('car.paidClick IS NOT NULL')
            ->getQuery()->getResult();
    }

    /**
     * @return array
     */
    public function carsWithCreatedAt(): array
    {
        return $this->createQueryBuilder('car')
            ->where('car.carCreatedAt IS NOT NULL')
            ->getQuery()->getResult();
    }

    /**
     * @param string $start
     * @param string $length
     * @param string $columnSort
     * @param string $sortType
     * @param string $search
     * @param array  $filters
     *
     * @return array
     */
    public function getHomepageCars(
        string $start,
        string $length,
        string $columnSort,
        string $sortType = '',
        string $search,
        array $filters = []
    ): array {
        $expr = $this->_em->getExpressionBuilder();
        $condition = $expr->andX();
        $main = $expr->orX();

        $query = $this->createQueryBuilder('car')
            ->andWhere('car.addedToArchiveDe IS NULL')
            ->andWhere('car.addedToArchivePl IS NULL')
            ->andWhere('car.status = :sale')
            ->setParameter('sale', 'sale');

        $main
            ->add($expr->isNull('car.carCondition'))
            ->add($expr->eq('car.carCondition', ':empty'));

        $condition->add($main);
        $query
            ->andWhere($condition)
            ->setParameter('empty', '');

        $query
            ->leftJoin('car.brand', 'brand')
            ->leftJoin('car.model', 'model')
            ->leftJoin('car.versionGerman', 'versionGerman')
            ->leftJoin('car.colorGerman', 'colorGerman');

        if ($search !== '') {
            $searchCondition = $expr->andX();
            $searchOrx = $expr->orX();

            $searchOrx
                ->add($expr->like('brand.title', ':search'))
                ->add($expr->like('model.title', ':search'))
                ->add($expr->like('versionGerman.german', ':search'))
                ->add($expr->like('colorGerman.german', ':search'))
                ->add($expr->like('car.vinNumber', ':search'));

            $searchCondition->add($searchOrx);
            $query
                ->setParameter('search', '%' . trim($search) . '%')
                ->andWhere($searchCondition);
        }

        foreach ($filters as $name => $filter) {
            if ($name === 'brand') {
                $orX = $expr->orX();
                $orX->add($expr->in('brand.title', ':brandValue'));
                $query->setParameter('brandValue', $filter);
                $query->andWhere($orX);
            } elseif ($name === 'model') {
                $orX = $expr->orX();
                $orX->add($expr->in('model.title', ':modelValue'));
                $query->setParameter('modelValue', $filter);
                $query->andWhere($orX);
            } elseif ($name === 'versionGerman') {
                $orX = $expr->orX();
                $orX->add($expr->in('versionGerman.german', ':versionValue'));
                $query->setParameter('versionValue', $filter);
                $query->andWhere($orX);
            } elseif ($name === 'colorGerman') {
                $orX = $expr->orX();
                $orX->add($expr->in('colorGerman.german', ':colorValue'));
                $query->setParameter('colorValue', $filter);
                $query->andWhere($orX);
            }
        }

        if ($columnSort !== 'minimumSellingPrice') {
            if ($columnSort === '') {
                $columnSort = 'completed';
            }
            if ($sortType === '') {
                $sortType = 'asc';
            }
            $query
                ->orderBy('car.' . $columnSort, $sortType)
                ->setFirstResult($start)
                ->setMaxResults($length);
        }

        $paginator = new Paginator($query);

        return [
            $paginator->count(),
            $paginator->getQuery()->getResult(),
        ];
    }

    /**
     * @return array
     */
    public function getCarsWithBuyer(): array
    {
        return $this->createQueryBuilder('car')
            ->where('car.buyer is not null')
            ->getQuery()->getResult();
    }

    /**
     * @param string      $search
     * @param array       $filters
     *
     * @return array
     */
    public function getHomepageCarsForFilters(
        string $search,
        array $filters = []
    ): array {
        $expr = $this->_em->getExpressionBuilder();
        $condition = $expr->andX();
        $main = $expr->orX();

        $query = $this->createQueryBuilder('car')
            ->andWhere('car.addedToArchiveDe IS NULL')
            ->andWhere('car.addedToArchivePl IS NULL')
            ->andWhere('car.status = :sale')
            ->setParameter('sale', 'sale');

        $main
            ->add($expr->isNull('car.carCondition'))
            ->add($expr->eq('car.carCondition', ':empty'));

        $condition->add($main);
        $query
            ->andWhere($condition)
            ->setParameter('empty', '');

        $query
            ->leftJoin('car.brand', 'brand')
            ->leftJoin('car.model', 'model')
            ->leftJoin('car.versionGerman', 'versionGerman')
            ->leftJoin('car.colorGerman', 'colorGerman');

        if ($search !== '') {
            $searchCondition = $expr->andX();
            $searchOrx = $expr->orX();

            $searchOrx
                ->add($expr->like('brand.title', ':search'))
                ->add($expr->like('model.title', ':search'))
                ->add($expr->like('versionGerman.german', ':search'))
                ->add($expr->like('colorGerman.german', ':search'))
                ->add($expr->like('car.vinNumber', ':search'));

            $searchCondition->add($searchOrx);
            $query
                ->setParameter('search', '%' . trim($search) . '%')
                ->andWhere($searchCondition);
        }

        foreach ($filters as $name => $filter) {
            if ($name === 'brand') {
                $orX = $expr->orX();
                $orX->add($expr->in('brand.title', ':brandValue'));
                $query->setParameter('brandValue', $filter);
                $query->andWhere($orX);
            } elseif ($name === 'model') {
                $orX = $expr->orX();
                $orX->add($expr->in('model.title', ':modelValue'));
                $query->setParameter('modelValue', $filter);
                $query->andWhere($orX);
            } elseif ($name === 'versionPolish') {
                $orX = $expr->orX();
                $orX->add($expr->in('versionGerman.german', ':versionValue'));
                $query->setParameter('versionValue', $filter);
                $query->andWhere($orX);
            } elseif ($name === 'colorGerman') {
                $orX = $expr->orX();
                $orX->add($expr->in('colorGerman.german', ':colorValue'));
                $query->setParameter('colorValue', $filter);
                $query->andWhere($orX);
            }
        }

        return $query->getQuery()->getResult();
    }

    /**
     * @param string $start
     * @param string $length
     * @param string $userId
     *
     * @return array
     */
    public function getUserCars(
        string $start,
        string $length,
        string $userId
    ): array {
        $query = $this->createQueryBuilder('car')
            ->where('car.user = :userId')
            ->setParameter('userId', $userId);

        $query
            ->setFirstResult($start)
            ->setMaxResults($length);

        $paginator = new Paginator($query);

        return [
            $paginator->count(),
            $paginator->getQuery()->getResult(),
        ];
    }

    /**
     * @return array
     */
    public function getDuplicates(): array {
        $query = "
            select vin_number 
            as vin_number 
            from car 
            group by vin_number 
            having count(*) > 1;
        ";

        $stmt = $this->_em->getConnection()->executeQuery($query);

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * @return array
     */
    public function getInvoiceNumbers(): array {
        return $this->createQueryBuilder('car')
            ->select('car.carInvoiceNumber, car.carInvoiceNumberYear')
            ->where('car.carInvoiceNumber is not null')
            ->andWhere('car.carInvoiceNumberYear is not null')
            ->getQuery()->getResult();
    }

    /**
     * @return int|mixed|string
     */
    public function findMaxDischarge()
    {
        $query = "
            select ifnull(max(CONVERT(discharge, SIGNED INTEGER)), 0) from car where discharge REGEXP '^[0-9]+$';
        ";

        $stmt = $this->_em->getConnection()->executeQuery($query);

        return $stmt->fetchColumn();
    }

    /**
     * @return int|mixed|string
     */
    public function findMaxCarlinenumber()
    {
        return $this->createQueryBuilder('car')
            ->select('MAX(car.carlineNumber)')
            ->getQuery()->getSingleScalarResult();
    }

    /**
     * @param integer $currentYear
     *
     * @return int|mixed|string
     */
    public function findMaxInvoiceNumber(int $currentYear)
    {
        return $this->createQueryBuilder('car')
            ->select('MAX(car.carInvoiceNumber)')
            ->where('car.carInvoiceNumberYear = :invoiceYear')
            ->setParameter('invoiceYear', $currentYear)
            ->getQuery()->getSingleScalarResult();
    }

    /**
     * @return int|mixed|string
     */
    public function findMaxProformaNumber()
    {
        return $this->createQueryBuilder('car')
            ->select('MAX(car.proformaNumber)')
            ->getQuery()->getSingleScalarResult();
    }

    /**
     * @return mixed
     */
    public function getCarFirmNames()
    {
        return $this->createQueryBuilder('car')
            ->select('car.id, car.firma, car.firstName, car.lastName, car.street, car.city, car.placeIndex, car.firmNumber, car.email, car.phoneNumber, car.mobileNumber, car.fax')
            ->where('car.firma is not null')
            ->getQuery()->getResult();
    }

    /**
     * @param string $start
     * @param string $length
     * @param string $columnSort
     * @param string $sortType
     * @param string $search
     * @param array  $filters
     *
     * @return array
     */
    public function getCarsForStatistics(
        string $start,
        string $length,
        string $columnSort,
        string $sortType,
        string $search,
        array $filters = []
    ): array {
        $query = $this->createQueryBuilder('car');

        foreach (self::JOINED_TABLE as $table) {
            $query->leftJoin('car.' . $table, $table);
        }

        $query
            ->andWhere('user.firmNumber = :selectCarpoint')
            ->setParameter('selectCarpoint', 'Carpoint GmbH');

        if ($search !== '') {
            $expr      = $this->_em->getExpressionBuilder();
            $condition = $expr->orX();

            foreach (self::STATISTICS_SEARCH_FIELDS as $column) {
                $condition->add($expr->like('car.' . $column, ':search'));
            }

            $query
                ->setParameter('search', '%'.trim($search).'%')
                ->andWhere($condition);
        }

        // FILTERS --------------------------------------------------------
        foreach ($filters as $name => $filter) {
            if ($selectAllKey = array_search('selectAll', $filter)) {
                unset($filter[$selectAllKey]);
                $filter = array_values($filter);
            }

            if ($name === 'customer') {
                $expr = $this->_em->getExpressionBuilder();
                $orX  = $expr->orX();

                if (in_array('Empty', $filter)) {
                    $andX = $expr->andX();
                    $andX->add($expr->isNull('car.customer'));
                    $andX->add($expr->isNull('car.vendor'));

                    $orX->add($andX);
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in('customer.title', ':customerStatisticValue'));
                $orX->add($expr->in('vendor.title', ':vendorStatisticValue'));
                $query->setParameter('customerStatisticValue', $filter);
                $query->setParameter('vendorStatisticValue', $filter);

                $query->andWhere($orX);
            } elseif (in_array($name, self::REFERENCES)) {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name . '.title'));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }
                if ($name === 'model' && in_array('Only blue', $filter)) {
                    $orX->add($expr->isNotNull('car.carCreatedAt'));
                    $emptyKey = array_search('Only blue', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in($name . '.title', ':'.$name.'Value'));
                $query->setParameter($name.'Value', $filter);

                $query->andWhere($orX);
            } elseif ($name === 'carCondition') {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                $resultArray = [];
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull('car.'.$name));
                    $emptyKey = array_search('Empty', $filter);
                    $resultArray[] = '';
                    unset($filter[$emptyKey]);
                }

                if (in_array('R', $filter)) {
                    $resultArray[] = 'reservation';
                }
                if (in_array('VK', $filter)) {
                    $resultArray[] = 'sold';
                }
                if (in_array('R', $filter)) {
                    $resultArray[] = 'reservation';
                }
                if (in_array('SP', $filter)) {
                    $resultArray[] = 'sold';
                }
                $resultArray = array_unique($resultArray);

                $orX->add($expr->in('car.carCondition', ':carCondition'));
                $query->setParameter('carCondition', $resultArray);

                $query->andWhere($orX);
            } elseif (in_array($name, self::VERSION)) {
                if ($name === 'versionPolish') {
                    $type = 'polish';
                } else {
                    $type = 'german';
                }
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name.'.'.$type));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                foreach ($filter as $key => $value) {
                    $orX->add($expr->eq($name.'.'.$type, ':'.$name.$key));
                    $query->setParameter($name.$key, $value);
                }
                $query->andWhere($orX);
            } elseif (in_array($name, self::COLOR)) {
                if ($name === 'colorPolish') {
                    $type = 'polish';
                } else {
                    $type = 'german';
                }
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name.'.'.$type));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                foreach ($filter as $key => $value) {
                    $orX->add($expr->eq($name.'.'.$type, ':'.$name.$key));
                    $query->setParameter($name.$key, $value);
                }
                $query->andWhere($orX);
            } elseif (in_array($name, self::DATE)) {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();

                if (in_array('selectAll', $filter)) {
                    $emptyKey = array_search('selectAll', $filter);
                    unset($filter[$emptyKey]);
                }

                foreach ($filter as $key => $value) {
                    try {
                        if ($value === 'Empty') {
                            $orX->add($expr->isNull('car.'.$name));
                        } else {
                            if (
                                in_array($name, [
                                    'completed', 'createdAt', 'datum', 'carlineDate', 'ankauf',
                                    'paymentDate', 'datumPayFour', 'dataFv2', 'carInvoiceDate', 'zahldatum'
                                ])
                            ) {
                                $month          = date('n', strtotime('01.'.$value));
                                $countMonthDays = date('t', mktime(0, 0, 0, $month));
                                $andX           = $expr->andX();
                                $startDate      = new \DateTime('01.'.$value);
                                $endDate        = new \DateTime($countMonthDays.'.'.$value);
                                $andX->add($expr->gte('car.'.$name, ':'.$name.'start'.$key));
                                $andX->add($expr->lte('car.'.$name, ':'.$name.'end'.$key));
                                $query->setParameter($name.'start'.$key, $startDate);
                                $query->setParameter($name.'end'.$key, $endDate);
                                $orX->add($andX);
                            } else {
                                $orX->add($expr->eq('car.'.$name, ':'.$name.$key));
                                $query->setParameter($name.$key, new \DateTime($value));
                            }
                        }
                    } catch (\Throwable $exception) {}
                }
                $query->andWhere($orX);
            } elseif (in_array($name, self::BOOLEAN)) {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                $resultArray = [];
                foreach ($filter as $value) {
                    if ($value === 'true') {
                        $resultArray[] = true;
                    } elseif ($value === 'false') {
                        $resultArray[] = false;
                    } elseif ($value === 'Only blue') {
                        $orX->add($expr->isNotNull('car.paidClick'));
                    }
                }
                $orX->add($expr->in('car.'.$name, ':'.$name.'Value'));
                $query->setParameter($name.'Value', $resultArray);
                $query->andWhere($orX);
            } elseif ($name === 'seller') {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($expr->concat(
                        $name.'.firstName',
                        $expr->concat(
                            $expr->literal(' '),
                            $name.'.lastName')
                    )));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }
                foreach ($filter as $key => $value) {
                    $value = trim($value);
                    $orX->add(
                        $expr->like(
                            $expr->concat(
                                $name.'.firstName',
                                $expr->concat(
                                    $expr->literal(' '),
                                    $name.'.lastName')
                            ),
                            ':'.$name.$key)
                    );
                    $orX->add($name.'.firstName = :first'.$name.$key);
                    $orX->add($name.'.lastName = :last'.$name.$key);
                    $query->setParameter($name.$key, $value);
                    $query->setParameter('first'.$name.$key, $value);
                    $query->setParameter('last'.$name.$key, $value);
                }
                $query->andWhere($orX);
            } elseif ($name === 'uploader') {
                $expr = $this->_em->getExpressionBuilder();
                $orX  = $expr->orX();

                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name . '.firstName'));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in($name . '.firstName', ':'.$name.'Value'));
                $query->setParameter($name.'Value', $filter);

                $query->andWhere($orX);
            } elseif ($name === 'zustand') {
                $expr = $this->_em->getExpressionBuilder();
                $orX  = $expr->orX();

                if (in_array('Empty', $filter) || in_array('Neu', $filter)) {
                    $orX->add($expr->isNull('car.carMileage'));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }
                if (in_array('Gebraucht', $filter)) {
                    $orX->add($expr->isNotNull('car.carMileage'));
                }

                $query->andWhere($orX);
            } else {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull('car.'.$name));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in('car.'.$name, ':'.$name.'Value'));
                $query->setParameter($name.'Value', $filter);

                $query->andWhere($orX);
            }
        }
        // END FILTERS -----------------------------------------------------

        switch ($columnSort) {
            case 'zustand':
                $columnSort = 'carMileage';
                break;
            case 'company':
                $columnSort = 'lastName';
                break;
            case 'rechnungsnr':
                $columnSort = 'id';
                break;
            case 'reDatum':
                $columnSort = 'id';
                break;
            case 'vkNetto':
                $columnSort = 'sellingPrice';
                break;
            case 'vkBrutto':
                $columnSort = 'sellingPrice';
                break;
        }

        $query
            ->orderBy('car.'.$columnSort, $sortType)
            ->setFirstResult($start)
            ->setMaxResults($length);

        $paginator = new Paginator($query);

        return [
            $paginator->count(),
            $paginator->getQuery()->getResult(),
        ];
    }

    /**
     * @param string $search
     * @param array  $filters
     *
     * @return array
     */
    public function getCarsForStatisticFilters(
        string $search,
        array $filters = []
    ): array {
        $query = $this->createQueryBuilder('car');

        foreach (self::JOINED_TABLE as $table) {
            $query->leftJoin('car.'.$table, $table);
        }

        $query
            ->andWhere('user.firmNumber = :selectCarpoint')
            ->setParameter('selectCarpoint', 'Carpoint GmbH');

        if ($search !== '') {
            $expr      = $this->_em->getExpressionBuilder();
            $condition = $expr->orX();

            foreach (self::STATISTICS_SEARCH_FIELDS as $column) {
                $condition->add($expr->like('car.' . $column, ':search'));
            }

            $query
                ->setParameter('search', '%'.trim($search).'%')
                ->andWhere($condition);
        }

        // FILTERS --------------------------------------------------------
        foreach ($filters as $name => $filter) {
            if ($selectAllKey = array_search('selectAll', $filter)) {
                unset($filter[$selectAllKey]);
                $filter = array_values($filter);
            }
            if ($name === 'customer') {
                $expr = $this->_em->getExpressionBuilder();
                $orX  = $expr->orX();

                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull('car.customer'));
                    $orX->add($expr->isNull('car.vendor'));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in('customer.title', ':customerStatisticValue'));
                $orX->add($expr->in('vendor.title', ':vendorStatisticValue'));
                $query->setParameter('customerStatisticValue', $filter);
                $query->setParameter('vendorStatisticValue', $filter);

                $query->andWhere($orX);
            } elseif (in_array($name, self::REFERENCES)) {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name . '.title'));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }
                if ($name === 'model' && in_array('Only blue', $filter)) {
                    $orX->add($expr->isNotNull('car.carCreatedAt'));
                    $emptyKey = array_search('Only blue', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in($name . '.title', ':'.$name.'Value'));
                $query->setParameter($name.'Value', $filter);

                $query->andWhere($orX);
            } elseif ($name === 'carCondition') {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                $resultArray = [];
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull('car.'.$name));
                    $emptyKey = array_search('Empty', $filter);
                    $resultArray[] = '';
                    unset($filter[$emptyKey]);
                }

                if (in_array('R', $filter)) {
                    $resultArray[] = 'reservation';
                }
                if (in_array('VK', $filter)) {
                    $resultArray[] = 'sold';
                }
                if (in_array('R', $filter)) {
                    $resultArray[] = 'reservation';
                }
                if (in_array('SP', $filter)) {
                    $resultArray[] = 'sold';
                }
                $resultArray = array_unique($resultArray);

                $orX->add($expr->in('car.carCondition', ':carCondition'));
                $query->setParameter('carCondition', $resultArray);

                $query->andWhere($orX);
            } elseif (in_array($name, self::VERSION)) {
                if ($name === 'versionPolish') {
                    $type = 'polish';
                } else {
                    $type = 'german';
                }
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name.'.'.$type));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                foreach ($filter as $key => $value) {
                    $orX->add($expr->eq($name.'.'.$type, ':'.$name.$key));
                    $query->setParameter($name.$key, $value);
                }
                $query->andWhere($orX);
            } elseif (in_array($name, self::COLOR)) {
                if ($name === 'colorPolish') {
                    $type = 'polish';
                } else {
                    $type = 'german';
                }
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name.'.'.$type));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                foreach ($filter as $key => $value) {
                    $orX->add($expr->eq($name.'.'.$type, ':'.$name.$key));
                    $query->setParameter($name.$key, $value);
                }
                $query->andWhere($orX);
            } elseif (in_array($name, self::DATE)) {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                foreach ($filter as $key => $value) {
                    try {
                        if ($value === 'Empty') {
                            $orX->add($expr->isNull('car.'.$name));
                        } else {
                            if (
                                in_array($name, [
                                    'completed', 'createdAt', 'datum', 'carlineDate', 'ankauf',
                                    'paymentDate', 'datumPayFour', 'dataFv2', 'carInvoiceDate', 'zahldatum'
                                ])
                            ) {
                                $month          = date('n', strtotime('01.'.$value));
                                $countMonthDays = date('t', mktime(0, 0, 0, $month));
                                $andX           = $expr->andX();
                                $startDate      = new \DateTime('01.'.$value);
                                $endDate        = new \DateTime($countMonthDays.'.'.$value);
                                $andX->add($expr->gte('car.'.$name, ':'.$name.'start'.$key));
                                $andX->add($expr->lte('car.'.$name, ':'.$name.'end'.$key));
                                $query->setParameter($name.'start'.$key, $startDate);
                                $query->setParameter($name.'end'.$key, $endDate);
                                $orX->add($andX);
                            } else {
                                $orX->add($expr->eq('car.'.$name, ':'.$name.$key));
                                $query->setParameter($name.$key, new \DateTime($value));
                            }
                        }
                    } catch (\Throwable $exception) {}
                }
                $query->andWhere($orX);
            } elseif (in_array($name, self::BOOLEAN)) {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                $resultArray = [];
                foreach ($filter as $value) {
                    if ($value === 'true') {
                        $resultArray[] = true;
                    } elseif ($value === 'false') {
                        $resultArray[] = false;
                    } elseif ($value === 'Only blue') {
                        $orX->add($expr->isNotNull('car.paidClick'));
                    }
                }
                $orX->add($expr->in('car.'.$name, ':'.$name.'Value'));
                $query->setParameter($name.'Value', $resultArray);
                $query->andWhere($orX);
            } elseif ($name === 'seller') {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($expr->concat(
                        $name.'.firstName',
                        $expr->concat(
                            $expr->literal(' '),
                            $name.'.lastName')
                    )));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }
                foreach ($filter as $key => $value) {
                    $value = trim($value);
                    $orX->add(
                        $expr->like(
                            $expr->concat(
                                $name.'.firstName',
                                $expr->concat(
                                    $expr->literal(' '),
                                    $name.'.lastName')
                            ),
                            ':'.$name.$key)
                    );
                    $orX->add($name.'.firstName = :first'.$name.$key);
                    $orX->add($name.'.lastName = :last'.$name.$key);
                    $query->setParameter($name.$key, $value);
                    $query->setParameter('first'.$name.$key, $value);
                    $query->setParameter('last'.$name.$key, $value);
                }
                $query->andWhere($orX);
            } elseif ($name === 'uploader') {
                $expr = $this->_em->getExpressionBuilder();
                $orX  = $expr->orX();

                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name . '.firstName'));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in($name . '.firstName', ':'.$name.'Value'));
                $query->setParameter($name.'Value', $filter);

                $query->andWhere($orX);
            } elseif ($name === 'zustand') {
                $expr = $this->_em->getExpressionBuilder();
                $orX  = $expr->orX();

                if (in_array('Empty', $filter) || $value === 'Neu') {
                    $orX->add($expr->isNull('car.carMileage'));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                } else {
                    $orX->add($expr->isNotNull('car.carMileage'));
                }

                $query->setParameter($name.'Value', $filter);
                $query->andWhere($orX);
            } else {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull('car.'.$name));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in('car.'.$name, ':'.$name.'Value'));
                $query->setParameter($name.'Value', $filter);

                $query->andWhere($orX);
            }
        }
        // END FILTERS -----------------------------------------------------

        return $query->getQuery()->getResult();
    }

    /**
     * @param string $search
     * @param array  $filters
     *
     * @return array
     */
    public function getCarsForStatisticsSummeAndCsv(
        string $search,
        array  $filters = []
    ): array {
        $query = $this->createQueryBuilder('car');

        foreach (self::JOINED_TABLE as $table) {
            $query->leftJoin('car.' . $table, $table);
        }

        $query
            ->andWhere('user.firmNumber = :selectCarpoint')
            ->setParameter('selectCarpoint', 'Carpoint GmbH');

        if ($search !== '') {
            $expr      = $this->_em->getExpressionBuilder();
            $condition = $expr->orX();

            foreach (self::STATISTICS_SEARCH_FIELDS as $column) {
                $condition->add($expr->like('car.' . $column, ':search'));
            }

            $query
                ->setParameter('search', '%'.trim($search).'%')
                ->andWhere($condition);
        }

        // FILTERS --------------------------------------------------------
        foreach ($filters as $name => $filter) {
            if ($selectAllKey = array_search('selectAll', $filter)) {
                unset($filter[$selectAllKey]);
                $filter = array_values($filter);
            }

            if ($name === 'customer') {
                $expr = $this->_em->getExpressionBuilder();
                $orX  = $expr->orX();

                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull('car.customer'));
                    $orX->add($expr->isNull('car.vendor'));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in('customer.title', ':customerStatisticValue'));
                $orX->add($expr->in('vendor.title', ':vendorStatisticValue'));
                $query->setParameter('customerStatisticValue', $filter);
                $query->setParameter('vendorStatisticValue', $filter);

                $query->andWhere($orX);
            } elseif (in_array($name, self::REFERENCES)) {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name . '.title'));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }
                if ($name === 'model' && in_array('Only blue', $filter)) {
                    $orX->add($expr->isNotNull('car.carCreatedAt'));
                    $emptyKey = array_search('Only blue', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in($name . '.title', ':'.$name.'Value'));
                $query->setParameter($name.'Value', $filter);

                $query->andWhere($orX);
            } elseif ($name === 'carCondition') {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                $resultArray = [];
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull('car.'.$name));
                    $emptyKey = array_search('Empty', $filter);
                    $resultArray[] = '';
                    unset($filter[$emptyKey]);
                }

                if (in_array('R', $filter)) {
                    $resultArray[] = 'reservation';
                }
                if (in_array('VK', $filter)) {
                    $resultArray[] = 'sold';
                }
                if (in_array('R', $filter)) {
                    $resultArray[] = 'reservation';
                }
                if (in_array('SP', $filter)) {
                    $resultArray[] = 'sold';
                }
                $resultArray = array_unique($resultArray);

                $orX->add($expr->in('car.carCondition', ':carCondition'));
                $query->setParameter('carCondition', $resultArray);

                $query->andWhere($orX);
            } elseif (in_array($name, self::VERSION)) {
                if ($name === 'versionPolish') {
                    $type = 'polish';
                } else {
                    $type = 'german';
                }
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name.'.'.$type));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                foreach ($filter as $key => $value) {
                    $orX->add($expr->eq($name.'.'.$type, ':'.$name.$key));
                    $query->setParameter($name.$key, $value);
                }
                $query->andWhere($orX);
            } elseif (in_array($name, self::COLOR)) {
                if ($name === 'colorPolish') {
                    $type = 'polish';
                } else {
                    $type = 'german';
                }
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name.'.'.$type));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                foreach ($filter as $key => $value) {
                    $orX->add($expr->eq($name.'.'.$type, ':'.$name.$key));
                    $query->setParameter($name.$key, $value);
                }
                $query->andWhere($orX);
            } elseif (in_array($name, self::DATE)) {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();

                if (in_array('selectAll', $filter)) {
                    $emptyKey = array_search('selectAll', $filter);
                    unset($filter[$emptyKey]);
                }

                foreach ($filter as $key => $value) {
                    try {
                        if ($value === 'Empty') {
                            $orX->add($expr->isNull('car.'.$name));
                        } else {
                            if (
                                in_array($name, [
                                    'completed', 'createdAt', 'datum', 'carlineDate', 'ankauf',
                                    'paymentDate', 'datumPayFour', 'dataFv2', 'carInvoiceDate', 'zahldatum'
                                ])
                            ) {
                                $month          = date('n', strtotime('01.'.$value));
                                $countMonthDays = date('t', mktime(0, 0, 0, $month));
                                $andX           = $expr->andX();
                                $startDate      = new \DateTime('01.'.$value);
                                $endDate        = new \DateTime($countMonthDays.'.'.$value);
                                $andX->add($expr->gte('car.'.$name, ':'.$name.'start'.$key));
                                $andX->add($expr->lte('car.'.$name, ':'.$name.'end'.$key));
                                $query->setParameter($name.'start'.$key, $startDate);
                                $query->setParameter($name.'end'.$key, $endDate);
                                $orX->add($andX);
                            } else {
                                $orX->add($expr->eq('car.'.$name, ':'.$name.$key));
                                $query->setParameter($name.$key, new \DateTime($value));
                            }
                        }
                    } catch (\Throwable $exception) {}
                }
                $query->andWhere($orX);
            } elseif (in_array($name, self::BOOLEAN)) {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                $resultArray = [];
                foreach ($filter as $value) {
                    if ($value === 'true') {
                        $resultArray[] = true;
                    } elseif ($value === 'false') {
                        $resultArray[] = false;
                    } elseif ($value === 'Only blue') {
                        $orX->add($expr->isNotNull('car.paidClick'));
                    }
                }
                $orX->add($expr->in('car.'.$name, ':'.$name.'Value'));
                $query->setParameter($name.'Value', $resultArray);
                $query->andWhere($orX);
            } elseif ($name === 'seller') {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($expr->concat(
                        $name.'.firstName',
                        $expr->concat(
                            $expr->literal(' '),
                            $name.'.lastName')
                    )));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }
                foreach ($filter as $key => $value) {
                    $value = trim($value);
                    $orX->add(
                        $expr->like(
                            $expr->concat(
                                $name.'.firstName',
                                $expr->concat(
                                    $expr->literal(' '),
                                    $name.'.lastName')
                            ),
                            ':'.$name.$key)
                    );
                    $orX->add($name.'.firstName = :first'.$name.$key);
                    $orX->add($name.'.lastName = :last'.$name.$key);
                    $query->setParameter($name.$key, $value);
                    $query->setParameter('first'.$name.$key, $value);
                    $query->setParameter('last'.$name.$key, $value);
                }
                $query->andWhere($orX);
            } elseif ($name === 'uploader') {
                $expr = $this->_em->getExpressionBuilder();
                $orX  = $expr->orX();

                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull($name . '.firstName'));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in($name . '.firstName', ':'.$name.'Value'));
                $query->setParameter($name.'Value', $filter);

                $query->andWhere($orX);
            } elseif ($name === 'zustand') {
                $expr = $this->_em->getExpressionBuilder();
                $orX  = $expr->orX();

                if (in_array('Empty', $filter) || in_array('Neu', $filter)) {
                    $orX->add($expr->isNull('car.carMileage'));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }
                if (in_array('Gebraucht', $filter)) {
                    $orX->add($expr->isNotNull('car.carMileage'));
                }

                $query->andWhere($orX);
            } else {
                $expr = $this->_em->getExpressionBuilder();
                $orX = $expr->orX();
                if (in_array('Empty', $filter)) {
                    $orX->add($expr->isNull('car.'.$name));
                    $emptyKey = array_search('Empty', $filter);
                    unset($filter[$emptyKey]);
                }

                $orX->add($expr->in('car.'.$name, ':'.$name.'Value'));
                $query->setParameter($name.'Value', $filter);

                $query->andWhere($orX);
            }
        }
        // END FILTERS -----------------------------------------------------

        return $query->getQuery()->getResult();
    }

    /**
     * @param string $start
     * @param string $length
     * @param string $columnSort
     * @param string $sortType
     * @param string $searchDate
     *
     * @return array
     */
    public function getInvoiceFiles(
        string $start,
        string $length,
        string $columnSort,
        string $sortType,
        string $searchDate
    ): array {
        $query = $this->createQueryBuilder('car')
            ->where('car.invoiceFileName is not null')
            ->andWhere('car.carInvoiceDate is not null')
            ->andWhere('car.carInvoiceDate LIKE :searchDate')
            ->setParameter('searchDate', '%'.$searchDate.'%')
            ->orderBy('car.'.$columnSort, $sortType)
            ->setFirstResult($start)
            ->setMaxResults($length);

        $paginator = new Paginator($query);

        return [
            $paginator->count(),
            $paginator->getQuery()->getResult(),
        ];
    }

    /**
     * Get invoice filter data
     */
    public function getInvoiceFilterData()
    {
        return $this->createQueryBuilder('car')
            ->select('distinct(car.carInvoiceDate)')
            ->where('car.invoiceFileName is not null')
            ->andWhere('car.carInvoiceDate is not null')
            ->getQuery()->getResult();
    }

    /**
     * @param string $searchDate
     *
     * @return array
     */
    public function getInvoiceFilesByMonth(string $searchDate): array
    {
        return $this->createQueryBuilder('car')
            ->select('car.invoiceFileName')
            ->where('car.invoiceFileName is not null')
            ->andWhere('car.carInvoiceDate is not null')
            ->andWhere('car.carInvoiceDate LIKE :searchDate')
            ->setParameter('searchDate', '%'.$searchDate.'%')
            ->getQuery()->getResult();
    }
}