<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\UseCase\Command\Handler;

use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\Core\UseCase\Command\CreateCatalogue;
use League\Tactician\CommandBus;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class CreateCatalogueHandlerTest extends WebTestCase
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = $this->getContainer()->get('tactician.commandbus');
        $this->loadFixtures([]);
    }

    /**
     * @test
     */
    public function itShouldAddNewCatalogue(): void
    {
        $catalogueName = 'my catalogue';
        $projectId = ProjectId::generate();
        $command = new CreateCatalogue($catalogueName, $projectId);

        $this->commandBus->handle($command);

        $catalogueRepo = $this->getContainer()->get('fazah.repository.catalogue');
        $filters = ['project_id' => $projectId];
        $criteria = new QueryCriteria(Catalogue::class, new FilterSet($filters));
        $foundCatalogues = $catalogueRepo->findAll($criteria);

        static::assertCount(1, $foundCatalogues);
    }
}
