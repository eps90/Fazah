<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\CriteriaMatcher;

use Eps\Fazah\Core\Repository\Query\QueryCriteria;

interface CriteriaMatcher
{
    public function match(QueryCriteria $criteria): array;
}
