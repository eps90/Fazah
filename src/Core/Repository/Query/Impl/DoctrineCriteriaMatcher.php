<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Query\Impl;

use Doctrine\ORM\EntityManagerInterface;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\Core\Repository\Query\CriteriaMatcher;

final class DoctrineCriteriaMatcher implements CriteriaMatcher
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

    public function match(QueryCriteria $criteria): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        foreach ($this->builders as $builder) {
            if ($builder->supports($criteria)) {
                $builder->build($criteria, $queryBuilder);
            }
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
