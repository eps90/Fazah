<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Handler\Project;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Repository\ProjectRepository;
use Eps\Fazah\Core\UseCase\Command\Handler\Project\DeleteProjectHandler;
use Eps\Fazah\Core\UseCase\Command\Project\DeleteProject;
use PHPUnit\Framework\TestCase;

class DeleteProjectHandlerTest extends TestCase
{
    /**
     * @var ProjectRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $projectRepo;

    /**
     * @var DeleteProjectHandler
     */
    private $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->projectRepo = $this->createMock(ProjectRepository::class);
        $this->handler = new DeleteProjectHandler($this->projectRepo);
    }
    
    /**
     * @test
     */
    public function itShouldDeleteProjectInRepository(): void
    {
        $projectId = new ProjectId('d4e3d880-ae15-4b72-a04b-60086aff056e');
        $command = new DeleteProject($projectId);

        $this->projectRepo->expects(static::once())
            ->method('remove')
            ->with($projectId);


        $this->handler->handle($command);
    }
}
