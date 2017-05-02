<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Exception;

use Eps\Fazah\Core\Model\Identity\MessageId;

class MessageRepositoryException extends \LogicException
{
    public static function notFound(MessageId $messageId, \Throwable $previous = null): MessageRepositoryException
    {
        $message = sprintf('Message with id %s has not been found', $messageId);
        $code = 1;
        return new self($message, $code, $previous);
    }

    public static function alreadyExists(MessageId $messageId, \Throwable $previous = null): MessageRepositoryException
    {
        $message = sprintf('Message with id %s already exists', $messageId);
        $code = 1;
        return new self($message, $code, $previous);
    }
}
