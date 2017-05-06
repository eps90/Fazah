<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model\ValueObject;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use PHPUnit\Framework\TestCase;

class MetadataTest extends TestCase
{
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
}