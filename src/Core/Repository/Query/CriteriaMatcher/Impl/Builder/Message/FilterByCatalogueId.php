<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\CriteriaMatcher\Impl\Builder\Message;

use Doctrine\ORM\QueryBuilder;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\Query\CriteriaMatcher\Impl\DoctrineConditionBuilder;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

final class FilterByCatalogueId implements DoctrineConditionBuilder
{
    public function supports(QueryCriteria $criteria): bool
    {
        return $criteria->getModelClass() === Message::class
            && $criteria->getFilters()->contains('catalogue_id');
    }

    public function build(QueryCriteria $criteria, QueryBuilder $queryBuilder): void
    {
        $queryBuilder->andWhere($queryBuilder->expr()->eq('p.catalogueId', ':catalogueId'))
            ->setParameter('catalogueId', $criteria->getFilters()->getFilter('catalogue_id'));
    }
}
