<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\ApiPlatform\DataProvider;

use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use Doctrine\Common\Collections\ArrayCollection;
use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\CatalogueRepository;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\FazahBundle\ApiPlatform\DataProvider\CatalogueDataProvider;
use Eps\Fazah\FazahBundle\ApiPlatform\Extension\ExtensionInterface;
use PHPUnit\Framework\TestCase;

class CatalogueDataProviderTest extends TestCase
{
    /**
     * @var CatalogueRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $repo;

    /**
     * @var CatalogueDataProvider
     */
    private $provider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repo = $this->createMock(CatalogueRepository::class);
        $this->provider = new CatalogueDataProvider($this->repo);
    }

    /**
     * @test
     */
    public function itShouldNotSupportOtherModelsThanCatalogue(): void
    {
        $this->expectException(ResourceClassNotSupportedException::class);

        $invalidModel = Message::class;
        $this->provider->getCollection($invalidModel);
    }

    /**
     * @test
     */
    public function itShouldCallRepositoryToFetchAllCatalogues(): void
    {
        $foundCatalogues = [
            Catalogue::create('aaa', ProjectId::generate()),
            Catalogue::create('bbb', ProjectId::generate())
        ];
        $this->repo->expects(static::once())
            ->method('findAll')
            ->with(new QueryCriteria(Catalogue::class))
            ->willReturn($foundCatalogues);

        $expectedResult = $foundCatalogues;
        $actualResult = $this->provider->getCollection(Catalogue::class);

        static::assertEquals($expectedResult, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldApplyExtensionsToCriteria(): void
    {
        $extensions = new ArrayCollection([$this->createFilterExtension()]);
        $this->provider = new CatalogueDataProvider($this->repo, $extensions);

        $foundCatalogues = [
            Catalogue::create('aaa', ProjectId::generate()),
            Catalogue::create('bbb', ProjectId::generate())
        ];
        $expectedCriteria = new QueryCriteria(Catalogue::class, new FilterSet(['my_filter' => 'filter_value']));
        $this->repo->expects(static::once())
            ->method('findAll')
            ->with($expectedCriteria)
            ->willReturn($foundCatalogues);

        $expectedResult = $foundCatalogues;
        $actualResult = $this->provider->getCollection(Catalogue::class);

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
