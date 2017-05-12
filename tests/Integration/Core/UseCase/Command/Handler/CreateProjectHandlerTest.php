<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\UseCase\Command\Handler;

use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\Core\UseCase\Command\CreateProject;
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

        $this->commandBus = $this->getContainer()->get('tactician.commandbus');
        $this->loadFixtures([]);
    }

    /**
     * @test
     */
    public function itShouldCreateNewProject(): void
    {
        $command = new CreateProject('project name');
        $this->commandBus->handle($command);

        $projectRepo = $this->getContainer()->get('fazah.repository.project');
        $filter = ['phrase' => 'project name'];
        $queryCriteria = new QueryCriteria(Project::class, new FilterSet($filter));
        $projects = $projectRepo->findAll($queryCriteria);

        static::assertCount(1, $projects);
    }
}
