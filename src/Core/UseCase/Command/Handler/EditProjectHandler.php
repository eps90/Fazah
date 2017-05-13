<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Handler;

use Eps\Fazah\Core\Repository\ProjectRepository;
use Eps\Fazah\Core\UseCase\Command\EditProject;

class EditProjectHandler
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function handle(EditProject $command): void
    {
        $projectId = $command->getProjectId();
        $projectData = $command->getProjectData();

        $project = $this->projectRepository->find($projectId);
        $project->updateFromArray($projectData);
        $this->projectRepository->save($project);
    }
}
