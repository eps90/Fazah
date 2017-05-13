<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\UseCase\Command\Handler;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\UseCase\Command\EditCatalogue;
use Eps\Fazah\Tests\Resources\Fixtures\AddCatalogues;
use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;
use League\Tactician\CommandBus;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class EditCatalogueHandlerTest extends WebTestCase
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
            AddProjects::class,
            AddCatalogues::class
        ]);
    }

    /**
     * @test
     */
    public function itShouldUpdateCatalogue(): void
    {
        $catalogueId = new CatalogueId('a853f467-403d-416b-8269-36369c34d723');
        $newName = 'new catalogue name';
        $newAlias = 'updated.alias';
        $updateMap = [
            'name' => $newName,
            'alias' => $newAlias
        ];
        $command = new EditCatalogue($catalogueId, $updateMap);

        $this->commandBus->handle($command);

        $catalogueRepo = $this->getContainer()->get('fazah.repository.catalogue');
        $catalogue = $catalogueRepo->find($catalogueId);

        static::assertEquals($newName, $catalogue->getName());
        static::assertEquals($newAlias, $catalogue->getAlias());
    }

}
