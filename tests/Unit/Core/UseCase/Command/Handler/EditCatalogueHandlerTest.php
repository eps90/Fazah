<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Handler;

use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Repository\CatalogueRepository;
use Eps\Fazah\Core\UseCase\Command\EditCatalogue;
use Eps\Fazah\Core\UseCase\Command\Handler\EditCatalogueHandler;
use PHPUnit\Framework\TestCase;

class EditCatalogueHandlerTest extends TestCase
{
    /**
     * @var CatalogueRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $catalogueRepo;

    /**
     * @var EditCatalogueHandler
     */
    private $handler;

    protected function setUp()
    {
        parent::setUp();

        $this->catalogueRepo = $this->createMock(CatalogueRepository::class);
        $this->handler = new EditCatalogueHandler($this->catalogueRepo);
    }

    /**
     * @test
     */
    public function itShouldSaveUpdatedCatalogueWithRepository(): void
    {
        $catalogueId = CatalogueId::generate();
        $newName = 'New name';
        $updateMap = [
            'name' => $newName
        ];
        $command = new EditCatalogue($catalogueId, $updateMap);

        $this->catalogueRepo->expects($this->once())
            ->method('find')
            ->with($catalogueId)
            ->willReturn(
                Catalogue::restoreFrom(
                    $catalogueId,
                    'old name',
                    ProjectId::generate(),
                    null,
                    Metadata::initialize(),
                    'old.alias'
                )
            );
        $this->catalogueRepo->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(
                    function (Catalogue $catalogue) use ($catalogueId, $newName) {
                        return $catalogue->getId() === $catalogueId
                            && $catalogue->getName() === $newName;
                    }
                )
            );

        $this->handler->handle($command);
    }
}
