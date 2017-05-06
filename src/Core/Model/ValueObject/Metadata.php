<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model\ValueObject;

use Carbon\Carbon;

final class Metadata
{
    /**
     * @var Carbon
     */
    private $createdAt;

    /**
     * @var Carbon|null
     */
    private $updatedAt;

    /**
     * @var bool
     */
    private $enabled;

    public static function initialize(): Metadata
    {
        $metadata = new self();
        $metadata->createdAt = Carbon::now();
        $metadata->enabled = true;

        return $metadata;
    }

    public static function restoreFrom(Carbon $creationTime, ?Carbon $updateTime, bool $enabled): Metadata
    {
        $metadata = new self();

        $metadata->createdAt = $creationTime;
        $metadata->updatedAt = $updateTime;
        $metadata->enabled = $enabled;

        return $metadata;
    }

    /**
     * @return Carbon
     */
    public function getCreationTime(): Carbon
    {
        return $this->createdAt;
    }

    /**
     * @return Carbon|null
     */
    public function getUpdateTime(): ?Carbon
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

        return $newMetadata;
    }

    public function markAsEnabled(): Metadata
    {
        $newMetadata = clone $this;
        $newMetadata->enabled = true;

        return $newMetadata;
    }
}
