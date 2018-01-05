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
        static::assertEquals(Pagination::DEFAULT_PAGE, $emptyPagination->getPage());
        static::assertEquals(Pagination::DEFAULT_SIZE, $emptyPagination->getElementsPerPage());
    }
}
