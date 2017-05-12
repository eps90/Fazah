<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\FazahBundle\Doctrine\Types\CatalogueIdType;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CatalogueIdTypeTest extends TestCase
{
    /**
     * @var CatalogueIdType
     */
    private $type;

    /**
     * @var AbstractPlatform|\PHPUnit_Framework_MockObject_MockObject
     */
    private $platform;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        if (!Type::hasType(CatalogueIdType::CATALOGUE_ID)) {
            Type::addType(CatalogueIdType::CATALOGUE_ID, CatalogueIdType::class);
        }
    }

    protected function setUp()
    {
        parent::setUp();

        $this->type = Type::getType(CatalogueIdType::CATALOGUE_ID);
        $this->platform = $this->createMock(AbstractPlatform::class);
    }

    /**
     * @test
     */
    public function itShouldConvertCatalogueIdToString(): void
    {
        $catalogueId = CatalogueId::generate();

        $expectedResult = $catalogueId->getId();
        $actualResult = $this->type->convertToDatabaseValue($catalogueId, $this->platform);

        static::assertEquals($expectedResult, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldConvertToDatabaseNullWhenValueIsNull(): void
    {
        $catalogueId = null;
        $actualResult = $this->type->convertToDatabaseValue($catalogueId, $this->platform);

        static::assertEquals($catalogueId, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldThrowWhenInputIsNotACatalogueId(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $badCatalogueId = Uuid::uuid4()->toString();
        $this->type->convertToDatabaseValue($badCatalogueId, $this->platform);
    }

    /**
     * @test
     */
    public function itShouldConvertPlainValueToCatalogueId(): void
    {
        $plainUuid = Uuid::uuid4()->toString();

        $expectedResult = new CatalogueId($plainUuid);
        $actualResult = $this->type->convertToPHPValue($plainUuid, $this->platform);

        static::assertEquals($expectedResult, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldConvertDatabaseNullToNullIdentity(): void
    {
        $nullId = null;
        $actualResult = $this->type->convertToPHPValue($nullId, $this->platform);

        self::assertNull($nullId, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldHaveAName(): void
    {
        $expectedName = CatalogueIdType::CATALOGUE_ID;
        $actualName = $this->type->getName();

        static::assertEquals($expectedName, $actualName);
    }
}
