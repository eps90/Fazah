<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\CriteriaMatcher\Impl\Builder\Catalogue;

use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Repository\Query\CriteriaMatcher\Impl\DoctrineConditionBuilder;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

abstract class CatalogueConditionBuilder implements DoctrineConditionBuilder
{
    abstract protected function supportsCatalogue(QueryCriteria $criteria): bool;

    public function supports(QueryCriteria $criteria): bool
    {
        return $criteria->getModelClass() === Catalogue::class && $this->supportsCatalogue($criteria);
    }
}
