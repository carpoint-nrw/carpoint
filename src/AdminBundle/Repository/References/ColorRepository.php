<?php

namespace AdminBundle\Repository\References;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class ColorRepository
 *
 * @package AdminBundle\Repository\References
 */
class ColorRepository extends AbstractReferencesRepository
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
                ->where('data.polish LIKE :search')
                ->orWhere('data.german LIKE :search')
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
    
    public function getAll(): array {
        $query = $this->createQueryBuilder('c');
        $query->orderBy('c.german');
        
        return $query->getQuery()->getResult();
        
    }
    
     public function getByBaseColor($baseColor): array {
        $query = $this->createQueryBuilder('c');
        $query
            ->where('c.baseColor = :baseColor')
            ->setParameter('baseColor', $baseColor);
        
        return $query->getQuery()->getResult();
        
    }
    
    public function getQueryByBaseColor($baseColor) {
        $query = $this->createQueryBuilder('c');
        $query
            ->where('c.baseColor = :baseColor')
            ->setParameter('baseColor', $baseColor)
            ->orderBy('c.german', 'ASC');
        
        return $query;
        
    }
    
    public function findByBaseColor($baseColor): array {
        $query = $this->createQueryBuilder('c');
        $query
            ->where('c.polish LIKE :search')
            ->orWhere('c.german LIKE :search')
            ->setParameter('search', '%' . trim($baseColor) . '%');
        
        return $query->getQuery()->getResult();
        
    }
}