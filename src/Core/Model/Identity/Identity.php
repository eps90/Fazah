<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model\Identity;

abstract class Identity implements \JsonSerializable
{
    protected $id;

    public function __construct(string $uuid)
    {
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
