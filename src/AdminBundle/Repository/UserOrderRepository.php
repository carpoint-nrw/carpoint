<?php

namespace AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class UserOrderRepository
 *
 * @package AdminBundle\Repository
 */
class UserOrderRepository extends EntityRepository
{
    /**
     * @param string $start
     * @param string $length
     * @param string $userId
     *
     * @return array
     */
    public function getUserOrders(
        string $start,
        string $length,
        string $userId
    ): array {
        $query = $this->createQueryBuilder('userOrder')
            ->where('userOrder.user = :userId')
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
}