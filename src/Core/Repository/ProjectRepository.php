<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Repository\Exception\ProjectRepositoryException;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

interface ProjectRepository extends RepositoryInterface
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
     * @param QueryCriteria|null $criteria
     * @return array|Project[]
     */
    public function findAll(QueryCriteria $criteria = null): array;
}
