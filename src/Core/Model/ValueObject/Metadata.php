<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model\ValueObject;

use Eps\Fazah\Core\Utils\DateTimeFactory;

final class Metadata
{
    /**
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * @var \DateTimeImmutable|null
     */
    private $updatedAt;

    /**
     * @var bool
     */
    private $enabled;

    private function __construct()
    {
    }

    public static function initialize(): Metadata
    {
        $metadata = new self();
        $metadata->createdAt = DateTimeFactory::now();
        $metadata->enabled = true;

        return $metadata;
    }

    public static function restoreFrom(
        \DateTimeImmutable $creationTime,
        ?\DateTimeImmutable $updateTime,
        bool $enabled
    ): Metadata {
        $metadata = new self();

        $metadata->createdAt = $creationTime;
        $metadata->updatedAt = $updateTime;
        $metadata->enabled = $enabled;

        return $metadata;
    }

    public function getCreationTime(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdateTime(): ?\DateTimeImmutable
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

    public function markAsDisabled(): Metadata
    {
        $newMetadata = clone $this;
        $newMetadata->enabled = false;
        $newMetadata = $newMetadata->markAsUpdated();

        return $newMetadata;
    }

    public function markAsEnabled(): Metadata
    {
        $newMetadata = clone $this;
        $newMetadata->enabled = true;
        $newMetadata = $newMetadata->markAsUpdated();

        return $newMetadata;
    }

    public function markAsUpdated(): Metadata
    {
        $newMetadata = clone $this;
        $newMetadata->updatedAt = DateTimeFactory::now();

        return $newMetadata;
    }
}
