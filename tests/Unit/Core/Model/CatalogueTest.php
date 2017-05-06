<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
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
        $expectedName = 'My translations';

        static::assertEquals($expectedName, $this->newCatalogue->getName());
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
        static::assertEquals($this->now, $this->newCatalogue->getMetadata()->getCreationTime());
    }

    /**
     * @test
     */
    public function itShouldHaveInitiallyEmptyUpdateTime(): void
    {
        static::assertNull($this->newCatalogue->getMetadata()->getUpdateTime());
    }

    /**
     * @test
     */
    public function itShouldBeInitiallyEnabled(): void
    {
        static::assertTrue($this->newCatalogue->getMetadata()->isEnabled());
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
        $metadata = Metadata::restoreFrom(
            Carbon::parse('2016-01-01 15:00:00'),
            Carbon::parse('2016-01-02 12:00:00'),
            true
        );

        $catalogue = Catalogue::restoreFrom(
            $catalogueId,
            $name,
            $projectId,
            $metadata
        );

        static::assertEquals($catalogueId, $catalogue->getCatalogueId());
        static::assertEquals($name, $catalogue->getName());
        static::assertEquals($projectId, $catalogue->getProjectId());
        static::assertEquals($metadata, $catalogue->getMetadata());
    }

    /**
     * @test
     */
    public function itShouldHaveDefaultAlias(): void
    {
        $catalogueName = 'This is my catalogue éáąć';
        $catalogue = Catalogue::create($catalogueName, ProjectId::generate());

        $expectedAlias = 'this_is_my_catalogue_eaac';
        $actualAlias = $catalogue->getAlias();

        static::assertEquals($expectedAlias, $actualAlias);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToDisableACatalogue(): void
    {
        $catalogue = Catalogue::create('My Catalogue', ProjectId::generate());
        $catalogue->disable();

        static::assertFalse($catalogue->getMetadata()->isEnabled());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToEnableACatalogue(): void
    {
        $catalogue = Catalogue::restoreFrom(
            CatalogueId::generate(),
            'My disabled catalogue',
            ProjectId::generate(),
            Metadata::restoreFrom(
                Carbon::now(),
                Carbon::now(),
                false
            )
        );
        $catalogue->enable();

        static::assertTrue($catalogue->getMetadata()->isEnabled());
    }

    private function createNewCatalogue(): Catalogue
    {
        $catalogueName = 'My translations';
        $projectId = ProjectId::generate();
        return Catalogue::create($catalogueName, $projectId);
    }
}
