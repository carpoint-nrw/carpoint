<?php

namespace AdminBundle\Repository\References;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class StandartComplectationRepository
 *
 * @package AdminBundle\Repository\References
 */
class StandartComplectationRepository extends AbstractReferencesRepository
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
        $query = $this->createQueryBuilder('data')
            ->join('data.version', 'version')
            ->join('version.model', 'model')
            ->join('model.brand', 'brand');
        if ($search !== '') {
            $query
                ->where('data.german LIKE :search')
                ->orWhere('data.polish LIKE :search')
                ->orWhere('brand.title LIKE :search')
                ->orWhere('model.title LIKE :search')
                ->orWhere('version.german LIKE :search')
                ->orWhere('version.polish LIKE :search')
                ->setParameter('search', '%' . trim($search) . '%');
        }
        if ($columnSort === 'brand') {
            $sorting = 'brand.title';
        } elseif ($columnSort === 'model') {
            $sorting = 'model.title';
        } else {
            $sorting = 'data.' . $columnSort;
        }
        $query
            ->orderBy($sorting, $sortType)
            ->setFirstResult($start)
            ->setMaxResults($length);

        $paginator = new Paginator($query);

        return [
            $paginator->count(),
            $paginator->getQuery()->getResult(),
        ];
    }
}