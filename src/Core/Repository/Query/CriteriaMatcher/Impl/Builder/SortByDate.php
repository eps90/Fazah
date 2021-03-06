<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\CriteriaMatcher\Impl\Builder;

use Doctrine\ORM\QueryBuilder;
use Eps\Fazah\Core\Repository\Query\CriteriaMatcher\Impl\DoctrineConditionBuilder;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

final class SortByDate implements DoctrineConditionBuilder
{
    public function supports(QueryCriteria $criteria): bool
    {
        return $criteria->getSorting()->contains('created_at')
            || $criteria->getSorting()->contains('updated_at');
    }

    public function build(QueryCriteria $criteria, QueryBuilder $queryBuilder): void
    {
        $createdAt = $criteria->getSorting()->findField('created_at');
        if ($createdAt !== null) {
            $queryBuilder->addOrderBy('p.metadata.createdAt', $createdAt->getDirection());
        }

        $updatedAt = $criteria->getSorting()->findField('updated_at');
        if ($updatedAt !== null) {
            $queryBuilder->addOrderBy('p.metadata.updatedAt', $updatedAt->getDirection());
        }
    }
}
