<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Project;

use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Req2CmdBundle\Command\DeserializableCommandInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class DeleteProject implements DeserializableCommandInterface
{
    /**
     * @var ProjectId
     */
    private $projectId;

    public function __construct(ProjectId $projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * @return ProjectId
     */
    public function getProjectId(): ProjectId
    {
        return $this->projectId;
    }

    public static function fromArray(array $commandProps): self
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired(['project_id']);
        $finalProps = $resolver->resolve($commandProps);

        return new self(
            new ProjectId((string)$finalProps['project_id'])
        );
    }
}
