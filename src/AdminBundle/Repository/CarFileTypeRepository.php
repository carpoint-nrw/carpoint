<?php

namespace AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class CarFileTypeRepository
 *
 * @package AdminBundle\Repository
 */
class CarFileTypeRepository extends EntityRepository
{
    /**
     * @param string $start
     * @param string $length
     * @param string $columnSort
     * @param string $sortType
     *
     * @return array
     */
    public function getTypes(
        string $start,
        string $length,
        string $columnSort,
        string $sortType
    ): array {
        $query = $this->createQueryBuilder('type')
            ->orderBy('type.' . $columnSort, $sortType)
            ->setFirstResult($start)
            ->setMaxResults($length);

        $paginator = new Paginator($query);

        return [
            $paginator->count(),
            $paginator->getQuery()->getResult(),
        ];
    }
}