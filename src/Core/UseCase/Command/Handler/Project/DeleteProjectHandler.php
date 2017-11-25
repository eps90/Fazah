<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Handler\Project;

use Eps\Fazah\Core\Repository\ProjectRepository;
use Eps\Fazah\Core\UseCase\Command\Project\DeleteProject;

class DeleteProjectHandler
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function handle(DeleteProject $command): void
    {
        $this->projectRepository->remove($command->getProjectId());
    }
}
