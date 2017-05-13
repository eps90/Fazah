<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model\ValueObject;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use PHPUnit\Framework\TestCase;

class MetadataTest extends TestCase
{
    /**
     * @var Carbon
     */
    private $now;

    protected function setUp()
    {
        parent::setUp();

        $this->now = Carbon::parse('2015-01-01 12:00:00');
        Carbon::setTestNow($this->now);
    }

    protected function tearDown()
    {
        parent::tearDown();

        Carbon::setTestNow();
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
            Carbon::now(),
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
            Carbon::now(),
            Carbon::now(),
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
            Carbon::now(),
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
            Carbon::parse('2011-11-12 12:00:00'),
            Carbon::parse('2011-11-12 12:00:00'),
            true
        );
        $newMetadata = $metadata->markAsUpdated();

        static::assertEquals($this->now, $newMetadata->getUpdateTime());
    }
}
