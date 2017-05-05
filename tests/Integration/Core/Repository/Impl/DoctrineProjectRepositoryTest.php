<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository\Impl;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Repository\Query\Builder\FilterByEnabled;
use Eps\Fazah\Core\Repository\Query\Builder\FilterByPhrase;
use Eps\Fazah\Core\Repository\Query\Builder\SelectProjects;
use Eps\Fazah\Core\Repository\Query\Builder\SortByDate;
use Eps\Fazah\Core\Repository\Query\Builder\SortByDefaultDates;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\Impl\DoctrineCriteriaMatcher;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\Core\Repository\Query\Sorting\Sorting;
use Eps\Fazah\Core\Repository\Query\Sorting\SortSet;
use Eps\Fazah\Core\Repository\Impl\DoctrineProjectRepository;
use Eps\Fazah\Core\Repository\Exception\ProjectRepositoryException;
use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class DoctrineProjectRepositoryTest extends WebTestCase
{
    /**
     * @var DoctrineProjectRepository
     */
    private $repository;

    protected function setUp()
    {
        parent::setUp();

        $container = $this->getContainer();
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $builder = new DoctrineCriteriaMatcher($entityManager);
        $builder->addBuilder(new SelectProjects());
        $builder->addBuilder(new FilterByEnabled());
        $builder->addBuilder(new FilterByPhrase());
        $builder->addBuilder(new SortByDefaultDates());
        $builder->addBuilder(new SortByDate());

        $this->repository = new DoctrineProjectRepository($entityManager, $builder);

        $this->loadFixtures([
            AddProjects::class
        ]);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToFindProjectById(): void
    {
        $projectId = new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260');

        $expectedResult = Project::restoreFrom(
            new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
            'my-awesome-project',
            Metadata::restoreFrom(
                Carbon::instance(new \DateTime('2015-01-01 12:00:01')),
                Carbon::instance(new \DateTime('2015-01-02 12:00:01')),
                true
            )
        );
        $actualResult = $this->repository->find($projectId);

        static::assertEquals($expectedResult, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldThrowWhenProjectForGivenIdDoesNotExist(): void
    {
        $this->expectException(ProjectRepositoryException::class);

        $missingProjectId = ProjectId::generate();
        $this->repository->find($missingProjectId);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToAddNewProject(): void
    {
        $project = Project::create('my-project');
        $this->repository->save($project);

        $expectedResult = $project;
        $actualResult = $this->repository->find($project->getProjectId());

        static::assertEquals($expectedResult, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToAddMultipleProjectsAtOnce(): void
    {
        $projectOne = Project::create('my project');
        $projectTwo = Project::create('another project');

        $this->repository->save($projectOne, $projectTwo);

        static::assertEquals($projectOne, $this->repository->find($projectOne->getProjectId()));
        static::assertEquals($projectTwo, $this->repository->find($projectTwo->getProjectId()));
    }

    /**
     * @test
     */
    public function itShouldBeAbleToFetchAllProjects(): void
    {
        $expectedResults = [
            Project::restoreFrom(
                new ProjectId('9b669c76-7a80-4d3f-9191-37c1eda80a05'),
                'disabled-project',
                Metadata::restoreFrom(
                    Carbon::parse('2015-01-01 12:00:03'),
                    Carbon::parse('2015-01-02 12:00:03'),
                    false
                )
            ),
            Project::restoreFrom(
                new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                'yet-another-cool-project',
                Metadata::restoreFrom(
                    Carbon::instance(new \DateTime('2015-01-01 12:00:02')),
                    Carbon::instance(new \DateTime('2015-01-02 12:00:02')),
                    true
                )
            ),
            Project::restoreFrom(
                new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                'my-awesome-project',
                Metadata::restoreFrom(
                    Carbon::instance(new \DateTime('2015-01-01 12:00:01')),
                    Carbon::instance(new \DateTime('2015-01-02 12:00:01')),
                    true
                )
            )
        ];
        $actualResults = $this->repository->findAll();

        static::assertEquals($expectedResults, $actualResults);
    }

    /**
     * @test
     */
    public function itShouldReturnOnlyEnabledProjects(): void
    {
        $filters = [
            'enabled' => false
        ];
        $criteria = new QueryCriteria(Project::class, new FilterSet($filters), new SortSet());
        $expectedResults = [
            Project::restoreFrom(
                new ProjectId('9b669c76-7a80-4d3f-9191-37c1eda80a05'),
                'disabled-project',
                Metadata::restoreFrom(
                    Carbon::parse('2015-01-01 12:00:03'),
                    Carbon::parse('2015-01-02 12:00:03'),
                    false
                )
            )
        ];
        $actualResults = $this->repository->findAll($criteria);

        static::assertEquals($expectedResults, $actualResults);
    }

    /**
     * @test
     */
    public function itShouldFindProjectByName(): void
    {
        $phrase = 'awesome';
        $filters = [
            'phrase' => $phrase
        ];
        $criteria = new QueryCriteria(Project::class, new FilterSet($filters), new SortSet());
        $expectedResult = [
            Project::restoreFrom(
                new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                'my-awesome-project',
                Metadata::restoreFrom(
                    Carbon::instance(new \DateTime('2015-01-01 12:00:01')),
                    Carbon::instance(new \DateTime('2015-01-02 12:00:01')),
                    true
                )
            )
        ];
        $actualResult = $this->repository->findAll($criteria);

        static::assertEquals($expectedResult, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToChangeOrdering(): void
    {
        $ordering = [
            Sorting::asc('updated_at')
        ];
        $criteria = new QueryCriteria(Project::class, new FilterSet(), new SortSet(...$ordering));

        $expectedResults = [
            Project::restoreFrom(
                new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                'my-awesome-project',
                Metadata::restoreFrom(
                    Carbon::instance(new \DateTime('2015-01-01 12:00:01')),
                    Carbon::instance(new \DateTime('2015-01-02 12:00:01')),
                    true
                )
            ),
            Project::restoreFrom(
                new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                'yet-another-cool-project',
                Metadata::restoreFrom(
                    Carbon::instance(new \DateTime('2015-01-01 12:00:02')),
                    Carbon::instance(new \DateTime('2015-01-02 12:00:02')),
                    true
                )
            ),
            Project::restoreFrom(
                new ProjectId('9b669c76-7a80-4d3f-9191-37c1eda80a05'),
                'disabled-project',
                Metadata::restoreFrom(
                    Carbon::parse('2015-01-01 12:00:03'),
                    Carbon::parse('2015-01-02 12:00:03'),
                    false
                )
            )
        ];
        $actualResults = $this->repository->findAll($criteria);

        static::assertEquals($expectedResults, $actualResults);
    }

    /**
     * @test
     */
    public function itShouldFindByMultipleFilters(): void
    {
        $filters = [
            'enabled' => true,
            'phrase' => 'project'
        ];
        $criteria = new QueryCriteria(Project::class, new FilterSet($filters), new SortSet());

        $expectedResults = [
            Project::restoreFrom(
                new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                'yet-another-cool-project',
                Metadata::restoreFrom(
                    Carbon::instance(new \DateTime('2015-01-01 12:00:02')),
                    Carbon::instance(new \DateTime('2015-01-02 12:00:02')),
                    true
                )
            ),
            Project::restoreFrom(
                new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                'my-awesome-project',
                Metadata::restoreFrom(
                    Carbon::instance(new \DateTime('2015-01-01 12:00:01')),
                    Carbon::instance(new \DateTime('2015-01-02 12:00:01')),
                    true
                )
            )
        ];
        $actualResults = $this->repository->findAll($criteria);

        static::assertEquals($expectedResults, $actualResults);
    }

    /**
     * @test
     */
    public function itShouldCombineSortingAndFilteringCapabilitieis(): void
    {
        $filters = [
            'enabled' => true,
            'phrase' => 'project'
        ];
        $ordering = [
            Sorting::asc('created_at')
        ];
        $criteria = new QueryCriteria(Project::class, new FilterSet($filters), new SortSet(...$ordering));

        $expectedResults = [
            Project::restoreFrom(
                new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                'my-awesome-project',
                Metadata::restoreFrom(
                    Carbon::instance(new \DateTime('2015-01-01 12:00:01')),
                    Carbon::instance(new \DateTime('2015-01-02 12:00:01')),
                    true
                )
            ),
            Project::restoreFrom(
                new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                'yet-another-cool-project',
                Metadata::restoreFrom(
                    Carbon::instance(new \DateTime('2015-01-01 12:00:02')),
                    Carbon::instance(new \DateTime('2015-01-02 12:00:02')),
                    true
                )
            )
        ];
        $actualResults = $this->repository->findAll($criteria);

        static::assertEquals($expectedResults, $actualResults);
    }
}
