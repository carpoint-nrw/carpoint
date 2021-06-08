<?php

namespace AdminBundle\Repository;

use AdminBundle\Entity\User\Admin;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class AdminRepository
 *
 * @package AdminBundle\Repository
 */
class AdminRepository extends EntityRepository
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
    public function getAdmins(
        string $start,
        string $length,
        string $columnSort,
        string $sortType,
        string $search
    ): array {
        $query = $this->createQueryBuilder('admin');
        if ($search !== '') {
            $query
                ->where('admin.firstName LIKE :search')
                ->orWhere('admin.lastName LIKE :search')
                ->orWhere('admin.email LIKE :search')
                ->orWhere('admin.role LIKE :search')
                ->setParameter('search', '%' . trim($search) . '%');
        }
        $query
            ->orderBy('admin.' . $columnSort, $sortType)
            ->setFirstResult($start)
            ->setMaxResults($length);

        $paginator = new Paginator($query);

        return [
            $paginator->count(),
            $paginator->getQuery()->getResult(),
        ];
    }

    /**
     * @param string      $email
     * @param string|null $userId
     *
     * @return array
     */
    public function checkEmail(
        string $email,
        $userId = null
    ):? Admin {
        $query = $this->createQueryBuilder('admin')
            ->where('admin.email = :email')
            ->setParameter('email', $email);

        if ($userId !== null) {
            $query
                ->andWhere('admin.id != :id')
                ->setParameter('id', $userId);
        }

        return $query->getQuery()->getOneOrNullResult();
    }
}