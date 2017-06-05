<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\ApiPlatform\DataProvider;

use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use Doctrine\Common\Collections\ArrayCollection;
use Eps\Fazah\Core\Repository\Exception\RepositoryManagerException;
use Eps\Fazah\Core\Repository\Manager\RepositoryManagerInterface;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\Core\Repository\RepositoryInterface;
use Eps\Fazah\FazahBundle\ApiPlatform\DataProvider\RepositoryDataProvider;
use Eps\Fazah\FazahBundle\ApiPlatform\Extension\ExtensionInterface;
use PHPUnit\Framework\TestCase;

class RepositoryDataProviderTest extends TestCase
{
    /**
     * @var RepositoryDataProvider
     */
    private $dataProvider;

    /**
     * @var RepositoryManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $repoManager;

    /**
     * @var ArrayCollection
     */
    private $extensions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repoManager = $this->createMock(RepositoryManagerInterface::class);
        $this->extensions = new ArrayCollection();
        $this->dataProvider = new RepositoryDataProvider($this->repoManager, $this->extensions);
    }

    /**
     * @test
     */
    public function itShouldThrowResourceNotSupportedExceptionOnNotFoundRepo(): void
    {
        $this->expectException(ResourceClassNotSupportedException::class);

        $invalidResource = \stdClass::class;
        $this->repoManager->expects(static::once())
            ->method('getRepository')
            ->with($invalidResource)
            ->willThrowException(new RepositoryManagerException());

        $this->dataProvider->getCollection($invalidResource);
    }

    /**
     * @test
     */
    public function itShouldReturnAllResultFromFoundRepository(): void
    {
        $resourceClass = \stdClass::class;

        $foundRepo = $this->createMock(RepositoryInterface::class);
        $this->repoManager->expects(static::once())
            ->method('getRepository')
            ->with($resourceClass)
            ->willReturn($foundRepo);

        $foundResults = ['o1', 'o2'];
        $foundRepo->expects(static::once())
            ->method('findAll')
            ->with(new QueryCriteria($resourceClass))
            ->willReturn($foundResults);

        $expectedResults = $foundResults;
        $actualResults = $this->dataProvider->getCollection($resourceClass);

        static::assertEquals($expectedResults, $actualResults);
    }

    /**
     * @test
     */
    public function itShouldApplyAllExtensions(): void
    {
        $this->extensions->add($this->createFilterExtension());

        $resourceClass = \stdClass::class;

        $foundRepo = $this->createMock(RepositoryInterface::class);
        $this->repoManager->expects(static::once())
            ->method('getRepository')
            ->with($resourceClass)
            ->willReturn($foundRepo);

        $expectedCriteria = new QueryCriteria($resourceClass, new FilterSet(['my_filter' => 'filter_value']));
        $foundResults = ['o1', 'o2'];
        $foundRepo->expects(static::once())
            ->method('findAll')
            ->with($expectedCriteria)
            ->willReturn($foundResults);

        $expectedResult = $foundResults;
        $actualResult = $this->dataProvider->getCollection($resourceClass);

        static::assertEquals($expectedResult, $actualResult);
    }

    private function createFilterExtension(): ExtensionInterface
    {
        return new class implements ExtensionInterface {
            public function applyFilters(string $resourceClass, QueryCriteria $criteria): void
            {
                $criteria->addFilter(['my_filter' => 'filter_value']);
            }
        };
    }
}
