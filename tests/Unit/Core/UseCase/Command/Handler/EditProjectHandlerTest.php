<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Handler;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Model\ValueObject\ProjectConfiguration;
use Eps\Fazah\Core\Repository\ProjectRepository;
use Eps\Fazah\Core\UseCase\Command\EditProject;
use Eps\Fazah\Core\UseCase\Command\Handler\EditProjectHandler;
use PHPUnit\Framework\TestCase;

class EditProjectHandlerTest extends TestCase
{
    /**
     * @var ProjectRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $projectRepo;

    /**
     * @var EditProjectHandler
     */
    private $handler;

    protected function setUp()
    {
        parent::setUp();

        $this->projectRepo = $this->createMock(ProjectRepository::class);
        $this->handler = new EditProjectHandler($this->projectRepo);
    }

    /**
     * @test
     */
    public function itShouldUpdateProjectInRepository(): void
    {
        $projectId = ProjectId::generate();
        $newName = 'updated name';
        $updateMap = [
            'name' => $newName
        ];
        $command = new EditProject($projectId, $updateMap);

        $this->projectRepo->expects($this->once())
            ->method('find')
            ->with($projectId)
            ->willReturn(
                Project::restoreFrom(
                    $projectId,
                    'old name',
                    Metadata::initialize(),
                    ProjectConfiguration::initialize()
                )
            );
        $this->projectRepo->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(
                    function (Project $project) use ($projectId, $newName) {
                        return $project->getId() === $projectId
                            && $project->getName() === $newName;
                    }
                )
            );

        $this->handler->handle($command);
    }
}
