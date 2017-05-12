<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Impl;

use Doctrine\ORM\EntityManagerInterface;
use Eps\Fazah\Core\Repository\Query\CriteriaMatcher\CriteriaMatcher;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

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
            $criteria = new QueryCriteria($this->getModelClass());
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
