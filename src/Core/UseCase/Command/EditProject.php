<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class EditProject
{
    /**
     * @var ProjectId
     */
    private $projectId;

    /**
     * @var array
     */
    private $projectData;

    public function __construct(ProjectId $projectId, array $projectData)
    {
        $this->projectData = $this->resolveOptions($projectData);
        $this->projectId = $projectId;
    }

    /**
     * @return ProjectId
     */
    public function getProjectId(): ProjectId
    {
        return $this->projectId;
    }

    /**
     * @return array
     */
    public function getProjectData(): array
    {
        return $this->projectData;
    }

    private function resolveOptions(array $properties): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefined(['name']);

        return $resolver->resolve($properties);
    }
}
