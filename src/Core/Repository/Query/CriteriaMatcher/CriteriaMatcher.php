<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\CriteriaMatcher;

use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Porpaginas\Result;

interface CriteriaMatcher
{
    public function match(QueryCriteria $criteria): Result;
}
