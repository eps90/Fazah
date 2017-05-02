<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Exception;

use Eps\Fazah\Core\Model\Identity\MessageId;

class MessageRepositoryException extends RepositoryException
{
    public static function notFound(MessageId $messageId, \Throwable $previous = null): MessageRepositoryException
    {
        return self::generateNotFoundException($messageId, $previous);
    }

    static protected function getModelAlias(): string
    {
        return 'Message';
    }

    static protected function getErrorCode(): int
    {
        return 1;
    }
}
