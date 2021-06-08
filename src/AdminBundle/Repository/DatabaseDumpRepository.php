<?php

namespace AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class DatabaseDumpRepository
 *
 * @package AdminBundle\Repository
 */
class DatabaseDumpRepository extends EntityRepository
{
    /**
     * @param string $start
     * @param string $length
     * @param string $columnSort
     * @param string $sortType
     *
     * @return array
     */
    public function getDumps(
        string $start,
        string $length,
        string $columnSort,
        string $sortType
    ): array {
        $query = $this->createQueryBuilder('dump')
            ->orderBy('dump.' . $columnSort, $sortType)
            ->setFirstResult($start)
            ->setMaxResults($length);

        $paginator = new Paginator($query);
        return [
            $paginator->count(),
            $paginator->getQuery()->getResult(),
        ];
    }
}