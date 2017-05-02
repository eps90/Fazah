<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use PHPUnit\Framework\TestCase;

class ProjectTest extends TestCase
{
    /**
     * @var Carbon
     */
    private $now;

    /**
     * @var Project
     */
    private $project;

    protected function setUp()
    {
        parent::setUp();

        $this->now = Carbon::create(
            2017,
            1,
            5,
            12,
            15,
            10,
            new \DateTimeZone('UTC')
        );
        Carbon::setTestNow($this->now);
        $this->project = $this->createNewProject();
    }

    protected function tearDown()
    {
        parent::tearDown();

        Carbon::setTestNow();
    }

    /**
     * @test
     */
    public function itShouldCreateNewApplicationWithAName(): void
    {
        $projectName = 'Fazah';
        $project = Project::create($projectName);

        static::assertEquals($projectName, $project->getName());
    }

    /**
     * @test
     */
    public function itShouldInitiallyHaveAnId(): void
    {
        static::assertNotNull($this->project->getProjectId());
    }

    /**
     * @test
     */
    public function itShouldHaveCreationDate(): void
    {
        static::assertEquals($this->now, $this->project->getMetadata()->getCreationTime());
    }

    /**
     * @test
     */
    public function itShouldBeInitiallyEnabled(): void
    {
        static::assertTrue($this->project->getMetadata()->isEnabled());
    }

    /**
     * @test
     */
    public function itShouldHaveInitiallyEmptyUpdateDate(): void
    {
        static::assertNull($this->project->getMetadata()->getUpdateTime());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToRestoreProjectFromGivenValues(): void
    {
        $name = 'My project';
        $projectId = ProjectId::generate();
        $metadata = Metadata::restoreFrom(
            Carbon::instance(new \DateTime('2014-01-15 11:14:00')),
            Carbon::instance(new \DateTime('2014-01-16 01:00:00')),
            true
        );
        $project = Project::restoreFrom($projectId, $name, $metadata);

        static::assertEquals($projectId, $project->getProjectId());
        static::assertEquals($name, $project->getName());
        static::assertEquals($metadata, $project->getMetadata());
    }

    private function createNewProject(): Project
    {
        $projectName = 'Fazah';
        return Project::create($projectName);
    }
}
