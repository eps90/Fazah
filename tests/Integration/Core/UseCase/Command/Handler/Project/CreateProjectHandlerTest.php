<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\UseCase\Command\Handler\Project;

use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\Core\UseCase\Command\Project\CreateProject;
use League\Tactician\CommandBus;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class CreateProjectHandlerTest extends WebTestCase
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    protected function setUp()
    {
        parent::setUp();

        $this->commandBus = $this->getContainer()->get('test.tactician.commandbus');
        $this->loadFixtures([]);
    }

    /**
     * @test
     */
    public function itShouldCreateNewProject(): void
    {
        $command = new CreateProject('project name');
        $this->commandBus->handle($command);

        $projectRepo = $this->getContainer()->get('test.fazah.repository.project');
        $filter = ['phrase' => 'project name'];
        $queryCriteria = new QueryCriteria(Project::class, new FilterSet($filter));
        $projects = $projectRepo->findAll($queryCriteria);

        static::assertCount(1, $projects);
    }

    /**
     * @test
     */
    public function itShouldOptionallyAddNewLanguageToAProject(): void
    {
        $availableLanguages = ['pl', 'gb'];
        $command = new CreateProject('some project', $availableLanguages);
        $this->commandBus->handle($command);

        $projectRepo = $this->getContainer()->get('test.fazah.repository.project');
        $filter = ['phrase' => 'some project'];
        $queryCriteria = new QueryCriteria(Project::class, new FilterSet($filter));
        /** @var Project[] $projects */
        $projects = iterator_to_array($projectRepo->findAll($queryCriteria));

        static::assertEquals($availableLanguages, $projects[0]->getConfig()->getAvailableLanguages());
    }
}
