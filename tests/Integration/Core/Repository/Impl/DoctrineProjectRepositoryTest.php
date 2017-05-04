<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository\Impl;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
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
        $this->repository = new DoctrineProjectRepository($entityManager);

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
            ),Project::restoreFrom(
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
}
