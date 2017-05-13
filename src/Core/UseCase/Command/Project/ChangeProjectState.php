<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Project;

use Eps\Fazah\Core\Model\Identity\ProjectId;

final class ChangeProjectState
{
    /**
     * @var ProjectId
     */
    private $projectId;

    /**
     * @var bool
     */
    private $shouldBeEnabled;

    public function __construct(ProjectId $projectId, bool $shouldBeEnabled)
    {
        $this->projectId = $projectId;
        $this->shouldBeEnabled = $shouldBeEnabled;
    }

    /**
     * @return ProjectId
     */
    public function getProjectId(): ProjectId
    {
        return $this->projectId;
    }

    /**
     * @return bool
     */
    public function shouldBeEnabled(): bool
    {
        return $this->shouldBeEnabled;
    }
}
