<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\Builder;

use Doctrine\ORM\QueryBuilder;
use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Repository\Query\Impl\DoctrineConditionBuilder;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

final class FilterByProjectId implements DoctrineConditionBuilder
{

    public function supports(QueryCriteria $criteria): bool
    {
        return $criteria->getModelClass() === Catalogue::class
            && $criteria->getFilters()->contains('project_id');
    }

    public function build(QueryCriteria $criteria, QueryBuilder $queryBuilder): void
    {
        $queryBuilder->andWhere($queryBuilder->expr()->eq('p.projectId', ':projectId'))
            ->setParameter('projectId', $criteria->getFilters()['project_id']);
    }
}
