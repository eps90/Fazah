<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Project;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\UseCase\Command\SerializableCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ChangeProjectState implements SerializableCommand
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

    public static function fromArray(array $commandProps): self
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired(['project_id', 'enabled']);
        $resolver->setAllowedTypes('enabled', 'bool');
        $props = $resolver->resolve($commandProps);

        return new self(
            new ProjectId((string)$props['project_id']),
            (bool)$props['enabled']
        );
    }
}
