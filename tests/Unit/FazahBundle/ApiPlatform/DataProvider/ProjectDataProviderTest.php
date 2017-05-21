<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\ApiPlatform\DataProvider;

use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use Doctrine\Common\Collections\ArrayCollection;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Repository\ProjectRepository;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\FazahBundle\ApiPlatform\DataProvider\ProjectDataProvider;
use Eps\Fazah\FazahBundle\ApiPlatform\Extension\ExtensionInterface;
use PHPUnit\Framework\TestCase;

class ProjectDataProviderTest extends TestCase
{
    /**
     * @var ProjectRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $repo;

    /**
     * @var ProjectDataProvider
     */
    private $provider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repo = $this->createMock(ProjectRepository::class);
        $this->provider = new ProjectDataProvider($this->repo);
    }

    /**
     * @test
     */
    public function itShouldNotSupportOtherModelsThanProject(): void
    {
        $this->expectException(ResourceClassNotSupportedException::class);

        $invalidModel = Message::class;
        $this->provider->getCollection($invalidModel);
    }

    /**
     * @test
     */
    public function itShouldCallRepositoryToFetchAllProjects(): void
    {
        $foundProjects = [
            Project::create('aaa'),
            Project::create('bbb'),
        ];
        $this->repo->expects(static::once())
            ->method('findAll')
            ->with(new QueryCriteria(Project::class))
            ->willReturn($foundProjects);

        $expectedResult = $foundProjects;
        $actualResult = $this->provider->getCollection(Project::class);

        static::assertEquals($expectedResult, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldApplyExtensionsToCriteria(): void
    {
        $extensions = new ArrayCollection([$this->createFilterExtension()]);
        $this->provider = new ProjectDataProvider($this->repo, $extensions);
        
        $foundProjects = [
            Project::create('aaa'),
            Project::create('bbb'),
        ];
        $expectedCriteria = new QueryCriteria(Project::class, new FilterSet(['my_filter' => 'filter_value']));
        $this->repo->expects(static::once())
            ->method('findAll')
            ->with($expectedCriteria)
            ->willReturn($foundProjects);

        $expectedResult = $foundProjects;
        $actualResult = $this->provider->getCollection(Project::class);

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
