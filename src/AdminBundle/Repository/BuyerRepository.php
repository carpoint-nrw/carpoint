<?php

namespace AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class BuyerRepository
 *
 * @package AdminBundle\Repository
 */
class BuyerRepository extends EntityRepository
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
    public function getBuyers(
        string $start,
        string $length,
        string $columnSort,
        string $sortType,
        string $search
    ): array {
        $query = $this->createQueryBuilder('buyer');
        if ($search !== '') {
            $query
                ->where('buyer.firstName LIKE :search')
                ->orWhere('buyer.lastName LIKE :search')
                ->orWhere('buyer.firma LIKE :search')
                ->setParameter('search', '%' . trim($search) . '%');
        }
        $query
            ->orderBy('buyer.' . $columnSort, $sortType)
            ->setFirstResult($start)
            ->setMaxResults($length);
        $paginator = new Paginator($query);
        return [
            $paginator->count(),
            $paginator->getQuery()->getResult(),
        ];
    }
}