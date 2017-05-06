<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model;

use Cocur\Slugify\Slugify;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\ValueObject\Metadata;

class Catalogue
{
    /**
     * @var CatalogueId
     */
    private $catalogueId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var ProjectId
     */
    private $projectId;

    /**
     * @var Metadata
     */
    private $metadata;

    public static function create(string $catalogueName, ProjectId $projectId): Catalogue
    {
        $catalogue = new self();
        $catalogue->catalogueId = CatalogueId::generate();
        $catalogue->name = $catalogueName;
        $catalogue->metadata = Metadata::initialize();
        $catalogue->projectId = $projectId;

        return $catalogue;
    }

    public static function restoreFrom(
        CatalogueId $catalogueId,
        string $name,
        ProjectId $projectId,
        Metadata $metadata
    ): Catalogue {
        $catalogue = new self();
        $catalogue->catalogueId = $catalogueId;
        $catalogue->name = $name;
        $catalogue->projectId = $projectId;
        $catalogue->metadata = $metadata;

        return $catalogue;
    }

    /**
     * @return CatalogueId
     */
    public function getCatalogueId(): CatalogueId
    {
        return $this->catalogueId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        $slugifier = new Slugify();
        return $slugifier->slugify($this->name, '_');
    }

    /**
     * @return ProjectId
     */
    public function getProjectId(): ProjectId
    {
        return $this->projectId;
    }

    /**
     * @return Metadata
     */
    public function getMetadata(): Metadata
    {
        return $this->metadata;
    }
}
