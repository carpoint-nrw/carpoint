<?php

namespace AdminBundle\Repository;

use AdminBundle\Entity\User\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class UserRepository
 *
 * @package AdminBundle\Repository
 */
class UserRepository extends EntityRepository
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
    public function getUsers(
        string $start,
        string $length,
        string $columnSort,
        string $sortType,
        string $search
    ): array {
        $query = $this->createQueryBuilder('user');

        if ($search !== '') {
            $query
                ->where('user.firmNumber LIKE :search')
                ->orWhere('user.firstName LIKE :search')
                ->orWhere('user.lastName LIKE :search')
                ->orWhere('user.email LIKE :search')
                ->orWhere('user.createdAt LIKE :search')
                ->orWhere('user.abbreviation LIKE :search')
                ->setParameter('search', '%' . trim($search) . '%');
        }

        $query
            ->orderBy('user.' . $columnSort, $sortType)
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
    ):? User {
        $query = $this->createQueryBuilder('user')
            ->where('user.email = :email')
            ->setParameter('email', $email);

        if ($userId !== null) {
            $query
                ->andWhere('user.id != :id')
                ->setParameter('id', $userId);
        }

        return $query->getQuery()->getOneOrNullResult();
    }
}