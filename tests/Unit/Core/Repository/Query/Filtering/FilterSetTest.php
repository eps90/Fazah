<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Repository\Query\Filtering;

use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use PHPUnit\Framework\TestCase;

class FilterSetTest extends TestCase
{
    /**
     * @var FilterSet
     */
    private $filterSet;

    protected function setUp()
    {
        parent::setUp();

        $this->filterSet = new FilterSet([
            'my_property' => 'abc'
        ]);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToDeremineWhetherFilterPropertyExists(): void
    {
        static::assertTrue(isset($this->filterSet['my_property']));
        static::assertFalse(isset($this->filterSet['missing_property']));
    }

    /**
     * @test
     */
    public function itShouldReturnAValueByIndex(): void
    {
        $expectedResult = 'abc';
        $actualResult = $this->filterSet['my_property'];

        static::assertEquals($expectedResult, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldNotModifuyValuesByArrayIndices(): void
    {
        $this->filterSet['my_property'] = 'bca';

        static::assertEquals('abc', $this->filterSet['my_property']);
    }

    /**
     * @test
     */
    public function itShouldNotBeAbleToRemoveValuesWithUnsetFunction(): void
    {
        unset($this->filterSet['my_property']);

        static::assertEquals('abc', $this->filterSet['my_property']);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToDetermineWhetherItContainsFilter(): void
    {
        static::assertTrue($this->filterSet->contains('my_property'));
        static::assertFalse($this->filterSet->contains('missing_filter'));
    }
}
