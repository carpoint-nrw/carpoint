<?php

namespace AdminBundle\Repository\References;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class ModelRepository
 *
 * @package AdminBundle\Repository\References
 */
class ModelRepository extends AbstractReferencesRepository
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
    public function getData(
        string $start,
        string $length,
        string $columnSort,
        string $sortType,
        string $search
    ): array {
        $query = $this->createQueryBuilder('data');
        if ($search !== '') {
            $query
                ->where('data.title LIKE :search')
                ->join('data.brand', 'brand')
                ->orWhere('brand.title LIKE :search')
                ->setParameter('search', '%' . trim($search) . '%');
        }
        $query
            ->orderBy('data.' . $columnSort, $sortType)
            ->setFirstResult($start)
            ->setMaxResults($length);

        $paginator = new Paginator($query);

        return [
            $paginator->count(),
            $paginator->getQuery()->getResult(),
        ];
    }
}