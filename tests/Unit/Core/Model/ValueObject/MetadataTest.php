<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model\ValueObject;

use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Utils\DateTimeFactory;
use PHPUnit\Framework\TestCase;

class MetadataTest extends TestCase
{
    /**
     * @var \DateTimeImmutable
     */
    private $now;

    protected function setUp()
    {
        parent::setUp();

        $this->now = new \DateTimeImmutable('2015-01-01 12:00:00');
        DateTimeFactory::freezeDate($this->now);
    }

    protected function tearDown()
    {
        parent::tearDown();

        DateTimeFactory::unfreezeDate();
    }

    /**
     * @test
     */
    public function itShouldBeAbleToSetDisabledState(): void
    {
        $metadata = Metadata::initialize();
        $newMetadata = $metadata->markAsDisabled();

        static::assertFalse($newMetadata->isEnabled());
    }

    /**
     * @test
     */
    public function itShouldChangeUpdateTimeOnStateChangeToDisabled(): void
    {
        $metadata = Metadata::restoreFrom(
            DateTimeFactory::now(),
            null,
            false
        );
        $newMetadata = $metadata->markAsDisabled();

        static::assertEquals($this->now, $newMetadata->getUpdateTime());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToSetEnabledState(): void
    {
        $metadata = Metadata::restoreFrom(
            DateTimeFactory::now(),
            DateTimeFactory::now(),
            false
        );
        $newMetadata = $metadata->markAsEnabled();

        static::assertTrue($newMetadata->isEnabled());
    }

    /**
     * @test
     */
    public function itShouldChangeUpdateTimeOnStateChangeToEnabled(): void
    {
        $metadata = Metadata::restoreFrom(
            DateTimeFactory::now(),
            null,
            false
        );
        $newMetadata = $metadata->markAsEnabled();

        static::assertEquals($this->now, $newMetadata->getUpdateTime());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToMarkAsUpdated(): void
    {
        $metadata = Metadata::restoreFrom(
            new \DateTimeImmutable('2011-11-12 12:00:00'),
            new \DateTimeImmutable('2011-11-12 12:00:00'),
            true
        );
        $newMetadata = $metadata->markAsUpdated();

        static::assertEquals($this->now, $newMetadata->getUpdateTime());
    }
}
