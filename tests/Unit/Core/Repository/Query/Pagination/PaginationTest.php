<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Repository\Query\Pagination;

use Eps\Fazah\Core\Repository\Query\Pagination\Pagination;
use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldBeAbleToCreateAnEmptyPagination(): void
    {
        $emptyPagination = Pagination::none();
        static::assertEquals(1, $emptyPagination->getPage());
        static::assertEquals(0, $emptyPagination->getElementsPerPage());
    }
}
