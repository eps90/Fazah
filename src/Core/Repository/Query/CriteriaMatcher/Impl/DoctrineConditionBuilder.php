<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\CriteriaMatcher\Impl;

use Doctrine\ORM\QueryBuilder;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

interface DoctrineConditionBuilder
{
    public function supports(QueryCriteria $criteria): bool;

    public function build(QueryCriteria $criteria, QueryBuilder $queryBuilder): void;
}
