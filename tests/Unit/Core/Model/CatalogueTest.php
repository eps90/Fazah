<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\Catalogue;
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

    private function createNewCatalogue(): Catalogue
    {
        $catalogueName = 'My translations';
        $projectId = ProjectId::generate();
        return Catalogue::create($catalogueName, $projectId);
    }
}
