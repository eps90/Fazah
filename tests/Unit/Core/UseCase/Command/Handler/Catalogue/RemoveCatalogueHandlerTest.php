<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Handler\Catalogue;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Repository\CatalogueRepository;
use Eps\Fazah\Core\UseCase\Command\Catalogue\RemoveCatalogue;
use Eps\Fazah\Core\UseCase\Command\Handler\Catalogue\RemoveCatalogueHandler;
use PHPUnit\Framework\TestCase;

class RemoveCatalogueHandlerTest extends TestCase
{
    /**
     * @var CatalogueRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $catalogueRepo;

    /**
     * @var RemoveCatalogueHandler
     */
    private $handler;

    protected function setUp()
    {
        parent::setUp();

        $this->catalogueRepo = $this->createMock(CatalogueRepository::class);
        $this->handler = new RemoveCatalogueHandler($this->catalogueRepo);
    }

    /**
     * @test
     */
    public function itShouldCallRepositoryToRemoveACatalogue(): void
    {
        $catalogueId = new CatalogueId('12853ef6-43a5-4e7f-8ff5-3fb47ef10a07');
        $command = new RemoveCatalogue($catalogueId);

        $this->catalogueRepo->expects(static::once())
            ->method('remove')
            ->with($catalogueId);

        $this->handler->handle($command);
    }
}
