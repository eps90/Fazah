<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Catalogue
{
    /**
     * @var UuidInterface
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

    public static function create($catalogueName): self
    {
        $catalogue = new self();
        $catalogue->catalogueId = Uuid::uuid4();
        $catalogue->name = $catalogueName;
        $catalogue->createdAt = Carbon::now();
        $catalogue->enabled = true;

        return $catalogue;
    }

    /**
     * @return UuidInterface
     */
    public function getCatalogueId(): UuidInterface
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
}
