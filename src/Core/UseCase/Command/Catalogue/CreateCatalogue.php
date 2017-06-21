<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Catalogue;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Req2CmdBundle\Command\DeserializableCommandInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CreateCatalogue implements DeserializableCommandInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var ProjectId
     */
    private $projectId;

    /**
     * @var CatalogueId|null
     */
    private $parentCatalogueId;

    public function __construct(string $name, ProjectId $projectId, ?CatalogueId $parentCatalogueId)
    {
        $this->name = $name;
        $this->projectId = $projectId;
        $this->parentCatalogueId = $parentCatalogueId;
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

    /**
     * @return CatalogueId|null
     */
    public function getParentCatalogueId(): ?CatalogueId
    {
        return $this->parentCatalogueId;
    }

    public static function fromArray(array $commandProps): self
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired(['name', 'project_id']);
        $resolver->setDefined('parent_catalogue_id');
        $props = $resolver->resolve($commandProps);

        return new self(
            (string)$props['name'],
            new ProjectId((string)$props['project_id']),
            isset($props['parent_catalogue_id'])
                ? new CatalogueId((string)$props['parent_catalogue_id'])
                : null
        );
    }
}
