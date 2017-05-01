<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\Identity\ProjectId;

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
     * @var Carbon
     */
    private $createdAt;

    /**
     * @var Carbon|null
     */
    private $updatedAt;

    /**
     * @var boolean
     */
    private $enabled;

    public static function create(string $name): Project
    {
        $project = new self();
        $project->projectId = ProjectId::generate();
        $project->name = $name;
        $project->createdAt = Carbon::now();
        $project->enabled = true;

        return $project;
    }

    public static function restoreFrom(
        ProjectId $projectId,
        string $name,
        Carbon $createdAt,
        ?Carbon $updatedAt,
        bool $enabled
    ): Project {
        $project = new self();
        $project->projectId = $projectId;
        $project->name = $name;
        $project->createdAt = $createdAt;
        $project->updatedAt = $updatedAt;
        $project->enabled = $enabled;

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
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
