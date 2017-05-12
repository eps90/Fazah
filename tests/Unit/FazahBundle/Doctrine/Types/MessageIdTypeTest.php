<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\FazahBundle\Doctrine\Types\MessageIdType;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class MessageIdTypeTest extends TestCase
{
    /**
     * @var MessageIdType
     */
    private $type;

    /**
     * @var AbstractPlatform|\PHPUnit_Framework_MockObject_MockObject
     */
    private $platform;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        if (!Type::hasType(MessageIdType::MESSAGE_ID)) {
            Type::addType(MessageIdType::MESSAGE_ID, MessageIdType::class);
        }
    }


    protected function setUp()
    {
        parent::setUp();

        $this->type = Type::getType(MessageIdType::MESSAGE_ID);
        $this->platform = $this->createMock(AbstractPlatform::class);
    }

    /**
     * @test
     */
    public function itShouldConvertMessageIdToDatabaseValue(): void
    {
        $messageId = MessageId::generate();

        $expectedResult = $messageId->getId();
        $actualResult = $this->type->convertToDatabaseValue($messageId, $this->platform);

        static::assertEquals($expectedResult, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldConvertToDatabaseNullWhenValueIsNull(): void
    {
        $messageId = null;
        $actualResult = $this->type->convertToDatabaseValue($messageId, $this->platform);

        static::assertEquals($messageId, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldThrowWhenInputValueIsNotAMessgeId(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $invalidMessageId = Uuid::uuid4()->toString();
        $this->type->convertToDatabaseValue($invalidMessageId, $this->platform);
    }

    /**
     * @test
     */
    public function itShouldConvertStringUuidToMessageId(): void
    {
        $someUuid = Uuid::uuid4()->toString();

        $expectedResult = new MessageId($someUuid);
        $actualResult = $this->type->convertToPHPValue($someUuid, $this->platform);

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
        $expectedName = MessageIdType::MESSAGE_ID;
        $actualName = $this->type->getName();

        static::assertEquals($expectedName, $actualName);
    }
}
