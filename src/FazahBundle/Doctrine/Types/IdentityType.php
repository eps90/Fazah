<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

abstract class IdentityType extends GuidType
{
    abstract protected function getIdentityType(): string;

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        $expectedClass = $this->getIdentityType();
        if (!is_a($value, $expectedClass)) {
            throw new \InvalidArgumentException(sprintf('Input value must be a type of %s', $expectedClass));
        }

        return $value->getId();
    }
}
