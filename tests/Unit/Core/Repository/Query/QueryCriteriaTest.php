<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Repository\Query;

use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\Core\Repository\Query\Sorting\Sorting;
use Eps\Fazah\Core\Repository\Query\Sorting\SortSet;
use PHPUnit\Framework\TestCase;

class QueryCriteriaTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCreateDefaultFilterSetWhenNullPassed(): void
    {
        $sorting = [
            Sorting::asc('my_field'),
            Sorting::asc('other_field')
        ];

        $expectedCriteria = new QueryCriteria(
            Message::class,
            FilterSet::none(),
            new SortSet(...$sorting)
        );
        $actualCriteria = new QueryCriteria(Message::class, null, new SortSet(...$sorting));

        static::assertEquals($expectedCriteria, $actualCriteria);
    }

    /**
     * @test
     */
    public function itShouldCreateEmptySortingWhenNullIsPassed(): void
    {
        $filters = [
            'my_property' => 'aaa'
        ];

        $expectedCriteria = new QueryCriteria(Message::class, new FilterSet($filters), new SortSet());
        $actualCriteria = new QueryCriteria(Message::class, new FilterSet($filters), null);

        static::assertEquals($expectedCriteria, $actualCriteria);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToCreateEmptyCriteria(): void
    {
        $expectedCriteria = new QueryCriteria(Message::class, new FilterSet(), new SortSet());
        $actualCriteria = new QueryCriteria(Message::class);

        static::assertEquals($expectedCriteria, $actualCriteria);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToAddFilter(): void
    {
        $filterToAdd = ['my_property' => 'my_value'];
        $initialCriteria = new QueryCriteria(Message::class);
        $initialCriteria->addFilter($filterToAdd);

        $expectedCriteria = new QueryCriteria(Message::class, new FilterSet($filterToAdd));

        static::assertEquals($expectedCriteria, $initialCriteria);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToAddSorting(): void
    {
        $sortingToAdd = Sorting::asc('bacecadada');
        $initialCriteria = new QueryCriteria(Message::class);
        $initialCriteria->addSorting($sortingToAdd);

        $expectedCriteria = new QueryCriteria(Message::class, null, new SortSet($sortingToAdd));

        static::assertEquals($expectedCriteria, $initialCriteria);
    }
}
