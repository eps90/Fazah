<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command;

use Eps\Fazah\Core\Model\Identity\ProjectId;

final class CreateCatalogue
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var ProjectId
     */
    private $projectId;

    public function __construct(string $name, ProjectId $projectId)
    {
        $this->name = $name;
        $this->projectId = $projectId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ProjectId
     */
    public function getProjectId(): ProjectId
    {
        return $this->projectId;
    }
}
