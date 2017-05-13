<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model;

use Assert\Assert;
use Assert\Assertion;
use Cocur\Slugify\Slugify;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\ValueObject\Metadata;

class Catalogue
{
    /**
     * @var CatalogueId
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var ProjectId
     */
    private $projectId;

    /**
     * @var CatalogueId
     */
    private $parentCatalogueId;

    /**
     * @var Metadata
     */
    private $metadata;

    /**
     * @var string
     */
    private $alias;

    public static function create(
        string $catalogueName,
        ProjectId $projectId,
        CatalogueId $parentCatalogueId = null
    ): Catalogue {
        $catalogue = new self();
        $catalogue->id = CatalogueId::generate();
        $catalogue->name = $catalogueName;
        $catalogue->metadata = Metadata::initialize();
        $catalogue->projectId = $projectId;
        $catalogue->parentCatalogueId = $parentCatalogueId;

        return $catalogue;
    }

    public static function restoreFrom(
        CatalogueId $catalogueId,
        string $name,
        ProjectId $projectId,
        ?CatalogueId $parentCatalogueId,
        Metadata $metadata,
        string $alias = null
    ): Catalogue {
        $catalogue = new self();
        $catalogue->id = $catalogueId;
        $catalogue->name = $name;
        $catalogue->projectId = $projectId;
        $catalogue->parentCatalogueId = $parentCatalogueId;
        $catalogue->metadata = $metadata;
        $catalogue->alias = $alias;

        return $catalogue;
    }

    /**
     * @return CatalogueId
     */
    public function getId(): CatalogueId
    {
        return $this->id;
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
        $alias = $this->alias;
        if ($alias === null) {
            $slugifier = new Slugify();
            $alias = $slugifier->slugify($this->name, '_');
        }

        return $alias;
    }

    /**
     * @return ProjectId
     */
    public function getProjectId(): ProjectId
    {
        return $this->projectId;
    }

    /**
     * @return CatalogueId
     */
    public function getParentCatalogueId(): ?CatalogueId
    {
        return $this->parentCatalogueId;
    }

    /**
     * @return Metadata
     */
    public function getMetadata(): Metadata
    {
        return $this->metadata;
    }

    public function disable(): void
    {
        $this->metadata = $this->metadata->markAsDisabled();
    }

    public function enable(): void
    {
        $this->metadata = $this->metadata->markAsEnabled();
    }

    public function rename(string $newName): void
    {
        Assertion::notBlank($newName, 'Catalogue name cannot be blank');
        $this->name = $newName;
    }

    public function changeAlias(string $newAlias): void
    {
        Assert::that($newAlias)
            ->notBlank('Catalogue alias cannot be blank')
            ->regex('/^[\S]+$/', 'Catalogue alias must not contain whitespaces');

        $this->alias = $newAlias;
    }

    public function updateFromArray(array $updateMap): void
    {
        if (array_key_exists('name', $updateMap)) {
            $this->rename($updateMap['name']);
        }

        if (array_key_exists('alias', $updateMap)) {
            $this->changeAlias($updateMap['alias']);
        }
    }
}
