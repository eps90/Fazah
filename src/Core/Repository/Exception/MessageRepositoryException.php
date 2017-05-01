<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Exception;

use Eps\Fazah\Core\Model\Identity\MessageId;

class MessageRepositoryException extends \LogicException
{
    public static function notFound(MessageId $messageId, \Throwable $previous = null): MessageRepositoryException
    {
        $message = "Message with id $messageId has not been found";
        $code = 1;
        return new self($message, $code, $previous);
    }

    public static function alreadyExists(MessageId $messageId, \Throwable $previous = null): MessageRepositoryException
    {
        $message = "Message with id $messageId already exists";
        $code = 1;
        return new self($message, $code, $previous);
    }
}
