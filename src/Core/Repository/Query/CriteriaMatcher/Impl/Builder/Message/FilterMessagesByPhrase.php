<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\CriteriaMatcher\Impl\Builder\Message;

use Doctrine\ORM\QueryBuilder;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

final class FilterMessagesByPhrase extends MessageConditionBuilder
{
    public function build(QueryCriteria $criteria, QueryBuilder $queryBuilder): void
    {
        $queryBuilder->andWhere(
            $queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('p.translation.translatedMessage', ':phrase'),
                $queryBuilder->expr()->like('p.translation.messageKey', ':phrase')
            )
        )
        ->setParameter('phrase', '%' . $criteria->getFilters()->getFilter('phrase')  . '%');
    }

    protected function supportsMessage(QueryCriteria $criteria): bool
    {
        return $criteria->getFilters()->contains('phrase');
    }
}
