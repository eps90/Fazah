<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Eps\Fazah\Core\Model\Identity\CatalogueId;

final class CatalogueIdType extends IdentityType
{
    const CATALOGUE_ID = 'catalogue_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): CatalogueId
    {
        return new CatalogueId($value);
    }

    public function getName(): string
    {
        return self::CATALOGUE_ID;
    }

    protected function getIdentityType(): string
    {
        return CatalogueId::class;
    }
}
