<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model;

use Assert\AssertionFailedException;
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
        static::assertNotNull($this->newCatalogue->getId());
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
    public function itShouldHaveInitiallyEmptyCatalogueId(): void
    {
        $catalogue = Catalogue::create('my catalogue', ProjectId::generate());
        static::assertNull($catalogue->getParentCatalogueId());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToCreateCatalogueWithParentReference(): void
    {
        $parentCatalogueId = CatalogueId::generate();
        $catalogue = Catalogue::create(
            'My catalogue',
            ProjectId::generate(),
            $parentCatalogueId
        );

        static::assertEquals($parentCatalogueId, $catalogue->getParentCatalogueId());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToRestoreModelFromGivenValues(): void
    {
        $name = 'My catalogue';
        $catalogueId = CatalogueId::generate();
        $projectId = ProjectId::generate();
        $parentCatalogueId = CatalogueId::generate();
        $metadata = Metadata::restoreFrom(
            Carbon::parse('2016-01-01 15:00:00'),
            Carbon::parse('2016-01-02 12:00:00'),
            true
        );
        $alias = 'my-custom-alias';

        $catalogue = Catalogue::restoreFrom(
            $catalogueId,
            $name,
            $projectId,
            $parentCatalogueId,
            $metadata,
            $alias
        );

        static::assertEquals($catalogueId, $catalogue->getId());
        static::assertEquals($name, $catalogue->getName());
        static::assertEquals($projectId, $catalogue->getProjectId());
        static::assertEquals($parentCatalogueId, $catalogue->getParentCatalogueId());
        static::assertEquals($metadata, $catalogue->getMetadata());
        static::assertEquals($alias, $catalogue->getAlias());
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
            null,
            Metadata::restoreFrom(
                Carbon::now(),
                Carbon::now(),
                false
            )
        );
        $catalogue->enable();

        static::assertTrue($catalogue->getMetadata()->isEnabled());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToRenameCatalogue(): void
    {
        $newCatalogueName = 'new catalogue';
        $this->newCatalogue->rename($newCatalogueName);

        static::assertEquals($newCatalogueName, $this->newCatalogue->getName());
    }

    /**
     * @test
     */
    public function itShouldThrowWhenEmptyCatalogueNameProvided(): void
    {
        $this->expectException(AssertionFailedException::class);
        $this->expectExceptionMessageRegExp('/Catalogue name cannot be blank/');

        $invalidName = '';
        $this->newCatalogue->rename($invalidName);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToChangeCatalogueAlias(): void
    {
        $newAlias = 'fancy-alias';
        $this->newCatalogue->changeAlias($newAlias);

        static::assertEquals($newAlias, $this->newCatalogue->getAlias());
    }

    /**
     * @test
     */
    public function itShouldThrowWhenTryingToSetEmptyAlias(): void
    {
        $this->expectException(AssertionFailedException::class);
        $this->expectExceptionMessageRegExp('/Catalogue alias cannot be blank/');

        $invalidAlias = '';
        $this->newCatalogue->changeAlias($invalidAlias);
    }

    /**
     * @test
     */
    public function itShouldThrowWhenAliasHasWhiteSpaces(): void
    {
        $this->expectException(AssertionFailedException::class);
        $this->expectExceptionMessageRegExp('/Catalogue alias must not contain whitespaces/');

        $invalidAlias = 'my alias bla bla bla';
        $this->newCatalogue->changeAlias($invalidAlias);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToUpdateCatalogueFromArray(): void
    {
        $newCatalogueName = 'new catalogue';
        $newAlias = 'new-alias-for-this';
        $updateMap = [
            'name' => $newCatalogueName,
            'alias' => $newAlias
        ];

        $this->newCatalogue->updateFromArray($updateMap);

        static::assertEquals($newCatalogueName, $this->newCatalogue->getName());
        static::assertEquals($newAlias, $this->newCatalogue->getAlias());
    }

    private function createNewCatalogue(): Catalogue
    {
        $catalogueName = 'My translations';
        $projectId = ProjectId::generate();
        return Catalogue::create($catalogueName, $projectId);
    }
}
