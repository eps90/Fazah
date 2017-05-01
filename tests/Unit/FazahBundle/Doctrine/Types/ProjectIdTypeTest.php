<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\FazahBundle\Doctrine\Types\ProjectIdType;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ProjectIdTypeTest extends TestCase
{
    /**
     * @var ProjectIdType
     */
    private $type;

    /**
     * @var AbstractPlatform|\PHPUnit_Framework_MockObject_MockObject
     */
    private $platform;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        if (!Type::hasType(ProjectIdType::PROJECT_ID)) {
            Type::addType(ProjectIdType::PROJECT_ID, ProjectIdType::class);
        }
    }

    protected function setUp()
    {
        parent::setUp();

        $this->type = Type::getType(ProjectIdType::PROJECT_ID);
        $this->platform = $this->createMock(AbstractPlatform::class);
    }

    /**
     * @test
     */
    public function itShouldConvertProjectIdToString(): void
    {
        $projectId = ProjectId::generate();

        $expectedResult = $projectId->getId();
        $actualResult = $this->type->convertToDatabaseValue($projectId, $this->platform);

        static::assertEquals($expectedResult, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldThrowWhenInputIsNotAProjectId(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $invalidProjectId = Uuid::uuid4()->toString();
        $this->type->convertToDatabaseValue($invalidProjectId, $this->platform);
    }

    /**
     * @test
     */
    public function itShouldConvertUuidToProjectId(): void
    {
        $plainProjectId = Uuid::uuid4()->toString();

        $expectedResult = new ProjectId($plainProjectId);
        $actualResult = $this->type->convertToPHPValue($plainProjectId, $this->platform);

        static::assertEquals($expectedResult, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldHaveAName(): void
    {
        $expectedName = ProjectIdType::PROJECT_ID;
        $actualName = $this->type->getName();

        static::assertEquals($expectedName, $actualName);
    }
}
