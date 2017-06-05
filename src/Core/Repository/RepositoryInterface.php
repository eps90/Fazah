<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository;

use Eps\Fazah\Core\Repository\Query\QueryCriteria;

interface RepositoryInterface
{
    public function findAll(QueryCriteria $criteria): array;
}
