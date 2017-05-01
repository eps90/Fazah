<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model\Identity;

use Eps\Fazah\Core\Model\Identity\Identity;
use Eps\Fazah\Tests\Resources\Assert\UuidAssertTrait;
use PHPUnit\Framework\TestCase;

abstract class BaseIdentityTest extends TestCase
{
    use UuidAssertTrait;

    protected abstract function getIdentityClass(): string;

    protected abstract function getGenerateMethodName(): string;

    /**
     * @test
     */
    public function itShouldGenerateUniqueId(): void
    {
        $identity = $this->callGenerationMethod();

        $this->assertValidUuid($identity->getId());
    }

    /**
     * @test
     */
    public function itShouldGenerateDifferentIdEachTimeCalled(): void
    {
        $firstIdentity = $this->callGenerationMethod();
        $secondIdentity= $this->callGenerationMethod();

        static::assertNotEquals($firstIdentity, $secondIdentity);
    }

    /**
     * @test
     */
    public function itShouldBeConvertableToString(): void
    {
        $identity = $this->callGenerationMethod();

        $expectedResult = $identity->getId();
        $actualResult = $identity->__toString();

        static::assertEquals($expectedResult, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldBeConvertableToJson(): void
    {
        $identity = $this->callGenerationMethod();

        $expectedResult = $identity->getId();
        $actualResult = $identity->jsonSerialize();

        static::assertEquals($expectedResult, $actualResult);
    }

    private function callGenerationMethod(): Identity
    {
        $identityClass = $this->getIdentityClass();
        $generateMethodName = $this->getGenerateMethodName();

        return $identityClass::$generateMethodName();
    }
}
