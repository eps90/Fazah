<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Eps\Fazah\Core\Model\Identity\MessageId;

final class MessageIdType extends IdentityType
{
    const MESSAGE_ID = 'message_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?MessageId
    {
        $result = null;

        if ($value !== null) {
            $result = new MessageId($value);
        }

        return $result;
    }

    public function getName(): string
    {
        return self::MESSAGE_ID;
    }

    protected function getIdentityType(): string
    {
        return MessageId::class;
    }
}
