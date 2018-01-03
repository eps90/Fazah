<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\ApiPlatform\Filter\FilterProcessor;

use Eps\Fazah\FazahBundle\ApiPlatform\Filter\FilterProcessor\DefaultFilterProcessor;
use PHPUnit\Framework\TestCase;

class DefaultFilterProcessorTest extends TestCase
{
    /**
     * @var DefaultFilterProcessor
     */
    private $filterProcessor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->filterProcessor = new DefaultFilterProcessor();
    }

    /**
     * @test
     */
    public function itShouldAlwaysSupportFilter(): void
    {
        static::assertTrue($this->filterProcessor->supportsType('anyFilter'));
    }

    /**
     * @test
     */
    public function itShouldReturnSameValue(): void
    {
        $filterValue = 'true';
        static::assertSame($filterValue, $this->filterProcessor->processFiler($filterValue));
    }
}
