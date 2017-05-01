<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;

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
     * @var Carbon
     */
    private $createdAt;

    /**
     * @var Carbon
     */
    private $updatedAt;

    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var ProjectId
     */
    private $projectId;

    public static function create(string $catalogueName, ProjectId $projectId): Catalogue
    {
        $catalogue = new self();
        $catalogue->catalogueId = CatalogueId::generate();
        $catalogue->name = $catalogueName;
        $catalogue->createdAt = Carbon::now();
        $catalogue->enabled = true;
        $catalogue->projectId = $projectId;

        return $catalogue;
    }

    public static function restoreFrom(
        CatalogueId $catalogueId,
        string $name,
        Carbon $createdAt,
        ?Carbon $updatedAt,
        bool $enabled,
        ProjectId $projectId
    ): Catalogue {
        $catalogue = new self();
        $catalogue->catalogueId = $catalogueId;
        $catalogue->name = $name;
        $catalogue->createdAt = $createdAt;
        $catalogue->updatedAt = $updatedAt;
        $catalogue->enabled = $enabled;
        $catalogue->projectId = $projectId;

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

    /**
     * @return ProjectId
     */
    public function getProjectId(): ProjectId
    {
        return $this->projectId;
    }
}
