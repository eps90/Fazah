<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\UseCase\Command\Handler\Project;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Repository\Exception\ProjectRepositoryException;
use Eps\Fazah\Core\UseCase\Command\Project\DeleteProject;
use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;
use League\Tactician\CommandBus;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class DeleteProjectHandlerTest extends WebTestCase
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    protected function setUp()
    {
        parent::setUp();

        $this->commandBus = $this->getContainer()->get('tactician.commandbus');
        $this->loadFixtures([
            AddProjects::class
        ]);
    }
    
    /**
     * @test
     */
    public function itShouldRemoveProject(): void
    {
        $this->expectException(ProjectRepositoryException::class);

        $projectId = new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260');
        $command = new DeleteProject($projectId);

        $this->commandBus->handle($command);

        $projectsRepo = $this->getContainer()->get('fazah.repository.project');
        $projectsRepo->find($projectId);
    }
}
