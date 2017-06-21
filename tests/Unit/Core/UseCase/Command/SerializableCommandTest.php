<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command;

use Eps\Req2CmdBundle\Command\DeserializableCommandInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;

abstract class SerializableCommandTest extends TestCase
{
    abstract public function validInputProperties(): array;

    abstract public function invalidInputProperties(): array;

    abstract public function getCommandClass(): string;

    /**
     * @test
     * @dataProvider validInputProperties
     */
    public function itShouldBeAbleToCreateFromArray(array $inputProps, DeserializableCommandInterface $expectedCommand): void
    {
        $actualCommand =  call_user_func($this->getCommandClass() . '::fromArray', $inputProps);
        static::assertEquals($expectedCommand, $actualCommand);
    }

    /**
     * @test
     * @dataProvider invalidInputProperties
     */
    public function itShouldThrowWhenItMissesAName(
        array $inputProps,
        string $exceptionClass = MissingOptionsException::class
    ): void
    {
        $this->expectException($exceptionClass);
        call_user_func($this->getCommandClass() . '::fromArray', $inputProps);
    }
}
