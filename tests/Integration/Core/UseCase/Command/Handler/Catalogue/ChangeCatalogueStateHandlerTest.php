<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\UseCase\Command\Handler\Catalogue;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\UseCase\Command\Catalogue\ChangeCatalogueState;
use Eps\Fazah\Tests\Resources\Fixtures\AddCatalogues;
use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;
use League\Tactician\CommandBus;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class ChangeCatalogueStateHandlerTest extends WebTestCase
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
            AddProjects::class,
            AddCatalogues::class
        ]);
    }

    /**
     * @test
     */
    public function itShouldChangeCatalogueState(): void
    {
        $catalogueId = new CatalogueId('a853f467-403d-416b-8269-36369c34d723');
        $enabled = false;
        $command = new ChangeCatalogueState($catalogueId, $enabled);

        $this->commandBus->handle($command);

        $catalogueRepo = $this->getContainer()->get('test.fazah.repository.catalogue');
        $modifiedCatalogue = $catalogueRepo->find($catalogueId);
        static::assertFalse($modifiedCatalogue->getMetadata()->isEnabled());
    }
}
