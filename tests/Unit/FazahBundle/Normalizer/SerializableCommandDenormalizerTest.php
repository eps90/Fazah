<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\Normalizer;

use Eps\Fazah\FazahBundle\Normalizer\SerializableCommandDenormalizer;
use Eps\Fazah\Tests\Resources\Fixtures\SerializableCommand\DummySerializableCommand;
use PHPUnit\Framework\TestCase;

class SerializableCommandDenormalizerTest extends TestCase
{
    /**
     * @var SerializableCommandDenormalizer
     */
    private $denormalizer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->denormalizer = new SerializableCommandDenormalizer();
    }

    /**
     * @test
     */
    public function itShouldSupportOnlySerializableCommandClass(): void
    {
        $supportedClass = DummySerializableCommand::class;
        $unsupportedClass = \stdClass::class;

        static::assertTrue($this->denormalizer->supportsDenormalization([], $supportedClass));
        static::assertFalse($this->denormalizer->supportsDenormalization([], $unsupportedClass));
    }

    /**
     * @test
     */
    public function itShouldCallStaticConstructorOnSerializableCommand(): void
    {
        $denormalizedData = [
            'name' => 'My command',
            'opts' => [
                'a' => 1,
                'b' => 32
            ]
        ];
        $className = DummySerializableCommand::class;

        $actualResult = $this->denormalizer->denormalize($denormalizedData, $className);
        $expectedResult = new DummySerializableCommand('My command', ['a' => 1, 'b' => 32]);

        static::assertEquals($expectedResult, $actualResult);
    }
}
