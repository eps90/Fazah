<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Handler\Project;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Model\ValueObject\ProjectConfiguration;
use Eps\Fazah\Core\Repository\ProjectRepository;
use Eps\Fazah\Core\UseCase\Command\Project\ChangeProjectState;
use Eps\Fazah\Core\UseCase\Command\Handler\Project\ChangeProjectStateHandler;
use PHPUnit\Framework\TestCase;

class ChangeProjectStateHandlerTest extends TestCase
{
    /**
     * @var ProjectRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $projectRepo;

    /**
     * @var ChangeProjectStateHandler
     */
    private $handler;

    protected function setUp()
    {
        parent::setUp();

        $this->projectRepo = $this->createMock(ProjectRepository::class);
        $this->handler = new ChangeProjectStateHandler($this->projectRepo);
    }

    /**
     * @test
     */
    public function itShouldSaveProjectWithStateChangeToDisabled(): void
    {
        $projectId = ProjectId::generate();
        $enabled = false;
        $command = new ChangeProjectState($projectId, $enabled);

        $existingProject = Project::create('My project');
        $this->projectRepo->expects($this->once())
            ->method('find')
            ->with($projectId)
            ->willReturn($existingProject);

        $this->projectRepo->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(
                    function (Project $project) use ($enabled) {
                        return $project->getMetadata()->isEnabled() === $enabled;
                    }
                )
            );

        $this->handler->handle($command);
    }

    /**
     * @test
     */
    public function itShouldSaveProjectWithStateChangeToEnabled(): void
    {
        $projectId = ProjectId::generate();
        $enabled = true;
        $command = new ChangeProjectState($projectId, $enabled);

        $existingProject = Project::restoreFrom(
            $projectId,
            'My project',
            Metadata::restoreFrom(
                Carbon::now(),
                Carbon::now(),
                false
            ),
            ProjectConfiguration::restoreFrom(['en'])
        );
        $this->projectRepo->expects($this->once())
            ->method('find')
            ->with($projectId)
            ->willReturn($existingProject);

        $this->projectRepo->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(
                    function (Project $project) use ($enabled) {
                        return $project->getMetadata()->isEnabled() === $enabled;
                    }
                )
            );

        $this->handler->handle($command);
    }
}
