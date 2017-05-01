<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Eps\Fazah\Core\Model\Identity\MessageId;

final class MessageIdType extends IdentityType
{
    const MESSAGE_ID = 'message_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): MessageId
    {
        return new MessageId($value);
    }

    public function getName()
    {
        return self::MESSAGE_ID;
    }

    protected function getIdentityType(): string
    {
        return MessageId::class;
    }
}
