<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Repository\DoctrineProjectRepository;
use Eps\Fazah\Core\Repository\Exception\ProjectRepositoryException;
use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use PHPUnit\Framework\TestCase;

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
            Carbon::instance(new \DateTime('2015-01-01 12:00:01')),
            Carbon::instance(new \DateTime('2015-01-02 12:00:01')),
            true
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
        $this->repository->add($project);

        $expectedResult = $project;
        $actualResult = $this->repository->find($project->getProjectId());

        static::assertEquals($expectedResult, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToFetchAllProjects(): void
    {
        $expectedResults = [
            Project::restoreFrom(
                new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260'),
                'my-awesome-project',
                Carbon::instance(new \DateTime('2015-01-01 12:00:01')),
                Carbon::instance(new \DateTime('2015-01-02 12:00:01')),
                true
            ),
            Project::restoreFrom(
                new ProjectId('4c3339d3-ad42-4614-bd83-8585cea0e54e'),
                'yet-another-cool-project',
                Carbon::instance(new \DateTime('2015-01-01 12:00:02')),
                Carbon::instance(new \DateTime('2015-01-02 12:00:02')),
                true
            )
        ];
        $actualResults = $this->repository->findAll();

        static::assertEquals($expectedResults, $actualResults);
    }
}
