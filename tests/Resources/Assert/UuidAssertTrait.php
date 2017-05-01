<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Resources\Assert;

use PHPUnit\Framework\Assert;
use Ramsey\Uuid\Uuid;

trait UuidAssertTrait
{
    protected function assertValidUuid(string $uuid): void
    {
        Assert::assertTrue(Uuid::isValid($uuid));
    }
}
