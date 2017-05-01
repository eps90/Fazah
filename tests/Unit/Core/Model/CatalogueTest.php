<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use PHPUnit\Framework\TestCase;

class CatalogueTest extends TestCase
{
    /**
     * @var Carbon
     */
    private $now;

    /**
     * @var Catalogue
     */
    private $newCatalogue;

    protected function setUp()
    {
        parent::setUp();

        $this->now = Carbon::create(
            2016,
            01,
            02,
            15,
            00,
            15,
            new \DateTimeZone('UTC')
        );
        Carbon::setTestNow($this->now);
        $this->newCatalogue = $this->createNewCatalogue();
    }

    protected function tearDown()
    {
        parent::tearDown();

        Carbon::setTestNow();
    }

    /**
     * @test
     */
    public function itShouldCreateCatalogueWithName(): void
    {
        $expectedCatalogueName = 'My translations';

        static::assertEquals($expectedCatalogueName, $this->newCatalogue->getName());
    }

    /**
     * @test
     */
    public function itShouldHaveInitiallySetId(): void
    {
        static::assertNotNull($this->newCatalogue->getCatalogueId());
    }

    /**
     * @test
     */
    public function itShouldSetCreationDate(): void
    {
        static::assertEquals($this->now, $this->newCatalogue->getCreatedAt());
    }

    /**
     * @test
     */
    public function itShouldHaveInitiallyEmptyUpdateTime(): void
    {
        static::assertNull($this->newCatalogue->getUpdatedAt());
    }

    /**
     * @test
     */
    public function itShouldBeInitiallyEnabled(): void
    {
        static::assertTrue($this->newCatalogue->isEnabled());
    }

    /**
     * @test
     */
    public function itShouldHaveAReferenceToProject(): void
    {
        static::assertNotNull($this->newCatalogue->getProjectId());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToRestoreModelFromGivenValues(): void
    {
        $name = 'My catalogue';
        $catalogueId = CatalogueId::generate();
        $projectId = ProjectId::generate();
        $createdAt = Carbon::instance(new \DateTime('2016-01-01 15:00:00'));
        $updatedAt = Carbon::instance(new \DateTime('2016-01-02 12:00:00'));
        $enabled = true;

        $catalogue = Catalogue::restoreFrom(
            $catalogueId,
            $name,
            $createdAt,
            $updatedAt,
            $enabled,
            $projectId
        );

        static::assertEquals($catalogueId, $catalogue->getCatalogueId());
        static::assertEquals($name, $catalogue->getName());
        static::assertEquals($createdAt, $catalogue->getCreatedAt());
        static::assertEquals($updatedAt, $catalogue->getUpdatedAt());
        static::assertEquals($enabled, $catalogue->isEnabled());
        static::assertEquals($projectId, $catalogue->getProjectId());
    }

    private function createNewCatalogue(): Catalogue
    {
        $catalogueName = 'My translations';
        $projectId = ProjectId::generate();
        return Catalogue::create($catalogueName, $projectId);
    }
}
