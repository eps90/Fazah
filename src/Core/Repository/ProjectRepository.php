<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Project;

interface ProjectRepository
{
    /**
     * @param Project $project
     * @throws \LogicException
     */
    public function add(Project $project): void;

    /**
     * @param ProjectId $projectId
     * @return Project
     * @throws \LogicException
     */
    public function find(ProjectId $projectId): Project;

    /**
     * @return Project[]
     */
    public function findAll(): array;
}
