<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\Model;

use Assert\AssertionFailedException;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Project;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Model\ValueObject\ProjectConfiguration;
use Eps\Fazah\Core\Utils\DateTimeFactory;
use PHPUnit\Framework\TestCase;

class ProjectTest extends TestCase
{
    /**
     * @var \DateTimeImmutable
     */
    private $now;

    /**
     * @var Project
     */
    private $project;

    protected function setUp()
    {
        parent::setUp();

        $this->now = new \DateTimeImmutable('2017-01-05 12:15:10');
        DateTimeFactory::freezeDate($this->now);
        $this->project = $this->createNewProject();
    }

    protected function tearDown()
    {
        parent::tearDown();

        DateTimeFactory::unfreezeDate();
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
        static::assertNotNull($this->project->getId());
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
    public function itShouldHaveInitiallyEmptyConfiguration(): void
    {
        $expectedConfig = ProjectConfiguration::restoreFrom([]);
        static::assertEquals($expectedConfig, $this->project->getConfig());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToRestoreProjectFromGivenValues(): void
    {
        $name = 'My project';
        $projectId = ProjectId::generate();
        $metadata = Metadata::restoreFrom(
            new \DateTimeImmutable('2014-01-15 11:14:00'),
            new \DateTimeImmutable('2014-01-16 01:00:00'),
            true
        );
        $configuration = ProjectConfiguration::restoreFrom(['fr', 'en']);
        $project = Project::restoreFrom($projectId, $name, $metadata, $configuration);

        static::assertEquals($projectId, $project->getId());
        static::assertEquals($name, $project->getName());
        static::assertEquals($metadata, $project->getMetadata());
        static::assertEquals($configuration, $project->getConfig());
    }

    /**
     * @test
     */
    public function itShouldThrowWhenRestoredProjectNameIsTooLong(): void
    {
        $this->expectException(AssertionFailedException::class);
        $this->expectExceptionMessageRegExp('/Project name must not be longer than 255 characters/');

        $invalidName = str_repeat('x', 300);
        Project::restoreFrom(
            ProjectId::generate(),
            $invalidName,
            Metadata::initialize(),
            ProjectConfiguration::initialize()
        );
    }

    /**
     * @test
     */
    public function itShouldBeAbleToDisableAProject(): void
    {
        $project = Project::create('my project');
        $project->disable();

        static::assertFalse($project->getMetadata()->isEnabled());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToEnableAProject(): void
    {
        $project = Project::restoreFrom(
            ProjectId::generate(),
            'my project',
            Metadata::restoreFrom(
                DateTimeFactory::now(),
                DateTimeFactory::now(),
                false
            ),
            ProjectConfiguration::restoreFrom(['fr', 'en', 'pl'])
        );
        $project->enable();

        static::assertTrue($project->getMetadata()->isEnabled());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToRenameTheProject(): void
    {
        $newProjectName = 'new project';
        $this->project->rename($newProjectName);

        static::assertEquals($newProjectName, $this->project->getName());
    }

    /**
     * @test
     */
    public function itShouldNotUpdateProjectNameWithEmptyString(): void
    {
        $this->expectException(AssertionFailedException::class);
        $this->expectExceptionMessageRegExp('/Project name cannot be blank/');

        $invalidProjectName = '';
        $this->project->rename($invalidProjectName);
    }

    /**
     * @test
     */
    public function itShouldThrowWhenNewNameIsLongerThan255Chars(): void
    {
        $this->expectException(AssertionFailedException::class);
        $this->expectExceptionMessageRegExp('/Project name must not be longer than 255 characters/');

        $invalidProjectName = str_repeat('x', 400);
        $this->project->rename($invalidProjectName);
    }

    /**
     * @test
     */
    public function itShouldSetNewUpdateTimeWhenUpdatingName(): void
    {
        $this->project->rename('new project');

        static::assertEquals($this->now, $this->project->getMetadata()->getUpdateTime());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToUpdateAvailableLanguages(): void
    {
        $newLanguages = ['en', 'es', 'fr', 'pl', 'ru'];
        $this->project->changeAvailableLanguages($newLanguages);

        static::assertEquals($newLanguages, $this->project->getConfig()->getAvailableLanguages());
    }

    /**
     * @test
     */
    public function itShouldChangeUpdateTimeWhenAvailableLanguagesChange(): void
    {
        $newLanguages = ['en', 'es', 'fr', 'pl', 'ru'];
        $this->project->changeAvailableLanguages($newLanguages);

        static::assertEquals($this->now, $this->project->getMetadata()->getUpdateTime());
    }

    /**
     * @test
     */
    public function itShouldBeAbleToUpdateProjectFromArray(): void
    {
        $newProjectName = 'new project';
        $newLanguages = ['en', 'fr', 'pl'];
        $updateMap = [
            'name' => $newProjectName,
            'available_languages' => $newLanguages
        ];
        $this->project->updateFromArray($updateMap);

        static::assertEquals($newProjectName, $this->project->getName());
        static::assertEquals($newLanguages, $this->project->getConfig()->getAvailableLanguages());
    }

    /**
     * @test
     */
    public function itShouldChangeUpdateTimeWhenUpdatedFromArray(): void
    {
        $newProjectName = 'new project';
        $updateMap = [
            'name' => $newProjectName
        ];
        $this->project->updateFromArray($updateMap);

        static::assertEquals($this->now, $this->project->getMetadata()->getUpdateTime());
    }

    /**
     * @test
     */
    public function itShouldNotChangeUpdateTimeWhenNothingIsUpdated(): void
    {
        $updateMap = [];
        $this->project->updateFromArray($updateMap);

        static::assertNull($this->project->getMetadata()->getUpdateTime());
    }

    private function createNewProject(): Project
    {
        $projectName = 'Fazah';
        return Project::create($projectName);
    }
}
