<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Impl;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Repository\Exception\ProjectRepositoryException;
use Eps\Fazah\Core\Repository\ProjectRepository;

class DoctrineProjectRepository extends BaseDoctrineRepository implements ProjectRepository
{
    /**
     * {@inheritdoc}
     */
    public function save(Project ...$projects): void
    {
        $this->saveAll($projects);
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

    protected function getModelClass(): string
    {
        return Project::class;
    }

    public function remove(ProjectId $projectId): void
    {
        $projectReference = $this->entityManager->getReference(Project::class, $projectId);
        $this->entityManager->remove($projectReference);
        $this->entityManager->flush();
    }
}
