<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Impl;

use Doctrine\ORM\EntityManagerInterface;
use Eps\Fazah\Core\Repository\Query\CriteriaMatcher;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\Core\Repository\Query\Sorting\SortSet;

abstract class BaseDoctrineRepository
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var CriteriaMatcher
     */
    protected $criteriaMatcher;

    public function __construct(EntityManagerInterface $entityManager, CriteriaMatcher $criteriaMatcher)
    {
        $this->entityManager = $entityManager;
        $this->criteriaMatcher = $criteriaMatcher;
    }

    abstract protected function getModelClass(): string;

    public function findAll(QueryCriteria $criteria = null): array
    {
        if ($criteria === null) {
            $criteria = new QueryCriteria($this->getModelClass(), new FilterSet(), new SortSet());
        }

        return $this->criteriaMatcher->match($criteria);
    }

    protected function saveAll(array $modelInstances): void
    {
        foreach ($modelInstances as $modelInstance) {
            $this->entityManager->persist($modelInstance);
        }

        $this->entityManager->flush();
    }
}
