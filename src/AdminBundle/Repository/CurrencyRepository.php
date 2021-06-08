<?php

namespace AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class CurrencyRepository
 *
 * @package AdminBundle\Repository
 */
class CurrencyRepository extends EntityRepository
{
    /**
     * @param string $start
     * @param string $length
     *
     * @return array
     */
    public function getCurrencies(
        string $start,
        string $length
    ): array {
        $query = $this->createQueryBuilder('currency');

        $query
            ->orderBy('currency.date', 'desc')
            ->setFirstResult($start)
            ->setMaxResults($length);

        $paginator = new Paginator($query);

        return [
            $paginator->count(),
            $paginator->getQuery()->getResult(),
        ];
    }
}