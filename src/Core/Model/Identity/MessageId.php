<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Model\Identity;

use Ramsey\Uuid\Uuid;

final class MessageId extends Identity
{
    public static function generate(): MessageId
    {
        return new self((string)Uuid::uuid4());
    }
}
