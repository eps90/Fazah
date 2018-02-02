<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Handler\Project;

use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Repository\ProjectRepository;
use Eps\Fazah\Core\UseCase\Command\Project\CreateProject;
use Eps\Fazah\Core\UseCase\Command\Handler\Project\CreateProjectHandler;
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

    /**
     * @test
     */
    public function itShouldAddProjectWithAvailableLanguages(): void
    {
        $projectName = 'my awesome project';
        $availableLanguages = ['pl', 'en'];
        $command = new CreateProject($projectName, $availableLanguages);

        $this->projectRepo->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(
                    function (Project $project) use ($projectName, $availableLanguages) {
                        return $project->getName() === $projectName
                            && $project->getConfig()->getAvailableLanguages() === $availableLanguages;
                    }
                )
            );

        $this->handler->handle($command);
    }
}
