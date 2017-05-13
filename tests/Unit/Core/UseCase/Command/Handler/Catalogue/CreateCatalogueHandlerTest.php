<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Handler\Catalogue;

use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Repository\CatalogueRepository;
use Eps\Fazah\Core\UseCase\Command\Catalogue\CreateCatalogue;
use Eps\Fazah\Core\UseCase\Command\Handler\Catalogue\CreateCatalogueHandler;
use PHPUnit\Framework\TestCase;

class CreateCatalogueHandlerTest extends TestCase
{
    /**
     * @var CatalogueRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $catalogueRepo;

    /**
     * @var CreateCatalogueHandler
     */
    private $handler;

    protected function setUp()
    {
        parent::setUp();

        $this->catalogueRepo = $this->createMock(CatalogueRepository::class);
        $this->handler = new CreateCatalogueHandler($this->catalogueRepo);
    }

    /**
     * @test
     */
    public function itShouldSaveCatalogueToRepository(): void
    {
        $catalogueName = 'New catalogue';
        $projectId = ProjectId::generate();
        $command = new CreateCatalogue($catalogueName, $projectId, null);

        $this->catalogueRepo->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(
                    function (Catalogue $catalogue) use ($catalogueName, $projectId) {
                        return $catalogue->getName() === $catalogueName
                            && $catalogue->getProjectId() === $projectId;
                    }
                )
            );

        $this->handler->handle($command);
    }

    /**
     * @test
     */
    public function itShouldAttachParentCatalogueToNewCatalogue(): void
    {
        $catalogueName = 'New catalogue';
        $projectId = ProjectId::generate();
        $parentCatalogueId = CatalogueId::generate();
        $command = new CreateCatalogue($catalogueName, $projectId, $parentCatalogueId);

        $this->catalogueRepo->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(
                    function (Catalogue $catalogue) use ($catalogueName, $projectId, $parentCatalogueId) {
                        return $catalogue->getName() === $catalogueName
                            && $catalogue->getProjectId() === $projectId
                            && $catalogue->getParentCatalogueId() === $parentCatalogueId;
                    }
                )
            );

        $this->handler->handle($command);
    }
}
