<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\ApiPlatform\Extension;

use Doctrine\Common\Collections\ArrayCollection;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\FazahBundle\ApiPlatform\Extension\FilterExtension;
use Eps\Fazah\FazahBundle\ApiPlatform\Filter\FilterInterface;
use Eps\Fazah\FazahBundle\ApiPlatform\Filter\FilterProcessor\BooleanFilterProcessor;
use Eps\Fazah\FazahBundle\ApiPlatform\Filter\FilterProcessor\DefaultFilterProcessor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class FilterExtensionTest extends TestCase
{
    /**
     * @var FilterExtension
     */
    private $extension;

    /**
     * @var RequestStack|\PHPUnit_Framework_MockObject_MockObject
     */
    private $requestStack;

    protected function setUp(): void
    {
        parent::setUp();

        $this->requestStack = $this->createMock(RequestStack::class);
        $this->extension = new FilterExtension(
            $this->requestStack,
            new ArrayCollection([$this->createFakeFilter()]),
            new ArrayCollection($this->getFilterProcessors())
        );
    }

    /**
     * @test
     */
    public function itShouldOmitUnsupportedFilters(): void
    {
        $resourceClass = \stdClass::class;
        $queryCriteria = new QueryCriteria($resourceClass);

        $requestQuery = ['my_property' => 'my_value', 'missing_property' => 'invalid_value'];
        $currentRequest = new Request($requestQuery);

        $this->requestStack->expects($this->once())
            ->method('getCurrentRequest')
            ->willReturn($currentRequest);

        $expectedCriteria = new QueryCriteria($resourceClass, new FilterSet([]));

        $this->extension->applyFilters($resourceClass, $queryCriteria);

        static::assertEquals($expectedCriteria, $queryCriteria);
    }

    /**
     * @test
     */
    public function itShouldRunThroughAllTheFiltersAndModifyInputQuery(): void
    {
        $resourceClass = Message::class;
        $queryCriteria = new QueryCriteria($resourceClass);

        $requestQuery = ['my_property' => 'my_value', 'missing_property' => 'invalid_value'];
        $currentRequest = new Request($requestQuery);

        $this->requestStack->expects($this->once())
            ->method('getCurrentRequest')
            ->willReturn($currentRequest);

        $expectedFilters = ['my_property' => 'my_value'];
        $expectedCriteria = new QueryCriteria($resourceClass, new FilterSet($expectedFilters));

        $this->extension->applyFilters($resourceClass, $queryCriteria);

        static::assertEquals($expectedCriteria, $queryCriteria);
    }

    /**
     * @test
     */
    public function itShouldProcessFiltersWithFilterProcessors(): void
    {
        $resourceClass = Message::class;
        $queryCriteria = new QueryCriteria($resourceClass);

        $requestQuery = ['my_boolean_property' => 'true', 'missing_property' => 'invalid_value'];
        $currentRequest = new Request($requestQuery);

        $this->requestStack->expects(static::once())
            ->method('getCurrentRequest')
            ->willReturn($currentRequest);

        $expectedFilters = ['my_boolean_property' => true];
        $expectedCriteria = new QueryCriteria($resourceClass, new FilterSet($expectedFilters));

        $this->extension->applyFilters($resourceClass, $queryCriteria);

        static::assertEquals($expectedCriteria, $queryCriteria);
    }

    private function createFakeFilter(): FilterInterface
    {
        return new class implements FilterInterface {
            public function getAvailableFilters(): array
            {
                return ['my_property'];
            }

            public function supportsResource(string $resourceClass): bool
            {
                return $resourceClass === Message::class;
            }

            public function getDescription(string $resourceClass): array
            {
                return [
                    'my_property' => [
                        'some' => 'example',
                        'values' => 'here',
                        'type' => 'string'
                    ],
                    'my_boolean_property' => [
                        'some' => 'example',
                        'value' => 'here',
                        'type' => 'bool'
                    ]
                ];
            }
        };
    }

    private function getFilterProcessors(): array
    {
        return [
            new BooleanFilterProcessor(),
            new DefaultFilterProcessor()
        ];
    }

}
