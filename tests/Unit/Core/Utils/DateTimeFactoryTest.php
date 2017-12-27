<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Utils;

use Eps\Fazah\Core\Utils\DateTimeFactory;
use PHPUnit\Framework\TestCase;

class DateTimeFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCreateNewDateTimeObject(): void
    {
        $newDate = DateTimeFactory::now();
        self::assertInstanceOf(\DateTimeImmutable::class, $newDate);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToFreezeTheDate(): void
    {
        $dateToFreeze = new \DateTimeImmutable('2012-01-01 12:00:00');
        DateTimeFactory::freezeDate($dateToFreeze);

        $createdDate = DateTimeFactory::now();
        self::assertEquals($dateToFreeze, $createdDate);
    }
}
