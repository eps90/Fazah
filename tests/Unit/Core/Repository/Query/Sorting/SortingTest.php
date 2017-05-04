<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Repository\Query\Sorting;

use Eps\Fazah\Core\Repository\Query\Sorting\Sorting;
use PHPUnit\Framework\TestCase;

class SortingTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCreateSortingObjectForFieldWithAscendingDirection(): void
    {
        $field = 'my_property';
        $sorting = Sorting::asc($field);

        $expectedResult = new Sorting($field, Sorting::ASCENDING);

        static::assertEquals($expectedResult, $sorting);
    }

    /**
     * @test
     */
    public function itShouldCreateSortingObjectForFieldWithDescendintDirection(): void
    {
        $field = 'my_property';
        $sorting = Sorting::desc($field);

        $expectedResult = new Sorting($field, Sorting::DESCENDING);
        static::assertEquals($expectedResult, $sorting);
    }

    /**
     * @test
     */
    public function itShouldCreateAscendingSortingByDefault(): void
    {
        $field = 'my_property';
        $sorting = new Sorting($field);
        $expectedResult = new Sorting($field, Sorting::ASCENDING);

        static::assertEquals($expectedResult, $sorting);
    }

    /**
     * @test
     */
    public function itShouldCreateAscendingSortingWhenFieldStartsWithPlus(): void
    {
        $field = '+my_property';
        $sorting = new Sorting($field);
        $expectedResult = new Sorting('my_property', Sorting::ASCENDING);

        static::assertEquals($expectedResult, $sorting);
    }

    /**
     * @test
     */
    public function itShouldCreateDescendingSortingWhenFieldStartsWithMinus(): void
    {
        $field = '-my_property';
        $sorting = new Sorting($field);
        $expectedResult = new Sorting('my_property', Sorting::DESCENDING);

        static::assertEquals($expectedResult, $sorting);
    }
}
