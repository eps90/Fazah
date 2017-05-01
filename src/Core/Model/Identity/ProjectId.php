<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model\Identity;

use Ramsey\Uuid\Uuid;

final class ProjectId extends Identity
{
    public static function generate(): ProjectId
    {
        return new self((string)Uuid::uuid4());
    }
}
