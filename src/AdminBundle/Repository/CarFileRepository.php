<?php

namespace AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class CarFileRepository
 *
 * @package AdminBundle\Repository
 */
class CarFileRepository extends EntityRepository
{
    /**
     * @param string $carId
     * @param string $columnSort
     * @param string $sortType
     * @param string $userId
     *
     * @return array
     */
    public function getFiles(
        string $carId,
        string $columnSort,
        string $sortType,
        string $userId
    ): array {
        $query = $this->createQueryBuilder('file')
            ->leftJoin('file.type', 'type')
            ->leftJoin('type.carFilePermission', 'permission')
            ->where('file.car = :carId')
            ->andWhere('permission.id = :userId')
            ->setParameter('carId', $carId)
            ->setParameter('userId', $userId)
            ->orderBy('file.' . $columnSort, $sortType);

        $paginator = new Paginator($query);

        return [
            $paginator->count(),
            $paginator->getQuery()->getResult(),
        ];
    }
}