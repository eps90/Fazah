<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\ApiPlatform\Extension;

use Eps\Fazah\Core\Repository\Query\QueryCriteria;

interface ExtensionInterface
{
    public function applyFilters(string $resourceClass, QueryCriteria $criteria): void;
}
