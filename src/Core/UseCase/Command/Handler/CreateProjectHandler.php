<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Handler;

use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Repository\ProjectRepository;
use Eps\Fazah\Core\UseCase\Command\CreateProject;

final class CreateProjectHandler
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
        $this->projectRepo->save($project);
    }
}
