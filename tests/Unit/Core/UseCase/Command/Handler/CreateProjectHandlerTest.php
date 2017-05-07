<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Handler;

use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Repository\ProjectRepository;
use Eps\Fazah\Core\UseCase\Command\CreateProject;
use Eps\Fazah\Core\UseCase\Command\Handler\CreateProjectHandler;
use PHPUnit\Framework\TestCase;

class CreateProjectHandlerTest extends TestCase
{
    /**
     * @var ProjectRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $projectRepo;

    /**
     * @var CreateProjectHandler
     */
    private $handler;

    protected function setUp()
    {
        parent::setUp();

        $this->projectRepo = $this->createMock(ProjectRepository::class);
        $this->handler = new CreateProjectHandler($this->projectRepo);
    }

    /**
     * @test
     */
    public function itShouldAddProjectToTheRepository(): void
    {
        $projectName = 'my awesome project';
        $command = new CreateProject($projectName);

        $this->projectRepo->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(
                    function (Project $project) use ($projectName) {
                        return $project->getName() === $projectName;
                    }
                )
            );

        $this->handler->handle($command);
    }
}
