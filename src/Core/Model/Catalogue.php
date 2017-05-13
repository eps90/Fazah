<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model;

use Assert\Assert;
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

    private function __construct()
    {
    }

    public static function create(
        string $catalogueName,
        ProjectId $projectId,
        CatalogueId $parentCatalogueId = null
    ): Catalogue {
        $catalogue = new self();
        $catalogue->id = CatalogueId::generate();
        $catalogue->setName($catalogueName);
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
        $catalogue->projectId = $projectId;
        $catalogue->parentCatalogueId = $parentCatalogueId;
        $catalogue->metadata = $metadata;

        $catalogue->setName($name);
        if ($alias !== null) {
            $catalogue->setAlias($alias);
        }

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
        $this->setName($newName);
        $this->metadata = $this->metadata->markAsUpdated();
    }

    public function changeAlias(string $newAlias): void
    {
        $this->setAlias($newAlias);
        $this->metadata = $this->metadata->markAsUpdated();
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

    private function setName(string $catalogueName): void
    {
        Assert::that($catalogueName)
            ->notBlank('Catalogue name cannot be blank')
            ->maxLength(255, 'Catalogue name must not be longer than 255 characters');

        $this->name = $catalogueName;
    }

    private function setAlias(string $newAlias): void
    {
        Assert::that($newAlias)
            ->notBlank('Catalogue alias cannot be blank')
            ->regex('/^[\S]+$/', 'Catalogue alias must not contain whitespaces');

        $this->alias = $newAlias;
    }
}
