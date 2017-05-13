<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Handler\Project;

use Eps\Fazah\Core\Repository\ProjectRepository;
use Eps\Fazah\Core\UseCase\Command\Project\ChangeProjectState;

class ChangeProjectStateHandler
{
    /**
     * @var ProjectRepository
     */
    private $projectRepo;

    public function __construct(ProjectRepository $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function handle(ChangeProjectState $command): void
    {
        $project = $this->projectRepo->find($command->getProjectId());
        $command->shouldBeEnabled() ? $project->enable() : $project->disable();

        $this->projectRepo->save($project);
    }
}
