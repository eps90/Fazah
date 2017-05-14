<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\CriteriaMatcher\Impl\Builder\Message;

use Doctrine\ORM\QueryBuilder;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

final class FilterByLanguage extends MessageConditionBuilder
{
    public function build(QueryCriteria $criteria, QueryBuilder $queryBuilder): void
    {
        $queryBuilder->andWhere($queryBuilder->expr()->eq('p.translation.language', ':language'))
            ->setParameter('language', $criteria->getFilters()->getFilter('language'));
    }

    protected function supportsMessage(QueryCriteria $criteria): bool
    {
        return $criteria->getFilters()->contains('language');
    }
}
