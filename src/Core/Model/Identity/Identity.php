<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model\Identity;

use Ramsey\Uuid\Uuid;

abstract class Identity implements \JsonSerializable
{
    protected $id;

    public function __construct(string $uuid)
    {
        if (!Uuid::isValid($uuid)) {
            throw new \InvalidArgumentException('Input value has to be a valid UUID string');
        }

        $this->id = $uuid;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function jsonSerialize(): string
    {
        return $this->id;
    }
}
