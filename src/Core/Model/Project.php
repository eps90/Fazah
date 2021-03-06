<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model;

use Assert\Assert;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Model\ValueObject\ProjectConfiguration;

class Project
{
    /**
     * @var ProjectId
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Metadata
     */
    private $metadata;

    /**
     * @var ProjectConfiguration
     */
    private $config;

    private function __construct()
    {
    }

    public static function create(string $name): Project
    {
        $project = new self();
        $project->id = ProjectId::generate();
        $project->name = $name;
        $project->metadata = Metadata::initialize();
        $project->config = ProjectConfiguration::initialize();

        return $project;
    }

    public static function restoreFrom(
        ProjectId $projectId,
        string $name,
        Metadata $metadata,
        ProjectConfiguration $config
    ): Project {
        $project = new self();
        $project->id = $projectId;
        $project->config = $config;
        $project->setName($name);

        $project->metadata = $metadata;

        return $project;
    }

    /**
     * @return ProjectId
     */
    public function getId(): ProjectId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Metadata
     */
    public function getMetadata(): Metadata
    {
        return $this->metadata;
    }

    /**
     * @return ProjectConfiguration
     */
    public function getConfig(): ProjectConfiguration
    {
        return $this->config;
    }

    public function disable(): void
    {
        $this->metadata = $this->metadata->markAsDisabled();
    }

    public function enable(): void
    {
        $this->metadata = $this->metadata->markAsEnabled();
    }

    public function rename(string $newName): void
    {
        $this->setName($newName);
        $this->metadata = $this->metadata->markAsUpdated();
    }

    public function changeAvailableLanguages(array $newLanguages): void
    {
        $this->config = $this->config->changeAvailableLanguages($newLanguages);
        $this->metadata = $this->metadata->markAsUpdated();
    }

    public function updateFromArray(array $updateMap): void
    {
        if (array_key_exists('name', $updateMap)) {
            $this->rename($updateMap['name']);
        }

        if (array_key_exists('available_languages', $updateMap)) {
            $this->changeAvailableLanguages($updateMap['available_languages']);
        }
    }

    private function setName(string $projectName): void
    {
        Assert::that($projectName)
            ->notBlank('Project name cannot be blank')
            ->maxLength(255, 'Project name must not be longer than 255 characters');

        $this->name = $projectName;
    }
}
