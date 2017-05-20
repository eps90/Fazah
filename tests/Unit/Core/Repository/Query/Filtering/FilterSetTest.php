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
    public function itShouldCreateEmptySet(): void
    {
        $filterSet = FilterSet::none();

        static::assertTrue($filterSet->isEmpty());
    }

    /**
     * @test
     */
    public function itShouldReturnAValueByPropertyName(): void
    {
        $expectedResult = 'abc';
        $actualResult = $this->filterSet->getFilter('my_property');

        static::assertEquals($expectedResult, $actualResult);
        static::assertNull($this->filterSet->getFilter('missing_property'));
    }

    /**
     * @test
     */
    public function itShouldBeAbleToDetermineWhetherItContainsFilter(): void
    {
        static::assertTrue($this->filterSet->contains('my_property'));
        static::assertFalse($this->filterSet->contains('missing_filter'));
    }

    /**
     * @test
     */
    public function itShouldDefineWhetherItIsEmpty(): void
    {
        $nonEmptySet = new FilterSet(['aaa' => 'bbb']);
        $emptySet = new FilterSet();

        static::assertFalse($nonEmptySet->isEmpty());
        static::assertTrue($emptySet->isEmpty());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToAddAFilter(): void
    {
        $filterToAdd = ['my_property' => 'my_value'];

        $emptySet = new FilterSet();
        $newFilterSet = $emptySet->addFilter($filterToAdd);

        $expectedSet = new FilterSet($filterToAdd);

        static::assertEquals($expectedSet, $newFilterSet);
    }
}
