<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\ApiPlatform\Extension;

use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\Query\Pagination\Pagination;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\FazahBundle\ApiPlatform\Extension\PagerExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class PagerExtensionTest extends TestCase
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var PagerExtension
     */
    private $extension;

    protected function setUp(): void
    {
        parent::setUp();

        $this->requestStack = new RequestStack();
        $this->extension = new PagerExtension($this->requestStack);
    }

    /**
     * @test
     */
    public function itShouldSetPaginationParamsInCriteriaObject(): void
    {
        $requestParams = ['page' => '1', 'limit' => '43'];
        $request = new Request($requestParams);
        $this->requestStack->push($request);

        $resourceClass = Message::class;
        $queryCriteria = new QueryCriteria($resourceClass);
        $this->extension->applyFilters($resourceClass, $queryCriteria);

        $expectedPagination = new Pagination(1, 43);
        static::assertEquals($expectedPagination, $queryCriteria->getPagination());
    }

    /**
     * @test
     */
    public function itShouldSetDefaultParamsWhenPaginationIsNotSet(): void
    {
        $request = new Request();
        $this->requestStack->push($request);

        $resourceClass = Message::class;
        $queryCriteria = new QueryCriteria($resourceClass);
        $this->extension->applyFilters($resourceClass, $queryCriteria);

        $expectedPagination = Pagination::none();
        static::assertEquals($expectedPagination, $queryCriteria->getPagination());
    }
}
