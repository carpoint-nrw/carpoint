<?php

namespace AdminBundle\Repository\References;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class VersionRepository
 *
 * @package AdminBundle\Repository\References
 */
class VersionRepository extends AbstractReferencesRepository
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
            ->join('data.model', 'model')
            ->join('model.brand', 'brand');

        if ($search !== '') {
            $query
                ->where('data.polish LIKE :search')
                ->orWhere('data.german LIKE :search')
                ->orWhere('model.title LIKE :search')
                ->orWhere('brand.title LIKE :search')
                ->setParameter('search', '%' . trim($search) . '%');
        }

        if ($columnSort === 'brand') {
            $sorting = 'brand.title';
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

    /**
     * @param string $modelId
     * @param string $versionId
     *
     * @return array
     */
    public function getVersions(
        string $modelId,
        string $versionId
    ): array {
        $query = $this->createQueryBuilder('verison')
            ->leftJoin('verison.model', 'model')
            ->where('model.id = :modelId')
            ->setParameter('modelId', $modelId);

        if ($versionId !== '') {
            $expr = $this->_em->getExpressionBuilder();
            $condition = $expr->orX();

            $condition->add($expr->eq('verison.isVisible', ':isVisible'));
            $condition->add($expr->eq('verison.id', ':versionId'));

            $query
                ->andWhere($condition)
                ->setParameter('isVisible', false)
                ->setParameter('versionId', $versionId);
        } else {
            $query
                ->andWhere('verison.isVisible = :isVisible')
                ->setParameter('isVisible', false);
        }

        return $query
            ->orderBy('verison.sort', 'asc')
            ->addOrderBy('verison.polish', 'asc')
            ->getQuery()
            ->getResult();
    }
}