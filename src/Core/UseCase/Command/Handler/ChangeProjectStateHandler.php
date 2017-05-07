<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Handler;

use Eps\Fazah\Core\Repository\ProjectRepository;
use Eps\Fazah\Core\UseCase\Command\ChangeProjectState;

final class ChangeProjectStateHandler
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
        if ($command->shouldBeEnabled()) {
            $project->enable();
        } else {
            $project->disable();
        }

        $this->projectRepo->save($project);
    }
}
