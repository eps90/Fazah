<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\CriteriaMatcher\Impl;

use Doctrine\ORM\EntityManagerInterface;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\Core\Repository\Query\CriteriaMatcher\CriteriaMatcher;
use Porpaginas\Doctrine\ORM\ORMQueryResult;
use Porpaginas\Result;

class DoctrineCriteriaMatcher implements CriteriaMatcher
{
    /**
     * @var DoctrineConditionBuilder[]
     */
    private $builders;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->builders = [];
    }

    public function addBuilder(DoctrineConditionBuilder $builder): void
    {
        $this->builders[] = $builder;
    }

    public function match(QueryCriteria $criteria): Result
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        foreach ($this->builders as $builder) {
            if ($builder->supports($criteria)) {
                $builder->build($criteria, $queryBuilder);
            }
        }

        return new ORMQueryResult($queryBuilder->getQuery());
    }
}
