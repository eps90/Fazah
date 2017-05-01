<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model\Identity;

use Ramsey\Uuid\Uuid;

final class CatalogueId extends Identity
{
    public static function generate(): CatalogueId
    {
        return new self((string)Uuid::uuid4());
    }
}
