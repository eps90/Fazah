<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\UseCase\Command\Handler\Project;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\UseCase\Command\Project\EditProject;
use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;
use League\Tactician\CommandBus;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class EditProjectHandlerTest extends WebTestCase
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = $this->getContainer()->get('test.tactician.commandbus');
        $this->loadFixtures([
            AddProjects::class
        ]);
    }

    /**
     * @test
     */
    public function itShouldEditProject(): void
    {
        $newName = 'updated_project';
        $newLanguages = ['en', 'pl', 'fr', 'de'];
        $updateMap = [
            'name' => $newName,
            'available_languages' => $newLanguages
        ];
        $projectId = new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260');
        $command = new EditProject($projectId, $updateMap);

        $this->commandBus->handle($command);

        $projectRepo = $this->getContainer()->get('test.fazah.repository.project');
        $project = $projectRepo->find($projectId);

        static::assertEquals($newName, $project->getName());
        static::assertEquals($newLanguages, $project->getConfig()->getAvailableLanguages());
    }

}
