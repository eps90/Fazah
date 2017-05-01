<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

abstract class IdentityType extends GuidType
{
    protected abstract function getIdentityType(): string;

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        $expectedClass = $this->getIdentityType();
        if (!is_a($value, $expectedClass)) {
            throw new \InvalidArgumentException("Input value must be a type of $expectedClass");
        }

        return $value->getId();
    }
}
