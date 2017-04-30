<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Project
{
    /**
     * @var UuidInterface
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

    public static function create($name): self
    {
        $project = new self();
        $project->projectId = Uuid::uuid4();
        $project->name = $name;
        $project->createdAt = Carbon::now();
        $project->enabled = true;

        return $project;
    }

    /**
     * @return UuidInterface
     */
    public function getProjectId(): UuidInterface
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
