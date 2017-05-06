<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\ValueObject\Metadata;

class Project
{
    /**
     * @var ProjectId
     */
    private $projectId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Metadata
     */
    private $metadata;

    public static function create(string $name): Project
    {
        $project = new self();
        $project->projectId = ProjectId::generate();
        $project->name = $name;
        $project->metadata = Metadata::initialize();

        return $project;
    }

    public static function restoreFrom(
        ProjectId $projectId,
        string $name,
        Metadata $metadata
    ): Project {
        $project = new self();
        $project->projectId = $projectId;
        $project->name = $name;
        $project->metadata = $metadata;

        return $project;
    }

    /**
     * @return ProjectId
     */
    public function getProjectId(): ProjectId
    {
        return $this->projectId;
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

    public function disable(): void
    {
        $this->metadata = $this->metadata->markAsDisabled();
    }

    public function enable(): void
    {
        $this->metadata = $this->metadata->markAsEnabled();
    }
}
