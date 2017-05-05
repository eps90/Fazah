<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\Builder;

use Doctrine\ORM\QueryBuilder;
use Eps\Fazah\Core\Repository\Query\Impl\DoctrineConditionBuilder;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

final class FilterByPhrase implements DoctrineConditionBuilder
{

    public function supports(QueryCriteria $criteria): bool
    {
        return $criteria->getFilters()->contains('phrase');
    }

    public function build(QueryCriteria $criteria, QueryBuilder $queryBuilder): void
    {
        $queryBuilder->andWhere($queryBuilder->expr()->like('p.name', ':phrase'))
            ->setParameter('phrase', '%' . $criteria->getFilters()['phrase'] . '%');
    }
}
