<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\CriteriaMatcher\Impl\Builder\Catalogue;

use Doctrine\ORM\QueryBuilder;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

final class SelectCatalogues extends CatalogueConditionBuilder
{
    public function build(QueryCriteria $criteria, QueryBuilder $queryBuilder): void
    {
        $queryBuilder->select('p')
            ->from('Fazah:Catalogue', 'p');
    }

    protected function supportsCatalogue(QueryCriteria $criteria): bool
    {
        return true;
    }
}
