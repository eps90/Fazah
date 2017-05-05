<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\Builder;

use Doctrine\ORM\QueryBuilder;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Repository\Query\Impl\DoctrineConditionBuilder;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

final class SortByDefaultDates implements DoctrineConditionBuilder
{

    public function supports(QueryCriteria $criteria): bool
    {
        return $criteria->getSorting()->isEmpty();
    }

    public function build(QueryCriteria $criteria, QueryBuilder $queryBuilder): void
    {
        $queryBuilder->addOrderBy('p.metadata.createdAt', 'DESC');
        $queryBuilder->addOrderBy('p.metadata.updatedAt', 'DESC');
    }
}
