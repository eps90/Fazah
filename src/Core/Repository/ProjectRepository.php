<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Repository\Exception\ProjectRepositoryException;

interface ProjectRepository
{
    /**
     * @param Project[] ...$projects
     */
    public function save(Project ...$projects): void;

    /**
     * @param ProjectId $projectId
     * @return Project
     * @throws ProjectRepositoryException
     */
    public function find(ProjectId $projectId): Project;

    /**
     * @return Project[]
     */
    public function findAll(): array;
}
