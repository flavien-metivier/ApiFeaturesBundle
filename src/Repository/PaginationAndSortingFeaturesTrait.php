<?php

namespace QualityCode\ApiFeaturesBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

trait PaginationAndSortingFeaturesTrait
{
    /**
     * Creates a new QueryBuilder instance that is prepopulated for this entity name.
     *
     * @param string $alias
     * @param string $indexBy The index for the from
     *
     * @return QueryBuilder
     */
    abstract public function createQueryBuilder($alias, $indexBy = null);

    /**
     * @return \Doctrine\ORM\Mapping\ClassMetadata
     */
    abstract protected function getClassMetadata();

    /**
     * @param int   $limit
     * @param int   $page
     * @param array $sorting
     * @param array $searching
     *
     * @return Pagerfanta
     */
    public function findAllPaginated($limit, $page, array $sorting = [], array $searching = [])
    {
        $fields = array_keys($this->getClassMetadata()->fieldMappings);
        $queryBuilder = $this->createQueryBuilder('r');

        $this->addOrderBy($queryBuilder, $fields, $sorting)->addSearchBy($queryBuilder, $fields, $searching);

        $pagerAdapter = new DoctrineORMAdapter($queryBuilder);
        $pager = new Pagerfanta($pagerAdapter);
        $pager->setCurrentPage($page);
        $pager->setMaxPerPage($limit);

        return $pager;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param array        $fields
     * @param array        $sorting
     *
     * @return QueryBuilder
     */
    protected function addOrderBy(QueryBuilder & $queryBuilder, array $fields, array $sorting)
    {
        foreach ($fields as $field) {
            if (isset($sorting[$field])) {
                $direction = ($sorting[$field] === 'asc') ? 'asc' : 'desc';
                $queryBuilder->addOrderBy('r.' . $field, $direction);
            }
        }

        return $this;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param array        $fields
     * @param array        $searching
     *
     * @return QueryBuilder
     */
    protected function addSearchBy(QueryBuilder & $queryBuilder, array $fields, array $searching)
    {
        foreach ($fields as $field) {
            if (isset($searching[$field])) {
                $queryBuilder->orWhere($queryBuilder->expr()->like('r.' . $field, ':' . $field));
                $queryBuilder->setParameter($field, '%' . $searching[$field] . '%');
            }
        }

        return $this;
    }
}
