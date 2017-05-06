<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\Builder;

use Doctrine\ORM\QueryBuilder;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\Core\Repository\Query\Impl\DoctrineConditionBuilder;

final class FilterByEnabled implements DoctrineConditionBuilder
{
    public function supports(QueryCriteria $criteria): bool
    {
        return $criteria->getFilters()->contains('enabled');
    }

    public function build(QueryCriteria $criteria, QueryBuilder $queryBuilder): void
    {
        $queryBuilder->andWhere($queryBuilder->expr()->eq('p.metadata.enabled', ':enabled'))
            ->setParameter(':enabled', $criteria->getFilters()->getFilter('enabled'));
    }
}
