<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Repository\Query\Sorting;

use Eps\Fazah\Core\Repository\Query\Sorting\Sorting;
use Eps\Fazah\Core\Repository\Query\Sorting\SortSet;
use PHPUnit\Framework\TestCase;

class SortSetTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeAbleToBeConstructedWithSortingObjects(): void
    {
        $sortingObjects = [
            Sorting::asc('my_property'),
            Sorting::desc('other_property')
        ];
        $sortSet = new SortSet(...$sortingObjects);

        $expectedSorting = $sortingObjects;
        $actualSorting = $sortSet->getFieldsSorting();

        static::assertEquals($expectedSorting, $actualSorting);
    }

    /**
     * @test
     */
    public function itShouldCreateEmptySortSet(): void
    {
        $sortSet = SortSet::none();

        static::assertTrue($sortSet->isEmpty());
    }

    /**
     * @test
     */
    public function itShouldThrowWhenInputObjectIsNotSortingObject(): void
    {
        $this->expectException(\Error::class);

        $sortingObjects = [
            Sorting::asc('my_property'),
            new SortSet()
        ];
        new SortSet(...$sortingObjects);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToDetermineWhetherSetIsEmpty(): void
    {
        $emptySortSet = new SortSet();
        $notEmptySortSet = new SortSet(...[
            Sorting::desc('my_property')
        ]);

        static::assertTrue($emptySortSet->isEmpty());
        static::assertFalse($notEmptySortSet->isEmpty());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToDetermineWhetherSortingPropertyExistsInSet(): void
    {
        $sortSet = new SortSet(...[
            Sorting::asc('my_property')
        ]);

        static::assertTrue($sortSet->contains('my_property'));
        static::assertFalse($sortSet->contains('missing_property'));
    }

    /**
     * @test
     */
    public function itShouldGetSortingObjectByName(): void
    {
        $propertyToFind = Sorting::asc('my_property');
        $sortSet = new SortSet(...[
            Sorting::desc('dont look at this'),
            $propertyToFind,
            Sorting::asc('here as well')
        ]);
        $foundProperty = $sortSet->findField('my_property');

        static::assertEquals($propertyToFind, $foundProperty);
    }

    /**
     * @test
     */
    public function itShouldReturnNullWhenSortingFieldHasntBeenFound(): void
    {
        $sortSet = new SortSet();
        static::assertNull($sortSet->findField('missing_property'));
    }

    /**
     * @test
     */
    public function itShouldBeAbleToAddNewSorting(): void
    {
        $sortSet = new SortSet();
        $sortingToAdd = Sorting::asc('aaaa');

        $newSet = $sortSet->addSorting($sortingToAdd);

        $expectedSorting = new SortSet(...[$sortingToAdd]);

        static::assertEquals($expectedSorting, $newSet);
    }
}
