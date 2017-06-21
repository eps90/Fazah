<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Project;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Req2CmdBundle\Command\DeserializableCommandInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class EditProject implements DeserializableCommandInterface
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
        $this->projectData = self::resolveOptions($projectData);
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

    public static function fromArray(array $commandProps): self
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired(['project_id', 'project_data']);
        $cmdProps = $resolver->resolve($commandProps);

        $projectData = self::resolveOptions($cmdProps['project_data']);

        return new self(
            new ProjectId((string)$cmdProps['project_id']),
            $projectData
        );
    }

    private static function resolveOptions(array $properties): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefined(['name', 'available_languages']);

        return $resolver->resolve($properties);
    }
}
