<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\CriteriaMatcher\Impl\Builder\Catalogue;

use Doctrine\ORM\QueryBuilder;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

final class FilterByProjectId extends CatalogueConditionBuilder
{
    public function build(QueryCriteria $criteria, QueryBuilder $queryBuilder): void
    {
        $queryBuilder->andWhere($queryBuilder->expr()->eq('p.projectId', ':projectId'))
            ->setParameter('projectId', $criteria->getFilters()->getFilter('project_id'));
    }

    protected function supportsCatalogue(QueryCriteria $criteria): bool
    {
        return $criteria->getFilters()->contains('project_id');
    }
}
