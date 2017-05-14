<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\CriteriaMatcher\Impl\Builder\Message;

use Doctrine\ORM\QueryBuilder;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

final class SelectMessages extends MessageConditionBuilder
{
    public function build(QueryCriteria $criteria, QueryBuilder $queryBuilder): void
    {
        $queryBuilder->select('p');
        $queryBuilder->from('Fazah:Message', 'p');
    }

    protected function supportsMessage(QueryCriteria $criteria): bool
    {
        return true;
    }
}
