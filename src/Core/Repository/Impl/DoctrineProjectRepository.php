<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Impl;

use Doctrine\ORM\EntityManagerInterface;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Repository\Exception\ProjectRepositoryException;
use Eps\Fazah\Core\Repository\Query\CriteriaMatcher;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\Core\Repository\Query\Sorting\SortSet;
use Eps\Fazah\Core\Repository\ProjectRepository;

final class DoctrineProjectRepository implements ProjectRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var CriteriaMatcher
     */
    private $matcher;

    public function __construct(EntityManagerInterface $entityManager, CriteriaMatcher $matcher)
    {
        $this->entityManager = $entityManager;
        $this->matcher = $matcher;
    }

    /**
     * {@inheritdoc}
     */
    public function save(Project ...$projects): void
    {
        foreach ($projects as $project) {
            $this->entityManager->persist($project);
        }

        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function find(ProjectId $projectId): Project
    {
        $project = $this->entityManager->find(Project::class, $projectId);
        if ($project === null) {
            throw ProjectRepositoryException::notFound($projectId);
        }

        return $project;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(QueryCriteria $criteria = null): array
    {
        if ($criteria === null) {
            $criteria = new QueryCriteria(Project::class, new FilterSet(), new SortSet());
        }

        return $this->matcher->match($criteria);
    }
}
