<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Handler\Project;

use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Repository\ProjectRepository;
use Eps\Fazah\Core\UseCase\Command\Project\CreateProject;

class CreateProjectHandler
{
    /**
     * @var ProjectRepository
     */
    private $projectRepo;

    /**
     * CreateProjectHandler constructor.
     * @param ProjectRepository $projectRepo
     */
    public function __construct(ProjectRepository $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    public function handle(CreateProject $command): void
    {
        $project = Project::create($command->getName());
        $project->changeAvailableLanguages($command->getAvailableLanguages());
        $this->projectRepo->save($project);
    }
}
