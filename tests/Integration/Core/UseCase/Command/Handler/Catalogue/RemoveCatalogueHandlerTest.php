<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\UseCase\Command\Handler\Catalogue;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Repository\CatalogueRepository;
use Eps\Fazah\Core\Repository\Exception\CatalogueRepositoryException;
use Eps\Fazah\Core\UseCase\Command\Catalogue\RemoveCatalogue;
use Eps\Fazah\Tests\Resources\Fixtures\AddFewCatalogues;
use League\Tactician\CommandBus;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class RemoveCatalogueHandlerTest extends WebTestCase
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var CatalogueRepository
     */
    private $catalogueRepo;

    protected function setUp()
    {
        parent::setUp();

        $container = $this->getContainer();
        $this->commandBus = $container->get('tactician.commandbus');
        $this->catalogueRepo = $container->get('fazah.repository.catalogue');

        $this->loadFixtures([
            AddFewCatalogues::class
        ]);
    }

    /**
     * @test
     */
    public function itShouldRemoveCatalogueWithGivenId(): void
    {
        $catalogueId = new CatalogueId('12853ef6-43a5-4e7f-8ff5-3fb47ef10a07');
        $command = new RemoveCatalogue($catalogueId);

        $this->commandBus->handle($command);

        $this->expectException(CatalogueRepositoryException::class);
        $this->catalogueRepo->find($catalogueId);
    }
}
