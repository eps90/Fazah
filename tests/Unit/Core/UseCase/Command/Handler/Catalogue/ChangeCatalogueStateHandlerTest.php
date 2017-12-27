<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Handler\Catalogue;

use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Repository\CatalogueRepository;
use Eps\Fazah\Core\UseCase\Command\Catalogue\ChangeCatalogueState;
use Eps\Fazah\Core\UseCase\Command\Handler\Catalogue\ChangeCatalogueStateHandler;
use Eps\Fazah\Core\Utils\DateTimeFactory;
use PHPUnit\Framework\TestCase;

class ChangeCatalogueStateHandlerTest extends TestCase
{
    /**
     * @var CatalogueRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $catalogueRepo;

    /**
     * @var ChangeCatalogueStateHandler
     */
    private $handler;

    protected function setUp()
    {
        parent::setUp();

        $this->catalogueRepo = $this->createMock(CatalogueRepository::class);
        $this->handler = new ChangeCatalogueStateHandler($this->catalogueRepo);
        DateTimeFactory::freezeDate(new \DateTimeImmutable('2015-01-01 12:00:00'));
    }

    protected function tearDown()
    {
        parent::tearDown();

        DateTimeFactory::unfreezeDate();
    }


    /**
     * @test
     */
    public function itShouldChangeCatalogueStateToDisabled(): void
    {
        $catalogueId = CatalogueId::generate();
        $enabled = false;
        $command = new ChangeCatalogueState($catalogueId, $enabled);

        $existingCatalogue = Catalogue::restoreFrom(
            $catalogueId,
            'My catalogue',
            ProjectId::generate(),
            null,
            Metadata::restoreFrom(
                DateTimeFactory::now(),
                DateTimeFactory::now(),
                true
            )
        );
        $this->catalogueRepo->expects($this->once())
            ->method('find')
            ->with($catalogueId)
            ->willReturn($existingCatalogue);
        $this->catalogueRepo->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(
                    function (Catalogue $catalogue) use ($catalogueId, $enabled) {
                        return $catalogue->getId() === $catalogueId
                            && $catalogue->getMetadata()->isEnabled() === $enabled;
                    }
                )
            );

        $this->handler->handle($command);
    }

    /**
     * @test
     */
    public function itShouldChangeCatalogueStateToEnabled(): void
    {
        $catalogueId = CatalogueId::generate();
        $enabled = true;
        $command = new ChangeCatalogueState($catalogueId, $enabled);

        $existingCatalogue = Catalogue::restoreFrom(
            $catalogueId,
            'My catalogue',
            ProjectId::generate(),
            null,
            Metadata::restoreFrom(
                DateTimeFactory::now(),
                DateTimeFactory::now(),
                false
            )
        );
        $this->catalogueRepo->expects($this->once())
            ->method('find')
            ->with($catalogueId)
            ->willReturn($existingCatalogue);
        $this->catalogueRepo->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(
                    function (Catalogue $catalogue) use ($catalogueId, $enabled) {
                        return $catalogue->getId() === $catalogueId
                            && $catalogue->getMetadata()->isEnabled() === $enabled;
                    }
                )
            );

        $this->handler->handle($command);
    }
}
