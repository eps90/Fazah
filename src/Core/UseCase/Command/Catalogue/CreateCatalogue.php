<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Catalogue;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
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
}
