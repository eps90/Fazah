<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\ApiPlatform\Filter\FilterProcessor;

use Eps\Fazah\FazahBundle\ApiPlatform\Filter\FilterProcessor\BooleanFilterProcessor;
use PHPUnit\Framework\TestCase;

class BooleanFilterProcessorTest extends TestCase
{
    /**
     * @var BooleanFilterProcessor
     */
    private $filterProcessor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->filterProcessor = new BooleanFilterProcessor();
    }

    /**
     * @test
     * @dataProvider allowedDataProvider
     */
    public function itShouldSupportBoolFilterTypesOnly(string $inputType): void
    {
        static::assertTrue($this->filterProcessor->supportsType($inputType));
    }

    /**
     * @test
     * @dataProvider processDataProvider
     */
    public function itShouldReturnBooleanOfInputValue($inputValue, $expected): void
    {
        static::assertEquals($expected, $this->filterProcessor->processFiler($inputValue));
    }

    public function allowedDataProvider()
    {
        yield ['boolean'];
        yield ['bool'];
        yield ['Bool'];
        yield ['Boolean'];
    }

    public function processDataProvider()
    {
        yield 'true' => ['true', true];
        yield 'false' => ['false', false];
        yield 'number - 1' => ['1', true];
        yield 'number - 0' => ['0', false];
        yield 'TRUE' => ['TRUE', true];
        yield 'FALSE' => ['FALSE', false];
        yield 'any string' => ['any string', true];
        yield '' => ['', false];
        yield 'null' => [null, false];
    }
}
