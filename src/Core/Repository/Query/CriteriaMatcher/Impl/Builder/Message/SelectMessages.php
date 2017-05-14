<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\CriteriaMatcher\Impl\Builder\Message;

use Doctrine\ORM\QueryBuilder;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\Query\CriteriaMatcher\Impl\DoctrineConditionBuilder;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

final class SelectMessages implements DoctrineConditionBuilder
{

    public function supports(QueryCriteria $criteria): bool
    {
        return $criteria->getModelClass() === Message::class;
    }

    public function build(QueryCriteria $criteria, QueryBuilder $queryBuilder): void
    {
        $queryBuilder->select('p');
        $queryBuilder->from('Fazah:Message', 'p');
    }
}
