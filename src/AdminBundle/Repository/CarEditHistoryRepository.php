<?php

namespace AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class CarEditHistoryRepository
 *
 * @package AdminBundle\Repository
 */
class CarEditHistoryRepository extends EntityRepository
{
    /**
     * @param string $start
     * @param string $length
     * @param string $columnSort
     * @param string $sortType
     * @param string $search
     *
     * @return array
     */
    public function getGetEditHistory(
        string $start,
        string $length,
        string $columnSort,
        string $sortType,
        string $search
    ): array {
        $query = $this->createQueryBuilder('history');
        if ($search !== '') {
            $query
                ->join('history.car', 'car')
                ->join('history.admin', 'admin')
                ->where('history.editDate LIKE :search')
                ->orWhere('history.columnGerman LIKE :search')
                ->orWhere('history.columnPolish LIKE :search')
                ->orWhere('history.oldValue LIKE :search')
                ->orWhere('history.newValue LIKE :search')
                ->orWhere('car.vinNumber LIKE :search')
                ->orWhere('admin.firstName LIKE :search')
                ->orWhere('admin.lastName LIKE :search')
                ->setParameter('search', '%' . trim($search) . '%');
        }
        $query
            ->orderBy('history.' . $columnSort, $sortType)
            ->setFirstResult($start)
            ->setMaxResults($length);

        $paginator = new Paginator($query);

        return [
            $paginator->count(),
            $paginator->getQuery()->getResult(),
        ];
    }
}