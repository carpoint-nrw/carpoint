<?php

namespace AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserOrderNumberRepository
 *
 * @package AdminBundle\Repository
 */
class UserOrderNumberRepository extends EntityRepository
{
    /**
     * @return int|mixed|string
     */
    public function findMaxCarlinenumber()
    {
        return $this->createQueryBuilder('userNumber')
            ->select('MAX(userNumber.number)')
            ->getQuery()->getSingleScalarResult();
    }
}