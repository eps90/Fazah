<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query;

interface CriteriaMatcher
{
    public function match(QueryCriteria $criteria): array;
}
